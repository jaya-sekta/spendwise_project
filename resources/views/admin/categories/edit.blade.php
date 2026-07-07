@extends('layouts.admin')

@section('title', 'Edit Kategori Bawaan')

@section('content')

    <div class="mb-8">
        <a href="{{ route('admin.categories.index') }}"
           class="text-sm text-gray-500 hover:text-slate-800 inline-flex items-center gap-1.5 mb-3">
            <i class="fa-solid fa-arrow-left text-xs"></i> Kembali
        </a>
        <h1 class="text-2xl font-bold text-gray-800">Edit Kategori Bawaan</h1>
        <p class="text-gray-500 text-sm mt-1">Perubahan akan berlaku untuk semua user.</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 max-w-xl">
        <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Kategori</label>
                <input type="text" name="category_name" value="{{ old('category_name', $category->category_name) }}"
                       placeholder="Misal: Makanan & Minuman"
                       class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-amber-400 focus:border-amber-400 outline-none">
                @error('category_name')
                    <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Tipe Kategori</label>
                <select name="category_type"
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-amber-400 focus:border-amber-400 outline-none">
                    <option value="primary" {{ old('category_type', $category->category_type) == 'primary' ? 'selected' : '' }}>Primer (kebutuhan pokok)</option>
                    <option value="consumptive" {{ old('category_type', $category->category_type) == 'consumptive' ? 'selected' : '' }}>Konsumtif (gaya hidup)</option>
                </select>
                @error('category_type')
                    <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Limit Bulanan (Rp)</label>
                <input type="number" name="monthly_limit" value="{{ old('monthly_limit', $category->monthly_limit) }}" min="0"
                       placeholder="500000"
                       class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-amber-400 focus:border-amber-400 outline-none">
                <p class="text-xs text-gray-400 mt-1.5">Ini nilai default, user tetap bisa menyesuaikan limitnya sendiri nanti.</p>
                @error('monthly_limit')
                    <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-3 flex gap-3">
                <button type="submit"
                        class="bg-slate-900 hover:bg-slate-800 text-white text-sm font-semibold px-6 py-2.5 rounded-xl shadow-sm transition">
                    Update Kategori
                </button>
                <a href="{{ route('admin.categories.index') }}"
                   class="text-sm font-semibold px-6 py-2.5 rounded-xl text-gray-500 hover:bg-gray-50 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>

@endsection