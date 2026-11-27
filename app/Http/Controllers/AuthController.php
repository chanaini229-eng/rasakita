<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            $user = Auth::user();

            if ($user->role === 'admin') {
                return redirect()->intended(route('admin.menus.index'))->with('success', 'Selamat datang kembali, ' . $user->name . ' (Admin)!');
            } elseif ($user->role === 'kasir') {
                return redirect()->intended(route('kasir.dashboard'))->with('success', 'Selamat datang kembali, ' . $user->name . ' (Kasir)!');
            }

            return redirect()->intended(route('home'))->with('success', 'Selamat datang kembali, ' . $user->name . '!');
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:500'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'pelanggan',
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'] ?? null,
        ]);

        Auth::login($user);

        return redirect()->route('home')->with('success', 'Akun berhasil dibuat! Selamat datang di RasaKita.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('info', 'Anda telah berhasil keluar.');
    }

    /**
     * Switcher akun untuk memverifikasi isolasi transaksi dan peran antar role
     */
    public function quickLogin($role)
    {
        if ($role === 'admin') {
            $user = User::where('role', 'admin')->first();
        } elseif ($role === 'kasir') {
            $user = User::where('role', 'kasir')->first();
        } elseif ($role === 'pelanggan') {
            $user = User::where('email', 'pelanggan@rasakita.com')->first();
        } elseif ($role === 'siti') {
            $user = User::where('email', 'siti@rasakita.com')->first();
        }

        if (isset($user) && $user) {
            Auth::login($user);
            if ($user->role === 'admin') {
                return redirect()->route('admin.menus.index')->with('success', 'Berhasil beralih akun: ' . $user->name . ' (Admin)');
            } elseif ($user->role === 'kasir') {
                return redirect()->route('kasir.dashboard')->with('success', 'Berhasil beralih akun: ' . $user->name . ' (Kasir)');
            }
            return redirect()->route('home')->with('success', 'Berhasil beralih akun: ' . $user->name . ' (Pelanggan)');
        }

        return back()->with('error', 'Pengguna tidak ditemukan.');
    }
}
