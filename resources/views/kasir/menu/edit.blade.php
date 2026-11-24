@extends('layouts.app')
@section('title', 'Edit Menu - Kasir RasaKita')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-10">
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 sm:p-8">
        <h1 class="text-xl font-extrabold text-slate-900 mb-6">Edit Menu: {{ $menu->name }}</h1>
        <form action="{{ route('kasir.menu.update', $menu) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Kategori</label>
                <select name="category_id" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm">
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" @selected($menu->category_id == $cat->id)>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Nama Menu</label>
                <input type="text" name="name" value="{{ $menu->name }}" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Harga (Rp)</label>
                <input type="number" name="price" value="{{ (int) $menu->price }}" required min="1000" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">URL Gambar Makanan</label>
                <input type="url" name="image" value="{{ $menu->image }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Deskripsi</label>
                <textarea name="description" rows="3" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm">{{ $menu->description }}</textarea>
            </div>
            <div class="flex items-center gap-6">
                <label class="flex items-center gap-2 text-xs font-semibold">
                    <input type="checkbox" name="is_available" value="1" @checked($menu->is_available) class="rounded text-[#e8503a]"> Tersedia
                </label>
                <label class="flex items-center gap-2 text-xs font-semibold">
                    <input type="checkbox" name="is_popular" value="1" @checked($menu->is_popular) class="rounded text-[#e8503a]"> Tandai Populer
                </label>
            </div>
            <div class="flex gap-3 pt-3">
                <button type="submit" class="btn-brand px-6 py-2.5 rounded-xl text-xs font-bold">Perbarui Menu</button>
                <a href="{{ route('kasir.menu.index') }}" class="px-6 py-2.5 rounded-xl bg-slate-100 text-slate-700 text-xs font-bold">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection