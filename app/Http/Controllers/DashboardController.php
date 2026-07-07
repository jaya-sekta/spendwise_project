<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Category;
use App\Models\Challenge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // 1. Hitung Total Pengeluaran & Sisa Anggaran Bulan Ini
        $totalPengeluaran = Expense::where('user_id', $userId)
            ->whereMonth('expense_date', $currentMonth)
            ->whereYear('expense_date', $currentYear)
            ->sum('amount');

        $totalAnggaran = Category::where('user_id', $userId)->sum('monthly_limit');
        $sisaAnggaran = $totalAnggaran - $totalPengeluaran;

        // 2. Hitung Kategori yang Over Budget
        // Mengambil kategori user, lalu mengecek apakah pengeluaran bulan ini melebihi limit
        $categories = Category::where('user_id', $userId)->get();
        $overBudgetCount = 0;
        
        foreach ($categories as $category) {
            $expensePerCategory = Expense::where('category_id', $category->id)
                ->whereMonth('expense_date', $currentMonth)
                ->sum('amount');
                
            if ($expensePerCategory > $category->monthly_limit) {
                $overBudgetCount++;
            }
        }

        // 3. Ambil 5 Transaksi Terakhir
        $recentExpenses = Expense::with('category')
            ->where('user_id', $userId)
            ->latest('expense_date')
            ->take(5)
            ->get();

        // 4. Ambil 1 Challenge Aktif
        $activeChallenge = Challenge::with('category')
            ->where('user_id', $userId)
            ->where('status', 'active')
            ->first();

        // 5. Siapkan Data untuk Chart (Pengeluaran per Kategori)
        $chartData = Expense::with('category')
            ->selectRaw('category_id, sum(amount) as total')
            ->where('user_id', $userId)
            ->whereMonth('expense_date', $currentMonth)
            ->groupBy('category_id')
            ->get();

        return view('dashboard', compact(
            'totalPengeluaran',
            'totalAnggaran',
            'sisaAnggaran',
            'overBudgetCount',
            'recentExpenses',
            'activeChallenge',
            'chartData'
        ));
    }
}