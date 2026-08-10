<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Pengurus Wilayah Muhammadiyah Sulawesi Barat</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Alpine.js CDN (Untuk Fitur Toggle Show/Hide Password & Interaktivitas) -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                    colors: {
                        pwm: {
                            blue: '#0B2545',
                            darkblue: '#134074',
                            green: '#059669',
                            lightgreen: '#10B981',
                            gold: '#D97706',
                        }
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-slate-950 min-h-screen flex items-center justify-center p-4 sm:p-6 relative overflow-hidden font-sans antialiased selection:bg-emerald-500 selection:text-white" x-data="{ showPassword: false }">

    <!-- ==================== AMBIENT BACKGROUND GLOWS ==================== -->
    <div class="absolute -top-32 -left-32 w-[500px] h-[500px] bg-emerald-500/20 rounded-full blur-[120px] pointer-events-none animate-pulse"></div>
    <div class="absolute -bottom-32 -right-32 w-[500px] h-[500px] bg-sky-600/20 rounded-full blur-[120px] pointer-events-none"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-pwm-blue/40 rounded-full blur-[140px] pointer-events-none"></div>

    <!-- Background Pattern Decorative -->
    <div class="absolute inset-0 bg-[radial-gradient(#ffffff_1px,transparent_1px)] [background-size:24px_24px] opacity-[0.03] pointer-events-none"></div>

    <!-- ==================== MAIN CARD CONTAINER ==================== -->
    <div class="w-full max-w-md bg-white/95 backdrop-blur-xl rounded-3xl shadow-[0_20px_50px_rgba(0,0,0,0.3)] border border-white/40 p-8 sm:p-10 relative z-10 transition-all duration-300">

        <!-- Navigasi Kembali Ke Website Utama -->
        <div class="flex justify-between items-center mb-6">
            <a href="<?= base_url('/') ?>" class="inline-flex items-center text-xs font-semibold text-slate-400 hover:text-emerald-600 transition-colors group">
                <svg class="w-4 h-4 mr-1.5 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Beranda Utama
            </a>
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold tracking-wide bg-emerald-100 text-emerald-800 uppercase">
                Secure Portal
            </span>
        </div>

        <!-- Header / Logo PWM -->
        <div class="text-center mb-8">
            <div class="relative inline-flex items-center justify-center mb-4 group">
                <!-- Glowing Aura behind Logo -->
                <div class="absolute inset-0 bg-emerald-500/20 rounded-2xl blur-lg group-hover:bg-emerald-500/30 transition-all"></div>
                <div class="relative bg-gradient-to-b from-slate-50 to-slate-100 p-3 rounded-2xl border border-slate-200/80 shadow-sm">
                    <img src="<?= base_url('assets/images/logo.png') ?>" alt="Logo PWM Sulawesi Barat" class="w-20 h-20 object-contain drop-shadow-md transform group-hover:scale-105 transition duration-300">
                </div>
            </div>

            <h1 class="text-xl font-bold text-slate-800 tracking-tight leading-snug">
                Pimpinan Wilayah Muhammadiyah
            </h1>
            <p class="text-sm font-bold text-pwm-green mt-0.5 tracking-wide uppercase">Sulawesi Barat</p>
            <p class="text-xs text-slate-500 mt-2">Silakan masuk untuk mengelola portal administrator</p>
        </div>

        <!-- Notification Flash Alert -->
        <?php if (session()->getFlashdata('error')) : ?>
            <div class="mb-6 bg-red-50/90 border border-red-200 p-4 rounded-2xl flex items-start space-x-3 animate-shake">
                <div class="p-1 bg-red-100 rounded-lg text-red-600 flex-shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <span class="text-xs font-medium text-red-700 leading-relaxed pt-0.5">
                    <?= session()->getFlashdata('error') ?>
                </span>
            </div>
        <?php endif; ?>

        <!-- Form Login -->
        <form action="<?= base_url('login/process') ?>" method="POST" class="space-y-5">
            <?= csrf_field() ?>

            <!-- Input Username -->
            <div>
                <label for="username" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Username</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 group-focus-within:text-emerald-600 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <input type="text" name="username" id="username" required placeholder="Masukkan username"
                        class="w-full pl-10 pr-4 py-3.5 bg-slate-50/80 border border-slate-200 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition duration-200 font-medium">
                </div>
            </div>

            <!-- Input Password (With Show/Hide Toggle) -->
            <div>
                <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Password</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 group-focus-within:text-emerald-600 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>

                    <input :type="showPassword ? 'text' : 'password'" name="password" id="password" required placeholder="••••••••"
                        class="w-full pl-10 pr-12 py-3.5 bg-slate-50/80 border border-slate-200 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition duration-200 font-medium">

                    <!-- Toggle Show/Hide Icon -->
                    <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none">
                        <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg x-show="showPassword" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858-5.908a8.96 8.96 0 012.122-.063c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m-1.92-2.193a3 3 0 01-3.83-3.83m.2 4.03l-10-10" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Options: Remember & Forgot Password -->
            <div class="flex items-center justify-between text-xs pt-1">
                <label class="flex items-center text-slate-600 cursor-pointer select-none group">
                    <input type="checkbox" class="w-4 h-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500/20 transition">
                    <span class="ml-2 font-medium group-hover:text-slate-900 transition-colors">Ingat saya</span>
                </label>
                <a href="#" class="text-emerald-600 hover:text-emerald-700 font-semibold transition hover:underline">Lupa password?</a>
            </div>

            <!-- Submit Button -->
            <button type="submit"
                class="w-full py-4 px-4 bg-gradient-to-r from-pwm-blue via-slate-900 to-emerald-700 hover:from-slate-900 hover:to-emerald-800 text-white text-sm font-bold rounded-xl shadow-lg shadow-emerald-900/20 hover:shadow-emerald-900/30 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transform active:scale-[0.98] transition-all duration-200 flex items-center justify-center space-x-2 group">
                <span>Masuk Sistem</span>
                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </button>
        </form>

        <!-- Footer -->
        <div class="mt-8 text-center border-t border-slate-100 pt-5">
            <p class="text-xs text-slate-400 font-medium">
                &copy; <?= date('Y') ?> <span class="text-slate-600 font-semibold">PW Muhammadiyah Sulbar</span>.
            </p>
        </div>
    </div>

</body>

</html>