@extends('layouts.app')

@section('title', 'Riwayat Reward')

@section('content')

<div class="mb-8 flex justify-between items-center">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">
            Riwayat Penukaran 🧾
        </h1>

        <p class="text-gray-500 mt-2">
            Daftar reward yang sudah kamu tukarkan.
        </p>
    </div>

    <a href="{{ route('rewards.index') }}"
       class="bg-white border border-gray-200 text-gray-700 px-5 py-3 rounded-xl shadow-sm hover:bg-gray-50 transition">
        ← Kembali ke Reward Store
    </a>
</div>


@if(session('success'))

<div class="mb-5 bg-green-100 border border-green-300 text-green-700 rounded-xl px-5 py-3">
    {{ session('success') }}
</div>

@endif


@if($errors->any())

<div class="mb-5 bg-red-100 border border-red-300 text-red-700 rounded-xl px-5 py-3">

    <ul>

        @foreach($errors->all() as $error)

        <li>{{ $error }}</li>

        @endforeach

    </ul>

</div>

@endif


<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

@forelse($userRewards as $userReward)

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-3 px-6 py-5 {{ !$loop->last ? 'border-b border-gray-100' : '' }}">

        <div class="flex items-center gap-4">

            <div class="text-3xl">
                🎁
            </div>

            <div>
                <h2 class="font-bold text-gray-800">
                    {{ $userReward->reward->reward_name ?? 'Reward tidak ditemukan' }}
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Ditukar pada {{ $userReward->redemption_date->translatedFormat('d F Y') }}
                </p>
            </div>

        </div>

        <div class="flex items-center gap-3">

            <span class="bg-indigo-50 text-indigo-600 text-xs font-semibold px-3 py-2 rounded-lg tracking-wide">
                {{ $userReward->voucher_code }}
            </span>

            <span class="bg-green-100 text-green-700 text-xs font-semibold px-3 py-2 rounded-lg">
                Berhasil
            </span>

        </div>

    </div>

@empty

    <div class="p-10 text-center">

        <h2 class="text-xl font-bold text-gray-800">
            Belum ada riwayat penukaran.
        </h2>

        <p class="text-gray-500 mt-2">
            Yuk tukarkan poin kamu dengan reward menarik.
        </p>

        <a href="{{ route('rewards.index') }}"
           class="inline-block mt-5 bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-xl transition">
            Lihat Reward
        </a>

    </div>

@endforelse

</div>


<div class="mt-8">

{{ $userRewards->links() }}

</div>

@endsection