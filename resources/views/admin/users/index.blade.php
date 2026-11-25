@extends('layouts.app')
@section('title', 'Kelola Pengguna & Role - Admin RasaKita')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">

    <!-- Header -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Kelola Pengguna & Role</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Tambah akun pengguna baru, pantau aktivitas login, dan atur hak akses (Role) setiap akun.</p>
        </div>

        <div class="flex flex-wrap items-center gap-2">
            <form action="{{ route('admin.users.index') }}" method="GET" class="flex flex-wrap items-center gap-2">
                <input type="text" name="cari" value="{{ request('cari') }}" placeholder="Cari nama / email..." class="px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-xs">
                <select name="role" onchange="this.form.submit()" class="px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-xs font-semibold text-slate-800">
                    <option value="semua">Semua Role ({{ $stats['total'] }})</option>
                    <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin ({{ $stats['admin'] }})</option>
                    <option value="kasir" {{ request('role') === 'kasir' ? 'selected' : '' }}>Kasir ({{ $stats['kasir'] }})</option>
                    <option value="pelanggan" {{ request('role') === 'pelanggan' ? 'selected' : '' }}>Pelanggan ({{ $stats['pelanggan'] }})</option>
                </select>
                <button type="submit" class="px-4 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold transition">Cari</button>
            </form>

            <button type="button" onclick="openAddUserModal()" class="btn-brand px-4 py-2.5 rounded-xl text-xs font-bold flex items-center gap-1.5 shadow-sm">
                <i class="fa-solid fa-user-plus"></i>
                <span>Tambah Pengguna</span>
            </button>
        </div>
    </div>

    <!-- Ringkasan Jumlah Role -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8">
        <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm">
            <p class="text-xs text-slate-400 font-semibold">Total Pengguna</p>
            <p class="text-2xl font-extrabold text-slate-900 mt-1">{{ $stats['total'] }}</p>
        </div>
        <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm">
            <p class="text-xs text-slate-400 font-semibold">Role Admin</p>
            <p class="text-2xl font-extrabold text-emerald-600 mt-1">{{ $stats['admin'] }}</p>
        </div>
        <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm">
            <p class="text-xs text-slate-400 font-semibold">Role Kasir</p>
            <p class="text-2xl font-extrabold text-blue-600 mt-1">{{ $stats['kasir'] }}</p>
        </div>
        <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm">
            <p class="text-xs text-slate-400 font-semibold">Role Pelanggan</p>
            <p class="text-2xl font-extrabold text-[#e8503a] mt-1">{{ $stats['pelanggan'] }}</p>
        </div>
    </div>

    <!-- Tabel Pengguna & Aktivitas Login -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-slate-100 text-[11px] uppercase text-slate-400 bg-slate-50">
                    <th class="py-3.5 px-5">Pengguna</th>
                    <th class="py-3.5 px-5">Kontak</th>
                    <th class="py-3.5 px-5">Status / Aktivitas Login</th>
                    <th class="py-3.5 px-5">Role Saat Ini</th>
                    <th class="py-3.5 px-5 text-right">Ubah Role</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-xs">
                @forelse($users as $u)
                    @php
                        $sessionInfo = $activeSessions->get($u->id);
                        $isOnline = $sessionInfo && (\Carbon\Carbon::createFromTimestamp($sessionInfo->last_activity)->diffInMinutes(now()) <= 15);
                    @endphp
                    <tr class="hover:bg-slate-50/70">
                        <td class="py-4 px-5">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-orange-50 text-[#e8503a] flex items-center justify-center font-extrabold text-xs">
                                    {{ strtoupper(substr($u->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-bold text-slate-800">
                                        {{ $u->name }}
                                        @if($u->id === auth()->id())
                                            <span class="ml-1 text-[10px] px-2 py-0.5 rounded-full bg-slate-200 text-slate-700">Anda</span>
                                        @endif
                                    </p>
                                    <p class="text-[11px] text-slate-400">{{ $u->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-5 text-slate-600">
                            <div>{{ $u->phone ?: '-' }}</div>
                            <div class="text-[10px] text-slate-400">Terdaftar: {{ $u->created_at ? $u->created_at->format('d M Y') : '-' }}</div>
                        </td>
                        <td class="py-4 px-5">
                            @if($sessionInfo)
                                <div class="flex items-center gap-1.5">
                                    <span class="w-2 h-2 rounded-full {{ $isOnline ? 'bg-emerald-500 animate-pulse' : 'bg-amber-400' }}"></span>
                                    <span class="font-semibold {{ $isOnline ? 'text-emerald-700' : 'text-slate-600' }}">
                                        {{ $isOnline ? 'Sedang Login (Online)' : 'Terakhir Aktif' }}
                                    </span>
                                </div>
                                <p class="text-[10px] text-slate-400 mt-0.5">
                                    {{ \Carbon\Carbon::createFromTimestamp($sessionInfo->last_activity)->diffForHumans() }}
                                    @if($sessionInfo->ip_address) • IP: {{ $sessionInfo->ip_address }} @endif
                                </p>
                            @else
                                <span class="text-slate-400 italic">Belum ada sesi aktif</span>
                            @endif
                        </td>
                        <td class="py-4 px-5">
                            @if($u->role === 'admin')
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-700 uppercase">Admin</span>
                            @elseif($u->role === 'kasir')
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-blue-100 text-blue-700 uppercase">Kasir</span>
                            @else
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-orange-100 text-orange-700 uppercase">Pelanggan</span>
                            @endif
                        </td>
                        <td class="py-4 px-5 text-right">
                            <form action="{{ route('admin.users.role', $u->id) }}" method="POST" class="inline-flex items-center gap-2">
                                @csrf
                                @method('PATCH')
                                <select name="role" class="px-3 py-1.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-700">
                                    <option value="pelanggan" {{ $u->role === 'pelanggan' ? 'selected' : '' }}>Pelanggan</option>
                                    <option value="kasir" {{ $u->role === 'kasir' ? 'selected' : '' }}>Kasir</option>
                                    <option value="admin" {{ $u->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                </select>
                                <button type="submit" class="px-3 py-1.5 rounded-xl bg-slate-900 hover:bg-[#e8503a] text-white text-xs font-bold transition">
                                    Simpan
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-10 text-center text-slate-400">Tidak ada pengguna yang sesuai.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $users->links() }}</div>
</div>

<!-- Modal Tambah Pengguna Baru -->
<div id="addUserModal" class="fixed inset-0 z-50 {{ $errors->any() ? 'flex' : 'hidden' }} items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 shadow-2xl border border-slate-100 max-h-[92vh] overflow-y-auto">
        <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-5">
            <div class="flex items-center gap-2.5">
                <div class="w-9 h-9 rounded-xl bg-orange-50 text-[#e8503a] flex items-center justify-center">
                    <i class="fa-solid fa-user-plus"></i>
                </div>
                <div>
                    <h3 class="text-base font-extrabold text-slate-900">Tambah Pengguna Baru</h3>
                    <p class="text-[11px] text-slate-400">Pilih role dan lengkapi data akun pengguna baru</p>
                </div>
            </div>
            <button type="button" onclick="closeAddUserModal()" class="text-slate-400 hover:text-slate-600">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        @if($errors->any())
            <div class="mb-4 p-3 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 text-xs space-y-1">
                @foreach($errors->all() as $error)
                    <div>• {{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Pilihan Role Pengguna (Kartu Visual) -->
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-2">Pilih Role Pengguna *</label>
                <div class="grid grid-cols-3 gap-2.5">
                    <label class="cursor-pointer">
                        <input type="radio" name="role" value="pelanggan" class="peer sr-only" {{ old('role', 'pelanggan') === 'pelanggan' ? 'checked' : '' }}>
                        <div class="p-3 rounded-2xl border-2 border-slate-200 bg-slate-50 peer-checked:border-[#e8503a] peer-checked:bg-orange-50/70 transition text-center">
                            <i class="fa-solid fa-user text-base text-[#e8503a] mb-1"></i>
                            <p class="text-xs font-extrabold text-slate-800">Pelanggan</p>
                            <p class="text-[10px] text-slate-500 mt-0.5">Pesan makanan</p>
                        </div>
                    </label>

                    <label class="cursor-pointer">
                        <input type="radio" name="role" value="kasir" class="peer sr-only" {{ old('role') === 'kasir' ? 'checked' : '' }}>
                        <div class="p-3 rounded-2xl border-2 border-slate-200 bg-slate-50 peer-checked:border-blue-600 peer-checked:bg-blue-50/70 transition text-center">
                            <i class="fa-solid fa-cash-register text-base text-blue-600 mb-1"></i>
                            <p class="text-xs font-extrabold text-slate-800">Kasir</p>
                            <p class="text-[10px] text-slate-500 mt-0.5">Konfirmasi & struk</p>
                        </div>
                    </label>

                    <label class="cursor-pointer">
                        <input type="radio" name="role" value="admin" class="peer sr-only" {{ old('role') === 'admin' ? 'checked' : '' }}>
                        <div class="p-3 rounded-2xl border-2 border-slate-200 bg-slate-50 peer-checked:border-emerald-600 peer-checked:bg-emerald-50/70 transition text-center">
                            <i class="fa-solid fa-user-shield text-base text-emerald-600 mb-1"></i>
                            <p class="text-xs font-extrabold text-slate-800">Admin</p>
                            <p class="text-[10px] text-slate-500 mt-0.5">Akses penuh</p>
                        </div>
                    </label>
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Lengkap *</label>
                <input type="text" name="name" value="{{ old('name') }}" required placeholder="Contoh: Andi Pratama" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-[#e8503a]">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Email *</label>
                    <input type="email" name="email" value="{{ old('email') }}" required placeholder="andi@rasakita.com" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-[#e8503a]">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Password *</label>
                    <input type="password" name="password" required minlength="6" placeholder="Min. 6 karakter" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-[#e8503a]">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">No. HP / WhatsApp</label>
                <input type="text" name="phone" value="{{ old('phone') }}" placeholder="0812xxxxxxxx" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-[#e8503a]">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Alamat</label>
                <textarea name="address" rows="2" placeholder="Alamat lengkap pengguna (opsional)" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-[#e8503a]">{{ old('address') }}</textarea>
            </div>

            <div class="pt-3 flex justify-end gap-2">
                <button type="button" onclick="closeAddUserModal()" class="px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 hover:bg-slate-50">
                    Batal
                </button>
                <button type="submit" class="btn-brand px-5 py-2.5 rounded-xl text-xs font-bold">
                    Simpan Pengguna
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openAddUserModal() {
        const modal = document.getElementById('addUserModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }
    function closeAddUserModal() {
        const modal = document.getElementById('addUserModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>
@endsection