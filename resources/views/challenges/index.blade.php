@extends('layouts.app')

@section('title', 'Challenge')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Challenge</h1>
        <p class="text-sm text-gray-500 mt-1">Selesaikan tantangan hemat dan kumpulkan poinnya!</p>
    </div>
    <a href="{{ route('challenges.create') }}" class="inline-flex items-center gap-2 bg-[#185adb] hover:bg-[#0A369D] text-white font-medium px-4 py-2 rounded-xl transition shadow-sm text-sm">
        <i class="fa-solid fa-plus"></i> Buat Challenge
    </a>
</div>

@if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6 text-sm flex items-center gap-2">
        <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
    </div>
@endif

<div class="flex gap-6 border-b border-gray-200 mb-6">
    <a href="{{ route('challenges.index', ['tab' => 'active']) }}"
       class="pb-3 border-b-2 text-sm font-semibold transition
              {{ $tab === 'active' ? 'border-[#185adb] text-[#185adb]' : 'border-transparent text-gray-400 hover:text-gray-600 font-medium' }}">
        Aktif
    </a>
    <a href="{{ route('challenges.index', ['tab' => 'finished']) }}"
       class="pb-3 border-b-2 text-sm font-semibold transition
              {{ $tab === 'finished' ? 'border-[#185adb] text-[#185adb]' : 'border-transparent text-gray-400 hover:text-gray-600 font-medium' }}">
        Selesai
    </a>
</div>

<div class="space-y-6">
    @forelse($challenges as $challenge)
        @php
            // Perhitungan dinamis untuk UI
            $totalDays = $challenge->start_date->diffInDays($challenge->end_date) ?: 1;
            $daysPassed = $challenge->start_date->diffInDays(now());
            // Batasi agar progress tidak lebih dari total hari atau kurang dari 0
            $currentProgress = max(0, min($daysPassed, $totalDays)); 
            $progressPercent = ($currentProgress / $totalDays) * 100;
            
            // Dummy Hadiah (karena tidak ada di DB, kita buat formula: 10 poin per hari)
            $rewardPoints = $totalDays * 10;
        @endphp
        <div style="width: {{ $progressPercent }}%"></div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 relative overflow-hidden transition hover:shadow-md">
            @if($challenge->status === 'active')
                <div class="absolute top-0 right-0 bg-blue-100 text-blue-700 text-xs font-bold px-3 py-1 rounded-bl-xl">Aktif</div>
            @elseif($challenge->status === 'successful')
                <div class="absolute top-0 right-0 bg-emerald-100 text-emerald-700 text-xs font-bold px-3 py-1 rounded-bl-xl">Berhasil</div>
            @else
                <div class="absolute top-0 right-0 bg-red-100 text-red-700 text-xs font-bold px-3 py-1 rounded-bl-xl">Gagal</div>
            @endif
            
            <div class="flex flex-col md:flex-row md:items-center gap-4 mb-6">
                <div class="w-16 h-16 rounded-xl flex items-center justify-center text-2xl shrink-0" 
                     style="background-color: {{ $challenge->category->color ?? '#E0E7FF' }}33; color: {{ $challenge->category->color ?? '#4F46E5' }}">
                    <i class="{{ $challenge->category->icon ?? 'fa-solid fa-car' }}"></i>
                </div>
                
                <div class="flex-1">
                    <h3 class="text-lg font-bold text-gray-800">
                        Hemat {{ $challenge->category->name ?? 'Kategori' }} {{ $totalDays }} Hari
                    </h3>
                    <p class="text-sm text-gray-500 mt-1">
                        Hindari over budget pada kategori {{ $challenge->category->name ?? 'ini' }} selama {{ $totalDays }} hari.
                    </p>
                </div>
            </div>

            <div class="mb-6">
                <div class="flex justify-between items-end mb-2">
                    <span class="text-xs font-semibold text-[#185adb]">Progress</span>
                    <span class="text-xs text-gray-500 font-medium">{{ $currentProgress }} / {{ $totalDays }} Hari</span>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-2.5">
                    <div class="bg-[#185adb] h-2.5 rounded-full transition-all duration-500" style="width: {{ $progressPercent }}%"></div>
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 bg-gray-50 rounded-xl p-4 border border-gray-100">
                <div>
                    <p class="text-xs text-gray-400 mb-1">Periode</p>
                    <p class="text-xs font-semibold text-gray-700">
                        {{ $challenge->start_date->translatedFormat('d M Y') }} - {{ $challenge->end_date->translatedFormat('d M Y') }}
                    </p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 mb-1">Kategori</p>
                    <p class="text-xs font-semibold text-gray-700">{{ $challenge->category_name ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 mb-1">Nyawa</p>
                    <div class="flex gap-1 text-red-500 text-sm">
                        @for($i = 0; $i < 3; $i++)
                            @if($i < $challenge->remaining_lives)
                                <i class="fa-solid fa-heart"></i>
                            @else
                                <i class="fa-regular fa-heart"></i>
                            @endif
                        @endfor
                    </div>
                </div>
                <div>
                    <p class="text-xs text-gray-400 mb-1">Hadiah</p>
                    <p class="text-sm font-bold text-yellow-500">+{{ $rewardPoints }} Poin</p>
                </div>
            </div>

                <div class="mt-4 flex justify-end gap-3">
                    <form action="{{ route('challenges.destroy', $challenge->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus challenge ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-xs text-gray-500 hover:text-red-600 transition"><i class="fa-solid fa-trash"></i> Hapus</button>
                </form>
            </div>
        </div>
    @empty
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
            <div class="w-20 h-20 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-4 text-blue-500 text-3xl">
                <i class="fa-solid fa-medal"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-800 mb-2">Belum ada challenge lainnya</h3>
            <p class="text-sm text-gray-500 mb-6">Yuk buat challenge baru dan menangkan poin untuk ditukar dengan reward!</p>
            <a href="{{ route('challenges.create') }}" class="inline-flex items-center gap-2 bg-[#185adb] hover:bg-[#0A369D] text-white font-medium px-5 py-2.5 rounded-xl transition shadow-sm text-sm">
                <i class="fa-solid fa-plus"></i> Buat Challenge
            </a>
        </div>
    @endforelse

    <div class="mt-6">
        {{ $challenges->links() }}
    </div>
</div>
@endsection