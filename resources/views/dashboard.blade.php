    @extends('layouts.app')

    @section('title', 'Dashboard Overview')

    @section('content')
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Halo, {{ Auth::user()->name ?? 'User' }} 👋</h1>
        <p class="text-gray-500 mt-1">Kelola budget-mu, menangkan tantangannya, dan kumpulkan poin!</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 border-l-4 border-l-red-500 hover:shadow-md transition">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Total Pengeluaran</p>
                    <h3 class="text-2xl font-bold text-gray-800 mt-1">
                        Rp {{ number_format($totalPengeluaran ?? 0, 0, ',', '.') }}
                    </h3>
                    <p class="text-xs text-gray-400 mt-2">Bulan ini</p>
                </div>
                <div class="bg-red-50 text-red-500 w-10 h-10 rounded-full flex items-center justify-center">
                    <i class="fa-solid fa-arrow-trend-up"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 border-l-4 border-l-emerald-500 hover:shadow-md transition">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Sisa Anggaran</p>
                    <h3 class="text-2xl font-bold text-gray-800 mt-1">
                        Rp {{ number_format($sisaAnggaran ?? 0, 0, ',', '.') }}
                    </h3>
                    <p class="text-xs text-gray-400 mt-2">Bulan ini</p>
                </div>
                <div class="bg-emerald-50 text-emerald-500 w-10 h-10 rounded-full flex items-center justify-center">
                    <i class="fa-solid fa-wallet"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 border-l-4 border-l-orange-400 hover:shadow-md transition">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Kategori Over Budget</p>
                    <h3 class="text-2xl font-bold text-gray-800 mt-1">
                        {{ $overBudgetCount ?? 0 }} <span class="text-sm font-normal text-gray-500">Kategori</span>
                    </h3>
                </div>
                <div class="bg-orange-50 text-orange-400 w-10 h-10 rounded-full flex items-center justify-center">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl shadow-sm p-6 text-white hover:shadow-lg transition relative overflow-hidden">
            <i class="fa-solid fa-coins absolute -right-4 -bottom-4 text-7xl opacity-20"></i>
            <div class="relative z-10 flex justify-between items-start">
                <div>
                    <p class="text-sm text-indigo-100 font-medium">Poin Kamu</p>
                    <h3 class="text-3xl font-bold mt-1 text-yellow-300">
                        {{ Auth::user()->points ?? 0 }}
                    </h3>
                    <a href="{{ route('rewards.index') }}" class="text-xs text-white underline mt-2 inline-block">Tukar Poin ></a>
                </div>
                <div class="bg-white/20 w-10 h-10 rounded-full flex items-center justify-center backdrop-blur-sm">
                    <i class="fa-solid fa-star text-yellow-300"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6">
    <div class="flex justify-between items-center mb-5">
        <h3 class="font-bold text-gray-800 text-base">Pengeluaran per Kategori</h3>
        <a href="{{ route('expense.index') }}" class="text-sm text-indigo-600 hover:underline">
            Lihat Selengkapnya >
        </a>
    </div>

    <div class="relative" style="height: 280px;">
        <canvas id="expenseByCategoryChart"></canvas>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('expenseByCategoryChart').getContext('2d');

    const categoryLabels = {!! json_encode($categoryLabels ?? []) !!};
    const categoryTotals = {!! json_encode($categoryTotals ?? []) !!};

    const hasData = categoryTotals.length > 0 && categoryTotals.some(v => v > 0);

    if (hasData) {
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: categoryLabels,
                datasets: [{
                    label: 'Pengeluaran',
                    data: categoryTotals,
                    backgroundColor: '#6366f1',
                    borderRadius: 8,
                    maxBarThickness: 48,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        },
                        grid: { color: '#f3f4f6' }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });
    } else {
        document.getElementById('expenseByCategoryChart').parentElement.innerHTML =
            '<p class="text-gray-400 text-sm text-center flex items-center justify-center h-full">Belum ada data grafik bulan ini.</p>';
    }
