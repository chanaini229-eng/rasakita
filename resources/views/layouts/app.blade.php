<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'RasaKita - Pusat Makanan, Nikmati Rasanya')</title>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#fff7ed',
                            100: '#ffedd5',
                            200: '#fed7aa',
                            300: '#fdba74',
                            400: '#fb923c',
                            500: '#f97316',
                            600: '#ea580c',
                            700: '#c2410c',
                            800: '#9a3412',
                            900: '#7c2d12',
                        },
                        brand: {
                            orange: '#e8503a',
                            lightOrange: '#fff1ee',
                            warmBg: '#fef8f6',
                            dark: '#1e293b',
                            footer: '#111827',
                        }
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #fafbfc;
            color: #1e293b;
        }
        .btn-brand {
            background-color: #e8503a;
            color: #ffffff;
            transition: all 0.2s ease-in-out;
        }
        .btn-brand:hover {
            background-color: #d13e28;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(232, 80, 58, 0.35);
        }
        .text-brand {
            color: #e8503a;
        }
        .bg-brand-soft {
            background-color: #fff1ee;
        }
        .border-brand-soft {
            border-color: #ffdcd6;
        }
        .category-pill {
            transition: all 0.2s ease;
        }
        .category-pill.active {
            background-color: #e8503a;
            color: white;
            box-shadow: 0 4px 12px rgba(232, 80, 58, 0.3);
        }
        .category-pill:hover:not(.active) {
            background-color: #f8fafc;
            border-color: #cbd5e1;
        }
        @media print {
            .no-print {
                display: none !important;
            }
        }
    </style>
    @stack('styles')
