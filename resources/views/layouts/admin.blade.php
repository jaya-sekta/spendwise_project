<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SpendWise - Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f1f5f9; }

        /* Bedanya di sini: active pakai amber, bukan putih */
        .sidebar-active { background: rgba(251,191,36,0.15); border-left: 4px solid #FBBF24; font-weight: 600; color: #FCD34D; }
        .sidebar-item { transition: all 0.3s ease; }
        .sidebar-item:hover { background: rgba(255,255,255,0.07); padding-left: 1.5rem; }

        /* Section label di dalam sidebar */
        .sidebar-section { font-size: 10px; letter-spacing: .1em; font-weight: 700; text-transform: uppercase; color: #475569; padding: 0.85rem 1rem 0.3rem; }
    </style>
</head>
<body class="flex h-screen overflow-hidden text-gray-800">

    {{-- SIDEBAR: gelap (slate-900→slate-800), bukan biru --}}
    <aside class="w-64 bg-gradient-to-b from-slate-900 to-slate-800 text-white flex flex-col shadow-xl z-20">

        {{-- Logo + badge Admin --}}
        <div class="p-6">
            <div class="flex items-center gap-3 mb-3">
                <div class="bg-amber-500/20 border border-amber-500/30 text-amber-400 p-2 rounded-lg">
                    <i class="fa-solid fa-wallet text-xl"></i>
                </div>
                <h1 class="text-2xl font-bold tracking-wide">SpendWise</h1>
            </div>
            {{-- Badge ini yang paling membedakan dari layout user --}}
            <div class="flex items-center gap-2 bg-amber-500/15 border border-amber-500/25 rounded-lg px-3 py-1.5">
                <span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-pulse"></span>
                <span class="text-amber-300 text-xs font-bold tracking-widest uppercase">Admin Panel</span>
            </div>
        </div>

       <nav class="flex-1 px-4 overflow-y-auto">

    {{-- Section Utama --}}
    <p class="sidebar-section">Utama</p>
    <a href="{{ route('admin.dashboard') }}" class="sidebar-item sidebar-active flex items-center gap-3 px-4 py-3 rounded-xl text-sm mb-1">
        <i class="fa-solid fa-gauge-high w-5"></i> Dashboard
    </a>

    {{-- Section Kelola --}}
    <p class="sidebar-section">Kelola</p>
    
    <a href="#" class="sidebar-item flex items-center gap-3 px-4 py-3 rounded-xl text-sm opacity-70 mb-1">
        <i class="fa-solid fa-gift w-5"></i> Kelola Reward
    </a>
    
    <a href="{{ route('admin.categories.index') }}" class="sidebar-item flex items-center gap-3 px-4 py-3 rounded-xl text-sm opacity-70 mb-1">
        <i class="fa-solid fa-tags w-5"></i> Kategori Bawaan
    </a>

    {{-- Section Logger --}}
    <p class="sidebar-section">Logger</p>
    
    <a href="{{ route('admin.logger') }}"
   class="{{ request()->routeIs('admin.logger') ? 'sidebar-active' : '' }} flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition">
    <i class="fa-solid fa-route"></i> Log Activity User
</a>
    

</nav>

        {{-- User card admin — sedikit beda: pakai inisial + badge "Administrator" --}}
        <div class="p-4 m-4 bg-white/5 rounded-2xl border border-white/10">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center font-bold text-white text-sm shrink-0">
                    {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold truncate">{{ Auth::user()->name ?? 'Admin' }}</p>
                    <span class="text-[10px] font-bold text-amber-400">
                        <i class="fa-solid fa-shield-halved mr-0.5"></i> Administrator
                    </span>
                </div>
            </div>
            <div class="mt-3 flex gap-2">
                {{-- Tombol switch ke tampilan user — tidak ada di layout user biasa --}}
                <a href="{{ route('dashboard') }}"
                   class="flex-1 text-xs text-center py-2 bg-white/10 hover:bg-indigo-600 transition rounded-lg text-slate-300 font-medium">
                    <i class="fa-solid fa-user mr-1"></i> User View
                </a>
                <form method="POST" action="{{ route('logout') }}" class="flex-1">
                    @csrf
                    <button type="submit" class="w-full text-xs py-2 bg-white/10 hover:bg-red-500 hover:text-white transition rounded-lg text-red-300">
                        <i class="fa-solid fa-right-from-bracket mr-1"></i> Keluar
                    </button>
                </form>
            </div>
        </div>
    </aside>

    {{-- MAIN: sama persis dengan layout user --}}
    <main class="flex-1 flex flex-col h-screen overflow-hidden bg-slate-100">
        <header class="bg-white shadow-sm border-b border-gray-100 px-8 py-4 flex justify-between items-center z-10">
            <div class="flex items-center gap-3">
                {{-- Satu-satunya tambahan di topbar: pill "Admin Zone" --}}
                <span class="hidden sm:inline-flex items-center gap-1.5 text-xs font-bold text-amber-700 bg-amber-50 border border-amber-200 px-2.5 py-1 rounded-lg">
                    <i class="fa-solid fa-shield-halved text-amber-500 text-[11px]"></i> Admin Zone
                </span>
                <h2 class="text-xl font-bold text-gray-800">@yield('title', 'Dashboard Admin')</h2>
            </div>
            <div class="flex items-center gap-4">
                <button class="text-gray-400 hover:text-amber-500"><i class="fa-regular fa-bell text-xl"></i></button>
            </div>
        </header>

        <div class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-100 p-8">
            @if (session('success'))
                <div class="mb-5 flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl px-4 py-3 text-sm font-medium">
                    <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="mb-5 flex items-center gap-3 bg-red-50 border border-red-200 text-red-600 rounded-2xl px-4 py-3 text-sm font-medium">
                    <i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    @stack('scripts')
</body>
</html>