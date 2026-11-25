<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query()->latest();

        if ($request->filled('cari')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->cari . '%')
                  ->orWhere('email', 'like', '%' . $request->cari . '%');
            });
        }

        if ($request->filled('role') && $request->role !== 'semua') {
            $query->where('role', $request->role);
        }

        $users = $query->paginate(12)->withQueryString();

        $activeSessions = collect();
        if (Schema::hasTable('sessions')) {
            $activeSessions = DB::table('sessions')
                ->whereNotNull('user_id')
                ->select('user_id', DB::raw('MAX(last_activity) as last_activity'), DB::raw('MAX(ip_address) as ip_address'))
                ->groupBy('user_id')
                ->get()
                ->keyBy('user_id');
        }

        $stats = [
            'total' => User::count(),
            'admin' => User::where('role', 'admin')->count(),
            'kasir' => User::where('role', 'kasir')->count(),
            'pelanggan' => User::where('role', 'pelanggan')->count(),
        ];

        return view('admin.users.index', compact('users', 'activeSessions', 'stats'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
            'role' => ['required', 'in:admin,kasir,pelanggan'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:500'],
        ], [
            'name.required' => 'Nama pengguna wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email ini sudah terdaftar pada akun lain.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'] ?? null,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'Pengguna baru "' . $user->name . '" dengan role ' . strtoupper($user->role) . ' berhasil ditambahkan!');
    }

    public function updateRole(Request $request, User $user)
    {
        $validated = $request->validate([
            'role' => 'required|in:admin,kasir,pelanggan',
        ]);

        if ($user->id === Auth::id() && $validated['role'] !== 'admin') {
            return back()->with('error', 'Anda tidak dapat menurunkan role akun Admin yang sedang Anda gunakan sendiri.');
        }

        $oldRole = strtoupper($user->role);
        $user->update(['role' => $validated['role']]);

        return back()->with('success', 'Role pengguna "' . $user->name . '" berhasil diubah dari ' . $oldRole . ' menjadi ' . strtoupper($validated['role']) . '.');
    }
}