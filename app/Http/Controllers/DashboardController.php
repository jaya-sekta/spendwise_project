<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Category;
use App\Models\Challenge;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $userId       = Auth::id();
        $currentMonth = Carbon::now()->month;
        $currentYear  = Carbon::now()->year;

        // ✅ Settle challenge expired setiap kali dashboard dibuka
        $this->settleCompletedChallenges($userId);

        // 1. Total pengeluaran bulan ini
        $totalPengeluaran = Expense::where('user_id', $userId)
            ->whereMonth('expense_date', $currentMonth)
            ->whereYear('expense_date', $currentYear)
            ->sum('amount');

        // 2. Total anggaran (kategori bawaan + milik user)
        $totalAnggaran = Category::visibleTo($userId)->sum('monthly_limit');
        $sisaAnggaran  = $totalAnggaran - $totalPengeluaran;

        // 3. Hitung kategori over budget
        $categories      = Category::visibleTo($userId)->get();
        $overBudgetCount = 0;

        foreach ($categories as $category) {
            $spent = Expense::where('user_id', $userId)
                ->where('category_id', $category->id)
                ->whereMonth('expense_date', $currentMonth)
                ->whereYear('expense_date', $currentYear)
                ->sum('amount');

            if ($spent > $category->monthly_limit) {
                $overBudgetCount++;
            }
        }

        // 4. 5 Transaksi terakhir
        $recentExpenses = Expense::with('category')
            ->where('user_id', $userId)
            ->latest('expense_date')
            ->take(5)
            ->get();

        // 5. Challenge aktif
        $activeChallenge = Challenge::with('category')
            ->where('user_id', $userId)
            ->where('status', 'active')
            ->latest()
            ->first();

        // 6. Data chart pengeluaran per kategori
        $chartData = Expense::with('category')
            ->selectRaw('category_id, sum(amount) as total')
            ->where('user_id', $userId)
            ->whereMonth('expense_date', $currentMonth)
            ->whereYear('expense_date', $currentYear)
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

    // ✅ Sama persis dengan yang ada di ChallengeController
    // Dipanggil di dashboard supaya poin masuk tanpa harus buka halaman Challenge
    private function settleCompletedChallenges(int $userId): void
    {
        $expired = Challenge::where('user_id', $userId)
            ->where('status', 'active')
            ->whereDate('end_date', '<', now()->toDateString())
            ->get();

        foreach ($expired as $challenge) {
            $totalDays    = max(1, (int) $challenge->start_date->diffInDays($challenge->end_date));
            $rewardPoints = $totalDays * 10;

            if ($challenge->remaining_lives > 0) {
                $challenge->update(['status' => 'successful']);
                User::where('id', $userId)->increment('points', $rewardPoints);
            } else {
                $challenge->update(['status' => 'failed']);
            }
        }
    }
}