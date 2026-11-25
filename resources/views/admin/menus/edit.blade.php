@extends('layouts.app')
@section('title', 'Edit Menu - Admin RasaKita')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 py-10">
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 sm:p-8">
        <h1 class="text-xl font-extrabold text-slate-900 mb-6">Edit Menu: {{ $menu->name }}</h1>

        <form action="{{ route('admin.menus.update', $menu->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Nama Menu *</label>
                <input type="text" name="name" value="{{ old('name', $menu->name) }}" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm">
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Kategori *</label>
                    <select name="category_id" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm">
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ $menu->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Harga (Rp) *</label>
                    <input type="number" name="price" value="{{ old('price', $menu->price) }}" required min="0" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm">
                </div>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Deskripsi</label>
                <textarea name="description" rows="3" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm">{{ old('description', $menu->description) }}</textarea>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">URL Gambar Menu</label>
                <input type="url" name="image" value="{{ old('image', $menu->image) }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Ganti Gambar (Upload Baru)</label>
                <input type="file" name="image_file" accept="image/*" class="w-full text-xs text-slate-600">
            </div>
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="is_popular" value="1" {{ $menu->is_popular ? 'checked' : '' }} class="w-4 h-4 text-[#e8503a] rounded">
                <span class="text-xs font-bold text-slate-700">Tandai sebagai Menu Populer</span>
            </label>
            <div class="pt-4 flex justify-end gap-3">
                <a href="{{ route('admin.menus.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-600">Batal</a>
                <button type="submit" class="btn-brand px-6 py-2.5 rounded-xl text-xs font-bold">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection