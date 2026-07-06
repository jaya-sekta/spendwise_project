@extends('layouts.admin')

@section('title', 'Kategori Bawaan')

@section('content')

    <div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Kategori Bawaan</h1>
            <p class="text-gray-500 text-sm mt-1">
                Kategori ini otomatis muncul di semua akun user.
            </p>
        </div>
        <a href="{{ route('admin.categories.create') }}"
           class="inline-flex items-center gap-2 bg-slate-900 hover:bg-slate-800 text-white text-sm font-semibold px-5 py-2.5 rounded-xl shadow-sm transition">
            <i class="fa-solid fa-plus"></i> Tambah Kategori
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-sm text-left">
            <thead class="bg-slate-50 text-gray-500 uppercase text-xs">
                <tr>
                    <th class="px-6 py-4">Nama Kategori</th>
                    <th class="px-6 py-4">Tipe</th>
                    <th class="px-6 py-4">Limit Bulanan</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($categories as $category)
                    <tr class="hover:bg-slate-50/60 transition">
                        <td class="px-6 py-4 font-medium text-gray-800">
                            <span class="inline-flex items-center gap-2">
                                <i class="fa-solid fa-shield-halved text-amber-500 text-xs"
                                   title="Kategori bawaan"></i>
                                {{ $category->category_name }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if ($category->category_type === 'primary')
                                <span class="text-xs font-semibold px-2.5 py-1 rounded-lg bg-blue-50 text-blue-600">Primer</span>
                            @else
                                <span class="text-xs font-semibold px-2.5 py-1 rounded-lg bg-purple-50 text-purple-600">Konsumtif</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-gray-600">
                            Rp {{ number_format($category->monthly_limit, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.categories.edit', $category) }}"
                                   class="w-9 h-9 flex items-center justify-center rounded-lg bg-slate-50 hover:bg-amber-50 text-slate-500 hover:text-amber-600 transition">
                                    <i class="fa-solid fa-pen text-xs"></i>
                                </a>
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
                                      onsubmit="return confirm('Hapus kategori ini? Kategori akan hilang dari semua akun user.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="w-9 h-9 flex items-center justify-center rounded-lg bg-slate-50 hover:bg-red-50 text-slate-500 hover:text-red-600 transition">
                                        <i class="fa-solid fa-trash text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center text-gray-400">
                            Belum ada kategori bawaan. Tambahkan yang pertama.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $categories->links() }}
    </div>

@endsection