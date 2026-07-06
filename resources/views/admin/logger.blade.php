@extends('layouts.admin')

@section('title', 'Log Akses Route')

@section('content')

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Log Akses Route</h1>
        <p class="text-gray-500 text-sm mt-1">Riwayat halaman/route yang diakses tiap user.</p>
    </div>

    <form method="GET" class="flex flex-wrap gap-3 mb-6">
        <select name="user_id" onchange="this.form.submit()" class="border border-gray-200 rounded-xl px-4 py-2 text-sm">
            <option value="">Semua User</option>
            @foreach ($users as $user)
                <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                    {{ $user->name }}
                </option>
            @endforeach
        </select>

        <select name="method" onchange="this.form.submit()" class="border border-gray-200 rounded-xl px-4 py-2 text-sm">
            <option value="">Semua Method</option>
            @foreach (['GET','POST','PUT','PATCH','DELETE'] as $m)
                <option value="{{ $m }}" {{ request('method') == $m ? 'selected' : '' }}>{{ $m }}</option>
            @endforeach
        </select>

        @if(request('user_id') || request('method'))
            <a href="{{ route('admin.logger') }}" class="text-sm text-gray-500 self-center hover:text-slate-800">Reset filter</a>
        @endif
    </form>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-sm text-left">
            <thead class="bg-slate-50 text-gray-500 uppercase text-xs">
                <tr>
                    <th class="px-6 py-4">User</th>
                    <th class="px-6 py-4">Method</th>
                    <th class="px-6 py-4">Route</th>
                    <th class="px-6 py-4">URL</th>
                    <th class="px-6 py-4">Waktu</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($logs as $log)
                    <tr class="hover:bg-slate-50/60 transition">
                        <td class="px-6 py-4 font-medium text-gray-800">{{ $log->user->name ?? '—' }}</td>
                        <td class="px-6 py-4">
                            <span class="text-xs font-semibold px-2.5 py-1 rounded-lg"
                                  style="background-color: {{ $log->method_color }}1A; color: {{ $log->method_color }}">
                                {{ $log->method }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-600">{{ $log->route_name ?? '—' }}</td>
                        <td class="px-6 py-4 text-gray-400 text-xs">/{{ $log->url }}</td>
                        <td class="px-6 py-4 text-gray-400 text-xs">{{ $log->created_at->translatedFormat('d M Y, H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-gray-400">Belum ada log akses.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $logs->links() }}
    </div>

@endsection