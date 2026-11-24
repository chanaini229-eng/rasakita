<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class KasirOrderController extends Controller
{
    // Halaman Konfirmasi Pesanan Mandiri Pelanggan
    public function konfirmasiIndex(Request $request)
    {
        $orders = Order::with(['user', 'items'])
            ->when($request->filled('status'), fn ($q) => $q->where('order_status', $request->status))
            ->when($request->filled('cari'), function ($q) use ($request) {
                $q->where('order_number', 'like', '%' . $request->cari . '%')
                  ->orWhere('customer_name', 'like', '%' . $request->cari . '%');
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('kasir.pesanan.index', compact('orders'));
    }

    // Proses Konfirmasi Status Pesanan & Pembayaran
    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'order_status' => 'required|in:menunggu,diproses,selesai,dibatalkan',
            'payment_status' => 'required|in:pending,paid,failed',
        ]);

        $order->update([
            'order_status' => $validated['order_status'],
            'payment_status' => $validated['payment_status'],
        ]);

        return back()->with('success', "Pesanan {$order->order_number} berhasil dikonfirmasi & diperbarui!");
    }

    // Laporan Transaksi & Struk Semua Pengguna
    public function laporan(Request $request)
    {
        $orders = Order::with(['user', 'items'])
            ->when($request->filled('cari'), function ($q) use ($request) {
                $q->where('order_number', 'like', '%' . $request->cari . '%')
                  ->orWhere('customer_name', 'like', '%' . $request->cari . '%');
            })
            ->when($request->filled('tanggal'), fn ($q) => $q->whereDate('created_at', $request->tanggal))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $totalOmzet = Order::where('payment_status', 'paid')
            ->where('order_status', '!=', 'dibatalkan')
            ->sum('total_price');

        return view('kasir.laporan.index', compact('orders', 'totalOmzet'));
    }

    // Cetak Struk Pembayaran Semua Pelanggan
    public function struk(Order $order)
    {
        $order->load(['items', 'user']);
        return view('kasir.struk', compact('order'));
    }

    // ATURAN KASIR 1: Kasir TIDAK BISA mengubah identitas pengguna
    public function blokirKelolaPengguna()
    {
        abort(403, 'Akses Ditolak: Role Kasir tidak diperbolehkan mengubah atau menghapus identitas pengguna.');
    }
}