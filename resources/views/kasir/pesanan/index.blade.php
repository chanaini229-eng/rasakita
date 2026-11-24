@extends('layouts.app')
@section('title', 'Konfirmasi Pesanan Pelanggan - Kasir RasaKita')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10">
    <div class="mb-6">
        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Konfirmasi Pesanan Mandiri Pelanggan</h1>
        <p class="text-xs sm:text-sm text-slate-500 mt-1">Verifikasi pembayaran tunai/QRIS dan konfirmasi status pesanan pelanggan.</p>
    </div>

    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 overflow-x-auto">
        <table class="w-full text-left border-collapse text-xs">
            <thead>
                <tr class="border-b border-slate-100 text-slate-400 uppercase">
                    <th class="py-3 px-3">Invoice & Waktu</th>
                    <th class="py-3 px-3">Pelanggan & Alamat/Meja</th>
                    <th class="py-3 px-3">Menu Dipesan</th>
                    <th class="py-3 px-3">Total</th>
                    <th class="py-3 px-3">Konfirmasi Status & Bayar</th>
                    <th class="py-3 px-3 text-right">Struk</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($orders as $order)
                    <tr>
                        <td class="py-4 px-3">
                            <span class="font-mono font-bold text-slate-900 block">{{ $order->order_number }}</span>
                            <span class="text-slate-400">{{ $order->created_at->format('d M Y, H:i') }}</span>
                        </td>
                        <td class="py-4 px-3">
                            <span class="font-bold text-slate-800 block">{{ $order->customer_name }} ({{ $order->customer_phone }})</span>
                            <span class="text-slate-500">{{ $order->customer_address }}</span>
                        </td>
                        <td class="py-4 px-3">
                            @foreach($order->items as $item)
                                <div>• {{ $item->menu_name }} ({{ $item->quantity }}x)</div>
                            @endforeach
                        </td>
                        <td class="py-4 px-3 font-extrabold text-[#e8503a]">
                            Rp {{ number_format($order->total_price, 0, ',', '.') }}<br>
                            <span class="text-[10px] text-slate-500 uppercase">{{ $order->payment_method }}</span>
                        </td>
                        <td class="py-4 px-3">
                            <form action="{{ route('kasir.pesanan.status', $order) }}" method="POST" class="flex flex-wrap items-center gap-2">
                                @csrf
                                @method('PATCH')
                                <select name="payment_status" class="px-2.5 py-1.5 bg-slate-50 border border-slate-200 rounded-lg text-xs font-semibold">
                                    <option value="pending" @selected($order->payment_status === 'pending')>Belum Lunas</option>
                                    <option value="paid" @selected($order->payment_status === 'paid')>Lunas (Paid)</option>
                                    <option value="failed" @selected($order->payment_status === 'failed')>Gagal</option>
                                </select>
                                <select name="order_status" class="px-2.5 py-1.5 bg-slate-50 border border-slate-200 rounded-lg text-xs font-semibold">
                                    <option value="menunggu" @selected($order->order_status === 'menunggu')>Menunggu</option>
                                    <option value="diproses" @selected($order->order_status === 'diproses')>Diproses</option>
                                    <option value="selesai" @selected($order->order_status === 'selesai')>Selesai</option>
                                    <option value="dibatalkan" @selected($order->order_status === 'dibatalkan')>Dibatalkan</option>
                                </select>
                                <button type="submit" class="btn-brand px-3 py-1.5 rounded-lg text-xs font-bold">Konfirmasi</button>
                            </form>
                        </td>
                        <td class="py-4 px-3 text-right">
                            <a href="{{ route('kasir.struk', $order) }}" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-slate-900 text-white font-bold">
                                <i class="fa-solid fa-print"></i> Cetak
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-6">{{ $orders->links() }}</div>
    </div>
</div>
@endsection