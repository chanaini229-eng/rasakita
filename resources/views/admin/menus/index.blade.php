@extends('layouts.app')
@section('title', 'Kelola Menu - Admin RasaKita')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Kelola Daftar Menu</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Tambah menu baru, perbarui harga/deskripsi, hapus menu, atau tambahkan ke pesanan.</p>
        </div>
        <a href="{{ route('admin.menus.create') }}" class="btn-brand px-5 py-3 rounded-2xl text-xs font-bold flex items-center justify-center gap-2 shadow-sm">
            <i class="fa-solid fa-plus"></i>
            <span>Tambah Menu Baru</span>
        </a>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-5">
        @foreach($menus as $menu)
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden flex flex-col">
                <div class="relative h-40 bg-slate-100">
                    <img src="{{ $menu->image }}" alt="{{ $menu->name }}" class="w-full h-full object-cover">
                    <span class="absolute top-2.5 left-2.5 bg-black/60 text-white text-[10px] font-semibold px-2.5 py-0.5 rounded-full">
                        {{ $menu->category->name }}
                    </span>
                    @if($menu->is_popular)
                        <span class="absolute top-2.5 right-2.5 bg-[#e8503a] text-white text-[10px] font-bold px-2 py-0.5 rounded-full shadow-sm">
                            Populer
                        </span>
                    @endif
                </div>
                <div class="p-4 flex flex-col flex-grow justify-between space-y-3">
                    <div>
                        <h3 class="text-sm font-bold text-slate-800 line-clamp-1">{{ $menu->name }}</h3>
                        <p class="text-[11px] text-slate-500 line-clamp-2 mt-1">{{ $menu->description }}</p>
                    </div>
                    <div class="space-y-2">
                        <p class="text-base font-extrabold text-[#e8503a]">{{ $menu->formatted_price }}</p>

                        <button type="button" onclick="addToCart({{ $menu->id }}, '{{ addslashes($menu->name) }}')" class="w-full btn-brand py-2 px-3 rounded-xl text-xs font-bold flex items-center justify-center gap-1.5">
                            <i class="fa-solid fa-cart-plus text-xs"></i>
                            <span>Tambah Pesanan</span>
                        </button>

                        <div class="grid grid-cols-2 gap-2 pt-2 border-t border-slate-100">
                            <a href="{{ route('admin.menus.edit', $menu->id) }}" class="py-2 px-3 rounded-xl bg-amber-50 hover:bg-amber-100 text-amber-700 text-xs font-bold text-center">
                                <i class="fa-solid fa-pen-to-square mr-1"></i>Edit
                            </a>
                            <form action="{{ route('admin.menus.destroy', $menu->id) }}" method="POST" onsubmit="return confirm('Hapus menu {{ addslashes($menu->name) }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full py-2 px-3 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-600 text-xs font-bold">
                                    <i class="fa-solid fa-trash mr-1"></i>Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-8">{{ $menus->links() }}</div>
</div>
@endsection