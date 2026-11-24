@extends('layouts.app')

@section('title', 'Daftar Menu - RasaKita')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">

    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
        <div>
            <nav class="flex items-center gap-2 text-xs text-slate-400 mb-2">
                <a href="{{ route('home') }}" class="hover:text-[#e8503a]">Beranda</a>
                <i class="fa-solid fa-chevron-right text-[10px]"></i>
                <span class="text-slate-700 font-semibold">Daftar Menu</span>
            </nav>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Daftar Menu Pilihan</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Pilih hidangan lezat dan tambahkan ke keranjang pesanan Anda</p>
        </div>

        <!-- Role Pelanggan Notice Badge -->
        <div class="inline-flex items-center gap-2 bg-amber-50 border border-amber-200 text-amber-800 px-4 py-2 rounded-2xl text-xs font-medium">
            <i class="fa-solid fa-lock text-amber-500"></i>
            <div>
                <span class="font-bold">Role Pelanggan:</span>
                <span>Mode Pemesanan (Tidak dapat menambah, mengedit, atau menghapus menu)</span>
            </div>
        </div>
    </div>

    <!-- Filter & Search Bar -->
    <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-sm mb-8">
        <form action="{{ route('menu.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-3 items-center">
            
            <!-- Search Keyword -->
            <div class="md:col-span-5 relative">
                <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                <input 
                    type="text" 
                    name="cari" 
                    value="{{ request('cari') }}" 
                    placeholder="Cari nama makanan atau minuman..." 
                    class="w-full pl-9 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500"
                >
            </div>

            <!-- Category Selector -->
            <div class="md:col-span-4">
                <select 
                    name="kategori" 
                    class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500"
                >
                    <option value="semua">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->slug }}" {{ request('kategori') === $cat->slug ? 'selected' : '' }}>
                            {{ $cat->name }} ({{ $cat->menus_count }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Sort Selector -->
            <div class="md:col-span-2">
                <select 
                    name="urutan" 
                    class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500"
                >
                    <option value="default" {{ request('urutan') === 'default' ? 'selected' : '' }}>Urutan Terbaru</option>
                    <option value="termurah" {{ request('urutan') === 'termurah' ? 'selected' : '' }}>Harga Termurah</option>
                    <option value="termahal" {{ request('urutan') === 'termahal' ? 'selected' : '' }}>Harga Termahal</option>
                    <option value="rating" {{ request('urutan') === 'rating' ? 'selected' : '' }}>Rating Tertinggi</option>
                </select>
            </div>

            <!-- Submit Button -->
            <div class="md:col-span-1">
                <button type="submit" class="w-full btn-brand py-2.5 rounded-xl text-xs font-bold tracking-wide flex items-center justify-center gap-1">
                    <i class="fa-solid fa-filter text-[11px]"></i>
                    <span>Filter</span>
                </button>
            </div>

        </form>
    </div>

    <!-- Menus Grid -->
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-4 gap-5">
        @forelse($menus as $menu)
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-all flex flex-col overflow-hidden group">
                <!-- Image -->
                <div class="relative h-44 overflow-hidden bg-slate-100">
                    <img 
                        src="{{ $menu->image }}" 
                        alt="{{ $menu->name }}" 
                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                    >
                    <span class="absolute top-2.5 left-2.5 bg-black/60 backdrop-blur-md text-white text-[10px] font-semibold px-2.5 py-0.5 rounded-full">
                        {{ $menu->category->name }}
                    </span>
                    @if($menu->is_popular)
                        <span class="absolute top-2.5 right-2.5 bg-[#e8503a] text-white text-[10px] font-bold px-2 py-0.5 rounded-full shadow-sm">
                            Populer
                        </span>
                    @endif
                </div>

                <!-- Info -->
                <div class="p-4 flex flex-col flex-grow justify-between space-y-3">
                    <div>
                        <h3 class="text-sm font-bold text-slate-800 line-clamp-1 group-hover:text-[#e8503a] transition-colors">
                            {{ $menu->name }}
                        </h3>
                        <p class="text-[11px] text-slate-500 line-clamp-2 mt-1 leading-relaxed">
                            {{ $menu->description }}
                        </p>
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-base font-extrabold text-[#e8503a]">
                                {{ $menu->formatted_price }}
                            </span>
                            <div class="flex items-center gap-1 text-[11px] text-slate-500">
                                <i class="fa-solid fa-star text-amber-400 text-xs"></i>
                                <span class="font-bold text-slate-700">{{ $menu->rating }}</span>
                            </div>
                        </div>

                        <!-- Action Button: Tambah ke Keranjang (Pelanggan only adds to cart, NO edit/delete) -->
                        <button 
                            type="button" 
                            onclick="addToCart({{ $menu->id }}, '{{ addslashes($menu->name) }}')"
                            class="w-full btn-brand py-2.5 px-3 rounded-xl text-xs font-bold flex items-center justify-center gap-1.5 shadow-sm active:scale-95"
                        >
                            <i class="fa-solid fa-cart-plus text-xs"></i>
                            <span>Tambah Pesanan</span>
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-16 text-center bg-white rounded-3xl border border-slate-200">
                <div class="w-16 h-16 rounded-full bg-orange-50 text-[#e8503a] flex items-center justify-center mx-auto mb-4 text-2xl">
                    <i class="fa-solid fa-utensils"></i>
                </div>
                <h3 class="text-base font-bold text-slate-800">Tidak ada menu yang sesuai</h3>
                <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">Silakan coba kata kunci lain atau ubah kategori filter.</p>
                <a href="{{ route('menu.index') }}" class="inline-block mt-4 text-xs font-bold text-[#e8503a] hover:underline">
                    Reset Filter
                </a>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-10">
        {{ $menus->links() }}
    </div>

</div>
@endsection
