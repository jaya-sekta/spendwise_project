@extends('layouts.app')

@section('title', 'Buat Challenge Baru')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6 flex items-center gap-4">
        <a href="{{ route('challenges.index') }}" class="text-gray-400 hover:text-gray-700 transition">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <h1 class="text-2xl font-bold text-gray-800">Buat Challenge Baru</h1>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
        <form action="{{ route('challenges.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label for="category_id" class="block text-sm font-semibold text-gray-700 mb-2">Kategori Target</label>
                <select name="category_id" id="category_id" class="block w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-[#185adb]/20 focus:border-[#185adb] outline-none transition @error('category_id') border-red-500 @enderror" required>
                    <option value="" disabled selected>Pilih kategori yang ingin dihemat</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                <p class="text-xs text-gray-500 mt-1">Challenge akan memantau agar pengeluaran di kategori ini tidak over budget.</p>
                @error('category_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="start_date" class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Mulai</label>
                    <input type="date" name="start_date" id="start_date" value="{{ old('start_date', date('Y-m-d')) }}" class="block w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-[#185adb]/20 focus:border-[#185adb] outline-none transition @error('start_date') border-red-500 @enderror" required>
                    @error('start_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="end_date" class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Selesai</label>
                    <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}" class="block w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-[#185adb]/20 focus:border-[#185adb] outline-none transition @error('end_date') border-red-500 @enderror" required>
                    @error('end_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label for="remaining_lives" class="block text-sm font-semibold text-gray-700 mb-2">Jumlah Nyawa (Lives)</label>
                <select name="remaining_lives" id="remaining_lives" class="block w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-[#185adb]/20 focus:border-[#185adb] outline-none transition @error('remaining_lives') border-red-500 @enderror" required>
                    <option value="3" {{ old('remaining_lives') == 3 ? 'selected' : '' }}>3 Nyawa (Standar)</option>
                    <option value="2" {{ old('remaining_lives') == 2 ? 'selected' : '' }}>2 Nyawa (Sulit)</option>
                    <option value="1" {{ old('remaining_lives') == 1 ? 'selected' : '' }}>1 Nyawa (Hardcore)</option>
                </select>
                <p class="text-xs text-gray-500 mt-1">Satu nyawa akan berkurang setiap kali kamu melebihi batas budget harian/mingguan.</p>
                @error('remaining_lives') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 mt-6 border-t border-gray-100">
                <a href="{{ route('challenges.index') }}" class="px-5 py-2.5 text-sm font-medium text-gray-600 bg-gray-100 rounded-xl hover:bg-gray-200 transition">Batal</a>
                <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-[#185adb] rounded-xl hover:bg-[#0A369D] transition shadow-sm">
                    Simpan Challenge
                </button>
            </div>
        </form>
    </div>
</div>
@endsection