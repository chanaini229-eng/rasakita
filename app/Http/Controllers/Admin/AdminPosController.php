<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminPosController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        $query = Menu::with('category');

        if ($request->filled('cari')) {
            $query->where('name', 'like', '%' . $request->cari . '%');
        }
        if ($request->filled('kategori') && $request->kategori !== 'semua') {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->kategori));
        }

        $menus = $query->get();
        $customers = User::where('role', 'pelanggan')->orderBy('name')->get();
        $cart = session()->get('cart', []);

        return view('admin.pos.index', compact('menus', 'categories', 'customers', 'cart'));
    }

    public function store(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return back()->with('error', 'Keranjang kasir masih kosong!');
        }

        $validated = $request->validate([
            'target_user_id' => 'nullable|exists:users,id',
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'customer_address' => 'nullable|string|max:500',
            'payment_method' => 'required|in:tunai,qris,transfer_bank',
            'delivery_fee' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string|max:1000',
        ]);

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $deliveryFee = (int) ($validated['delivery_fee'] ?? 0);
        $total = $subtotal + $deliveryFee;
        $orderUserId = !empty($validated['target_user_id']) ? $validated['target_user_id'] : auth()->id();
        $orderNumber = 'KSR-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -4));

        // Ambil nomor HP & alamat dari akun pelanggan jika dipilih dan tidak diisi manual
        $targetCustomer = !empty($validated['target_user_id'])
            ? User::find($validated['target_user_id'])
            : null;

        $customerPhone = !empty($validated['customer_phone'])
            ? $validated['customer_phone']
            : ($targetCustomer?->phone ?: '-');

        $customerAddress = !empty($validated['customer_address'])
            ? $validated['customer_address']
            : ($targetCustomer?->address ?: 'Dine-In / Transaksi Langsung di Kasir');

        $order = DB::transaction(function () use ($validated, $subtotal, $deliveryFee, $total, $orderNumber, $cart, $orderUserId, $customerPhone, $customerAddress) {
            $order = Order::create([
                'order_number' => $orderNumber,
                'user_id' => $orderUserId,
                'customer_name' => $validated['customer_name'],
                'customer_phone' => $customerPhone,
                'customer_address' => $customerAddress,
                'notes' => $validated['notes'] ?? null,
                'subtotal' => $subtotal,
                'delivery_fee' => $deliveryFee,
                'total_price' => $total,
                'payment_method' => $validated['payment_method'],
                'payment_status' => 'paid',
                'order_status' => 'diproses',
            ]);

            foreach ($cart as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_id' => $item['id'] ?? null,
                    'menu_name' => $item['name'],
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['price'] * $item['quantity'],
                    'notes' => $item['notes'] ?? null,
                ]);
            }

            return $order;
        });

        session()->forget('cart');

        return redirect()->route('order.receipt', $order->id)
            ->with('success', 'Transaksi Kasir berhasil! Struk pembayaran pelanggan siap dicetak.');
    }
}