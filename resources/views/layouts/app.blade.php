<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SpendWise - User Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; }
        .sidebar-active { background: rgba(255, 255, 255, 0.15); border-left: 4px solid #fff; font-weight: 600; }
        .sidebar-item { transition: all 0.3s ease; }
        .sidebar-item:hover { background: rgba(255, 255, 255, 0.1); padding-left: 1.5rem; }
    </style>
</head>
<body class="flex h-screen overflow-hidden text-gray-800">

    <aside class="w-64 bg-gradient-to-b from-blue-600 to-indigo-800 text-white flex flex-col shadow-xl z-20">
        <div class="p-6 flex items-center gap-3">
            <div class="bg-white text-blue-600 p-2 rounded-lg">
                <i class="fa-solid fa-wallet text-xl"></i>
            </div>
            <h1 class="text-2xl font-bold tracking-wide">SpendWise</h1>
        </div>

        <nav class="flex-1 px-4 space-y-2 mt-4 overflow-y-auto">
            <a href="{{ route('dashboard') }}" class="sidebar-item sidebar-active flex items-center gap-3 px-4 py-3 rounded-xl text-sm">
                <i class="fa-solid fa-chart-pie w-5"></i> Dashboard
            </a>
            <a href="{{ route('categories.index') }}" class="sidebar-item flex items-center gap-3 px-4 py-3 rounded-xl text-sm opacity-80">
                <i class="fa-solid fa-tags w-5"></i> Kategori
            </a>
            <a href="{{ route('expense.index') }}" class="sidebar-item flex items-center gap-3 px-4 py-3 rounded-xl text-sm opacity-80">
                <i class="fa-solid fa-receipt w-5"></i> Pengeluaran
            </a>
            <a href="{{ route('challenges.index') }}" class="sidebar-item flex items-center gap-3 px-4 py-3 rounded-xl text-sm opacity-80">
                <i class="fa-solid fa-trophy w-5"></i> Challenge
            </a>
            <a href="{{ route('rewards.index') }}" class="sidebar-item flex items-center gap-3 px-4 py-3 rounded-xl text-sm opacity-80">
                <i class="fa-solid fa-gift w-5"></i> Reward
            </a>
            <a href="{{ route('user-rewards.index') }}" class="sidebar-item flex items-center gap-3 px-4 py-3 rounded-xl text-sm opacity-80">
                <i class="fa-solid fa-history w-5"></i> Riwayat
            </a>
        </nav>

        <div class="p-4 m-4 bg-white/10 rounded-2xl backdrop-blur-sm border border-white/20">
            <div class="flex items-center gap-3">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'User') }}&background=E0F2FE&color=0284C7" alt="Profile" class="w-10 h-10 rounded-full border-2 border-white">
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold truncate">{{ Auth::user()->name ?? 'Aulia Rahman' }}</p>
                    <p class="text-xs text-yellow-300 font-medium"><i class="fa-solid fa-star mr-1"></i>{{ Auth::user()->points ?? 0 }}</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="mt-3">
                @csrf
                <button type="submit" class="w-full text-xs text-center py-2 bg-white/10 hover:bg-red-500 hover:text-white transition rounded-lg text-red-200">
                    <i class="fa-solid fa-right-from-bracket mr-1"></i> Keluar
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 flex flex-col h-screen overflow-hidden bg-slate-50">
        <header class="bg-white shadow-sm border-b border-gray-100 px-8 py-4 flex justify-between items-center z-10">
            <h2 class="text-xl font-bold text-gray-800">@yield('title', 'Dashboard')</h2>
            <div class="flex items-center gap-4">
                <button class="text-gray-400 hover:text-blue-600"><i class="fa-regular fa-bell text-xl"></i></button>
            </div>
        </header>

        <div class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-50 p-8">
            @yield('content')
        </div>
    </main>

    @stack('scripts')
</body>
</html>