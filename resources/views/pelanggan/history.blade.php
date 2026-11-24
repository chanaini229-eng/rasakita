@extends('layouts.app')

@section('title', 'Riwayat Transaksi Saya - RasaKita')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">

    <!-- Header & Breadcrumbs -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
        <div>
            <nav class="flex items-center gap-2 text-xs text-slate-400 mb-2">
                <a href="{{ route('home') }}" class="hover:text-[#e8503a]">Beranda</a>
                <i class="fa-solid fa-chevron-right text-[10px]"></i>
                <span class="text-slate-700 font-semibold">Riwayat Transaksi Diri Sendiri</span>
            </nav>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Laporan & Riwayat Transaksi</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Daftar seluruh riwayat pesanan yang Anda lakukan di RasaKita</p>
        </div>

        <!-- Rule 2 & 3 Compliance Notice -->
        <div class="inline-flex items-center gap-2 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-2 rounded-2xl text-xs font-medium">
            <i class="fa-solid fa-user-shield text-emerald-500"></i>
            <div>
                <span class="font-bold">Privasi Terjaga:</span>
                <span>Hanya menampilkan riwayat transaksi akun Anda ({{ auth()->user()->name }})</span>
            </div>
        </div>
    </div>

    <!-- Summary Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-8">
        <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-[#fff1ee] text-[#e8503a] flex items-center justify-center text-xl flex-shrink-0">
                <i class="fa-solid fa-bag-shopping"></i>
            </div>
            <div>
                <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Total Pesanan</span>
                <p class="text-xl font-extrabold text-slate-900">{{ $totalOrders }} Pesanan</p>
            </div>
        </div>

        <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl flex-shrink-0">
                <i class="fa-solid fa-wallet"></i>
            </div>
            <div>
                <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Total Pembelian</span>
                <p class="text-xl font-extrabold text-slate-900">Rp {{ number_format($totalSpent, 0, ',', '.') }}</p>
            </div>
        </div>

        <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl flex-shrink-0">
                <i class="fa-solid fa-user-tag"></i>
            </div>
            <div>
                <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Status Akun</span>
                <p class="text-xl font-extrabold text-slate-900">{{ ucfirst(auth()->user()->role) }} Aktif</p>
            </div>
        </div>
    </div>

    <!-- Orders List -->
    @if($orders->count() > 0)
        <div class="space-y-4">
            @foreach($orders as $order)
                <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-5 sm:p-6 hover:border-orange-200 transition">
                    <div class="flex flex-col md:flex-row md:items-center justify-between pb-4 border-b border-slate-100 gap-3">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-orange-50 text-[#e8503a] flex items-center justify-center font-bold text-sm">
                                <i class="fa-solid fa-receipt"></i>
                            </div>
                            <div>
                                <h3 class="text-sm font-extrabold text-slate-900 font-mono">{{ $order->order_number }}</h3>
                                <p class="text-[11px] text-slate-400">{{ $order->created_at->format('d F Y, H:i') }} WIB</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <!-- Status Badges -->
                            <span class="px-3 py-1 rounded-full text-xs font-bold uppercase {{ $order->order_status === 'selesai' ? 'bg-emerald-100 text-emerald-800' : 'bg-orange-100 text-[#e8503a]' }}">
                                {{ ucfirst($order->order_status) }}
                            </span>

                            <span class="px-3 py-1 rounded-full text-xs font-semibold uppercase bg-slate-100 text-slate-700">
                                {{ strtoupper($order->payment_method) }}
                            </span>
                        </div>
                    </div>

                    <!-- Items Summary -->
                    <div class="py-4 grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                        <div class="md:col-span-8 space-y-1">
                            <p class="text-xs font-semibold text-slate-700">Rincian Menu:</p>
                            <div class="flex flex-wrap gap-2 pt-1">
                                @foreach($order->items as $item)
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl bg-slate-50 border border-slate-200 text-xs text-slate-700">
                                        <span class="font-bold text-[#e8503a]">{{ $item->quantity }}x</span>
                                        <span>{{ $item->menu_name }}</span>
                                    </span>
                                @endforeach
                            </div>
                        </div>

                        <div class="md:col-span-4 flex flex-col sm:flex-row md:flex-col sm:items-end justify-between gap-3">
                            <div>
                                <span class="text-[11px] text-slate-400 block sm:text-right">Total Transaksi:</span>
                                <span class="text-base font-black text-[#e8503a] block sm:text-right">
                                    Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                </span>
                            </div>

                            <!-- Button to View Struk Diri Sendiri (Rule 5) -->
                            <a 
                                href="{{ route('order.receipt', $order->id) }}" 
                                class="btn-brand px-4 py-2 rounded-xl text-xs font-bold flex items-center justify-center gap-1.5 shadow-sm"
                            >
                                <i class="fa-solid fa-receipt text-xs"></i>
                                <span>Lihat Struk</span>
                            </a>
                        </div>
                    </div>

                </div>
            @endforeach

            <!-- Pagination -->
            <div class="mt-6">
                {{ $orders->links() }}
            </div>
        </div>
    @else
        <div class="bg-white rounded-3xl border border-slate-100 p-12 text-center max-w-md mx-auto shadow-sm">
            <div class="w-16 h-16 rounded-full bg-orange-50 text-[#e8503a] flex items-center justify-center mx-auto mb-4 text-2xl">
                <i class="fa-solid fa-receipt"></i>
            </div>
            <h3 class="text-base font-bold text-slate-800">Belum Ada Riwayat Transaksi</h3>
            <p class="text-xs text-slate-500 mt-1">Anda belum melakukan pemesanan makanan. Pesan menu pertama Anda sekarang!</p>
            <div class="mt-5">
                <a href="{{ route('menu.index') }}" class="btn-brand px-5 py-2.5 rounded-full text-xs font-bold tracking-wide inline-flex items-center gap-1.5 shadow-sm">
                    <i class="fa-solid fa-utensils"></i>
                    <span>Mulai Memesan</span>
                </a>
            </div>
        </div>
    @endif

</div>
@endsection
