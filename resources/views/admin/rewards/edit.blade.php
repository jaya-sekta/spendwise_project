@extends('layouts.admin')

@section('title', 'Edit Reward')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-800">Edit Reward</h1>
    <p class="text-gray-500 mt-1 text-sm">Perbarui detail reward "{{ $reward->reward_name }}".</p>
</div>

<div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6 max-w-2xl">
    <form action="{{ route('admin.rewards.update', $reward) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-5">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Reward</label>
            <input type="text" name="reward_name" value="{{ old('reward_name', $reward->reward_name) }}"
                   class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
            @error('reward_name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-5">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Poin Dibutuhkan</label>
            <input type="number" name="required_points" value="{{ old('required_points', $reward->required_points) }}"
                   class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
            @error('required_points')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Stok</label>
            <input type="number" name="stock" value="{{ old('stock', $reward->stock) }}"
                   class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
            @error('stock')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex gap-3">
            <button type="submit"
                    class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl text-sm font-semibold shadow-sm transition">
                <i class="fa-solid fa-check text-xs"></i>
                <span>Perbarui Reward</span>
            </button>
            <a href="{{ route('admin.rewards.index') }}"
               class="inline-flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 px-5 py-2.5 rounded-xl text-sm font-semibold transition">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection