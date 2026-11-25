@extends('layouts.app')
@section('title', 'Laporan Transaksi Pelanggan - Admin RasaKita')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Laporan Transaksi Pelanggan</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Pantau riwayat pesanan dan pembayaran tiap pelanggan secara real-time.</p>
        </div>

        <form action="{{ route('admin.reports.index') }}" method="GET" class="flex flex-wrap items-center gap-2">
            <select name="user_id" onchange="this.form.submit()" class="px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-xs font-semibold text-slate-800">
                <option value="semua">Semua Pelanggan</option>
                @foreach($customers as $cust)
                    <option value="{{ $cust->id }}" {{ request('user_id') == $cust->id ? 'selected' : '' }}>
                        {{ $cust->name }} ({{ $cust->email }})
                    </option>
                @endforeach
            </select>
            <select name="payment_status" onchange="this.form.submit()" class="px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-xs font-semibold text-slate-800">
                <option value="semua">Semua Status Bayar</option>
                <option value="paid" {{ request('payment_status') === 'paid' ? 'selected' : '' }}>Lunas (Paid)</option>
                <option value="pending" {{ request('payment_status') === 'pending' ? 'selected' : '' }}>Menunggu (Pending)</option>
            </select>
        </form>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm">
            <p class="text-xs text-slate-400 font-semibold">Total Pendapatan (Lunas)</p>
            <p class="text-2xl font-extrabold text-[#e8503a] mt-1">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm">
            <p class="text-xs text-slate-400 font-semibold">Jumlah Transaksi</p>
            <p class="text-2xl font-extrabold text-slate-800 mt-1">{{ $totalOrders }} Pesanan</p>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm">
            <p class="text-xs text-slate-400 font-semibold">Belum Lunas (Pending)</p>
            <p class="text-2xl font-extrabold text-amber-600 mt-1">{{ $pendingOrders }} Pesanan</p>
        </div>
    </div>

    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-slate-100 text-[11px] uppercase text-slate-400 bg-slate-50">
                    <th class="py-3.5 px-5">No. Order</th>
                    <th class="py-3.5 px-5">Pelanggan</th>
                    <th class="py-3.5 px-5">Menu Dipesan</th>
                    <th class="py-3.5 px-5">Total</th>
                    <th class="py-3.5 px-5">Status</th>
                    <th class="py-3.5 px-5 text-right">Struk</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-xs">
                @forelse($orders as $order)
                    <tr class="hover:bg-slate-50/70">
                        <td class="py-4 px-5 font-bold text-slate-800">
                            {{ $order->order_number }}
                            <div class="text-[10px] text-slate-400 font-normal">{{ $order->created_at->format('d M Y, H:i') }}</div>
                        </td>
                        <td class="py-4 px-5">
                            <p class="font-bold text-slate-800">{{ $order->customer_name }}</p>
                            <p class="text-[11px] text-slate-400">{{ $order->user->email ?? 'Walk-In' }}</p>
                        </td>
                        <td class="py-4 px-5 text-slate-600">
                            @foreach($order->items as $item)
                                <div>{{ $item->quantity }}x {{ $item->menu_name }}</div>
                            @endforeach
                        </td>
                        <td class="py-4 px-5 font-extrabold text-[#e8503a]">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                        <td class="py-4 px-5">
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold {{ $order->payment_status === 'paid' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                {{ strtoupper($order->payment_status) }}
                            </span>
                        </td>
                        <td class="py-4 px-5 text-right">
                            <a href="{{ route('order.receipt', $order->id) }}" class="px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-orange-50 text-slate-700 hover:text-[#e8503a] font-bold">
                                Lihat Struk
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-10 text-center text-slate-400">Belum ada transaksi ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $orders->links() }}</div>
</div>
@endsection