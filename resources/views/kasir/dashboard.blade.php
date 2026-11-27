@extends('layouts.app')
@section('title', 'Dashboard Kasir - RasaKita')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10 space-y-8">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <span class="inline-block px-3 py-1 rounded-full bg-orange-100 text-[#e8503a] text-xs font-bold uppercase tracking-wider mb-2">
                Panel Kasir Restoran RasaKita
            </span>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Dashboard Kasir</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Konfirmasi pesanan pelanggan, kelola daftar menu, dan cetak struk pembayaran.</p>
        </div>
        <div class="flex flex-wrap gap-2.5">
            <a href="{{ route('kasir.pos.index') }}" class="btn-brand px-5 py-2.5 rounded-xl text-xs font-bold flex items-center gap-2">
                <i class="fa-solid fa-cash-register"></i> Mode Kasir
            </a>
            <a href="{{ route('kasir.pesanan.index') }}" class="px-5 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold flex items-center gap-2">
                <i class="fa-solid fa-clipboard-check"></i> Konfirmasi Pesanan ({{ $pesananPerluKonfirmasi }})
            </a>
            <a href="{{ route('kasir.menu.create') }}" class="px-5 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold flex items-center gap-2">
                <i class="fa-solid fa-plus"></i> Tambah Menu
            </a>
        </div>
    </div>

    <!-- Statistik Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
            <p class="text-xs text-slate-400 font-semibold">Total Pendapatan (Lunas)</p>
            <p class="text-2xl font-black text-[#e8503a] mt-2">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
        </div>
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
            <p class="text-xs text-slate-400 font-semibold">Total Semua Transaksi</p>
            <p class="text-2xl font-black text-slate-900 mt-2">{{ $totalTransaksi }} Pesanan</p>
        </div>
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
            <p class="text-xs text-slate-400 font-semibold">Perlu Konfirmasi / Diproses</p>
            <p class="text-2xl font-black text-amber-600 mt-2">{{ $pesananPerluKonfirmasi }} Pesanan</p>
        </div>
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
            <p class="text-xs text-slate-400 font-semibold">Total Daftar Menu</p>
            <p class="text-2xl font-black text-slate-900 mt-2">{{ $totalMenu }} Menu</p>
        </div>
    </div>

    <!-- Tabel Pesanan Terbaru -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6">
        <div class="flex items-center justify-between mb-5">
            <h2 class="text-lg font-extrabold text-slate-900">Antrean Pesanan Masuk Terbaru</h2>
            <a href="{{ route('kasir.laporan.index') }}" class="text-xs font-bold text-[#e8503a] hover:underline">Lihat Semua Laporan →</a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="border-b border-slate-100 text-slate-400 uppercase">
                        <th class="py-3 px-3">No. Invoice</th>
                        <th class="py-3 px-3">Pelanggan</th>
                        <th class="py-3 px-3">Total</th>
                        <th class="py-3 px-3">Pembayaran</th>
                        <th class="py-3 px-3">Status Pesanan</th>
                        <th class="py-3 px-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($pesananTerbaru as $order)
                        <tr>
                            <td class="py-3.5 px-3 font-mono font-bold text-slate-800">{{ $order->order_number }}</td>
                            <td class="py-3.5 px-3">
                                <span class="font-bold text-slate-800 block">{{ $order->customer_name }}</span>
                                <span class="text-slate-400">{{ $order->created_at->format('d M Y H:i') }}</span>
                            </td>
                            <td class="py-3.5 px-3 font-bold text-[#e8503a]">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                            <td class="py-3.5 px-3">
                                <span class="px-2 py-0.5 rounded-full font-bold {{ $order->payment_status === 'paid' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                    {{ strtoupper($order->payment_method) }} • {{ $order->payment_status === 'paid' ? 'LUNAS' : 'PENDING' }}
                                </span>
                            </td>
                            <td class="py-3.5 px-3 font-bold uppercase text-slate-700">{{ $order->order_status }}</td>
                            <td class="py-3.5 px-3 text-right space-x-1">
                                <a href="{{ route('kasir.struk', $order) }}" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-slate-900 text-white font-bold hover:bg-slate-700">
                                    <i class="fa-solid fa-print"></i> Struk
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection