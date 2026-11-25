@extends('layouts.app')
@section('title', 'Mode Kasir Admin - RasaKita')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6">
        <h1 class="text-2xl font-extrabold text-slate-900">Kasir & Pemesanan Langsung (Admin)</h1>
        <p class="text-xs text-slate-500 mt-1">Pilih menu untuk pelanggan, hitung kembalian tunai, dan cetak struk pembayaran.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Daftar Menu -->
        <div class="lg:col-span-7 space-y-4">
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                @foreach($menus as $menu)
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-3 flex flex-col justify-between">
                        <div>
                            <img src="{{ $menu->image }}" alt="{{ $menu->name }}" class="w-full h-28 object-cover rounded-xl mb-2">
                            <h3 class="text-xs font-bold text-slate-800 line-clamp-1">{{ $menu->name }}</h3>
                            <p class="text-xs font-extrabold text-[#e8503a] mt-0.5">{{ $menu->formatted_price }}</p>
                        </div>
                        <form action="{{ route('cart.add') }}" method="POST" class="mt-2">
                            @csrf
                            <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="w-full btn-brand py-2 rounded-xl text-[11px] font-bold">
                                + Tambah
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Panel Transaksi Kasir -->
        <div class="lg:col-span-5">
            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 space-y-4 sticky top-24">
                <h2 class="text-base font-extrabold text-slate-900 border-b border-slate-100 pb-3">Keranjang Kasir</h2>

                @php $subtotal = 0; @endphp
                @forelse($cart as $id => $item)
                    @php $subtotal += $item['price'] * $item['quantity']; @endphp
                    <div class="flex items-center justify-between text-xs border-b border-slate-50 pb-2">
                        <div>
                            <p class="font-bold text-slate-800">{{ $item['name'] }}</p>
                            <p class="text-slate-400">{{ $item['quantity'] }} x Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                        </div>
                        <span class="font-bold text-slate-800">Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</span>
                    </div>
                @empty
                    <p class="text-xs text-slate-400 py-4 text-center">Belum ada item dipilih.</p>
                @endforelse

                <form action="{{ route('admin.pos.store') }}" method="POST" class="space-y-3 pt-2">
                    @csrf
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Akun Pelanggan (Opsional)</label>
                        <select name="target_user_id" id="pos_user" onchange="fillCustomer(this)" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs">
                            <option value="" data-name="Pelanggan Umum (Walk-In)">-- Pelanggan Umum (Walk-In) --</option>
                            @foreach($customers as $c)
                                <option value="{{ $c->id }}" data-name="{{ $c->name }}" data-phone="{{ $c->phone }}" data-address="{{ $c->address }}">
                                    {{ $c->name }} ({{ $c->email }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Pelanggan *</label>
                        <input type="text" name="customer_name" id="pos_name" value="Pelanggan Umum (Walk-In)" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs">
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Metode Bayar</label>
                            <select name="payment_method" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs">
                                <option value="tunai">Tunai (Cash)</option>
                                <option value="qris">QRIS</option>
                                <option value="transfer_bank">Transfer Bank</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Uang Diterima (Rp)</label>
                            <input type="number" id="cash_received" oninput="calcChange({{ $subtotal }})" placeholder="0" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs">
                        </div>
                    </div>

                    <div class="bg-slate-50 p-3 rounded-2xl text-xs space-y-1">
                        <div class="flex justify-between font-bold text-slate-800">
                            <span>Total Tagihan</span>
                            <span class="text-[#e8503a]">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between font-bold text-emerald-700">
                            <span>Kembalian</span>
                            <span id="cash_change">Rp 0</span>
                        </div>
                    </div>

                    <button type="submit" {{ empty($cart) ? 'disabled' : '' }} class="w-full btn-brand py-3 rounded-xl text-xs font-bold disabled:opacity-50">
                        Proses Pembayaran & Cetak Struk
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function fillCustomer(sel) {
        const opt = sel.options[sel.selectedIndex];
        document.getElementById('pos_name').value = opt.getAttribute('data-name') || 'Pelanggan Umum (Walk-In)';
    }
    function calcChange(total) {
        const paid = parseInt(document.getElementById('cash_received').value || 0);
        const diff = paid - total;
        document.getElementById('cash_change').innerText = diff >= 0 ? 'Rp ' + diff.toLocaleString('id-ID') : 'Kurang Rp ' + Math.abs(diff).toLocaleString('id-ID');
    }
</script>
@endsection