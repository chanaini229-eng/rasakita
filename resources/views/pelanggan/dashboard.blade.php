@extends('layouts.app')

@section('title', 'RasaKita - Pesan Makanan Favoritmu dengan Mudah')

@section('content')

    <!-- HERO SECTION (Matches Screenshot Exactly) -->
    <section class="relative bg-gradient-to-r from-[#2a1b18] via-[#3d2722] to-[#1e1310] text-white py-12 lg:py-16 overflow-hidden">
        <!-- Background Food Texture Overlay -->
        <div class="absolute inset-0 opacity-15 bg-[radial-gradient(#e8503a_1px,transparent_1px)] [background-size:16px_16px]"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
                
                <!-- Left Hero Text & Search Box -->
                <div class="lg:col-span-7 space-y-6">
                    <!-- Tagline pill -->
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-orange-500/20 text-orange-300 text-xs font-semibold tracking-wide border border-orange-500/30">
                        <i class="fa-solid fa-fire-flame-curved text-orange-400"></i>
                        <span>Makanan Enak, Langsung ke Rumah</span>
                    </div>

                    <!-- Main Heading -->
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight leading-tight">
                        Pesan Makanan Favoritmu <br class="hidden sm:inline">
                        <span class="text-[#e8503a]">dengan Mudah!</span>
                    </h1>

                    <!-- Description -->
                    <p class="text-slate-300 text-sm sm:text-base leading-relaxed max-w-xl">
                        Nikmati berbagai pilihan menu lezat dengan harga terbaik. Kami siap mengantarkan hidangan hangat dan fresh ke lokasi kamu.
                    </p>

                    <!-- Search Input Box (As seen in the screenshot) -->
                    <form action="{{ route('home') }}" method="GET" class="pt-2 max-w-xl">
                        <div class="relative flex items-center bg-white rounded-full p-1.5 shadow-2xl border border-slate-100">
                            <div class="pl-4 text-slate-400">
                                <i class="fa-solid fa-magnifying-glass text-sm"></i>
                            </div>
                            <input 
                                type="text" 
                                name="cari" 
                                value="{{ request('cari') }}" 
                                placeholder="Cari makanan, minuman, atau kategori..." 
                                class="w-full pl-3 pr-4 py-2.5 text-xs sm:text-sm text-slate-800 placeholder-slate-400 bg-transparent focus:outline-none rounded-full"
                            >
                            <button type="submit" class="btn-brand px-6 py-2.5 rounded-full text-xs sm:text-sm font-bold tracking-wide flex-shrink-0">
                                Cari
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Right Hero Image with Floating Badge -->
                <div class="lg:col-span-5 relative flex justify-center lg:justify-end">
                    <div class="relative w-full max-w-md">
                        <!-- Hero Image Frame -->
                        <div class="relative rounded-3xl overflow-hidden shadow-2xl border-4 border-white/10 group">
                            <img 
                                src="https://images.unsplash.com/photo-1626082927389-6cd097cdc6ec?auto=format&fit=crop&w=800&q=80" 
                                alt="Ayam Geprek dan Nasi Hangat RasaKita" 
                                class="w-full h-72 sm:h-80 object-cover transform group-hover:scale-105 transition-transform duration-500"
                            >
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                        </div>

                        <!-- Floating Badge "Rasa Lezat Setiap Saat" (As seen in the screenshot) -->
                        <div class="absolute -top-3 -right-3 sm:-right-4 bg-[#2b1810]/90 backdrop-blur-md border border-orange-500/40 text-white px-4 py-2.5 rounded-2xl shadow-xl flex items-center gap-3">
                            <div class="w-8 h-8 rounded-xl bg-[#e8503a] text-white flex items-center justify-center text-xs shadow-md">
                                <i class="fa-solid fa-star"></i>
                            </div>
                            <div>
                                <p class="text-[10px] text-orange-200 uppercase tracking-wider font-semibold">Jaminan Kualitas</p>
                                <p class="text-xs font-bold text-white">Rasa Lezat Setiap Saat</p>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- CATEGORY FILTER PILLS (Matches Screenshot) -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-6 sm:-mt-8 relative z-20">
        <div class="bg-white rounded-2xl sm:rounded-3xl p-3 sm:p-4 shadow-xl border border-slate-100/80">
            <div class="flex items-center gap-3 overflow-x-auto pb-1 scrollbar-none justify-start md:justify-center">
                
                <!-- Pill: Semua -->
                <a 
                    href="{{ route('home', ['cari' => request('cari')]) }}" 
                    class="category-pill flex flex-col items-center justify-center min-w-[76px] sm:min-w-[88px] py-2.5 px-3 rounded-2xl border text-center {{ empty($selectedCategory) || $selectedCategory === 'semua' ? 'active' : 'bg-white border-slate-200 text-slate-700' }}"
                >
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center mb-1 text-base {{ empty($selectedCategory) || $selectedCategory === 'semua' ? 'text-white' : 'text-[#e8503a] bg-orange-50' }}">
                        <i class="fa-solid fa-border-all"></i>
                    </div>
                    <span class="text-xs font-bold">Semua</span>
                </a>

                <!-- Pill: Ayam -->
                <a 
                    href="{{ route('home', ['kategori' => 'ayam', 'cari' => request('cari')]) }}" 
                    class="category-pill flex flex-col items-center justify-center min-w-[76px] sm:min-w-[88px] py-2.5 px-3 rounded-2xl border text-center {{ $selectedCategory === 'ayam' ? 'active' : 'bg-white border-slate-200 text-slate-700' }}"
                >
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center mb-1 text-base {{ $selectedCategory === 'ayam' ? 'text-white' : 'text-[#e8503a] bg-orange-50' }}">
                        <i class="fa-solid fa-drumstick-bite"></i>
                    </div>
                    <span class="text-xs font-bold">Ayam</span>
                </a>

                <!-- Pill: Nasi -->
                <a 
                    href="{{ route('home', ['kategori' => 'nasi', 'cari' => request('cari')]) }}" 
                    class="category-pill flex flex-col items-center justify-center min-w-[76px] sm:min-w-[88px] py-2.5 px-3 rounded-2xl border text-center {{ $selectedCategory === 'nasi' ? 'active' : 'bg-white border-slate-200 text-slate-700' }}"
                >
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center mb-1 text-base {{ $selectedCategory === 'nasi' ? 'text-white' : 'text-[#e8503a] bg-orange-50' }}">
                        <i class="fa-solid fa-bowl-rice"></i>
                    </div>
                    <span class="text-xs font-bold">Nasi</span>
                </a>

                <!-- Pill: Mie -->
                <a 
                    href="{{ route('home', ['kategori' => 'mie', 'cari' => request('cari')]) }}" 
                    class="category-pill flex flex-col items-center justify-center min-w-[76px] sm:min-w-[88px] py-2.5 px-3 rounded-2xl border text-center {{ $selectedCategory === 'mie' ? 'active' : 'bg-white border-slate-200 text-slate-700' }}"
                >
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center mb-1 text-base {{ $selectedCategory === 'mie' ? 'text-white' : 'text-[#e8503a] bg-orange-50' }}">
                        <i class="fa-solid fa-bowl-food"></i>
                    </div>
                    <span class="text-xs font-bold">Mie</span>
                </a>

                <!-- Pill: Minuman -->
                <a 
                    href="{{ route('home', ['kategori' => 'minuman', 'cari' => request('cari')]) }}" 
                    class="category-pill flex flex-col items-center justify-center min-w-[76px] sm:min-w-[88px] py-2.5 px-3 rounded-2xl border text-center {{ $selectedCategory === 'minuman' ? 'active' : 'bg-white border-slate-200 text-slate-700' }}"
                >
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center mb-1 text-base {{ $selectedCategory === 'minuman' ? 'text-white' : 'text-[#e8503a] bg-orange-50' }}">
                        <i class="fa-solid fa-mug-hot"></i>
                    </div>
                    <span class="text-xs font-bold">Minuman</span>
                </a>

                <!-- Pill: Cemilan -->
                <a 
                    href="{{ route('home', ['kategori' => 'cemilan', 'cari' => request('cari')]) }}" 
                    class="category-pill flex flex-col items-center justify-center min-w-[76px] sm:min-w-[88px] py-2.5 px-3 rounded-2xl border text-center {{ $selectedCategory === 'cemilan' ? 'active' : 'bg-white border-slate-200 text-slate-700' }}"
                >
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center mb-1 text-base {{ $selectedCategory === 'cemilan' ? 'text-white' : 'text-[#e8503a] bg-orange-50' }}">
                        <i class="fa-solid fa-cookie-bite"></i>
                    </div>
                    <span class="text-xs font-bold">Cemilan</span>
                </a>

            </div>
        </div>
    </section>

    <!-- SECTION: MENU POPULER (Matches the 5 Cards in Screenshot) -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-12">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">Menu Populer</h2>
                <p class="text-xs text-slate-500 mt-0.5">Paling sering dipesan oleh pelanggan RasaKita</p>
            </div>
            <a href="{{ route('menu.index') }}" class="text-xs sm:text-sm font-bold text-[#e8503a] hover:text-[#c2410c] flex items-center gap-1 transition">
                <span>Lihat Semua</span>
                <i class="fa-solid fa-arrow-right text-xs"></i>
            </a>
        </div>

        <!-- 5 Menu Cards Grid (Ayam Geprek, Nasi Goreng, Mie Ayam Bakso, Es Teh, Pisang Goreng) -->
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 sm:gap-5">
            @forelse($popularMenus as $menu)
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-all duration-200 flex flex-col overflow-hidden group">
                    <!-- Image -->
                    <div class="relative h-36 sm:h-40 overflow-hidden bg-slate-100">
                        <img 
                            src="{{ $menu->image }}" 
                            alt="{{ $menu->name }}" 
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                            loading="lazy"
                        >
                        <span class="absolute top-2 left-2 bg-black/60 backdrop-blur-md text-white text-[10px] font-semibold px-2 py-0.5 rounded-full">
                            {{ $menu->category->name }}
                        </span>
                    </div>

                    <!-- Content -->
                    <div class="p-3.5 flex flex-col flex-grow justify-between space-y-2.5">
                        <div>
                            <h3 class="text-xs sm:text-sm font-bold text-slate-800 line-clamp-1 group-hover:text-[#e8503a] transition-colors" title="{{ $menu->name }}">
                                {{ $menu->name }}
                            </h3>
                            <p class="text-sm font-extrabold text-[#e8503a] mt-1">
                                {{ $menu->formatted_price }}
                            </p>
                        </div>

                        <!-- Rating & Reviews -->
                        <div class="flex items-center gap-1 text-[11px] text-slate-500">
                            <i class="fa-solid fa-star text-amber-400 text-xs"></i>
                            <span class="font-bold text-slate-700">{{ $menu->rating }}</span>
                            <span class="text-slate-400">({{ $menu->reviews_count }})</span>
                        </div>

                        <!-- Button: + Tambah (Customer Action - No Edit/Delete) -->
                        <button 
                            type="button" 
                            onclick="addToCart({{ $menu->id }}, '{{ addslashes($menu->name) }}')"
                            class="w-full btn-brand py-2 px-3 rounded-xl text-xs font-bold flex items-center justify-center gap-1.5 shadow-sm active:scale-95"
                        >
                            <i class="fa-solid fa-plus text-[10px]"></i>
                            <span>Tambah</span>
                        </button>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-8 text-center text-slate-400 text-xs">
                    Belum ada menu populer yang tersedia.
                </div>
            @endforelse
        </div>
    </section>

    <!-- SECTION: DAFTAR MENU FILTERED (Semua / Kategori yang dipilih) -->
    @if(request('kategori') || request('cari'))
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-12">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">
                    Hasil Pencarian: 
                    <span class="text-[#e8503a]">
                        {{ request('cari') ? '"' . request('cari') . '"' : (ucfirst(request('kategori')) ?? 'Semua') }}
                    </span>
                </h2>
                <p class="text-xs text-slate-500 mt-0.5">Ditemukan {{ $allMenus->count() }} menu pilihan</p>
            </div>
            <a href="{{ route('home') }}" class="text-xs font-semibold text-slate-500 hover:text-[#e8503a]">Reset Filter</a>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 sm:gap-5">
            @forelse($allMenus as $menu)
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-all flex flex-col overflow-hidden group">
                    <div class="relative h-36 sm:h-40 overflow-hidden bg-slate-100">
                        <img src="{{ $menu->image }}" alt="{{ $menu->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform">
                        <span class="absolute top-2 left-2 bg-black/60 text-white text-[10px] font-semibold px-2 py-0.5 rounded-full">
                            {{ $menu->category->name }}
                        </span>
                    </div>
                    <div class="p-3.5 flex flex-col flex-grow justify-between space-y-2.5">
                        <div>
                            <h3 class="text-xs sm:text-sm font-bold text-slate-800 line-clamp-1">{{ $menu->name }}</h3>
                            <p class="text-sm font-extrabold text-[#e8503a] mt-1">{{ $menu->formatted_price }}</p>
                        </div>
                        <div class="flex items-center gap-1 text-[11px] text-slate-500">
                            <i class="fa-solid fa-star text-amber-400 text-xs"></i>
                            <span class="font-bold text-slate-700">{{ $menu->rating }}</span>
                            <span class="text-slate-400">({{ $menu->reviews_count }})</span>
                        </div>
                        <button 
                            type="button" 
                            onclick="addToCart({{ $menu->id }}, '{{ addslashes($menu->name) }}')"
                            class="w-full btn-brand py-2 px-3 rounded-xl text-xs font-bold flex items-center justify-center gap-1.5 shadow-sm active:scale-95"
                        >
                            <i class="fa-solid fa-plus text-[10px]"></i>
                            <span>Tambah</span>
                        </button>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-12 text-center bg-white rounded-2xl border border-slate-200">
                    <i class="fa-solid fa-utensils text-4xl text-slate-300 mb-3"></i>
                    <p class="text-sm font-bold text-slate-700">Menu tidak ditemukan</p>
                    <p class="text-xs text-slate-400 mt-1">Coba gunakan kata kunci lain atau pilih kategori berbeda.</p>
                </div>
            @endforelse
        </div>
    </section>
    @endif

    <!-- SECTION: 4 FEATURES VALUE PROPOSITION (Matches Screenshot) -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-16">
        <div class="bg-gradient-to-r from-orange-50/60 via-white to-orange-50/60 rounded-3xl p-6 sm:p-8 border border-orange-100/70 shadow-sm">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
                
                <!-- Feature 1: Pengiriman Cepat -->
                <div class="flex flex-col items-center space-y-2 group">
                    <div class="w-14 h-14 rounded-2xl bg-[#fff1ee] text-[#e8503a] flex items-center justify-center text-xl shadow-sm group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-truck-fast"></i>
                    </div>
                    <h4 class="text-xs sm:text-sm font-bold text-slate-800">Pengiriman Cepat</h4>
                    <p class="text-[11px] text-slate-500">Pesanan sampai tepat waktu & hangat</p>
                </div>

                <!-- Feature 2: Makanan Terjamin -->
                <div class="flex flex-col items-center space-y-2 group">
                    <div class="w-14 h-14 rounded-2xl bg-[#fff1ee] text-[#e8503a] flex items-center justify-center text-xl shadow-sm group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-shield-heart"></i>
                    </div>
                    <h4 class="text-xs sm:text-sm font-bold text-slate-800">Makanan Terjamin</h4>
                    <p class="text-[11px] text-slate-500">Fresh, bersih dan berkualitas higienis</p>
                </div>

                <!-- Feature 3: Pembayaran Mudah -->
                <div class="flex flex-col items-center space-y-2 group">
                    <div class="w-14 h-14 rounded-2xl bg-[#fff1ee] text-[#e8503a] flex items-center justify-center text-xl shadow-sm group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-wallet"></i>
                    </div>
                    <h4 class="text-xs sm:text-sm font-bold text-slate-800">Pembayaran Mudah</h4>
                    <p class="text-[11px] text-slate-500">Banyak metode (QRIS, Bank, Tunai)</p>
                </div>

                <!-- Feature 4: CS 24 Jam -->
                <div class="flex flex-col items-center space-y-2 group">
                    <div class="w-14 h-14 rounded-2xl bg-[#fff1ee] text-[#e8503a] flex items-center justify-center text-xl shadow-sm group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-headset"></i>
                    </div>
                    <h4 class="text-xs sm:text-sm font-bold text-slate-800">CS 24 Jam</h4>
                    <p class="text-[11px] text-slate-500">Siap membantu kelancaran pesanan</p>
                </div>

            </div>
        </div>
    </section>

    <!-- SECTION: TENTANG KAMI TEASER (Matches Screenshot Banner) -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-16 mb-6">
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 sm:p-8 lg:p-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                
                <!-- Left Image: Fresh food / Salad bowl -->
                <div class="lg:col-span-5">
                    <div class="rounded-2xl overflow-hidden shadow-md">
                        <img 
                            src="https://images.unsplash.com/photo-1540420773420-3366772f4999?auto=format&fit=crop&w=700&q=80" 
                            alt="Fresh Food RasaKita" 
                            class="w-full h-64 sm:h-72 object-cover"
                        >
                    </div>
                </div>

                <!-- Right Text Content -->
                <div class="lg:col-span-7 space-y-4">
                    <div class="inline-block px-3 py-1 rounded-full bg-orange-100 text-[#e8503a] text-[11px] font-bold uppercase tracking-wider">
                        Tentang Kami
                    </div>
                    <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900 leading-snug">
                        Rasa Terbaik untuk Setiap Momen
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                        RasaKita hadir untuk memberikan pengalaman memesan makanan yang mudah, cepat, dan terpercaya. Kami menyajikan berbagai menu pilihan dengan cita rasa lezat yang selalu fresh setiap hari dari dapur para koki berpengalaman kami.
                    </p>
                    <div class="pt-2">
                        <a href="{{ route('about') }}" class="btn-brand inline-flex items-center gap-2 px-6 py-2.5 rounded-full text-xs sm:text-sm font-bold tracking-wide shadow-sm">
                            <span>Pelajari Lebih Lanjut</span>
                            <i class="fa-solid fa-arrow-right text-xs"></i>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection
