<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - SpendWise</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 flex min-h-screen">

    <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-[#0F4CDB] to-[#0A369D] text-white p-12 flex-col justify-between relative overflow-hidden">
        <i class="fa-solid fa-wallet absolute -bottom-24 -left-16 text-[250px] text-white opacity-5 -rotate-12"></i>
        
        <div class="flex items-center gap-3 relative z-10">
            <div class="bg-white text-[#0F4CDB] p-2 rounded-lg">
                <i class="fa-solid fa-wallet text-xl"></i>
            </div>
            <h1 class="text-2xl font-bold tracking-wide">SpendWise</h1>
        </div>

        <div class="relative z-10 mb-20">
            <h2 class="text-4xl font-bold leading-tight mb-6">
                Mulai atur keuanganmu <br> <span class="text-[#4ADEDE]">hari ini!</span>
            </h2>
            <p class="text-blue-100 text-lg leading-relaxed max-w-md">
                Daftar sekarang untuk mulai mencatat pengeluaran, mencapai target hemat, dan meraih poin reward.
            </p>
        </div>
        <div></div>
    </div>

    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 sm:p-12 overflow-y-auto">
        <div class="w-full max-w-md bg-white p-8 rounded-2xl shadow-sm lg:shadow-none lg:bg-transparent lg:p-0">
            
            <div class="text-center mb-8">
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Buat Akun Baru</h3>
                <p class="text-gray-500 text-sm">Bergabunglah dengan komunitas hemat SpendWise.</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}" required autofocus
                        class="block w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-[#0F4CDB]/20 focus:border-[#0F4CDB] outline-none @error('name') border-red-500 @enderror"
                        placeholder="Masukkan nama lengkap">
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        class="block w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-[#0F4CDB]/20 focus:border-[#0F4CDB] outline-none @error('email') border-red-500 @enderror"
                        placeholder="nama@email.com">
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Password</label>
                    <input type="password" name="password" required
                        class="block w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-[#0F4CDB]/20 focus:border-[#0F4CDB] outline-none @error('password') border-red-500 @enderror"
                        placeholder="Minimal 8 karakter">
                    @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" required
                        class="block w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-[#0F4CDB]/20 focus:border-[#0F4CDB] outline-none"
                        placeholder="Ulangi password">
                </div>

                <button type="submit" class="w-full bg-[#185adb] hover:bg-[#0A369D] text-white font-semibold py-3 px-4 rounded-xl transition duration-200 shadow-md mt-6">
                    Daftar Akun
                </button>
            </form>

            <p class="text-center text-sm text-gray-600 mt-8">
                Sudah punya akun? <a href="{{ route('login') }}" class="font-semibold text-[#0F4CDB] hover:underline">Masuk di sini</a>
            </p>
        </div>
    </div>
</body>
</html>