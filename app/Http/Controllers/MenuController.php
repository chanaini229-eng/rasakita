<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Menampilkan katalog menu untuk pelanggan.
     * Mode Read-Only: Pelanggan hanya melihat dan memesan menu.
     */
    public function index(Request $request)
    {
        $categories = Category::withCount('menus')->get();
        $selectedCategory = $request->query('kategori');
        $search = $request->query('cari');
        $sort = $request->query('urutan', 'default');

        $query = Menu::with('category')->where('is_available', true);

        if ($selectedCategory && $selectedCategory !== 'semua') {
            $query->whereHas('category', function ($q) use ($selectedCategory) {
                $q->where('slug', $selectedCategory);
            });
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('category', function ($catQ) use ($search) {
                      $catQ->where('name', 'like', "%{$search}%");
                  });
            });
        }

        if ($sort === 'termurah') {
            $query->orderBy('price', 'asc');
        } elseif ($sort === 'termahal') {
            $query->orderBy('price', 'desc');
        } elseif ($sort === 'rating') {
            $query->orderBy('rating', 'desc');
        } else {
            $query->latest();
        }

        $menus = $query->paginate(12)->withQueryString();

        return view('pelanggan.menu', compact('menus', 'categories', 'selectedCategory', 'search', 'sort'));
    }

    /**
     * ATURAN PELANGGAN 1:
     * Pelanggan TIDAK BISA tambah menu.
     */
    public function store(Request $request)
    {
        abort(403, 'Akses Ditolak: Role Pelanggan tidak memiliki izin untuk menambah menu.');
    }

    /**
     * ATURAN PELANGGAN 1:
     * Pelanggan TIDAK BISA edit menu.
     */
    public function update(Request $request, Menu $menu)
    {
        abort(403, 'Akses Ditolak: Role Pelanggan tidak memiliki izin untuk mengedit menu.');
    }

    /**
     * ATURAN PELANGGAN 1:
     * Pelanggan TIDAK BISA hapus menu.
     */
    public function destroy(Menu $menu)
    {
        abort(403, 'Akses Ditolak: Role Pelanggan tidak memiliki izin untuk menghapus menu.');
    }
}
