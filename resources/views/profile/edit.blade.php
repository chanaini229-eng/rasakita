@extends('layouts.app')
@section('title', 'Edit Profil Saya - RasaKita')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-10">
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 sm:p-8 space-y-6">
        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
            <div>
                <h1 class="text-2xl font-extrabold text-slate-900">Edit Profil Saya</h1>
                <p class="text-xs text-slate-500 mt-1">Perbarui data akun dan kata sandi Anda sendiri.</p>
            </div>
            <span class="px-3 py-1 text-xs font-bold rounded-full {{ $user->role === 'kasir' ? 'bg-emerald-100 text-emerald-700' : 'bg-orange-100 text-orange-700' }} uppercase">
                Role: {{ $user->role }}
            </span>
        </div>

        @if ($errors->any())
            <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-700 text-xs space-y-1">
                @foreach ($errors->all() as $error)
                    <p>• {{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('profile.update') }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[#e8503a]">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Alamat Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[#e8503a]">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Nomor WhatsApp / HP</label>
                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[#e8503a]">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Alamat</label>
                <textarea name="address" rows="2" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[#e8503a]">{{ old('address', $user->address) }}</textarea>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-3 border-t border-slate-100">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Kata Sandi Baru (Opsional)</label>
                    <input type="password" name="password" placeholder="Kosongkan jika tidak diubah" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[#e8503a]">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Konfirmasi Kata Sandi Baru</label>
                    <input type="password" name="password_confirmation" placeholder="Ulangi kata sandi baru" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[#e8503a]">
                </div>
            </div>

            <div class="pt-4 flex gap-3">
                <button type="submit" class="btn-brand px-6 py-2.5 rounded-xl text-xs font-bold shadow-sm">Simpan Perubahan</button>
                <a href="{{ $user->role === 'kasir' ? route('kasir.dashboard') : route('home') }}" class="px-6 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition">Kembali</a>
            </div>
        </form>
    </div>
</div>
@endsection