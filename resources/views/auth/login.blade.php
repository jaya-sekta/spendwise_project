<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - SpendWise</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 flex min-h-screen">

    <!-- Kolom Kiri: Branding (Hanya tampil di layar besar/Desktop) -->
    <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-[#0F4CDB] to-[#0A369D] text-white p-12 flex-col justify-between relative overflow-hidden">
        
        <!-- Ornamen Background (Meniru gambar dompet transparan di pojok) -->
        <i class="fa-solid fa-wallet absolute -bottom-24 -left-16 text-[250px] text-white opacity-5 -rotate-12"></i>

        <!-- Logo -->
        <div class="flex items-center gap-3 relative z-10">
            <div class="bg-white text-[#0F4CDB] p-2 rounded-lg">
                <i class="fa-solid fa-wallet text-xl"></i>
            </div>
            <h1 class="text-2xl font-bold tracking-wide">SpendWise</h1>
        </div>

        <!-- Teks Copywriting -->
        <div class="relative z-10 mb-20">
            <h2 class="text-4xl font-bold leading-tight mb-6">
                Kelola <span class="text-[#4ADEDE]">budget-mu,</span><br>
                menangkan tantangannya.
            </h2>
            <p class="text-blue-100 text-lg leading-relaxed max-w-md">
                Pantau pengeluaran, ikuti tantangan hemat, dan kumpulkan poin untuk ditukar reward menarik.
            </p>
        </div>
        
        <!-- Kosong untuk menyeimbangkan flex justify-between -->
        <div></div>
    </div>

    <!-- Kolom Kanan: Form Login -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 sm:p-12">
        <div class="w-full max-w-md bg-white p-8 rounded-2xl shadow-sm lg:shadow-none lg:bg-transparent lg:p-0">
            
            <!-- Logo untuk versi Mobile (Merespon jika layar kecil) -->
            <div class="flex items-center gap-3 mb-8 lg:hidden justify-center">
                <div class="bg-[#0F4CDB] text-white p-2 rounded-lg">
                    <i class="fa-solid fa-wallet text-xl"></i>
                </div>
                <h1 class="text-2xl font-bold text-gray-800 tracking-wide">SpendWise</h1>
            </div>

            <div class="text-center mb-8">
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Selamat datang kembali!</h3>
                <p class="text-gray-500 text-sm">Masuk ke akunmu untuk lanjut memantau budget.</p>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <!-- Input Email -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-1.5">Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fa-regular fa-envelope text-gray-400"></i>
                        </div>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                            class="block w-full pl-11 pr-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-[#0F4CDB]/20 focus:border-[#0F4CDB] transition-colors outline-none @error('email') border-red-500 @enderror"
                            placeholder="nama@email.com">
                    </div>
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Input Password -->
                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-1.5">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fa-solid fa-lock text-gray-400"></i>
                        </div>
                        <input type="password" name="password" id="password" required
                            class="block w-full pl-11 pr-12 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-[#0F4CDB]/20 focus:border-[#0F4CDB] transition-colors outline-none"
                            placeholder="Masukkan password">
                        
                        <!-- Toggle Show/Hide Password -->
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center">
                            <button type="button" id="togglePassword" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                                <i class="fa-regular fa-eye" id="eyeIcon"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between mt-4">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded border-gray-300 text-[#0F4CDB] focus:ring-[#0F4CDB]">
                        <span class="text-sm text-gray-600">Ingat saya</span>
                    </label>
                    <a href="#" class="text-sm font-semibold text-[#0F4CDB] hover:underline">Lupa password?</a>
                </div>

                <!-- Tombol Masuk -->
                <button type="submit" class="w-full bg-[#185adb] hover:bg-[#0A369D] text-white font-semibold py-3 px-4 rounded-xl transition duration-200 shadow-md hover:shadow-lg mt-6">
                    Masuk
                </button>
            </form>

            <!-- Divider -->
            <div class="mt-8 flex items-center justify-between">
                <hr class="w-full border-gray-200">
                <span class="px-4 text-sm text-gray-400 bg-white lg:bg-transparent">atau</span>
                <hr class="w-full border-gray-200">
            </div>

            <!-- Login Google (Opsional/UI saja untuk saat ini) -->
            <button type="button" class="mt-6 w-full flex items-center justify-center gap-3 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 font-semibold py-3 px-4 rounded-xl transition duration-200 shadow-sm">
                <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google Logo" class="w-5 h-5">
                Masuk dengan Google
            </button>

            <!-- Link Register -->
            <p class="text-center text-sm text-gray-600 mt-8">
                Belum punya akun? <a href="{{ route('register') }}" class="font-semibold text-[#0F4CDB] hover:underline">Daftar sekarang</a>
            </p>

        </div>
    </div>

    <!-- Script Interaktif (Toggle Password) -->
    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');
        const eyeIcon = document.querySelector('#eyeIcon');

        togglePassword.addEventListener('click', function (e) {
            // Toggle type input antara password & text
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            
            // Toggle icon mata
            if(type === 'text'){
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        });
    </script>
</body>
</html>