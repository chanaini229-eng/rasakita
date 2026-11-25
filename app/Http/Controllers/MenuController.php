<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->check() && auth()->user()->role === 'admin') {
            return redirect()->route('admin.menus.index');
        }

        $categories = Category::withCount('menus')->get();
        $query = Menu::with('category');

        if ($request->filled('cari')) {
            $query->where('name', 'like', '%' . $request->cari . '%');
        }

        if ($request->filled('kategori') && $request->kategori !== 'semua') {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->kategori);
            });
        }

        switch ($request->urutan) {
            case 'termurah':
                $query->orderBy('price', 'asc');
                break;
            case 'termahal':
                $query->orderBy('price', 'desc');
                break;
            case 'rating':
                $query->orderBy('rating', 'desc');
                break;
            default:
                $query->latest();
                break;
        }

        $menus = $query->paginate(12)->withQueryString();

        $viewName = view()->exists('pelanggan.menu') ? 'pelanggan.menu' : 'menu';

        return view($viewName, compact('menus', 'categories'));
    }

    public function store(Request $request)
    {
        abort(403, 'Akses Ditolak: Pelanggan tidak dapat menambah menu.');
    }

    public function update(Request $request, Menu $menu)
    {
        abort(403, 'Akses Ditolak: Pelanggan tidak dapat mengedit menu.');
    }

    public function destroy(Menu $menu)
    {
        abort(403, 'Akses Ditolak: Pelanggan tidak dapat menghapus menu.');
    }
}