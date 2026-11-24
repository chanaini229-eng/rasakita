@extends('layouts.app')

@section('title', 'Kontak Kami - RasaKita')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-16">

    <div class="text-center max-w-2xl mx-auto mb-12">
        <div class="inline-block px-3 py-1 rounded-full bg-orange-100 text-[#e8503a] text-xs font-bold uppercase tracking-wider mb-3">
            Hubungi Kami
        </div>
        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">
            Kami Selalu Siap Membantu Anda
        </h1>
        <p class="text-xs sm:text-sm text-slate-500 mt-2">
            Punya pertanyaan mengenai pesanan, menu, atau kerja sama? Jangan ragu untuk mengirimkan pesan kepada tim kami.
        </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- Contact Info Cards -->
        <div class="lg:col-span-5 space-y-4">
            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex items-start gap-4">
                <div class="w-12 h-12 rounded-2xl bg-[#fff1ee] text-[#e8503a] flex items-center justify-center text-xl flex-shrink-0">
                    <i class="fa-solid fa-location-dot"></i>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-slate-800">Alamat Restoran</h3>
                    <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                        Jl. Rasa Nusantara No. 88, Kebayoran Baru, Jakarta Selatan, 12160
                    </p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex items-start gap-4">
                <div class="w-12 h-12 rounded-2xl bg-[#fff1ee] text-[#e8503a] flex items-center justify-center text-xl flex-shrink-0">
                    <i class="fa-brands fa-whatsapp"></i>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-slate-800">Customer Support (WhatsApp)</h3>
                    <p class="text-xs text-slate-500 mt-1">
                        +62 812-3456-7890 (Aktif 24 Jam)
                    </p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex items-start gap-4">
                <div class="w-12 h-12 rounded-2xl bg-[#fff1ee] text-[#e8503a] flex items-center justify-center text-xl flex-shrink-0">
                    <i class="fa-solid fa-clock"></i>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-slate-800">Jam Operasional</h3>
                    <p class="text-xs text-slate-500 mt-1">
                        Senin - Minggu: 09:00 - 22:00 WIB
                    </p>
                </div>
            </div>
        </div>

        <!-- Contact Form -->
        <div class="lg:col-span-7 bg-white p-6 sm:p-8 rounded-3xl border border-slate-100 shadow-sm">
            <h2 class="text-lg font-bold text-slate-800 mb-4">Kirim Pesan Langsung</h2>

            <form action="{{ route('contact.send') }}" method="POST" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Lengkap</label>
                        <input 
                            type="text" 
                            name="name" 
                            required 
                            value="{{ auth()->check() ? auth()->user()->name : old('name') }}" 
                            class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500" 
                            placeholder="Nama Anda"
                        >
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Email</label>
                        <input 
                            type="email" 
                            name="email" 
                            required 
                            value="{{ auth()->check() ? auth()->user()->email : old('email') }}" 
                            class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500" 
                            placeholder="nama@email.com"
                        >
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Subjek</label>
                    <input 
                        type="text" 
                        name="subject" 
                        required 
                        value="{{ old('subject') }}" 
                        class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500" 
                        placeholder="Pertanyaan seputar pesanan, katering, dll."
                    >
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Pesan</label>
                    <textarea 
                        name="message" 
                        rows="4" 
                        required 
                        class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500" 
                        placeholder="Tuliskan pesan Anda di sini..."
                    >{{ old('message') }}</textarea>
                </div>

                <button type="submit" class="btn-brand px-6 py-2.5 rounded-xl text-xs sm:text-sm font-bold tracking-wide shadow-sm flex items-center gap-2">
                    <i class="fa-solid fa-paper-plane text-xs"></i>
                    <span>Kirim Pesan</span>
                </button>
            </form>
        </div>

    </div>

</div>
@endsection
