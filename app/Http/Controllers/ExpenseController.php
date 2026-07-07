<?php
// app/Http/Controllers/ExpenseController.php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::with('category')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('expense.index', compact('expenses'));
    }

    public function create()
    {
        $categories = \App\Models\Category::where('user_id', auth()->id())
        ->orWhere('is_default', true)
        ->get();

    return view('expense.create', compact('categories'));
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'expense_name' => 'required|string|max:255',
        'category_id'  => 'required|exists:categories,id', // Memastikan ID kategori valid
        'amount'       => 'required|numeric|min:1',
        'expense_date' => 'required|date',
    ]);

    // Simpan data
    \App\Models\Expense::create([
        'user_id'      => auth()->id(),
        'category_id'  => $validated['category_id'],
        'expense_name' => $validated['expense_name'],
        'amount'       => $validated['amount'],
        'expense_date' => $validated['expense_date'],
    ]);

    return redirect()->route('expense.index')->with('success', 'Pengeluaran berhasil dicatat.');
}

    public function show(Expense $expense)
    {
        $this->authorizeOwner($expense->user_id);

        return view('expense.show', compact('expense'));
    }

    public function edit(Expense $expense)
    {
        $this->authorizeOwner($expense->user_id);

        $categories = Category::where('user_id', Auth::id())->get();

        return view('expense.edit', compact('expense', 'categories'));
    }

    public function update(Request $request, Expense $expense)
    {
        $this->authorizeOwner($expense->user_id);

        $validated = $request->validate([
            'category_id'  => 'required|exists:categories,id',
            'expense_name' => 'required|string|max:255',
            'amount'       => 'required|numeric|min:0',
            'expense_date' => 'required|date',
        ]);

        $category    = Category::findOrFail($validated['category_id']);
        $totalMonth  = Expense::where('category_id', $category->id)
            ->whereMonth('expense_date', now()->month)
            ->where('id', '!=', $expense->id)
            ->sum('amount');
        $isOverLimit = ($totalMonth + $validated['amount']) > $category->monthly_limit;

        $expense->update([
            'category_id'  => $validated['category_id'],
            'expense_name' => $validated['expense_name'],
            'amount'       => $validated['amount'],
            'expense_date' => $validated['expense_date'],
            'is_over_limit' => $isOverLimit,
        ]);

        return redirect()->route('expense.index')->with('success', 'Pengeluaran berhasil diupdate.');
    }

    public function destroy(Expense $expense)
    {
        $this->authorizeOwner($expense->user_id);
        $expense->delete();

        return redirect()->route('expense.index')->with('success', 'Pengeluaran berhasil dihapus.');
    }

    // Helper cek kepemilikan data
    private function authorizeOwner(int $userId): void
    {
        if ($userId !== Auth::id()) {
            abort(403, 'Unauthorized');
        }
    }
}