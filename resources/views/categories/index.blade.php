@extends('layouts.app')

@section('title', 'Kategori')

@section('content')

    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Kategori</h1>
        <p class="text-gray-500 text-sm mt-1">Pilih kategori bawaan atau kelola kategori milikmu sendiri.</p>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6 text-sm flex items-center gap-2">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
    @endif

    @php
        $defaults = $categories->where('is_default', true);
        $owned    = $categories->where('is_default', false);
    @endphp

    {{-- Kategori Bawaan --}}
    <div class="mb-4 flex items-center gap-2">
        <i class="fa-solid fa-shield-halved text-amber-500 text-sm"></i>
        <h2 class="text-sm font-bold text-gray-700 uppercase tracking-wide">Kategori Bawaan</h2>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 mb-10">
        @foreach ($defaults as $category)
            <a href="{{ route('categories.show', $category) }}"
               class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 relative hover:shadow-md hover:border-amber-200 transition block">
                <span class="absolute top-4 right-4 text-amber-400" title="Kategori bawaan">
                    <i class="fa-solid fa-shield-halved text-xs"></i>
                </span>
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-lg mb-3"
                     style="background-color: {{ $category->color }}1A; color: {{ $category->color }}">
                    <i class="{{ $category->icon }}"></i>
                </div>
                <p class="font-semibold text-gray-800 text-sm pr-4">{{ $category->category_name }}</p>
                <p class="text-xs text-gray-400 mt-1 line-clamp-2">{{ $category->description }}</p>
            </a>
        @endforeach
    </div>

    {{-- Kategori Saya --}}
    <div class="mb-4 flex items-center gap-2">
        <i class="fa-solid fa-user text-indigo-500 text-sm"></i>
        <h2 class="text-sm font-bold text-gray-700 uppercase tracking-wide">Kategori Saya</h2>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
        @foreach ($owned as $category)
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 relative hover:shadow-md transition group">
                <span class="absolute top-4 right-4 text-indigo-400" title="Kategori milik saya">
                    <i class="fa-solid fa-user text-xs"></i>
                </span>

                <a href="{{ route('categories.show', $category) }}" class="block">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center text-lg mb-3"
                         style="background-color: {{ $category->color }}1A; color: {{ $category->color }}">
                        <i class="{{ $category->icon }}"></i>
                    </div>
                    <p class="font-semibold text-gray-800 text-sm pr-4">{{ $category->category_name }}</p>
                    <p class="text-xs text-gray-400 mt-1 line-clamp-2">{{ $category->description }}</p>
                </a>

                <div class="mt-4 pt-3 border-t border-gray-50 flex gap-2 opacity-0 group-hover:opacity-100 transition">
                    <a href="{{ route('categories.edit', $category) }}"
                       class="flex-1 text-center text-xs font-semibold py-1.5 rounded-lg bg-gray-50 hover:bg-indigo-50 text-gray-500 hover:text-indigo-600 transition">
                        Edit
                    </a>
                    <form action="{{ route('categories.destroy', $category) }}" method="POST"
                          onsubmit="return confirm('Hapus kategori ini?');" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="w-full text-xs font-semibold py-1.5 rounded-lg bg-gray-50 hover:bg-red-50 text-gray-500 hover:text-red-600 transition">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        @endforeach

        {{-- Card "Lainnya" --}}
        <a href="{{ route('categories.create') }}"
           class="bg-white rounded-2xl border-2 border-dashed border-gray-200 p-5 flex flex-col items-center justify-center text-center hover:border-indigo-300 hover:bg-indigo-50/30 transition min-h-[148px]">
            <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-500 flex items-center justify-center text-lg mb-3">
                <i class="fa-solid fa-plus"></i>
            </div>
            <p class="font-semibold text-gray-600 text-sm">Lainnya</p>
            <p class="text-xs text-gray-400 mt-1">Buat kategori sendiri</p>
        </a>
    </div>

    <div class="mt-6">
        {{ $categories->links() }}
    </div>

@endsection