@extends('layouts.app')

@section('title', 'Daftar Akun Pelanggan - RasaKita')

@section('content')
<div class="max-w-md mx-auto px-4 py-12 sm:py-16">

    <div class="bg-white rounded-3xl border border-slate-100 shadow-xl p-6 sm:p-8 space-y-6">
        
        <!-- Header -->
        <div class="text-center space-y-1">
            <div class="w-12 h-12 rounded-2xl bg-[#fff1ee] text-[#e8503a] flex items-center justify-center mx-auto mb-2 text-2xl">
                <i class="fa-solid fa-user-plus"></i>
            </div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Daftar Akun Pelanggan</h1>
            <p class="text-xs text-slate-500">Bergabung dan nikmati kemudahan memesan makanan di RasaKita</p>
        </div>

        <!-- Form Register -->
        <form action="{{ route('register') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Lengkap</label>
                <input 
                    type="text" 
                    name="name" 
                    required 
                    value="{{ old('name') }}" 
                    class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500" 
                    placeholder="Nama Lengkap Anda"
                >
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Alamat Email</label>
                <input 
                    type="email" 
                    name="email" 
                    required 
                    value="{{ old('email') }}" 
                    class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500" 
                    placeholder="nama@email.com"
                >
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Nomor WhatsApp / HP</label>
                <input 
                    type="text" 
                    name="phone" 
                    value="{{ old('phone') }}" 
                    class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500" 
                    placeholder="081234567890"
                >
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Alamat Pengiriman</label>
                <textarea 
                    name="address" 
                    rows="2" 
                    class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500" 
                    placeholder="Alamat rumah / kantor untuk pengiriman makanan"
                >{{ old('address') }}</textarea>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Kata Sandi</label>
                    <input 
                        type="password" 
                        name="password" 
                        required 
                        class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500" 
                        placeholder="Min. 6 karakter"
                    >
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Konfirmasi Sandi</label>
                    <input 
                        type="password" 
                        name="password_confirmation" 
                        required 
                        class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500" 
                        placeholder="Ulangi sandi"
                    >
                </div>
            </div>

            <div class="pt-2">
                <button type="submit" class="btn-brand w-full py-3 rounded-xl text-xs sm:text-sm font-bold tracking-wide shadow-md flex items-center justify-center gap-2">
                    <i class="fa-solid fa-user-plus text-xs"></i>
                    <span>Daftar Sebagai Pelanggan</span>
                </button>
            </div>
        </form>

        <div class="text-center pt-2 border-t border-slate-100 text-xs text-slate-500">
            Sudah memiliki akun? 
            <a href="{{ route('login') }}" class="font-bold text-[#e8503a] hover:underline">Masuk di sini</a>
        </div>

    </div>

</div>
@endsection
