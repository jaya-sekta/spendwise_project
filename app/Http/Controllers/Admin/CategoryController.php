<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Hanya menampilkan kategori bawaan (is_default = true)
    public function index()
    {
        $categories = Category::default()
            ->latest()
            ->paginate(10);

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_name' => 'required|string|max:255',
            'monthly_limit' => 'required|numeric|min:0',
            'category_type' => 'required|in:primary,consumptive',
        ]);

        Category::create([
            'user_id'       => null,   // kategori bawaan tidak punya pemilik
            'is_default'    => true,
            'category_name' => $validated['category_name'],
            'monthly_limit' => $validated['monthly_limit'],
            'category_type' => $validated['category_type'],
        ]);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Kategori bawaan berhasil ditambahkan.');
    }

    public function edit(Category $category)
    {
        $this->ensureIsDefault($category);

        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $this->ensureIsDefault($category);

        $validated = $request->validate([
            'category_name' => 'required|string|max:255',
            'monthly_limit' => 'required|numeric|min:0',
            'category_type' => 'required|in:primary,consumptive',
        ]);

        $category->update($validated);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Kategori bawaan berhasil diupdate.');
    }

    public function destroy(Category $category)
    {
        $this->ensureIsDefault($category);
        $category->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Kategori bawaan berhasil dihapus.');
    }

    // Pastikan admin hanya bisa CRUD kategori bawaan, bukan kategori milik user
    private function ensureIsDefault(Category $category): void
    {
        if (! $category->is_default) {
            abort(403, 'Kategori ini milik user, tidak bisa dikelola dari admin.');
        }
    }
}