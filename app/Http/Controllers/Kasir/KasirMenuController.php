<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KasirMenuController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::withCount('menus')->get();

        $menus = Menu::with('category')
            ->when($request->filled('cari'), function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->cari . '%')
                  ->orWhere('description', 'like', '%' . $request->cari . '%');
            })
            ->when($request->filled('kategori') && $request->kategori !== 'semua', function ($q) use ($request) {
                $q->whereHas('category', fn ($c) => $c->where('slug', $request->kategori));
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('kasir.menu.index', compact('menus', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('kasir.menu.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:1000',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|url|max:500',
        ]);

        Menu::create([
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']) . '-' . strtolower(Str::random(4)),
            'price' => $validated['price'],
            'description' => $validated['description'] ?? null,
            'image' => $validated['image'] ?? 'https://images.unsplash.com/photo-1626082927389-6cd097cdc6ec?auto=format&fit=crop&w=600&q=80',
            'is_popular' => $request->boolean('is_popular'),
            'is_available' => $request->boolean('is_available', true),
        ]);

        return redirect()->route('kasir.menu.index')->with('success', 'Menu baru berhasil ditambahkan!');
    }

    public function edit(Menu $menu)
    {
        $categories = Category::all();
        return view('kasir.menu.edit', compact('menu', 'categories'));
    }

    public function update(Request $request, Menu $menu)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:1000',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|url|max:500',
        ]);

        $menu->update([
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'price' => $validated['price'],
            'description' => $validated['description'] ?? null,
            'image' => $validated['image'] ?: $menu->image,
            'is_popular' => $request->boolean('is_popular'),
            'is_available' => $request->boolean('is_available'),
        ]);

        return redirect()->route('kasir.menu.index')->with('success', 'Data menu berhasil diperbarui!');
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();
        return redirect()->route('kasir.menu.index')->with('success', 'Menu berhasil dihapus.');
    }
}