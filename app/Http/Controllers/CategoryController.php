<?php
// app/Http/Controllers/CategoryController.php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::where('user_id', Auth::id())->paginate(10);

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
            'category_name' => $validated['category_name'],
            'monthly_limit' => $validated['monthly_limit'],
            'category_type' => $validated['category_type'],
        ]);

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function show(Category $category)
    {
        $this->authorizeOwner($category->user_id);

        return view('categories.show', compact('category'));
    }

    public function edit(Category $category)
    {
        $this->authorizeOwner($category->user_id);

        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $this->authorizeOwner($category->user_id);

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
        $this->authorizeOwner($category->user_id);
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil dihapus.');
    }

    private function authorizeOwner(int $userId): void
    {
        if ($userId !== Auth::id()) {
            abort(403, 'Unauthorized');
        }
    }
}