@extends('layouts.app')

@section('title', 'Ubah Pengeluaran')

@section('content')
<div class="mb-8">
    <a href="{{ route('expense.index') }}" class="text-sm text-gray-500 hover:text-blue-600 transition flex items-center gap-2 mb-2">
        <i class="fa-solid fa-arrow-left"></i> Kembali ke Riwayat
    </a>
    <h1 class="text-2xl font-bold text-gray-800">Ubah Catatan Pengeluaran</h1>
</div>

<div class="max-w-2xl bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
    <form action="{{ route('expense.update', $expense->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- Nama Pengeluaran --}}
        <div>
            <label for="expense_name" class="block text-sm font-semibold text-gray-700 mb-2">Nama Pengeluaran</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                    <i class="fa-solid fa-basket-shopping"></i>
                </div>
                <input type="text" name="expense_name" id="expense_name" value="{{ old('expense_name', $expense->expense_name) }}" placeholder="Contoh: Belanja Bulanan" class="w-full pl-11 pr-4 py-3 rounded-xl border @error('expense_name') border-red-300 ring-1 ring-red-300 @else border-gray-200 @enderror focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition text-sm">
            </div>
            @error('expense_name')
                <p class="text-xs text-red-500 mt-1 font-medium"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
            @enderror
        </div>

        {{-- Pilihan Kategori --}}
        <div>
            <label for="category_id" class="block text-sm font-semibold text-gray-700 mb-2">Kategori Anggaran</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                    <i class="fa-solid fa-tags"></i>
                </div>
                <select name="category_id" id="category_id" class="w-full pl-11 pr-10 py-3 rounded-xl border appearance-none @error('category_id') border-red-300 ring-1 ring-red-300 @else border-gray-200 @enderror focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition text-sm bg-white">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $expense->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->category_name }} (Limit: Rp {{ number_format($category->monthly_limit, 0, ',', '.') }})
                        </option>
                    @endforeach
                </select>
                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-gray-400">
                    <i class="fa-solid fa-chevron-down text-xs"></i>
                </div>
            </div>
            @error('category_id')
                <p class="text-xs text-red-500 mt-1 font-medium"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            {{-- Nominal Pengeluaran --}}
            <div>
                <label for="amount" class="block text-sm font-semibold text-gray-700 mb-2">Jumlah Nominal (Rp)</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 font-bold text-xs">
                        Rp
                    </div>
                    <input type="number" name="amount" id="amount" value="{{ old('amount', $expense->amount) }}" placeholder="Contoh: 35000" class="w-full pl-11 pr-4 py-3 rounded-xl border @error('amount') border-red-300 ring-1 ring-red-300 @else border-gray-200 @enderror focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition text-sm">
                </div>
                @error('amount')
                    <p class="text-xs text-red-500 mt-1 font-medium"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
                @enderror
            </div>

            {{-- Tanggal Pengeluaran --}}
            <div>
                <label for="expense_date" class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Transaksi</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                        <i class="fa-solid fa-calendar-day"></i>
                    </div>
                    <input type="date" name="expense_date" id="expense_date" value="{{ old('expense_date', $expense->expense_date ? $expense->expense_date->format('Y-m-d') : '') }}" class="w-full pl-11 pr-4 py-3 rounded-xl border @error('expense_date') border-red-300 ring-1 ring-red-300 @else border-gray-200 @enderror focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition text-sm">
                </div>
                @error('expense_date')
                    <p class="text-xs text-red-500 mt-1 font-medium"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Tombol Aksi --}}
        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-50">
            <a href="{{ route('expense.index') }}" class="px-5 py-2.5 rounded-xl border border-gray-200 text-sm font-semibold text-gray-600 hover:bg-slate-50 transition">
                Batal
            </a>
            <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-semibold shadow-sm transition">
                Update Catatan
            </button>
        </div>
    </form>
</div>
@endsection