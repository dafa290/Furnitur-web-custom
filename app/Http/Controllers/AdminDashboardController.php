<?php

namespace App\Http\Controllers;

use App\Models\OrderHistory;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalSales = OrderHistory::whereNotIn('status', ['PENDING', 'CANCELLED', 'Menunggu pembayaran (DOKU)', 'BATAL', 'FAILED'])->sum('total_amount');
        $totalOrders = OrderHistory::count();
        $totalProducts = Product::count();
        $totalUsers = User::where('role', 'USER')->count();

        $recentOrders = OrderHistory::with('user')->orderBy('created_at', 'desc')->take(5)->get();
        $lowStockProducts = Product::where('stock', '<', 10)->take(5)->get();

        return view('admin.dashboard', compact(
            'totalSales', 
            'totalOrders', 
            'totalProducts', 
            'totalUsers',
            'recentOrders',
            'lowStockProducts'
        ));
    }
}
