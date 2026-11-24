@extends('layouts.app')
@section('title', 'Laporan Transaksi Semua Pelanggan - Kasir RasaKita')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Laporan Transaksi & Struk Semua Pengguna</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Total Pemasukan Lunas: <strong class="text-[#e8503a]">Rp {{ number_format($totalOmzet, 0, ',', '.') }}</strong></p>
        </div>
        <button onclick="window.print()" class="no-print px-5 py-2.5 rounded-xl bg-slate-900 text-white text-xs font-bold flex items-center gap-2">
            <i class="fa-solid fa-print"></i> Cetak Laporan
        </button>
    </div>

    <form method="GET" action="{{ route('kasir.laporan.index') }}" class="no-print bg-white p-4 rounded-2xl border border-slate-100 shadow-sm mb-6 flex flex-wrap gap-3">
        <input type="text" name="cari" value="{{ request('cari') }}" placeholder="Cari invoice atau nama pelanggan..." class="px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs">
        <input type="date" name="tanggal" value="{{ request('tanggal') }}" class="px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs">
        <button type="submit" class="btn-brand px-5 py-2 rounded-xl text-xs font-bold">Filter</button>
    </form>

    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 overflow-x-auto">
        <table class="w-full text-left border-collapse text-xs">
            <thead>
                <tr class="border-b border-slate-100 text-slate-400 uppercase">
                    <th class="py-3 px-3">Invoice</th>
                    <th class="py-3 px-3">Pelanggan</th>
                    <th class="py-3 px-3">Tanggal</th>
                    <th class="py-3 px-3">Metode</th>
                    <th class="py-3 px-3">Total</th>
                    <th class="py-3 px-3">Status</th>
                    <th class="py-3 px-3 text-right no-print">Struk</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($orders as $order)
                    <tr>
                        <td class="py-3.5 px-3 font-mono font-bold">{{ $order->order_number }}</td>
                        <td class="py-3.5 px-3 font-bold">{{ $order->customer_name }}</td>
                        <td class="py-3.5 px-3 text-slate-500">{{ $order->created_at->format('d M Y H:i') }}</td>
                        <td class="py-3.5 px-3 uppercase">{{ $order->payment_method }}</td>
                        <td class="py-3.5 px-3 font-bold text-[#e8503a]">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                        <td class="py-3.5 px-3 uppercase font-bold">{{ $order->payment_status }} / {{ $order->order_status }}</td>
                        <td class="py-3.5 px-3 text-right no-print">
                            <a href="{{ route('kasir.struk', $order) }}" class="btn-brand px-3 py-1.5 rounded-lg text-xs font-bold">
                                <i class="fa-solid fa-receipt"></i> Lihat & Cetak Struk
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-6 no-print">{{ $orders->links() }}</div>
    </div>
</div>
@endsection