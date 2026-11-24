@extends('layouts.app')
@section('title', 'Cetak Struk Pembayaran - ' . $order->order_number)

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 py-8 sm:py-12">
    <div class="no-print flex items-center justify-between gap-4 mb-6">
        <a href="{{ route('kasir.laporan.index') }}" class="px-4 py-2 rounded-xl border border-slate-200 bg-white text-slate-700 text-xs font-bold">
            ← Kembali ke Laporan Kasir
        </a>
        <button onclick="window.print()" class="btn-brand px-5 py-2.5 rounded-xl text-xs font-bold flex items-center gap-2 shadow-sm">
            <i class="fa-solid fa-print"></i> Cetak Struk Pembayaran
        </button>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200 shadow-xl p-6 sm:p-10">
        <div class="text-center pb-6 border-b-2 border-dashed border-slate-200">
            <h2 class="text-2xl font-black text-slate-900">Rasa<span class="text-[#e8503a]">Kita</span></h2>
            <p class="text-xs text-slate-400">Pusat Makanan, Nikmati Rasanya</p>
            <p class="text-[11px] text-slate-500 mt-1">Struk Resmi Pembayaran Kasir</p>
        </div>

        <div class="py-5 border-b border-slate-100 text-xs text-slate-600 grid grid-cols-2 gap-3">
            <div>
                <span class="text-slate-400 block text-[10px] uppercase">Nomor Invoice</span>
                <span class="font-extrabold text-slate-900 font-mono text-sm">{{ $order->order_number }}</span>
            </div>
            <div class="text-right">
                <span class="text-slate-400 block text-[10px] uppercase">Waktu Transaksi</span>
                <span class="font-bold text-slate-800">{{ $order->created_at->format('d M Y, H:i') }} WIB</span>
            </div>
            <div>
                <span class="text-slate-400 block text-[10px] uppercase">Pelanggan</span>
                <span class="font-bold text-slate-900">{{ $order->customer_name }} ({{ $order->customer_phone }})</span>
            </div>
            <div class="text-right">
                <span class="text-slate-400 block text-[10px] uppercase">Kasir Bertugas</span>
                <span class="font-bold text-slate-800">{{ auth()->user()->name }}</span>
            </div>
        </div>

        <div class="py-5 divide-y divide-slate-100 text-xs">
            @foreach($order->items as $item)
                <div class="py-2.5 flex justify-between">
                    <div>
                        <p class="font-bold text-slate-800">{{ $item->menu_name }}</p>
                        <p class="text-slate-400">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                    </div>
                    <span class="font-bold text-slate-900">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                </div>
            @endforeach
        </div>

        <div class="pt-4 border-t-2 border-dashed border-slate-200 space-y-2 text-xs">
            <div class="flex justify-between"><span>Subtotal</span><strong>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</strong></div>
            <div class="flex justify-between"><span>Biaya Layanan / Antar</span><strong>Rp {{ number_format($order->delivery_fee, 0, ',', '.') }}</strong></div>
            <div class="flex justify-between text-base font-black pt-2 border-t border-slate-100">
                <span>TOTAL BAYAR</span>
                <span class="text-[#e8503a]">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between pt-1">
                <span>Metode / Status</span>
                <strong>{{ strtoupper($order->payment_method) }} ({{ $order->payment_status === 'paid' ? 'LUNAS' : 'PENDING' }})</strong>
            </div>
        </div>
    </div>
</div>
@endsection