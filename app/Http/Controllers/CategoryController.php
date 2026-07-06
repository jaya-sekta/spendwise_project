<?php
// app/Http/Controllers/CategoryController.php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index()
    {
        // Gabungan: kategori bawaan (dibuat admin) + kategori milik user sendiri
        $categories = Category::visibleTo(Auth::id())
            ->orderByDesc('is_default') // bawaan tampil duluan
            ->orderBy('category_name')
            ->paginate(10);

        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_name' => 'required|string|max:255',
            'monthly_limit' => 'required|numeric|min:0',
            'category_type' => 'required|string|max:100',
        ]);

        Category::create([
            'user_id'       => Auth::id(),
            'is_default'    => false, // kategori yang dibuat user selalu custom
            'category_name' => $validated['category_name'],
            'monthly_limit' => $validated['monthly_limit'],
            'category_type' => $validated['category_type'],
        ]);

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function show(Category $category)
{
    $this->authorizeAccess($category); // sudah ada, cek bawaan atau milik sendiri

    $spent = Expense::where('category_id', $category->id)
        ->where('user_id', Auth::id())
        ->whereMonth('expense_date', now()->month)
        ->whereYear('expense_date', now()->year)
        ->sum('amount');

    $remaining  = max(0, $category->monthly_limit - $spent);
    $percentage = $category->monthly_limit > 0
        ? min(100, round(($spent / $category->monthly_limit) * 100))
        : 0;

    $expenses = Expense::where('category_id', $category->id)
        ->where('user_id', Auth::id())
        ->whereMonth('expense_date', now()->month)
        ->whereYear('expense_date', now()->year)
        ->latest('expense_date')
        ->get();

    return view('categories.show', compact('category', 'spent', 'remaining', 'percentage', 'expenses'));
}

    public function edit(Category $category)
    {
        $this->authorizeOwner($category); // kategori bawaan tidak boleh diedit user

        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $this->authorizeOwner($category);

        $validated = $request->validate([
            'category_name' => 'required|string|max:255',
            'monthly_limit' => 'required|numeric|min:0',
            'category_type' => 'required|string|max:100',
        ]);

        $category->update($validated);

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil diupdate.');
    }

    public function destroy(Category $category)
    {
        $this->authorizeOwner($category);
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil dihapus.');
    }

    // Boleh dilihat kalau kategori bawaan ATAU milik sendiri
    private function authorizeAccess(Category $category): void
    {
        if (! $category->is_default && $category->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }
    }

    // Hanya boleh diedit/dihapus kalau milik sendiri (bukan kategori bawaan)
    private function authorizeOwner(Category $category): void
    {
        if ($category->is_default || $category->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }
    }
}