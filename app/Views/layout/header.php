<header class="h-20 bg-white border-b border-slate-200/80 flex items-center justify-between px-6 md:px-8 shadow-sm">
    <!-- Left Title -->
    <div class="flex items-center space-x-4">
        <button @click="sidebarOpen = !sidebarOpen" class="md:hidden text-slate-600 focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
        <h1 class="text-xl font-bold text-slate-800">
            Pengurus Wilayah <span class="text-emerald-600">Muhammadiyah Sulawesi Barat</span>
        </h1>
    </div>

    <!-- Right Profile Section -->
    <div class="flex items-center space-x-5">
        <!-- Notification Bell -->
        <button class="relative text-slate-400 hover:text-slate-600 transition">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 01-6 0v-1m6 0H9" />
            </svg>
            <span class="absolute top-0 right-0 w-2.5 h-2.5 bg-red-500 rounded-full border-2 border-white"></span>
        </button>

        <!-- Profile Badge -->
        <div class="flex items-center space-x-3 pl-4 border-l border-slate-200">
            <div class="w-10 h-10 rounded-full bg-pwm-sidebar text-white flex items-center justify-center font-bold text-base shadow">
                <?= strtoupper(substr(session()->get('nama_lengkap') ?? 'A', 0, 1)) ?>
            </div>
            <div class="hidden sm:block text-left leading-tight">
                <p class="text-sm font-bold text-slate-800"><?= session()->get('nama_lengkap') ?? 'Administrator PWM' ?></p>
                <p class="text-xs text-slate-400 font-medium"><?= session()->get('level') ?? 'Super Admin' ?></p>
            </div>
        </div>
    </div>
</header>