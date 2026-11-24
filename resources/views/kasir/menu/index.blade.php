@extends('layouts.app')
@section('title', 'Kelola Daftar Menu - Kasir RasaKita')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Kelola Daftar Menu</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Tambah, edit, hapus, atau atur ketersediaan menu Restoran RasaKita.</p>
        </div>
        <a href="{{ route('kasir.menu.create') }}" class="btn-brand px-5 py-3 rounded-xl text-xs sm:text-sm font-bold flex items-center gap-2 shadow-sm">
            <i class="fa-solid fa-plus"></i> Tambah Menu Baru
        </a>
    </div>

    <!-- Filter -->
    <form method="GET" action="{{ route('kasir.menu.index') }}" class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm mb-6 grid grid-cols-1 md:grid-cols-12 gap-3">
        <div class="md:col-span-6">
            <input type="text" name="cari" value="{{ request('cari') }}" placeholder="Cari nama menu..." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm">
        </div>
        <div class="md:col-span-4">
            <select name="kategori" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm">
                <option value="semua">Semua Kategori</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->slug }}" @selected(request('kategori') === $cat->slug)>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="md:col-span-2">
            <button type="submit" class="w-full btn-brand py-2.5 rounded-xl text-xs font-bold">Filter</button>
        </div>
    </form>

    <!-- Grid Menu -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        @foreach($menus as $menu)
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden flex flex-col">
                <div class="relative h-40 bg-slate-100">
                    <img src="{{ $menu->image }}" alt="{{ $menu->name }}" class="w-full h-full object-cover">
                    <span class="absolute top-2.5 left-2.5 bg-black/60 text-white text-[10px] font-bold px-2.5 py-0.5 rounded-full">
                        {{ $menu->category->name }}
                    </span>
                    <span class="absolute top-2.5 right-2.5 text-[10px] font-bold px-2.5 py-0.5 rounded-full {{ $menu->is_available ? 'bg-emerald-500 text-white' : 'bg-rose-600 text-white' }}">
                        {{ $menu->is_available ? 'Tersedia' : 'Habis' }}
                    </span>
                </div>
                <div class="p-4 flex-1 flex flex-col justify-between space-y-3">
                    <div>
                        <h3 class="text-sm font-bold text-slate-800">{{ $menu->name }}</h3>
                        <p class="text-sm font-extrabold text-[#e8503a] mt-1">Rp {{ number_format($menu->price, 0, ',', '.') }}</p>
                        <p class="text-[11px] text-slate-500 line-clamp-2 mt-1">{{ $menu->description }}</p>
                    </div>
                    <div class="flex items-center gap-2 pt-2 border-t border-slate-100">
                        <a href="{{ route('kasir.menu.edit', $menu) }}" class="flex-1 text-center py-2 rounded-xl bg-amber-100 hover:bg-amber-200 text-amber-800 text-xs font-bold">
                            <i class="fa-solid fa-pen-to-square"></i> Edit
                        </a>
                        <form action="{{ route('kasir.menu.destroy', $menu) }}" method="POST" class="flex-1" onsubmit="return confirm('Hapus menu {{ $menu->name }}?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full py-2 rounded-xl bg-rose-100 hover:bg-rose-200 text-rose-700 text-xs font-bold">
                                <i class="fa-solid fa-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-8">{{ $menus->links() }}</div>
</div>
@endsection