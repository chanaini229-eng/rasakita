@extends('layouts.app')

@section('title', 'Masuk Akun Pelanggan - RasaKita')

@section('content')
<div class="max-w-md mx-auto px-4 py-12 sm:py-16">

    <div class="bg-white rounded-3xl border border-slate-100 shadow-xl p-6 sm:p-8 space-y-6">
        
        <!-- Header -->
        <div class="text-center space-y-1">
            <div class="w-12 h-12 rounded-2xl bg-[#fff1ee] text-[#e8503a] flex items-center justify-center mx-auto mb-2 text-2xl">
                <i class="fa-solid fa-kitchen-set"></i>
            </div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Masuk ke Rasa<span class="text-[#e8503a]">Kita</span></h1>
            <p class="text-xs text-slate-500">Pesan makanan favorit dan pantau riwayat transaksi Anda</p>
        </div>

        <!-- Quick 1-Click Login for Easy Testing -->
        <div class="bg-orange-50/70 border border-orange-200/60 rounded-2xl p-3.5 space-y-2">
            <p class="text-[11px] font-bold text-[#e8503a] uppercase tracking-wider flex items-center gap-1.5">
                <i class="fa-solid fa-bolt"></i> 1-Klik Masuk (Untuk Pengujian Aturan):
            </p>
            <div class="grid grid-cols-2 gap-2 text-xs">
                <a href="{{ route('quick.login', 'pelanggan') }}" class="px-2.5 py-1.5 rounded-xl bg-white border border-orange-200 text-slate-700 hover:bg-[#e8503a] hover:text-white font-bold transition text-center shadow-xs">
                    Pelanggan 1 (Budi)
                </a>
                <a href="{{ route('quick.login', 'siti') }}" class="px-2.5 py-1.5 rounded-xl bg-white border border-orange-200 text-slate-700 hover:bg-[#e8503a] hover:text-white font-bold transition text-center shadow-xs">
                    Pelanggan 2 (Siti)
                </a>
            </div>
        </div>

        <!-- Form Login -->
        <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Alamat Email</label>
                <input 
                    type="email" 
                    name="email" 
                    required 
                    value="{{ old('email', 'pelanggan@rasakita.com') }}" 
                    class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500" 
                    placeholder="nama@email.com"
                >
            </div>

            <div>
                <div class="flex items-center justify-between mb-1">
                    <label class="block text-xs font-semibold text-slate-700">Kata Sandi</label>
                    <span class="text-[11px] text-slate-400">Default: password</span>
                </div>
                <input 
                    type="password" 
                    name="password" 
                    required 
                    value="password"
                    class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500" 
                    placeholder="••••••••"
                >
            </div>

            <div class="flex items-center justify-between text-xs">
                <label class="flex items-center gap-2 cursor-pointer text-slate-600">
                    <input type="checkbox" name="remember" class="w-4 h-4 rounded text-[#e8503a] focus:ring-[#e8503a]">
                    <span>Ingat Saya</span>
                </label>
            </div>

            <button type="submit" class="btn-brand w-full py-3 rounded-xl text-xs sm:text-sm font-bold tracking-wide shadow-md flex items-center justify-center gap-2">
                <i class="fa-solid fa-arrow-right-to-bracket text-xs"></i>
                <span>Masuk Sekarang</span>
            </button>
        </form>

        <div class="text-center pt-2 border-t border-slate-100 text-xs text-slate-500">
            Belum punya akun? 
            <a href="{{ route('register') }}" class="font-bold text-[#e8503a] hover:underline">Daftar Akun Baru</a>
        </div>

    </div>

</div>
@endsection
