@extends('layouts.app')

@section('title', 'Struk Pemesanan - ' . $order->order_number)

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 py-8 sm:py-12">

    <!-- Actions Bar (Hidden on print) -->
    <div class="no-print flex flex-wrap items-center justify-between gap-4 mb-6">
        <div>
            <nav class="flex items-center gap-2 text-xs text-slate-400 mb-1">
                <a href="{{ route('home') }}" class="hover:text-[#e8503a]">Beranda</a>
                <i class="fa-solid fa-chevron-right text-[10px]"></i>
                <a href="{{ route('order.history') }}" class="hover:text-[#e8503a]">Riwayat</a>
                <i class="fa-solid fa-chevron-right text-[10px]"></i>
                <span class="text-slate-700 font-semibold">Struk {{ $order->order_number }}</span>
            </nav>
            <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900">Struk Pemesanan</h1>
        </div>

        <div class="flex items-center gap-2">
            <button 
                onclick="window.print()" 
                class="px-4 py-2 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold transition flex items-center gap-2 shadow-sm"
            >
                <i class="fa-solid fa-print"></i>
                <span>Cetak Struk</span>
            </button>
            <a 
                href="{{ route('order.history') }}" 
                class="px-4 py-2 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-xs font-bold transition flex items-center gap-1.5"
            >
                <i class="fa-solid fa-list-check"></i>
                <span>Riwayat Saya</span>
            </a>
        </div>
    </div>

    <!-- Success Banner (Rule 5 requirement: Menampilkan struk setelah melakukan transaksi) -->
    <div class="no-print mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs flex items-center gap-3 shadow-sm">
        <div class="w-8 h-8 rounded-full bg-emerald-500 text-white flex items-center justify-center flex-shrink-0 text-sm">
            <i class="fa-solid fa-check"></i>
        </div>
        <div>
            <p class="font-bold text-sm">Transaksi Anda Telah Berhasil!</p>
            <p class="text-emerald-700">Terima kasih atas pesanan Anda. Dapur kami sedang memproses hidangan lezat untuk Anda.</p>
        </div>
    </div>

    <!-- Thermal / Modern Printable Receipt Card -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-xl overflow-hidden p-6 sm:p-10 relative">
        
        <!-- Watermark / Background Accent -->
        <div class="absolute -right-8 -top-8 text-slate-50 text-9xl font-black pointer-events-none select-none">
            <i class="fa-solid fa-utensils"></i>
        </div>

        <!-- Receipt Header -->
        <div class="text-center pb-6 border-b-2 border-dashed border-slate-200 relative z-10">
            <div class="w-12 h-12 rounded-2xl bg-[#fff1ee] text-[#e8503a] flex items-center justify-center mx-auto mb-2 text-2xl font-bold">
                <i class="fa-solid fa-kitchen-set"></i>
            </div>
            <h2 class="text-2xl font-black text-slate-900 tracking-tight">Rasa<span class="text-[#e8503a]">Kita</span></h2>
            <p class="text-xs text-slate-400 font-medium">Pusat Makanan, Nikmati Rasanya</p>
            <p class="text-[11px] text-slate-500 mt-1">Jl. Rasa Nusantara No. 88, Jakarta Selatan • Telp: 0812-3456-7890</p>
        </div>

        <!-- Order Meta Details -->
        <div class="py-5 border-b border-slate-100 text-xs text-slate-600 grid grid-cols-2 gap-3">
            <div>
                <span class="text-slate-400 block text-[10px] uppercase tracking-wider">Nomor Nota / Struk</span>
                <span class="font-extrabold text-slate-900 font-mono text-sm">{{ $order->order_number }}</span>
            </div>
            <div class="text-right">
                <span class="text-slate-400 block text-[10px] uppercase tracking-wider">Tanggal & Waktu</span>
                <span class="font-bold text-slate-800">{{ $order->created_at->format('d M Y, H:i') }} WIB</span>
            </div>
            <div>
                <span class="text-slate-400 block text-[10px] uppercase tracking-wider">Pelanggan</span>
                <span class="font-bold text-slate-900">{{ $order->customer_name }}</span>
                <span class="text-slate-500 block text-[11px]">{{ $order->customer_phone }}</span>
            </div>
            <div class="text-right">
                <span class="text-slate-400 block text-[10px] uppercase tracking-wider">Metode Bayar</span>
                <span class="inline-block px-2 py-0.5 rounded-md font-bold text-[11px] uppercase {{ $order->payment_method === 'qris' ? 'bg-orange-100 text-orange-800' : 'bg-slate-100 text-slate-800' }}">
                    {{ strtoupper($order->payment_method) }}
                </span>
            </div>
            <div class="col-span-2 pt-1">
                <span class="text-slate-400 block text-[10px] uppercase tracking-wider">Tujuan Pengantaran / Meja</span>
                <span class="font-medium text-slate-800">{{ $order->customer_address }}</span>
            </div>
            @if($order->notes)
                <div class="col-span-2 bg-slate-50 p-2.5 rounded-xl border border-slate-100">
                    <span class="text-slate-400 block text-[10px] uppercase tracking-wider">Catatan Pesanan:</span>
                    <span class="text-slate-700 italic text-[11px]">{{ $order->notes }}</span>
                </div>
            @endif
        </div>

        <!-- Order Items Table -->
        <div class="py-5">
            <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Rincian Menu Dipesan</h4>
            <div class="divide-y divide-slate-100">
                @foreach($order->items as $item)
                    <div class="py-2.5 flex items-start justify-between text-xs">
                        <div class="space-y-0.5">
                            <p class="font-bold text-slate-800">{{ $item->menu_name }}</p>
                            <p class="text-slate-400 text-[11px]">
                                {{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}
                            </p>
                            @if($item->notes)
                                <p class="text-[10px] text-amber-600 italic">({{ $item->notes }})</p>
                            @endif
                        </div>
                        <span class="font-bold text-slate-900">
                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Totals & Payment Summary -->
        <div class="pt-4 border-t-2 border-dashed border-slate-200 space-y-2 text-xs">
            <div class="flex justify-between text-slate-600">
                <span>Subtotal Menu</span>
                <span class="font-bold text-slate-800">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between text-slate-600">
                <span>Biaya Pengantaran / Layanan</span>
                <span class="font-bold text-slate-800">Rp {{ number_format($order->delivery_fee, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between text-base font-black text-slate-900 pt-3 border-t border-slate-100">
                <span>TOTAL TRANSAKSI</span>
                <span class="text-[#e8503a]">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between items-center pt-2">
                <span class="text-[11px] text-slate-500">Status Pembayaran:</span>
                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $order->payment_status === 'paid' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                    {{ $order->payment_status === 'paid' ? 'LUNAS' : 'MENUNGGU PEMBAYARAN' }}
                </span>
            </div>
        </div>

        <!-- Receipt Footer Note -->
        <div class="text-center pt-8 mt-6 border-t border-slate-100 text-slate-400 text-[11px] space-y-1">
            <p class="font-bold text-slate-600">Terima kasih atas kunjungan Anda!</p>
            <p>Struk ini sah sebagai bukti pembayaran resmi RasaKita.</p>
            <p class="text-[10px]">Simpan struk ini untuk pengecekan pesanan Anda.</p>
        </div>

    </div>

    <!-- Back to Home / Order More -->
    <div class="no-print mt-8 text-center space-x-4">
        <a href="{{ route('home') }}" class="btn-brand px-6 py-2.5 rounded-full text-xs font-bold tracking-wide inline-flex items-center gap-1.5 shadow-sm">
            <i class="fa-solid fa-house text-xs"></i>
            <span>Kembali ke Beranda</span>
        </a>
        <a href="{{ route('menu.index') }}" class="px-6 py-2.5 rounded-full border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-xs font-bold inline-flex items-center gap-1.5">
            <i class="fa-solid fa-plus text-xs"></i>
            <span>Pesan Menu Lain</span>
        </a>
    </div>

</div>
@endsection
