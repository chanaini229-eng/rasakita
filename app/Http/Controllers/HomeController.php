<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Menu;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::withCount('menus')->get();

        $selectedCategory = $request->query('kategori');
        $search = $request->query('cari');

        // Popular Menus query (for the featured row shown in screenshot)
        $popularMenus = Menu::with('category')
            ->where('is_available', true)
            ->where('is_popular', true)
            ->take(5)
            ->get();

        // All menus or filtered menus
        $menuQuery = Menu::with('category')->where('is_available', true);

        if ($selectedCategory && $selectedCategory !== 'semua') {
            $menuQuery->whereHas('category', function ($q) use ($selectedCategory) {
                $q->where('slug', $selectedCategory);
            });
        }

        if ($search) {
            $menuQuery->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('category', function ($catQ) use ($search) {
                      $catQ->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $allMenus = $menuQuery->get();

        return view('pelanggan.dashboard', compact('categories', 'popularMenus', 'allMenus', 'selectedCategory', 'search'));
    }

    public function about()
    {
        return view('pelanggan.about');
    }

    public function contact()
    {
        return view('pelanggan.contact');
    }

    public function sendContact(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        return back()->with('success', 'Terima kasih atas pesan Anda! Tim RasaKita akan segera menghubungi Anda.');
    }
}
