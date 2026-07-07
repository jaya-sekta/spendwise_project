@extends('layouts.admin')

@section('title', 'Kelola Reward')

@section('content')
<div class="mb-8 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Kelola Reward</h1>
        <p class="text-gray-500 mt-1 text-sm">Tambah, edit, atau hapus reward yang bisa ditukar user.</p>
    </div>
    <a href="{{ route('admin.rewards.create') }}"
       class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2.5 rounded-xl shadow-sm transition">
        <i class="fa-solid fa-plus text-xs"></i>
        <span>Tambah Reward</span>
    </a>
</div>

@if(session('success'))
<div class="mb-5 bg-green-100 border border-green-300 text-green-700 rounded-xl px-5 py-3 text-sm">
    {{ session('success') }}
</div>
@endif

<div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100 text-gray-600 text-xs font-semibold uppercase">
                    <th class="p-4 pl-6">Nama Reward</th>
                    <th class="p-4">Poin Dibutuhkan</th>
                    <th class="p-4">Stok</th>
                    <th class="p-4 text-right pr-6">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50 text-gray-700 text-sm">
                @forelse($rewards as $reward)
                    <tr class="hover:bg-gray-50/50 transition">
                        <td class="p-4 pl-6 font-medium text-gray-900">
                            {{ $reward->reward_name }}
                        </td>
                        <td class="p-4 font-semibold text-amber-500">
                            ⭐ {{ number_format($reward->required_points) }}
                        </td>
                        <td class="p-4">
                            <span class="px-2.5 py-1 rounded-lg text-xs font-semibold
                                {{ $reward->stock > 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $reward->stock }} tersisa
                            </span>
                        </td>
                        <td class="p-4 text-right pr-6">
                            <div class="inline-flex gap-2">
                                <a href="{{ route('admin.rewards.edit', $reward) }}"
                                   class="px-3 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-xs font-medium transition">
                                    <i class="fa-solid fa-pen"></i> Edit
                                </a>
                                <form action="{{ route('admin.rewards.destroy', $reward) }}" method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus reward ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg text-xs font-medium transition">
                                        <i class="fa-solid fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="p-12 text-center text-gray-400 text-sm">
                            Belum ada reward. Klik "Tambah Reward" untuk membuat yang pertama.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-6">
    {{ $rewards->links() }}
</div>
@endsection