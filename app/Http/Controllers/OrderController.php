<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Tampilan checkout menu
     */
    public function checkout()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('warning', 'Keranjang Anda masih kosong. Silakan pilih menu terlebih dahulu!');
        }

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $deliveryFee = 5000;
        $total = $subtotal + $deliveryFee;

        $user = Auth::user();

        return view('pelanggan.checkout', compact('cart', 'subtotal', 'deliveryFee', 'total', 'user'));
    }

    /**
     * ATURAN PELANGGAN 4: Bisa memesan makanan (Admin juga bisa memesan makanan)
     */
    public function store(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('menu.index')->with('error', 'Keranjang kosong!');
        }

        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'required|string|max:500',
            'payment_method' => 'required|in:qris,transfer_bank,tunai',
            'notes' => 'nullable|string|max:1000',
        ]);

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        $deliveryFee = 5000;
        $total = $subtotal + $deliveryFee;

        $today = date('Ymd');
        $randomSeq = strtoupper(substr(uniqid(), -4));
        $orderNumber = 'RSK-' . $today . '-' . $randomSeq;

        $order = DB::transaction(function () use ($validated, $subtotal, $deliveryFee, $total, $orderNumber, $cart) {
            $order = Order::create([
                'order_number' => $orderNumber,
                'user_id' => Auth::id(),
                'customer_name' => $validated['customer_name'],
                'customer_phone' => $validated['customer_phone'],
                'customer_address' => $validated['customer_address'],
                'notes' => $validated['notes'] ?? null,
                'subtotal' => $subtotal,
                'delivery_fee' => $deliveryFee,
                'total_price' => $total,
                'payment_method' => $validated['payment_method'],
                'payment_status' => $validated['payment_method'] === 'tunai' ? 'pending' : 'paid',
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

        // ATURAN PELANGGAN 5: Menampilkan struk pemesanan diri sendiri setelah melakukan transaksi
        return redirect()->route('order.receipt', $order->id)->with('success', 'Pesanan Anda berhasil dibuat! Berikut adalah struk transaksi Anda.');
    }

    /**
     * ATURAN PELANGGAN 5: Menampilkan struk pemesanan diri sendiri
     * ATURAN PELANGGAN 3: Tidak bisa melihat laporan transaksi orang lain (Admin & Kasir diizinkan)
     */
    public function receipt(Order $order)
    {
        if (!in_array(Auth::user()->role, ['admin', 'kasir']) && Auth::id() !== $order->user_id) {
            abort(403, 'Akses Ditolak: Anda tidak dapat melihat laporan transaksi / struk milik pelanggan lain.');
        }

        $order->load('items');

        return view('pelanggan.receipt', compact('order'));
    }

    /**
     * ATURAN PELANGGAN 2: Melihat laporan transaksi diri sendiri
     * ATURAN PELANGGAN 3: Tidak bisa melihat laporan transaksi orang lain
     */
    public function history()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with('items')
            ->latest()
            ->paginate(10);

        $totalSpent = Order::where('user_id', Auth::id())
            ->where('payment_status', 'paid')
            ->sum('total_price');

        $totalOrders = Order::where('user_id', Auth::id())->count();

        return view('pelanggan.history', compact('orders', 'totalSpent', 'totalOrders'));
    }
}