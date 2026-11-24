@extends('layouts.app')

@section('title', 'Tentang Kami - RasaKita')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-16">

    <!-- Hero Header -->
    <div class="text-center max-w-2xl mx-auto mb-16">
        <div class="inline-block px-3 py-1 rounded-full bg-orange-100 text-[#e8503a] text-xs font-bold uppercase tracking-wider mb-3">
            Cerita RasaKita
        </div>
        <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
            Menghadirkan Cita Rasa Terbaik Langsung ke Rumah Anda
        </h1>
        <p class="text-sm text-slate-600 mt-4 leading-relaxed">
            RasaKita lahir dari kecintaan kami terhadap kekayaan kuliner nusantara. Kami berkomitmen menyajikan hidangan lezat dengan standar higienis tinggi dan bahan baku terbaik.
        </p>
    </div>

    <!-- Story Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center mb-16">
        <div class="rounded-3xl overflow-hidden shadow-xl border border-slate-100">
            <img 
                src="https://images.unsplash.com/photo-1555396273-367ea4eb4db5?auto=format&fit=crop&w=800&q=80" 
                alt="Dapur RasaKita" 
                class="w-full h-80 sm:h-96 object-cover"
            >
        </div>
        <div class="space-y-6">
            <h2 class="text-2xl font-extrabold text-slate-900">
                Komitmen Kami untuk Kepuasan Pelanggan
            </h2>
            <p class="text-sm text-slate-600 leading-relaxed">
                Setiap menu yang kami masak dipersiapkan langsung secara mendadak saat pesanan masuk, memastikan makanan tetap hangat, aroma menggugah selera, dan rasa otentik yang tidak berubah.
            </p>
            <div class="space-y-3">
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 rounded-xl bg-orange-100 text-[#e8503a] flex items-center justify-center flex-shrink-0 text-sm">
                        <i class="fa-solid fa-leaf"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-slate-800">Bahan 100% Segar & Alami</h4>
                        <p class="text-xs text-slate-500">Dipilih langsung dari produsen lokal tepercaya setiap pagi.</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 rounded-xl bg-orange-100 text-[#e8503a] flex items-center justify-center flex-shrink-0 text-sm">
                        <i class="fa-solid fa-certificate"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-slate-800">Higienis & Halal</h4>
                        <p class="text-xs text-slate-500">Proses pengolahan bersih sesuai standar keamanan pangan.</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 rounded-xl bg-orange-100 text-[#e8503a] flex items-center justify-center flex-shrink-0 text-sm">
                        <i class="fa-solid fa-bolt"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-slate-800">Pengiriman Cepat & Rapi</h4>
                        <p class="text-xs text-slate-500">Kemasan ramah lingkungan yang aman sampai di tangan Anda.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA -->
    <div class="bg-gradient-to-r from-[#2a1b18] to-[#1e1310] text-white rounded-3xl p-8 sm:p-12 text-center">
        <h3 class="text-2xl font-extrabold mb-2">Sudah Lapar? Pesan Sekarang Juga!</h3>
        <p class="text-xs sm:text-sm text-slate-300 max-w-md mx-auto mb-6">Nikmati berbagai pilihan hidangan favorit Anda dengan mudah dan praktis.</p>
        <a href="{{ route('menu.index') }}" class="btn-brand px-8 py-3 rounded-full text-xs sm:text-sm font-bold tracking-wide inline-flex items-center gap-2">
            <i class="fa-solid fa-utensils"></i>
            <span>Buka Daftar Menu</span>
        </a>
    </div>

</div>
@endsection