</script>
@endpush

        <div class="space-y-8">
            @if(isset($activeChallenge) && $activeChallenge)
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 relative overflow-hidden">
        <div class="absolute top-0 right-0 bg-blue-600 text-white text-xs font-bold px-3 py-1 rounded-bl-xl">Aktif</div>

        <h3 class="font-bold text-gray-800 mb-4">Challenge Aktif</h3>

        @php
            $totalDays   = max(1, (int) $activeChallenge->start_date->diffInDays($activeChallenge->end_date));
            $daysPassed  = min((int) $activeChallenge->start_date->diffInDays(now()), $totalDays);
            $pct         = round(($daysPassed / $totalDays) * 100);
            $rewardPts   = $totalDays * 10;
            $catName     = $activeChallenge->category->category_name ?? 'Kategori';
            $catIcon     = $activeChallenge->category->icon  ?? 'fa-solid fa-trophy';
            $catColor    = $activeChallenge->category->color ?? '#4F46E5';
        @endphp

        <div class="flex items-center gap-4 mb-4">
            {{-- ✅ Ikon dan warna dari kategori challenge, bukan property yang tidak ada --}}
            <div class="w-14 h-14 rounded-xl flex items-center justify-center text-2xl shrink-0"
                 style="background-color: {{ $catColor }}22; color: {{ $catColor }}">
                <i class="{{ $catIcon }}"></i>
            </div>
            <div>
                <h4 class="font-bold text-gray-800 text-sm">
                    Hemat {{ $catName }} {{ $totalDays }} Hari
                </h4>
                <p class="text-xs text-gray-500 mt-1">
                    Hindari over budget kategori {{ $catName }}.
                </p>
            </div>
        </div>

        <div class="mb-2 flex justify-between items-end">
            <span class="text-xs font-semibold text-blue-600">Progress</span>
            <span class="text-xs text-gray-500">{{ $daysPassed }} / {{ $totalDays }} Hari</span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-2.5 mb-4">
            <div class="bg-blue-600 h-2.5 rounded-full transition-all"
                 style="width: {{ $pct }}%"></div>
        </div>

        <div class="flex justify-between items-center bg-slate-50 p-3 rounded-xl border border-gray-100">
            <div>
                <p class="text-xs text-gray-500 mb-1">Nyawa (Lives)</p>
                <div class="flex gap-1 text-red-500">
                    @for($i = 0; $i < 3; $i++)
                        @if($i < $activeChallenge->remaining_lives)
                            <i class="fa-solid fa-heart"></i>
                        @else
                            <i class="fa-regular fa-heart"></i>
                        @endif
                    @endfor
                </div>
            </div>
            <div class="text-right">
                <p class="text-xs text-gray-500 mb-1">Hadiah</p>
                {{-- ✅ Hitung dari totalDays * 10, bukan dari property yang tidak ada --}}
                <p class="text-sm font-bold text-yellow-500">+{{ $rewardPts }} Poin</p>
            </div>
        </div>
    </div>
            @else
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 text-center">
                    <h3 class="font-bold text-gray-800 mb-2 text-left">Challenge Aktif</h3>
                    <div class="py-6">
                        <i class="fa-solid fa-flag-checkered text-gray-300 text-4xl mb-3"></i>
                        <p class="text-sm text-gray-400 italic">Kamu tidak sedang mengikuti tantangan hemat.</p>
                        <a href="{{ route('challenges.index') }}"
                        class="text-xs text-blue-600 font-semibold hover:underline mt-2 inline-block">
                        Cari Challenge Baru >
                        </a>
                    </div>
                </div>
            @endif

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-gray-800 mb-4">Ringkasan Bulan Ini</h3>
                <div class="space-y-4">
                    <div class="flex justify-between items-center border-b border-gray-50 pb-2">
                        <div class="flex items-center gap-2 text-gray-600">
                            <i class="fa-regular fa-credit-card w-5 text-center text-blue-500"></i>
                            <span class="text-sm">Total Pengeluaran</span>
                        </div>
                        <span class="font-semibold text-sm">Rp {{ number_format($totalPengeluaran ?? 0, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center border-b border-gray-50 pb-2">
                        <div class="flex items-center gap-2 text-gray-600">
                            <i class="fa-solid fa-bullseye w-5 text-center text-emerald-500"></i>
                            <span class="text-sm">Total Anggaran</span>
                        </div>
                        <span class="font-semibold text-sm">Rp {{ number_format($totalAnggaran ?? 0, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <div class="flex items-center gap-2 text-gray-600">
                            <i class="fa-solid fa-chart-line w-5 text-center text-purple-500"></i>
                            <span class="text-sm">Persentase Penggunaan</span>
                        </div>
                        <span class="font-bold text-sm text-blue-600">
                            @if(($totalAnggaran ?? 0) > 0)
                                {{ round(($totalPengeluaran / $totalAnggaran) * 100, 1) }}%
                            @else
                                0%
                            @endif
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('expenseChart').getContext('2d');
            
            // Mengonversi data dari PHP controller agar dibaca oleh JavaScript Chart.js
            const chartDataRaw = @json($chartData ?? []);
            
            const labels = chartDataRaw.map(item =>
                item.category ? item.category.category_name : 'Lainnya');            
            const dataValues = chartDataRaw.map(item => item.total);
            const colors = chartDataRaw.map(item =>
                item.category ? item.category.color : '#9CA3AF'
        );

            // Jika data kosong, tampilkan grafik default abu-abu (Empty State)
            const finalData = dataValues.length > 0 ? dataValues : [1];
            const finalLabels = labels.length > 0 ? labels : ['Belum ada pengeluaran'];
            const finalColors = colors.length > 0 ? colors : ['#E5E7EB'];

            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: finalLabels,
                    datasets: [{
                        data: finalData,
                        backgroundColor: finalColors,
                        borderWidth: 0,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '75%',
                    plugins: {
                        legend: { display: false }
                    }
                }
            });
        });
    </script>
    @endpush