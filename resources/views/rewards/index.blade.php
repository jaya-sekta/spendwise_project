@extends('layouts.app')

@section('title', 'Rewards')

@section('content')

<div class="mb-8 flex justify-between items-center">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">
            Reward Store 🎁
        </h1>

        <p class="text-gray-500 mt-2">
            Tukarkan poin yang telah kamu kumpulkan.
        </p>
    </div>

    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white px-6 py-4 rounded-2xl shadow-lg">
        <p class="text-sm opacity-90">
            Poin Kamu
        </p>

        <h2 class="text-3xl font-bold">
            ⭐ {{ Auth::user()->points }}
        </h2>
    </div>
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


<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">

@forelse($rewards as $reward)

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-lg transition">

    <div class="flex justify-between items-start">

        <div>

            <h2 class="text-xl font-bold">
                {{ $reward->reward_name }}
            </h2>

            <p class="text-sm text-gray-500 mt-2">

                Dibutuhkan

                <span class="font-bold text-indigo-600">

                    {{ number_format($reward->required_points) }}

                </span>

                poin

            </p>

        </div>

        <div class="text-4xl">
            🎁
        </div>

    </div>


    <div class="mt-6 flex justify-between text-sm">

        <span class="text-gray-500">
            Stock
        </span>

        <span class="font-semibold">

            {{ $reward->stock }}

        </span>

    </div>


    <form
        action="{{ route('rewards.redeem',$reward) }}"
        method="POST"
        class="mt-6">

        @csrf

        <button
            class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-3 rounded-xl transition">

            Tukarkan Reward

        </button>

    </form>

</div>

@empty

<div class="col-span-3">

    <div class="bg-white rounded-xl p-10 text-center shadow">

        <h2 class="text-xl font-bold">

            Belum ada reward.

        </h2>

    </div>

</div>

@endforelse

</div>


<div class="mt-8">

{{ $rewards->links() }}

</div>

@endsection
