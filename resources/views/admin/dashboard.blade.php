@extends('layouts.admin') <!-- Asumsi menggunakan layout yang sama, nanti sidebar bisa disesuaikan -->

@section('title', 'Admin Dashboard')

@section('content')
<!-- Welcome Message -->
<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-800">Halo,{{ Auth::user()->name }} 🛡️</h1>
    <p class="text-gray-500 mt-1">Pantau performa sistem, kelola pengguna, dan awasi stok reward.</p>
</div>

<!-- 4 Top Summary Cards (Warna aksen dibedakan sedikit dari user) -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Card 1: Total Users -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 border-l-4 border-l-blue-500 hover:shadow-md transition">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-sm text-gray-500 font-medium">Total Pengguna</p>
                <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ number_format($totalUsers ?? 0) }}</h3>
                <p class="text-xs text-blue-500 mt-2 font-medium">Terdaftar di sistem</p>
            </div>
            <div class="bg-blue-50 text-blue-500 w-10 h-10 rounded-full flex items-center justify-center">
                <i class="fa-solid fa-users"></i>
            </div>
        </div>
    </div>

    <!-- Card 2: Total Kategori -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 border-l-4 border-l-emerald-500 hover:shadow-md transition">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-sm text-gray-500 font-medium">Total Kategori</p>
                <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ number_format($totalCategories ?? 0) }}</h3>
                <p class="text-xs text-emerald-500 mt-2 font-medium">Tersedia untuk user</p>
            </div>
            <div class="bg-emerald-50 text-emerald-500 w-10 h-10 rounded-full flex items-center justify-center">
                <i class="fa-solid fa-tags"></i>
            </div>
        </div>
    </div>

    <!-- Card 3: Challenge Aktif -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 border-l-4 border-l-orange-400 hover:shadow-md transition">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-sm text-gray-500 font-medium">Challenge Berjalan</p>
                <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ number_format($activeChallenges ?? 0) }}</h3>
                <p class="text-xs text-orange-400 mt-2 font-medium">Sedang diikuti user</p>
            </div>
            <div class="bg-orange-50 text-orange-400 w-10 h-10 rounded-full flex items-center justify-center">
                <i class="fa-solid fa-trophy"></i>
            </div>
        </div>
    </div>

    <!-- Card 4: Dark Slate/Teal Gradient untuk Admin (Berbeda dari Purple milik User) -->
    <div class="bg-gradient-to-br from-slate-700 to-slate-900 rounded-2xl shadow-sm p-6 text-white hover:shadow-lg transition relative overflow-hidden">
        <i class="fa-solid fa-box-open absolute -right-4 -bottom-4 text-7xl opacity-10"></i>
        <div class="relative z-10 flex justify-between items-start">
            <div>
                <p class="text-sm text-slate-300 font-medium">Total Stok Reward</p>
                <h3 class="text-3xl font-bold mt-1 text-emerald-400">{{ number_format($totalRewards ?? 0) }}</h3>
                <a href="#" class="text-xs text-white underline mt-2 inline-block">Kelola Reward ></a>
            </div>
            <div class="bg-white/20 w-10 h-10 rounded-full flex items-center justify-center backdrop-blur-sm">
                <i class="fa-solid fa-gift text-emerald-400"></i>
            </div>
        </div>
    </div>
</div>

<!-- Main Grid Content -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    <!-- Left Column (User Baru) -->
    <div class="lg:col-span-2 space-y-8">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="font-bold text-gray-800">Pengguna Baru Terdaftar</h3>
                <a href="#" class="text-sm text-blue-600 hover:underline">Lihat Semua User ></a>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-gray-100 text-sm text-gray-500">
                            <th class="pb-3 font-medium">Nama User</th>
                            <th class="pb-3 font-medium">Email</th>
                            <th class="pb-3 font-medium">Tanggal Daftar</th>
                            <th class="pb-3 font-medium text-right">Total Poin</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @forelse($recentUsers ?? [] as $u)
                        <tr class="border-b border-gray-50 hover:bg-slate-50 transition">
                            <td class="py-3 font-semibold text-gray-800 flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold">
                                    {{ substr($u->name, 0, 1) }}
                                </div>
                                {{ $u->name }}
                            </td>
                            <td class="py-3 text-gray-600">{{ $u->email }}</td>
                            <td class="py-3 text-gray-500">{{ $u->created_at->format('d M Y') }}</td>
                            <td class="py-3 font-bold text-yellow-500 text-right">{{ number_format($u->points ?? 0) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="py-6 text-center text-gray-400 italic">Belum ada pengguna baru.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Right Column (Actionable Alerts) -->
    <div class="space-y-8">
        <!-- Warning: Low Stock Rewards -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 relative overflow-hidden">
            <div class="absolute top-0 right-0 bg-red-600 text-white text-xs font-bold px-3 py-1 rounded-bl-xl">Perhatian</div>
            
            <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fa-solid fa-triangle-exclamation text-red-500"></i> Stok Reward Menipis
            </h3>
            
            <div class="space-y-4">
                @forelse($lowStockRewards ?? [] as $rw)
                <div class="flex justify-between items-center bg-red-50 p-3 rounded-xl border border-red-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg flex items-center justify-center text-xl shrink-0" 
                             style="background-color: {{ $rw->color ?? '#EF4444' }}33; color: {{ $rw->color ?? '#EF4444' }}">
                            <i class="{{ $rw->icon ?? 'fa-solid fa-gift' }}"></i>
                        </div>
                        <div>
                            <p class="font-bold text-gray-800 text-sm">{{ $rw->reward_name }}</p>
                            <p class="text-xs text-gray-500">Butuh Restock</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="inline-block bg-red-200 text-red-700 text-xs font-bold px-2 py-1 rounded-md">
                            Sisa: {{ $rw->stock }}
                        </span>
                    </div>
                </div>
                @empty
                <div class="py-4 text-center">
                    <i class="fa-solid fa-box-check text-emerald-400 text-3xl mb-2"></i>
                    <p class="text-sm text-gray-500">Semua stok reward dalam kondisi aman.</p>
                </div>
                @endforelse
            </div>
            
            @if(count($lowStockRewards ?? []) > 0)
                <a href="#" class="block w-full text-center bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold py-2.5 rounded-xl transition mt-4">
                    Kelola Stok Reward
                </a>
            @endif
        </div>
    </div>
</div>
@endsection