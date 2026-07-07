@extends('layouts.app')

@section('title', 'Riwayat Reward')

@section('content')

<div class="mb-8 flex justify-between items-center">

    <div>
        <h1 class="text-3xl font-bold text-gray-800">
            Riwayat Reward 🎁
        </h1>

        <p class="text-gray-500 mt-2">
            Daftar reward yang sudah pernah kamu tukarkan.
        </p>
    </div>

</div>

@if(session('success'))

<div class="mb-5 bg-green-100 border border-green-300 text-green-700 rounded-xl px-5 py-3">
    {{ session('success') }}
</div>

@endif

<div class="bg-white rounded-2xl shadow border border-gray-100 overflow-hidden">

<table class="w-full">

<thead class="bg-gray-100">

<tr>

<th class="px-6 py-4 text-left">
Reward
</th>

<th class="px-6 py-4 text-left">
Voucher
</th>

<th class="px-6 py-4 text-left">
Tanggal
</th>

</tr>

</thead>

<tbody>

@forelse($userRewards as $reward)

<tr class="border-t">

<td class="px-6 py-4">

{{ $reward->reward->reward_name }}

</td>

<td class="px-6 py-4">

<span class="font-mono bg-indigo-100 text-indigo-700 px-3 py-1 rounded-lg">

{{ $reward->voucher_code }}

</span>

</td>

<td class="px-6 py-4">

{{ $reward->redemption_date->format('d M Y') }}

</td>

</tr>

@empty

<tr>

<td colspan="3" class="text-center py-10 text-gray-500">

Belum ada reward yang ditukarkan.

</td>

</tr>

@endforelse

</tbody>

</table>

</div>

<div class="mt-8">

{{ $userRewards->links() }}

</div>

@endsection
