@extends('layouts.app')

@section('title', 'Detail Kategori')

@section('content')
<div class="mb-8">
    <a href="{{ route('categories.index') }}" class="text-sm text-gray-500 hover:text-blue-600 transition flex items-center gap-2 mb-2">
        <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Kategori
    </a>
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <h1 class="text-2xl font-bold text-gray-800">Detail Kategori</h1>
        <div class="flex items-center gap-2">
            <a href="{{ route('categories.edit', $category->id) }}" class="px-4 py-2 bg-white border border-gray-200 text-gray-600 hover:bg-slate-50 rounded-xl text-sm font-semibold shadow-sm transition flex items-center gap-2">
                <i class="fa-solid fa-pen-to-square text-amber-500"></i> Edit Kategori
            </a>
            <form action="{{ route('categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-50 text-red-600 hover:bg-red-100 rounded-xl text-sm font-semibold transition flex items-center gap-2">
                    <i class="fa-solid fa-trash-can"></i> Hapus
                </button>
            </form>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-8">
    {{-- Kartu Info Utama --}}
    <div class="md:col-span-2 space-y-6">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Informasi Kategori</h3>
            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4">
                <div>
                    <dt class="text-xs text-gray-400 font-medium">Nama Kategori</dt>
                    <dd class="text-base font-bold text-gray-800 mt-1 flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full {{ $category->category_type === 'primary' ? 'bg-blue-500' : 'bg-orange-400' }}"></div>
                        {{ $category->category_name }}
                    </dd>
                </div>
                <div>
                    <dt class="text-xs text-gray-400 font-medium">Tipe Kategori</dt>
                    <dd class="text-sm font-semibold text-gray-800 mt-1">
                        @if($category->category_type === 'primary')
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-xs font-medium bg-blue-50 text-blue-600">
                                Primer (Kebutuhan Wajib)
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-xs font-medium bg-orange-50 text-orange-600">
                                Konsumtif (Keinginan)
                            </span>
                        @endif
                    </dd>
                </div>
                <div class="sm:col-span-2 pt-4 border-t border-gray-50">
                    <dt class="text-xs text-gray-400 font-medium">Batas Anggaran Bulanan (Limit)</dt>
                    <dd class="text-2xl font-black text-gray-800 mt-1">
                        Rp {{ number_format($category->monthly_limit, 0, ',', '.') }}
                    </dd>
                </div>
            </dl>
        </div>
    </div>

    {{-- Info Tambahan (Metrik Statis Placeholder untuk Fitur Mendatang) --}}
    <div class="space-y-6">
        <div class="bg-gradient-to-br from-slate-800 to-slate-900 text-white rounded-2xl shadow-sm p-6 relative overflow-hidden">
            <i class="fa-solid fa-shield-halved absolute -right-6 -bottom-6 text-8xl opacity-10"></i>
            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Tips Manajemen Keuangan</h3>
            @if($category->category_type === 'primary')
                <p class="text-sm text-slate-200 leading-relaxed font-medium">Kategori ini bersifat **Primer**. Upayakan untuk selalu mendahulukan alokasi dana dari pendapatan utama Anda demi mengamankan kebutuhan pokok bulanan.</p>
            @else
                <p class="text-sm text-slate-200 leading-relaxed font-medium">Kategori ini bersifat **Konsumtif**. Jika anggaran mendekati limit, pertimbangkan untuk menunda pengeluaran tidak mendesak demi menjaga stabilitas poin gamifikasi Anda!</p>
            @endif
        </div>
    </div>
</div>
@endsection