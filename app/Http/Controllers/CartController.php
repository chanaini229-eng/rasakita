<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display Shopping Cart
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $deliveryFee = $subtotal > 0 ? 5000 : 0;
        $total = $subtotal + $deliveryFee;

        return view('pelanggan.cart', compact('cart', 'subtotal', 'deliveryFee', 'total'));
    }

    /**
     * Add item to cart
     */
    public function add(Request $request)
    {
        $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'quantity' => 'nullable|integer|min:1',
            'notes' => 'nullable|string|max:255',
        ]);

        $menu = Menu::findOrFail($request->menu_id);
        $quantity = $request->input('quantity', 1);
        $notes = $request->input('notes', '');

        $cart = session()->get('cart', []);

        if (isset($cart[$menu->id])) {
            $cart[$menu->id]['quantity'] += $quantity;
            if ($notes) {
                $cart[$menu->id]['notes'] = $notes;
            }
        } else {
            $cart[$menu->id] = [
                'id' => $menu->id,
                'name' => $menu->name,
                'price' => (float) $menu->price,
                'quantity' => $quantity,
                'image' => $menu->image,
                'category' => $menu->category ? $menu->category->name : 'Umum',
                'notes' => $notes,
            ];
        }

        session()->put('cart', $cart);

        $cartCount = array_sum(array_column($cart, 'quantity'));

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'status' => 'success',
                'message' => "{$menu->name} berhasil ditambahkan ke keranjang!",
                'cart_count' => $cartCount,
                'cart' => $cart,
            ]);
        }

        return back()->with('success', "{$menu->name} berhasil ditambahkan ke keranjang!");
    }

    /**
     * Update quantity of item in cart
     */
    public function update(Request $request)
    {
        $request->validate([
            'menu_id' => 'required',
            'quantity' => 'required|integer|min:0',
        ]);

        $cart = session()->get('cart', []);
        $menuId = $request->menu_id;
        $quantity = $request->quantity;

        if (isset($cart[$menuId])) {
            if ($quantity <= 0) {
                unset($cart[$menuId]);
            } else {
                $cart[$menuId]['quantity'] = $quantity;
            }
            session()->put('cart', $cart);
        }

        if ($request->wantsJson() || $request->ajax()) {
            $subtotal = 0;
            foreach ($cart as $item) {
                $subtotal += $item['price'] * $item['quantity'];
            }
            $deliveryFee = $subtotal > 0 ? 5000 : 0;
            $total = $subtotal + $deliveryFee;
            $cartCount = array_sum(array_column($cart, 'quantity'));

            return response()->json([
                'status' => 'success',
                'cart_count' => $cartCount,
                'subtotal' => $subtotal,
                'deliveryFee' => $deliveryFee,
                'total' => $total,
                'formatted_total' => 'Rp ' . number_format($total, 0, ',', '.'),
            ]);
        }

        return back()->with('success', 'Keranjang belanja berhasil diperbarui.');
    }

    /**
     * Remove item from cart
     */
    public function remove(Request $request)
    {
        $request->validate([
            'menu_id' => 'required',
        ]);

        $cart = session()->get('cart', []);
        $menuId = $request->menu_id;

        if (isset($cart[$menuId])) {
            unset($cart[$menuId]);
            session()->put('cart', $cart);
        }

        return back()->with('info', 'Item dihapus dari keranjang.');
    }

    /**
     * Clear all items in cart
     */
    public function clear()
    {
        session()->forget('cart');
        return back()->with('info', 'Keranjang pesanan dikosongkan.');
    }
}
