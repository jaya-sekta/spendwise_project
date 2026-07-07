@extends('layouts.app')

@section('title', 'Riwayat Pengeluaran')

@section('content')
<div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Catatan Pengeluaran</h1>
        <p class="text-gray-500 mt-1">Pantau semua histori transaksi pengeluaran harian Anda.</p>
    </div>
    <a href="{{ route('expense.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl text-sm font-semibold shadow-sm transition-all flex items-center gap-2">
        <i class="fa-solid fa-plus"></i> Catat Pengeluaran
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
    @if($expenses->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-gray-100 text-gray-400 text-xs font-bold uppercase tracking-wider">
                        <th class="px-6 py-4">Nama Pengeluaran</th>
                        <th class="px-6 py-4">Kategori</th>
                        <th class="px-6 py-4">Tanggal</th>
                        <th class="px-6 py-4">Jumlah</th>
                        <th class="px-6 py-4">Status Anggaran</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 text-gray-700 text-sm">
                    @foreach($expenses as $expense)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="px-6 py-4 font-semibold text-gray-800">
                                {{ $expense->expense_name }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-medium bg-slate-100 text-slate-700">
                                    <i class="fa-solid fa-tag text-[10px]"></i> {{ $expense->category->category_name }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-500">
                                {{ $expense->expense_date->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 font-bold text-gray-900">
                                Rp {{ number_format($expense->amount, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4">
                                @if($expense->is_over_limit)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-xs font-semibold bg-rose-50 text-rose-600 border border-rose-100">
                                        <i class="fa-solid fa-triangle-exclamation animate-pulse"></i> Melebihi Limit
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-xs font-semibold bg-emerald-50 text-emerald-600 border border-emerald-100">
                                        <i class="fa-solid fa-circle-check"></i> Aman
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end items-center gap-2">
                                    <a href="{{ route('expense.show', $expense->id) }}" class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Detail">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="{{ route('expense.edit', $expense->id) }}" class="p-2 text-gray-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition" title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form action="{{ route('expense.destroy', $expense->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus catatan pengeluaran ini?');" class="inline">
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
        @if($expenses->hasPages())
            <div class="px-6 py-4 border-t border-gray-50">
                {{ $expenses->links() }}
            </div>
        @endif
    @else
        {{-- Empty State --}}
        <div class="p-12 text-center">
            <div class="w-16 h-16 bg-slate-100 text-slate-400 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fa-solid fa-receipt text-2xl"></i>
            </div>
            <h3 class="font-bold text-gray-700 text-base">Belum Ada Pengeluaran</h3>
            <p class="text-gray-400 text-sm mt-1 max-w-sm mx-auto">Catat pengeluaran Anda untuk memantau sisa limit anggaran bulanan.</p>
            <a href="{{ route('expense.create') }}" class="mt-4 inline-flex items-center gap-2 bg-slate-100 hover:bg-blue-600 hover:text-white text-gray-600 px-4 py-2 rounded-xl text-xs font-semibold transition-all">
                <i class="fa-solid fa-plus"></i> Catat Transaksi Baru
            </a>
        </div>
    @endif
</div>
@endsection