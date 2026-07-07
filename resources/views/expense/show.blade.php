@extends('layouts.app')

@section('title', 'Detail Pengeluaran')

@section('content')
<div class="mb-8">
    <a href="{{ route('expense.index') }}" class="text-sm text-gray-500 hover:text-blue-600 transition flex items-center gap-2 mb-2">
        <i class="fa-solid fa-arrow-left"></i> Kembali ke Riwayat
    </a>
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <h1 class="text-2xl font-bold text-gray-800">Detail Transaksi Pengeluaran</h1>
        <div class="flex items-center gap-2">
            <a href="{{ route('expense.edit', $expense->id) }}" class="px-4 py-2 bg-white border border-gray-200 text-gray-600 hover:bg-slate-50 rounded-xl text-sm font-semibold shadow-sm transition flex items-center gap-2">
                <i class="fa-solid fa-pen-to-square text-amber-500"></i> Edit
            </a>
            <form action="{{ route('expense.destroy', $expense->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');" class="inline">
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
    <div class="md:col-span-2 space-y-6">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Informasi Transaksi</h3>
            
            @if($expense->is_over_limit)
                <div class="mb-6 p-4 bg-rose-50 border border-rose-100 rounded-xl flex items-start gap-3 text-rose-900 text-sm">
                    <i class="fa-solid fa-triangle-exclamation text-lg text-rose-500 mt-0.5"></i>
                    <div>
                        <span class="font-bold">Peringatan Over-Budget!</span>
                        <p class="text-rose-700/90 mt-0.5">Transaksi ini telah melampaui sisa ambang batas bulanan dari kategori yang diatur (**{{ $expense->category->category_name }}**).</p>
                    </div>
                </div>
            @endif

            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-6">
                <div>
                    <dt class="text-xs text-gray-400 font-medium uppercase tracking-wider">Nama Pengeluaran</dt>
                    <dd class="text-lg font-bold text-gray-800 mt-1">{{ $expense->expense_name }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-gray-400 font-medium uppercase tracking-wider">Kategori Terkait</dt>
                    <dd class="text-sm font-semibold text-gray-800 mt-1">
                        <span class="px-2.5 py-1 bg-slate-100 rounded-md">{{ $expense->category->category_name }}</span>
                    </dd>
                </div>
                <div>
                    <dt class="text-xs text-gray-400 font-medium uppercase tracking-wider">Tanggal Transaksi</dt>
                    <dd class="text-sm font-medium text-gray-800 mt-1">{{ $expense->expense_date->format('l, d F Y') }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-gray-400 font-medium uppercase tracking-wider">Total Nominal</dt>
                    <dd class="text-xl font-black text-blue-600 mt-1">Rp {{ number_format($expense->amount, 0, ',', '.') }}</dd>
                </div>
            </dl>
        </div>
    </div>

    <div class="space-y-6">
        <div class="bg-gradient-to-br from-slate-50 to-slate-100 rounded-2xl p-6 border border-slate-200">
            <h4 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Catatan Sistem</h4>
            <p class="text-xs text-slate-500 leading-relaxed">Data ini dicatat pertama kali pada <span class="font-semibold">{{ $expense->created_at->format('d/m/Y H:i') }}</span> dan diperbarui terakhir kali pada <span class="font-semibold">{{ $expense->updated_at->format('d/m/Y H:i') }}</span>.</p>
        </div>
    </div>
</div>
@endsection