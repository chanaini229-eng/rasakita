@extends('layouts.app')

@section('title', 'Keranjang Pesanan - RasaKita')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">

    <div class="flex items-center justify-between mb-8">
        <div>
            <nav class="flex items-center gap-2 text-xs text-slate-400 mb-2">
                <a href="{{ route('home') }}" class="hover:text-[#e8503a]">Beranda</a>
                <i class="fa-solid fa-chevron-right text-[10px]"></i>
                <span class="text-slate-700 font-semibold">Keranjang Pesanan</span>
            </nav>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Keranjang Pesanan Anda</h1>
        </div>
        @if(count($cart) > 0)
            <form action="{{ route('cart.clear') }}" method="POST" onsubmit="return confirm('Kosongkan semua pesanan di keranjang?')">
                @csrf
                <button type="submit" class="text-xs font-semibold text-rose-600 hover:text-rose-700 hover:underline flex items-center gap-1.5">
                    <i class="fa-regular fa-trash-can"></i>
                    <span>Kosongkan Keranjang</span>
                </button>
            </form>
        @endif
    </div>

    @if(count($cart) > 0)
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Items List -->
            <div class="lg:col-span-8 bg-white rounded-3xl border border-slate-100 shadow-sm p-4 sm:p-6 space-y-4">
                <div class="divide-y divide-slate-100">
                    @foreach($cart as $id => $item)
                        <div class="py-4 first:pt-0 last:pb-0 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                            <!-- Image & Details -->
                            <div class="flex items-center gap-4">
                                <img 
                                    src="{{ $item['image'] ?? 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=120' }}" 
                                    alt="{{ $item['name'] }}" 
                                    class="w-20 h-20 rounded-2xl object-cover bg-slate-100 flex-shrink-0"
                                >
                                <div>
                                    <span class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider">{{ $item['category'] }}</span>
                                    <h4 class="text-sm font-bold text-slate-800">{{ $item['name'] }}</h4>
                                    <p class="text-xs font-bold text-[#e8503a] mt-0.5">
                                        Rp {{ number_format($item['price'], 0, ',', '.') }}
                                    </p>
                                    @if(!empty($item['notes']))
                                        <p class="text-[11px] text-slate-400 italic mt-1">Catatan: {{ $item['notes'] }}</p>
                                    @endif
                                </div>
                            </div>

                            <!-- Quantity Stepper & Subtotal -->
                            <div class="flex items-center justify-between w-full sm:w-auto gap-6 sm:justify-end">
                                <!-- Stepper -->
                                <div class="flex items-center border border-slate-200 rounded-xl bg-slate-50 p-1">
                                    <form action="{{ route('cart.update') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="menu_id" value="{{ $id }}">
                                        <input type="hidden" name="quantity" value="{{ $item['quantity'] - 1 }}">
                                        <button type="submit" class="w-7 h-7 rounded-lg bg-white shadow-sm flex items-center justify-center text-slate-600 hover:text-rose-600 text-xs font-bold transition">
                                            -
                                        </button>
                                    </form>

                                    <span class="w-8 text-center text-xs font-bold text-slate-800">{{ $item['quantity'] }}</span>

                                    <form action="{{ route('cart.update') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="menu_id" value="{{ $id }}">
                                        <input type="hidden" name="quantity" value="{{ $item['quantity'] + 1 }}">
                                        <button type="submit" class="w-7 h-7 rounded-lg bg-white shadow-sm flex items-center justify-center text-slate-600 hover:text-emerald-600 text-xs font-bold transition">
                                            +
                                        </button>
                                    </form>
                                </div>

                                <!-- Subtotal for this item -->
                                <div class="text-right min-w-[90px]">
                                    <p class="text-[10px] text-slate-400">Subtotal</p>
                                    <p class="text-xs sm:text-sm font-extrabold text-slate-900">
                                        Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                                    </p>
                                </div>

                                <!-- Remove Button -->
                                <form action="{{ route('cart.remove') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="menu_id" value="{{ $id }}">
                                    <button type="submit" class="text-slate-400 hover:text-rose-500 transition p-1" title="Hapus menu ini">
                                        <i class="fa-solid fa-xmark text-sm"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Order Summary Sidebar -->
            <div class="lg:col-span-4 bg-white rounded-3xl border border-slate-100 shadow-sm p-6 space-y-5">
                <h3 class="text-base font-extrabold text-slate-900">Ringkasan Biaya</h3>

                <div class="space-y-3 text-xs text-slate-600 divide-y divide-slate-100">
                    <div class="flex justify-between pt-1">
                        <span>Total Harga Menu</span>
                        <span class="font-bold text-slate-800">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between pt-2">
                        <span>Ongkos Kirim / Layanan</span>
                        <span class="font-bold text-slate-800">Rp {{ number_format($deliveryFee, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between pt-3 text-sm font-extrabold text-slate-900">
                        <span>Total Pembayaran</span>
                        <span class="text-[#e8503a] text-base">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- Checkout CTA -->
                @auth
                    <a href="{{ route('order.checkout') }}" class="btn-brand w-full py-3.5 rounded-2xl text-xs sm:text-sm font-bold tracking-wide flex items-center justify-center gap-2 shadow-md">
                        <span>Lanjut ke Checkout</span>
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                @else
                    <div class="space-y-2">
                        <a href="{{ route('login') }}" class="btn-brand w-full py-3.5 rounded-2xl text-xs sm:text-sm font-bold tracking-wide flex items-center justify-center gap-2 shadow-md">
                            <i class="fa-solid fa-arrow-right-to-bracket text-xs"></i>
                            <span>Masuk untuk Checkout</span>
                        </a>
                        <p class="text-[11px] text-slate-400 text-center">Silakan masuk atau daftar sebagai Pelanggan untuk melanjutkan.</p>
                    </div>
                @endauth

                <div class="pt-2">
                    <a href="{{ route('menu.index') }}" class="block text-center text-xs font-semibold text-slate-500 hover:text-[#e8503a]">
                        <i class="fa-solid fa-arrow-left text-[10px] mr-1"></i> Tambah Menu Lain
                    </a>
                </div>
            </div>

        </div>
    @else
        <!-- Empty Cart State -->
        <div class="bg-white rounded-3xl border border-slate-100 p-12 text-center max-w-lg mx-auto shadow-sm">
            <div class="w-20 h-20 rounded-full bg-orange-50 text-[#e8503a] flex items-center justify-center mx-auto mb-4 text-3xl">
                <i class="fa-solid fa-basket-shopping"></i>
            </div>
            <h3 class="text-lg font-bold text-slate-800">Keranjang Anda Masih Kosong</h3>
            <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                Pilih aneka menu makanan dan minuman lezat khas RasaKita sekarang juga!
            </p>
            <div class="mt-6">
                <a href="{{ route('menu.index') }}" class="btn-brand px-6 py-2.5 rounded-full text-xs font-bold tracking-wide inline-flex items-center gap-2 shadow-sm">
                    <i class="fa-solid fa-utensils text-xs"></i>
                    <span>Jelajahi Menu</span>
                </a>
            </div>
        </div>
    @endif

</div>
@endsection
