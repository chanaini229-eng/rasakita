<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Order;

class KasirDashboardController extends Controller
{
    public function index()
    {
        $totalPendapatan = Order::where('payment_status', 'paid')
            ->where('order_status', '!=', 'dibatalkan')
            ->sum('total_price');

        $totalTransaksi = Order::count();
        $pesananPerluKonfirmasi = Order::whereIn('order_status', ['menunggu', 'diproses'])->count();
        $totalMenu = Menu::count();

        $pesananTerbaru = Order::with(['user', 'items'])
            ->latest()
            ->take(8)
            ->get();

        return view('kasir.dashboard', compact(
            'totalPendapatan',
            'totalTransaksi',
            'pesananPerluKonfirmasi',
            'totalMenu',
            'pesananTerbaru'
        ));
    }
}