@extends('layouts.app')

@section('title', 'Edit Kategori')

@section('content')
<div class="mb-8">
    <a href="{{ route('categories.index') }}" class="text-sm text-gray-500 hover:text-blue-600 transition flex items-center gap-2 mb-2">
        <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Kategori
    </a>
    <h1 class="text-2xl font-bold text-gray-800">Edit Kategori: {{ $category->category_name }}</h1>
</div>

<div class="max-w-2xl bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
    <form action="{{ route('categories.update', $category->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- Nama Kategori --}}
        <div>
            <label for="category_name" class="block text-sm font-semibold text-gray-700 mb-2">Nama Kategori</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                    <i class="fa-solid fa-tag"></i>
                </div>
                <input type="text" name="category_name" id="category_name" value="{{ old('category_name', $category->category_name) }}" placeholder="Contoh: Makanan & Minuman" class="w-full pl-11 pr-4 py-3 rounded-xl border @error('category_name') border-red-300 ring-1 ring-red-300 @else border-gray-200 @enderror focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition text-sm">
            </div>
            @error('category_name')
                <p class="text-xs text-red-500 mt-1 font-medium"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
            @enderror
        </div>

        {{-- Tipe Kategori --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Tipe Kategori</label>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <label class="relative flex p-4 rounded-xl border border-gray-200 cursor-pointer hover:bg-slate-50 transition focus-within:ring-2 focus-within:ring-blue-500/20">
                    <input type="radio" name="category_type" value="primary" {{ old('category_type', $category->category_type) === 'primary' ? 'checked' : '' }} class="mt-0.5 text-blue-600 focus:ring-blue-500 h-4 w-4 border-gray-300">
                    <span class="ml-3 flex flex-col">
                        <span class="block text-sm font-bold text-gray-800">Primer</span>
                        <span class="block text-xs text-gray-500 mt-0.5">Kebutuhan utama yang wajib dipenuhi.</span>
                    </span>
                </label>

                <label class="relative flex p-4 rounded-xl border border-gray-200 cursor-pointer hover:bg-slate-50 transition focus-within:ring-2 focus-within:ring-blue-500/20">
                    <input type="radio" name="category_type" value="consumptive" {{ old('category_type', $category->category_type) === 'consumptive' ? 'checked' : '' }} class="mt-0.5 text-blue-600 focus:ring-blue-500 h-4 w-4 border-gray-300">
                    <span class="ml-3 flex flex-col">
                        <span class="block text-sm font-bold text-gray-800">Konsumtif</span>
                        <span class="block text-xs text-gray-500 mt-0.5">Keinginan atau hiburan tambahan Anda.</span>
                    </span>
                </label>
            </div>
            @error('category_type')
                <p class="text-xs text-red-500 mt-1 font-medium"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
            @enderror
        </div>

        {{-- Batas Bulanan --}}
        <div>
            <label for="monthly_limit" class="block text-sm font-semibold text-gray-700 mb-2">Batas Anggaran Bulanan (Rp)</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 font-bold text-xs">
                    Rp
                </div>
                <input type="number" name="monthly_limit" id="monthly_limit" value="{{ old('monthly_limit', $category->monthly_limit) }}" placeholder="Contoh: 1500000" class="w-full pl-11 pr-4 py-3 rounded-xl border @error('monthly_limit') border-red-300 ring-1 ring-red-300 @else border-gray-200 @enderror focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition text-sm">
            </div>
            @error('monthly_limit')
                <p class="text-xs text-red-500 mt-1 font-medium"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
            @enderror
        </div>

        {{-- Tombol Aksi --}}
        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-50">
            <a href="{{ route('categories.index') }}" class="px-5 py-2.5 rounded-xl border border-gray-200 text-sm font-semibold text-gray-600 hover:bg-slate-50 transition">
                Batal
            </a>
            <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-semibold shadow-sm transition">
                Update Kategori
            </button>
        </div>
    </form>
</div>
@endsection