</head>
<body class="min-h-screen flex flex-col bg-slate-50 antialiased">

    <!-- Top Pelanggan Account Switcher Bar -->
    <div class="no-print bg-slate-900 text-slate-300 text-xs py-1.5 px-4">
        <div class="max-w-7xl mx-auto flex flex-wrap items-center justify-between gap-2">
            <div class="flex items-center gap-2">
                <span class="inline-block w-2 h-2 rounded-full bg-emerald-400"></span>
                <span>Akun Aktif:</span>
                @auth
                    <span class="font-bold text-white px-2 py-0.5 rounded bg-orange-600">
                        PELANGGAN ({{ auth()->user()->name }})
                    </span>
                    <span class="text-orange-300 italic hidden sm:inline">• Menu Read-Only & Riwayat Transaksi Diri Sendiri</span>
                @else
                    <span class="font-bold text-amber-300 px-2 py-0.5 rounded bg-slate-800">Tamu / Belum Login</span>
                @endauth
            </div>
            <div class="flex items-center gap-2">
                <span class="text-slate-400">Ganti Akun Pelanggan:</span>
                <a href="{{ route('quick.login', 'pelanggan') }}" class="px-2.5 py-0.5 rounded bg-orange-600 hover:bg-orange-500 text-white font-medium transition">
                    <i class="fa-solid fa-user-check mr-1"></i> Pelanggan 1 (Budi)
                </a>
                <a href="{{ route('quick.login', 'siti') }}" class="px-2.5 py-0.5 rounded bg-slate-700 hover:bg-slate-600 text-white font-medium transition">
                    <i class="fa-solid fa-user mr-1"></i> Pelanggan 2 (Siti)
                </a>
            </div>
        </div>
    </div>

    <!-- Main Navigation Bar -->
    <header class="no-print sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-slate-100 shadow-sm transition-all">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Brand Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <div class="w-11 h-11 rounded-2xl bg-orange-500/10 flex items-center justify-center text-orange-600 border border-orange-200/50 group-hover:scale-105 transition-transform">
                        <i class="fa-solid fa-kitchen-set text-2xl text-[#e8503a]"></i>
                    </div>
                    <div>
                        <div class="flex items-center gap-1.5">
                            <span class="text-2xl font-extrabold tracking-tight text-slate-900">Rasa<span class="text-[#e8503a]">Kita</span></span>
                        </div>
                        <p class="text-[11px] font-medium text-slate-400 -mt-1 tracking-wide">Pusat Makanan, Nikmati Rasanya</p>
                    </div>
                </a>

                <!-- Desktop Nav Links -->
                <nav class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="text-sm font-semibold transition-colors {{ request()->routeIs('home') ? 'text-[#e8503a] border-b-2 border-[#e8503a] pb-1' : 'text-slate-600 hover:text-[#e8503a]' }}">
                        Beranda
                    </a>
                    <a href="{{ route('menu.index') }}" class="text-sm font-semibold transition-colors {{ request()->routeIs('menu.*') ? 'text-[#e8503a] border-b-2 border-[#e8503a] pb-1' : 'text-slate-600 hover:text-[#e8503a]' }}">
                        Menu
                    </a>
                    <a href="{{ route('about') }}" class="text-sm font-semibold transition-colors {{ request()->routeIs('about') ? 'text-[#e8503a] border-b-2 border-[#e8503a] pb-1' : 'text-slate-600 hover:text-[#e8503a]' }}">
                        Tentang Kami
                    </a>
                    <a href="{{ route('contact') }}" class="text-sm font-semibold transition-colors {{ request()->routeIs('contact') ? 'text-[#e8503a] border-b-2 border-[#e8503a] pb-1' : 'text-slate-600 hover:text-[#e8503a]' }}">
                        Kontak
                    </a>
                    @auth
                        <a href="{{ route('order.history') }}" class="text-sm font-semibold transition-colors {{ request()->routeIs('order.history') ? 'text-[#e8503a] border-b-2 border-[#e8503a] pb-1' : 'text-slate-600 hover:text-[#e8503a]' }}">
                            Riwayat Transaksi
                        </a>
                    @endauth
                </nav>

                <!-- Right Side Actions: Search, Cart, User -->
                <div class="flex items-center gap-4">
                    <!-- Search Icon Trigger -->
                    <a href="{{ route('menu.index') }}" class="w-10 h-10 rounded-full flex items-center justify-center text-slate-500 hover:text-[#e8503a] hover:bg-orange-50 transition" title="Cari Menu">
                        <i class="fa-solid fa-magnifying-glass text-lg"></i>
                    </a>

                    <!-- Cart Icon with Live Badge -->
                    @php
                        $cart = session()->get('cart', []);
                        $cartCount = array_sum(array_column($cart, 'quantity'));
                    @endphp
                    <a href="{{ route('cart.index') }}" class="relative w-10 h-10 rounded-full flex items-center justify-center text-slate-700 hover:text-[#e8503a] hover:bg-orange-50 transition" title="Keranjang Pesanan">
                        <i class="fa-solid fa-cart-shopping text-lg"></i>
                        <span id="cart-badge" class="absolute -top-1 -right-1 bg-[#e8503a] text-white text-[11px] font-bold w-5 h-5 rounded-full flex items-center justify-center border-2 border-white shadow-sm {{ $cartCount > 0 ? '' : 'hidden' }}">
                            {{ $cartCount }}
                        </span>
                    </a>

                    <!-- User Profile / Auth Button -->
                    @auth
                        <div class="relative group" id="user-dropdown-container">
                            <button type="button" class="flex items-center gap-2 pl-3 pr-4 py-1.5 rounded-full border border-slate-200 hover:border-orange-300 bg-white transition shadow-sm">
                                <div class="w-7 h-7 rounded-full bg-[#fff1ee] text-[#e8503a] flex items-center justify-center font-bold text-xs">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                                <span class="text-xs font-semibold text-slate-700 max-w-[100px] truncate">{{ auth()->user()->name }}</span>
                                <i class="fa-solid fa-chevron-down text-[10px] text-slate-400"></i>
                            </button>

                            <!-- Dropdown Menu -->
                            <div class="absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-xl border border-slate-100 py-2 hidden group-hover:block transition-all z-50">
                                <div class="px-4 py-2 border-b border-slate-100">
                                    <p class="text-xs text-slate-400">Pelanggan Aktif:</p>
                                    <p class="text-sm font-bold text-slate-800 truncate">{{ auth()->user()->name }}</p>
                                    <span class="inline-block mt-1 px-2 py-0.5 text-[10px] font-bold rounded-full bg-orange-100 text-orange-700">
                                        Role: Pelanggan
                                    </span>
                                </div>
                                <a href="{{ route('order.history') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-xs font-medium text-slate-700 hover:bg-orange-50 hover:text-[#e8503a] transition">
                                    <i class="fa-solid fa-receipt text-slate-400"></i> Riwayat Transaksi Saya
                                </a>
                                <a href="{{ route('cart.index') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-xs font-medium text-slate-700 hover:bg-orange-50 hover:text-[#e8503a] transition">
                                    <i class="fa-solid fa-cart-shopping text-slate-400"></i> Keranjang Pesanan
                                </a>
                                <div class="border-t border-slate-100 my-1"></div>
                                <form action="{{ route('logout') }}" method="POST" class="w-full">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-2.5 px-4 py-2 text-xs font-medium text-rose-600 hover:bg-rose-50 transition text-left">
                                        <i class="fa-solid fa-arrow-right-from-bracket"></i> Keluar (Logout)
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="btn-brand px-5 py-2.5 rounded-full text-xs font-bold tracking-wide shadow-sm flex items-center gap-1.5">
                            <i class="fa-regular fa-user"></i>
                            <span>Masuk / Daftar</span>
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Flash Messages -->
    <div class="no-print max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 w-full">
        @if(session('success'))
            <div class="flex items-center p-4 mb-4 text-emerald-800 rounded-2xl bg-emerald-50 border border-emerald-200 text-sm shadow-sm">
                <i class="fa-solid fa-circle-check text-emerald-500 text-lg mr-3"></i>
                <div class="font-medium">{{ session('success') }}</div>
            </div>
        @endif

        @if(session('error'))
            <div class="flex items-center p-4 mb-4 text-rose-800 rounded-2xl bg-rose-50 border border-rose-200 text-sm shadow-sm">
                <i class="fa-solid fa-circle-xmark text-rose-500 text-lg mr-3"></i>
                <div class="font-medium">{{ session('error') }}</div>
            </div>
        @endif

        @if(session('warning'))
            <div class="flex items-center p-4 mb-4 text-amber-800 rounded-2xl bg-amber-50 border border-amber-200 text-sm shadow-sm">
                <i class="fa-solid fa-triangle-exclamation text-amber-500 text-lg mr-3"></i>
                <div class="font-medium">{{ session('warning') }}</div>
            </div>
        @endif

        @if(session('info'))
            <div class="flex items-center p-4 mb-4 text-blue-800 rounded-2xl bg-blue-50 border border-blue-200 text-sm shadow-sm">
                <i class="fa-solid fa-circle-info text-blue-500 text-lg mr-3"></i>
                <div class="font-medium">{{ session('info') }}</div>
            </div>
        @endif
    </div>

    <!-- Main Content Yield -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer Matching Screenshot -->
    <footer class="no-print bg-[#0f172a] text-slate-300 mt-20 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10">
                <!-- Col 1: Logo & Tagline -->
                <div class="space-y-4 md:col-span-1">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-orange-500/20 flex items-center justify-center text-orange-400">
                            <i class="fa-solid fa-kitchen-set text-xl"></i>
                        </div>
                        <span class="text-2xl font-black text-white">Rasa<span class="text-[#e8503a]">Kita</span></span>
                    </div>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        Pusat Makanan, Nikmati Rasanya. Menyajikan aneka masakan nusantara pilihan dengan bahan segar dan higienis langsung ke meja Anda.
                    </p>
                    <div class="flex items-center gap-3 pt-2">
                        <a href="#" class="w-8 h-8 rounded-full bg-slate-800 hover:bg-[#e8503a] flex items-center justify-center text-slate-300 hover:text-white transition text-xs">
                            <i class="fa-brands fa-instagram"></i>
                        </a>
                        <a href="#" class="w-8 h-8 rounded-full bg-slate-800 hover:bg-[#e8503a] flex items-center justify-center text-slate-300 hover:text-white transition text-xs">
                            <i class="fa-brands fa-facebook-f"></i>
                        </a>
                        <a href="#" class="w-8 h-8 rounded-full bg-slate-800 hover:bg-[#e8503a] flex items-center justify-center text-slate-300 hover:text-white transition text-xs">
                            <i class="fa-brands fa-tiktok"></i>
                        </a>
                        <a href="#" class="w-8 h-8 rounded-full bg-slate-800 hover:bg-[#e8503a] flex items-center justify-center text-slate-300 hover:text-white transition text-xs">
                            <i class="fa-brands fa-whatsapp"></i>
                        </a>
                    </div>
                </div>

                <!-- Col 2: Navigasi Cepat -->
                <div>
                    <h4 class="text-sm font-bold text-white uppercase tracking-wider mb-4">Navigasi</h4>
                    <ul class="space-y-2.5 text-xs text-slate-400">
                        <li><a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a></li>
                        <li><a href="{{ route('menu.index') }}" class="hover:text-white transition">Daftar Menu</a></li>
                        <li><a href="{{ route('about') }}" class="hover:text-white transition">Tentang Kami</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-white transition">Hubungi Kami</a></li>
                        @auth
                            <li><a href="{{ route('order.history') }}" class="hover:text-white transition">Riwayat Transaksi Saya</a></li>
                        @endauth
                    </ul>
                </div>

                <!-- Col 3: Ketentuan Pelanggan -->
                <div>
                    <h4 class="text-sm font-bold text-white uppercase tracking-wider mb-4">Aturan Pelanggan</h4>
                    <ul class="space-y-2 text-xs text-slate-400 leading-relaxed">
                        <li class="flex items-start gap-2">
                            <i class="fa-solid fa-check text-emerald-400 mt-0.5"></i>
                            <span>Bisa memesan aneka makanan & minuman</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fa-solid fa-check text-emerald-400 mt-0.5"></i>
                            <span>Melihat struk & riwayat transaksi diri sendiri</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fa-solid fa-shield-halved text-amber-400 mt-0.5"></i>
                            <span>Privasi terjaga: Tidak bisa melihat transaksi orang lain</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fa-solid fa-lock text-slate-400 mt-0.5"></i>
                            <span>Tidak bisa menambah, mengedit, atau menghapus menu</span>
                        </li>
                    </ul>
                </div>

                <!-- Col 4: Kontak & Jam Buka -->
                <div>
                    <h4 class="text-sm font-bold text-white uppercase tracking-wider mb-4">Kontak & Operasional</h4>
                    <ul class="space-y-2.5 text-xs text-slate-400">
                        <li class="flex items-center gap-2">
                            <i class="fa-solid fa-location-dot text-[#e8503a]"></i>
                            <span>Jl. Rasa Nusantara No. 88, Jakarta Selatan</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="fa-solid fa-phone text-[#e8503a]"></i>
                            <span>+62 812-3456-7890</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="fa-solid fa-clock text-[#e8503a]"></i>
                            <span>Buka Setiap Hari: 09:00 - 22:00 WIB</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Bottom Copyright -->
            <div class="border-t border-slate-800 mt-12 pt-6 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500 gap-4">
                <p>&copy; 2024 RasaKita. Semua Hak Dilindungi.</p>
                <p class="text-slate-600">Aplikasi Khusus <span class="text-orange-400 font-semibold">Pelanggan RasaKita</span></p>
            </div>
        </div>
    </footer>

    <!-- Global Dynamic Add-to-Cart Toast -->
    <div id="cart-toast" class="fixed bottom-6 right-6 z-50 transform translate-y-24 opacity-0 transition-all duration-300 bg-white border border-emerald-200 rounded-2xl shadow-2xl p-4 flex items-center gap-3 max-w-sm pointer-events-none">
        <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center flex-shrink-0">
            <i class="fa-solid fa-check text-lg"></i>
        </div>
        <div class="flex-grow">
            <h5 class="text-xs font-bold text-slate-800">Berhasil Ditambahkan!</h5>
            <p id="toast-message" class="text-[11px] text-slate-500">Menu masuk ke keranjang pesanan.</p>
        </div>
        <a href="{{ route('cart.index') }}" class="btn-brand px-3 py-1.5 rounded-lg text-[11px] font-bold pointer-events-auto">
            Keranjang
        </a>
    </div>

    <!-- Script to handle asynchronous Add to Cart without page reload -->
    <script>
        function addToCart(menuId, menuName) {
            fetch("{{ route('cart.add') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Accept": "application/json"
                },
                body: JSON.stringify({
                    menu_id: menuId,
                    quantity: 1
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    // Update badge
                    const badge = document.getElementById('cart-badge');
                    if (badge) {
                        badge.innerText = data.cart_count;
                        badge.classList.remove('hidden');
                    }

                    // Show Toast
                    const toast = document.getElementById('cart-toast');
                    const toastMsg = document.getElementById('toast-message');
                    toastMsg.innerText = menuName + " ditambahkan ke keranjang.";
                    toast.classList.remove('translate-y-24', 'opacity-0');
                    toast.classList.add('translate-y-0', 'opacity-100');

                    setTimeout(() => {
                        toast.classList.remove('translate-y-0', 'opacity-100');
                        toast.classList.add('translate-y-24', 'opacity-0');
                    }, 3000);
                }
            })
            .catch(err => {
                console.error(err);
                window.location.href = "{{ route('menu.index') }}";
            });
        }
    </script>

    @stack('scripts')
</body>
</html>
