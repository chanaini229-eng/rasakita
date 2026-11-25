<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class AdminReportController extends Controller
{
    public function index(Request $request)
    {
        $customers = User::where('role', 'pelanggan')->orderBy('name')->get();
        $query = Order::with(['items', 'user'])->latest();

        if ($request->filled('user_id') && $request->user_id !== 'semua') {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('payment_status') && $request->payment_status !== 'semua') {
            $query->where('payment_status', $request->payment_status);
        }

        $orders = $query->paginate(12)->withQueryString();

        $statsQuery = Order::query();
        if ($request->filled('user_id') && $request->user_id !== 'semua') {
            $statsQuery->where('user_id', $request->user_id);
        }

        $totalRevenue = (clone $statsQuery)->where('payment_status', 'paid')->sum('total_price');
        $totalOrders = (clone $statsQuery)->count();
        $pendingOrders = (clone $statsQuery)->where('payment_status', 'pending')->count();

        return view('admin.reports.index', compact(
            'orders',
            'customers',
            'totalRevenue',
            'totalOrders',
            'pendingOrders'
        ));
    }
}