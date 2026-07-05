@extends('layouts.app')

@section('title', 'Kelola Kategori')

@section('content')
<div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Daftar Kategori</h1>
        <p class="text-gray-500 mt-1">Kelola dan kelompokkan anggaran pengeluaran Anda.</p>
    </div>
    <a href="{{ route('categories.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl text-sm font-semibold shadow-sm transition-all flex items-center gap-2">
        <i class="fa-solid fa-plus"></i> Tambah Kategori
    </a>
</div>

{{-- Alert Sukses --}}
@if(session('success'))
<div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl flex items-center gap-3">
    <i class="fa-solid fa-circle-check text-lg text-emerald-500"></i>
    <p class="text-sm font-medium">{{ session('success') }}</p>
</div>
@endif

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    @if($categories->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-gray-100 text-gray-400 text-xs font-bold uppercase tracking-wider">
                        <th class="px-6 py-4">Nama Kategori</th>
                        <th class="px-6 py-4">Tipe Kategori</th>
                        <th class="px-6 py-4">Batas Bulanan (Limit)</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 text-gray-700 text-sm">
                    @foreach($categories as $category)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="px-6 py-4 font-semibold text-gray-800">
                                <div class="flex items-center gap-3">
                                    <div class="w-2.5 h-2.5 rounded-full {{ $category->category_type === 'primary' ? 'bg-blue-500' : 'bg-orange-400' }}"></div>
                                    {{ $category->category_name }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($category->category_type === 'primary')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-xs font-medium bg-blue-50 text-blue-600">
                                        <i class="fa-solid fa-star text-[10px]"></i> Primer
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-xs font-medium bg-orange-50 text-orange-600">
                                        <i class="fa-solid fa-basket-shopping text-[10px]"></i> Konsumtif
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900">
                                Rp {{ number_format($category->monthly_limit, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end items-center gap-2">
                                    <a href="{{ route('categories.show', $category->id) }}" class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Detail">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="{{ route('categories.edit', $category->id) }}" class="p-2 text-gray-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition" title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition" title="Hapus">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if($categories->hasPages())
            <div class="px-6 py-4 border-t border-gray-50">
                {{ $categories->links() }}
            </div>
        @endif
    @else
        {{-- Empty State --}}
        <div class="p-12 text-center">
            <div class="w-16 h-16 bg-slate-100 text-slate-400 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fa-solid fa-tags text-2xl"></i>
            </div>
            <h3 class="font-bold text-gray-700 text-base">Belum Ada Kategori</h3>
            <p class="text-gray-400 text-sm mt-1 max-w-sm mx-auto">Buat kategori pengeluaran pertama Anda untuk mulai mengatur batasan budget.</p>
            <a href="{{ route('categories.create') }}" class="mt-4 inline-flex items-center gap-2 bg-slate-100 hover:bg-blue-600 hover:text-white text-gray-600 px-4 py-2 rounded-xl text-xs font-semibold transition-all">
                <i class="fa-solid fa-plus"></i> Buat Kategori Baru
            </a>
        </div>
    @endif
</div>
@endsection