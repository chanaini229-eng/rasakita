@extends('layouts.app')

@section('title', 'Tampilan Checkout Menu - RasaKita')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">

    <!-- Breadcrumb & Header -->
    <div class="mb-8">
        <nav class="flex items-center gap-2 text-xs text-slate-400 mb-2">
            <a href="{{ route('home') }}" class="hover:text-[#e8503a]">Beranda</a>
            <i class="fa-solid fa-chevron-right text-[10px]"></i>
            <a href="{{ route('cart.index') }}" class="hover:text-[#e8503a]">Keranjang</a>
            <i class="fa-solid fa-chevron-right text-[10px]"></i>
            <span class="text-slate-700 font-semibold">Checkout Menu</span>
        </nav>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Checkout Pemesanan</h1>
        <p class="text-xs sm:text-sm text-slate-500 mt-1">Lengkapi data pengiriman dan pilih metode pembayaran</p>
    </div>

    <form action="{{ route('order.store') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Form Details -->
            <div class="lg:col-span-7 space-y-6">
                
                <!-- Customer Details Card -->
                <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 space-y-4">
                    <div class="flex items-center gap-2.5 pb-2 border-b border-slate-100">
                        <div class="w-8 h-8 rounded-xl bg-orange-100 text-[#e8503a] flex items-center justify-center text-sm">
                            <i class="fa-solid fa-user"></i>
                        </div>
                        <h2 class="text-base font-bold text-slate-800">Informasi Pemesan</h2>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Pelanggan <span class="text-rose-500">*</span></label>
                            <input 
                                type="text" 
                                name="customer_name" 
                                required 
                                value="{{ old('customer_name', $user->name ?? '') }}" 
                                class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 font-medium"
                                placeholder="Nama Lengkap"
                            >
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Nomor WhatsApp / HP <span class="text-rose-500">*</span></label>
                            <input 
                                type="text" 
                                name="customer_phone" 
                                required 
                                value="{{ old('customer_phone', $user->phone ?? '081234567890') }}" 
                                class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 font-medium"
                                placeholder="Contoh: 081234567890"
                            >
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Alamat Pengantaran / Nomor Meja <span class="text-rose-500">*</span></label>
                        <textarea 
                            name="customer_address" 
                            rows="2" 
                            required 
                            class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 font-medium"
                            placeholder="Alamat lengkap tujuan atau Nomor Meja (jika makan di tempat / dine-in)"
                        >{{ old('customer_address', $user->address ?? 'Jl. Mawar Indah Blok B3 No. 14, Jakarta') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Catatan Tambahan untuk Dapur</label>
                        <input 
                            type="text" 
                            name="notes" 
                            value="{{ old('notes') }}" 
                            class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500"
                            placeholder="Contoh: Sambal dipisah, sendok plastik 2 pcs, tidak pakai seledri"
                        >
                    </div>
                </div>

                <!-- Payment Method Card -->
                <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 space-y-4">
                    <div class="flex items-center gap-2.5 pb-2 border-b border-slate-100">
                        <div class="w-8 h-8 rounded-xl bg-orange-100 text-[#e8503a] flex items-center justify-center text-sm">
                            <i class="fa-solid fa-credit-card"></i>
                        </div>
                        <h2 class="text-base font-bold text-slate-800">Pilihan Metode Pembayaran</h2>
                    </div>

                    <div class="space-y-3">
                        <!-- Option 1: QRIS -->
                        <label class="flex items-center justify-between p-3.5 border-2 border-orange-500/80 bg-orange-50/40 rounded-2xl cursor-pointer hover:bg-orange-50 transition">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="payment_method" value="qris" checked class="w-4 h-4 text-[#e8503a] focus:ring-[#e8503a]">
                                <div>
                                    <p class="text-xs sm:text-sm font-bold text-slate-800">QRIS (Gopay, OVO, Dana, ShopeePay)</p>
                                    <p class="text-[11px] text-slate-500">Scan QR Code instan tanpa biaya admin</p>
                                </div>
                            </div>
                            <span class="text-xs font-bold text-[#e8503a] bg-white px-2.5 py-1 rounded-lg border border-orange-200">
                                Instan
                            </span>
                        </label>

                        <!-- Option 2: Transfer Bank -->
                        <label class="flex items-center justify-between p-3.5 border border-slate-200 rounded-2xl cursor-pointer hover:bg-slate-50 transition">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="payment_method" value="transfer_bank" class="w-4 h-4 text-[#e8503a] focus:ring-[#e8503a]">
                                <div>
                                    <p class="text-xs sm:text-sm font-bold text-slate-800">Transfer Virtual Account (BCA / Mandiri / BRI)</p>
                                    <p class="text-[11px] text-slate-500">Otomatis terverifikasi 24 jam</p>
                                </div>
                            </div>
                            <i class="fa-solid fa-building-columns text-slate-400 text-sm"></i>
                        </label>

                        <!-- Option 3: Tunai / Kasir -->
                        <label class="flex items-center justify-between p-3.5 border border-slate-200 rounded-2xl cursor-pointer hover:bg-slate-50 transition">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="payment_method" value="tunai" class="w-4 h-4 text-[#e8503a] focus:ring-[#e8503a]">
                                <div>
                                    <p class="text-xs sm:text-sm font-bold text-slate-800">Bayar Tunai di Kasir / COD</p>
                                    <p class="text-[11px] text-slate-500">Bayar saat pesanan diterima</p>
                                </div>
                            </div>
                            <i class="fa-solid fa-money-bill-wave text-slate-400 text-sm"></i>
                        </label>
                    </div>
                </div>

            </div>

            <!-- Order Summary & Confirm -->
            <div class="lg:col-span-5 bg-white rounded-3xl border border-slate-100 shadow-sm p-6 space-y-5">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <h3 class="text-base font-extrabold text-slate-900">Pesanan Kamu ({{ count($cart) }} Item)</h3>
                    <a href="{{ route('cart.index') }}" class="text-xs font-bold text-[#e8503a] hover:underline">Ubah</a>
                </div>

                <!-- Items Preview -->
                <div class="space-y-3 max-h-64 overflow-y-auto pr-1">
                    @foreach($cart as $item)
                        <div class="flex items-center justify-between text-xs py-1">
                            <div class="flex items-center gap-2.5">
                                <span class="font-bold text-[#e8503a]">{{ $item['quantity'] }}x</span>
                                <span class="text-slate-800 font-medium">{{ $item['name'] }}</span>
                            </div>
                            <span class="font-bold text-slate-800">
                                Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                            </span>
                        </div>
                    @endforeach
                </div>

                <!-- Price Breakdown -->
                <div class="space-y-2 pt-3 border-t border-slate-100 text-xs text-slate-600">
                    <div class="flex justify-between">
                        <span>Subtotal Menu</span>
                        <span class="font-bold text-slate-800">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Biaya Pengantaran</span>
                        <span class="font-bold text-slate-800">Rp {{ number_format($deliveryFee, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-sm font-extrabold text-slate-900 pt-2 border-t border-slate-100">
                        <span>Total Tagihan</span>
                        <span class="text-[#e8503a] text-lg">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- Rule 5 Notice: Struk akan langsung muncul -->
                <div class="bg-orange-50/70 border border-orange-200/60 rounded-2xl p-3 text-[11px] text-orange-900 flex items-start gap-2">
                    <i class="fa-solid fa-receipt text-[#e8503a] mt-0.5"></i>
                    <span>Setelah menekan tombol konfirmasi, struk pemesanan Anda akan otomatis diterbitkan.</span>
                </div>

                <!-- Submit Button (Rule 4: Bisa Memesan Makanan) -->
                <button type="submit" class="btn-brand w-full py-4 rounded-2xl text-xs sm:text-sm font-bold tracking-wide flex items-center justify-center gap-2 shadow-lg active:scale-95">
                    <i class="fa-solid fa-circle-check"></i>
                    <span>Konfirmasi & Pesan Sekarang</span>
                </button>

                <p class="text-[11px] text-slate-400 text-center">
                    Dengan memesan, Anda menyetujui syarat & ketentuan RasaKita.
                </p>
            </div>

        </div>
    </form>

</div>
@endsection
