<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Category;
use App\Models\Reward;
use App\Models\Challenge;
// use App\Models\UserReward; // Uncomment jika sudah ada riwayat penukaran

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Ambil metrik utama
        $totalUsers = User::where('role', '!=', 'admin')->count(); // Asumsi ada kolom role
        $totalCategories = Category::count();
        $totalRewards = Reward::sum('stock');
        $activeChallenges = Challenge::where('status', 'active')->count();

        // 2. Ambil data actionable (contoh: user terbaru & stok menipis)
        $recentUsers = User::where('role', '!=', 'admin')->latest()->take(5)->get();
        $lowStockRewards = Reward::where('stock', '<=', 5)->orderBy('stock', 'asc')->take(4)->get();

        return view('admin.dashboard', compact(
            'totalUsers', 
            'totalCategories', 
            'totalRewards', 
            'activeChallenges',
            'recentUsers',
            'lowStockRewards'
        ));
    }
}