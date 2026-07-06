@extends('layouts.app')

@section('title', $category->category_name)

@section('content')

    <a href="{{ route('categories.index') }}" class="text-sm text-gray-500 hover:text-indigo-600 inline-flex items-center gap-1.5 mb-4">
        <i class="fa-solid fa-arrow-left text-xs"></i> Kembali ke Kategori
    </a>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6 text-sm flex items-center gap-2">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
        <div class="flex items-start justify-between mb-6">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-xl flex items-center justify-center text-xl"
                     style="background-color: {{ $category->color }}1A; color: {{ $category->color }}">
                    <i class="{{ $category->icon }}"></i>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-gray-800">{{ $category->category_name }}</h1>
                    <p class="text-sm text-gray-400">{{ $category->description }}</p>
                </div>
            </div>

            @if ($category->is_default)
                <span class="text-xs font-semibold px-3 py-1.5 rounded-lg bg-amber-50 text-amber-600 inline-flex items-center gap-1.5 shrink-0">
                    <i class="fa-solid fa-shield-halved"></i> Kategori Bawaan
                </span>
            @else
                <div class="flex gap-2 shrink-0">
                    <a href="{{ route('categories.edit', $category) }}"
                       class="text-xs font-semibold px-3 py-1.5 rounded-lg bg-gray-50 hover:bg-indigo-50 text-gray-500 hover:text-indigo-600 transition">
                        <i class="fa-solid fa-pen"></i> Edit
                    </a>
                    <form action="{{ route('categories.destroy', $category) }}" method="POST"
                          onsubmit="return confirm('Hapus kategori ini?');">
                        @csrf @method('DELETE')
                        <button type="submit"
                                class="text-xs font-semibold px-3 py-1.5 rounded-lg bg-gray-50 hover:bg-red-50 text-gray-500 hover:text-red-600 transition">
                            <i class="fa-solid fa-trash"></i> Hapus
                        </button>
                    </form>
                </div>
            @endif
        </div>

        {{-- Progress anggaran --}}
        <div class="flex justify-between items-end mb-2">
            <span class="text-sm font-semibold text-gray-700">Anggaran Bulan Ini</span>
            <span class="text-xs text-gray-400">{{ now()->translatedFormat('F Y') }}</span>
        </div>
        <div class="w-full bg-gray-100 rounded-full h-3 mb-3">
            <div class="h-3 rounded-full transition-all duration-500"
                 style="width: {{ $percentage }}%; background-color: {{ $percentage >= 100 ? '#EF4444' : $category->color }}"></div>
        </div>

        <div class="grid grid-cols-3 gap-4 text-center bg-gray-50 rounded-xl p-4 border border-gray-100">
            <div>
                <p class="text-xs text-gray-400 mb-1">Terpakai</p>
                <p class="text-sm font-bold text-gray-800">Rp {{ number_format($spent, 0, ',', '.') }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 mb-1">Limit</p>
                <p class="text-sm font-bold text-gray-800">Rp {{ number_format($category->monthly_limit, 0, ',', '.') }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 mb-1">Sisa</p>
                <p class="text-sm font-bold {{ $remaining <= 0 ? 'text-red-500' : 'text-emerald-600' }}">
                    Rp {{ number_format($remaining, 0, ',', '.') }}
                </p>
            </div>
        </div>
    </div>

    {{-- Riwayat expense di kategori ini --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h2 class="text-sm font-bold text-gray-700 uppercase tracking-wide mb-4">Pengeluaran Bulan Ini</h2>

        @forelse ($expenses as $expense)
            <div class="flex justify-between items-center py-3 {{ !$loop->last ? 'border-b border-gray-50' : '' }}">
                <div>
                    <p class="text-sm text-gray-700">{{ $expense->description ?? '-' }}</p>
                    <p class="text-xs text-gray-400">{{ $expense->expense_date->translatedFormat('d M Y') }}</p>
                </div>
                <p class="text-sm font-semibold text-gray-800">Rp {{ number_format($expense->amount, 0, ',', '.') }}</p>
            </div>
        @empty
            <p class="text-sm text-gray-400 text-center py-6">Belum ada pengeluaran di kategori ini bulan ini.</p>
        @endforelse
    </div>

@endsection