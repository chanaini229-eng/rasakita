<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminMenuController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::withCount('menus')->get();
        $query = Menu::with('category')->latest();

        if ($request->filled('cari')) {
            $query->where('name', 'like', '%' . $request->cari . '%');
        }

        if ($request->filled('kategori') && $request->kategori !== 'semua') {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->kategori));
        }

        $menus = $query->paginate(12)->withQueryString();

        return view('admin.menus.index', compact('menus', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.menus.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|url',
            'image_file' => 'nullable|image|max:2048',
            'is_popular' => 'nullable|boolean',
        ]);

        $imagePath = $validated['image'] ?? 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&w=800&q=80';
        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('menus', 'public');
            $imagePath = asset('storage/' . $path);
        }

        $baseSlug = Str::slug($validated['name']);
        $slug = Menu::where('slug', $baseSlug)->exists()
            ? $baseSlug . '-' . strtolower(Str::random(4))
            : $baseSlug;

        Menu::create([
            'name' => $validated['name'],
            'slug' => $slug,
            'category_id' => $validated['category_id'],
            'price' => $validated['price'],
            'description' => $validated['description'] ?? 'Menu spesial pilihan dari dapur RasaKita.',
            'image' => $imagePath,
            'is_popular' => $request->boolean('is_popular'),
            'rating' => 4.8,
            'reviews_count' => 1,
        ]);

        return redirect()->route('admin.menus.index')->with('success', 'Menu baru berhasil ditambahkan!');
    }

    public function edit(Menu $menu)
    {
        $categories = Category::all();
        return view('admin.menus.edit', compact('menu', 'categories'));
    }

    public function update(Request $request, Menu $menu)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|url',
            'image_file' => 'nullable|image|max:2048',
            'is_popular' => 'nullable|boolean',
        ]);

        $imagePath = $menu->image;
        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('menus', 'public');
            $imagePath = asset('storage/' . $path);
        } elseif (!empty($validated['image'])) {
            $imagePath = $validated['image'];
        }

        $slug = $menu->slug;
        if ($menu->name !== $validated['name'] || empty($slug)) {
            $baseSlug = Str::slug($validated['name']);
            $slug = Menu::where('slug', $baseSlug)->where('id', '!=', $menu->id)->exists()
                ? $baseSlug . '-' . strtolower(Str::random(4))
                : $baseSlug;
        }

        $menu->update([
            'name' => $validated['name'],
            'slug' => $slug,
            'category_id' => $validated['category_id'],
            'price' => $validated['price'],
            'description' => $validated['description'] ?? $menu->description,
            'image' => $imagePath,
            'is_popular' => $request->boolean('is_popular'),
        ]);

        return redirect()->route('admin.menus.index')->with('success', 'Menu "' . $menu->name . '" berhasil diperbarui!');
    }

    public function destroy(Menu $menu)
    {
        $name = $menu->name;
        $menu->delete();

        return redirect()->route('admin.menus.index')->with('success', 'Menu "' . $name . '" berhasil dihapus!');
    }
}