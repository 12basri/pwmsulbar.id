<aside
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    class="fixed inset-y-0 left-0 z-40 w-64 bg-pwm-sidebar text-white transition-transform duration-300 md:translate-x-0 md:sticky md:top-0 flex flex-col justify-between shadow-xl shrink-0 h-screen">

    <div class="flex flex-col flex-1 min-h-0 overflow-hidden">
        <!-- Logo / Brand Header -->
        <div class="h-20 flex items-center px-6 border-b border-white/10 bg-black/10 shrink-0">
            <div class="flex items-center space-x-3">
                <img src="<?= base_url('assets/images/logo.png') ?>" alt="Logo PWM Sulbar" class="w-10 h-10 object-contain drop-shadow">
                <div>
                    <h2 class="font-bold text-base tracking-wide leading-tight text-white">PWM SULBAR</h2>
                    <p class="text-[10px] tracking-wider text-yellow-400 font-semibold uppercase">ADMIN SYSTEM</p>
                </div>
            </div>
        </div>

        <!-- Navigation Links -->
        <nav class="flex-1 px-4 py-4 space-y-1.5 text-sm font-medium overflow-y-auto custom-scrollbar">

            <!-- Dashboard -->
            <a href="<?= base_url('admin/dashboard') ?>" class="flex items-center space-x-3 px-4 py-3 rounded-lg transition <?= url_is('admin/dashboard') ? 'bg-white/10 text-white font-semibold' : 'text-slate-200 hover:bg-white/5' ?>">
                <svg class="w-5 h-5 <?= url_is('admin/dashboard') ? 'text-yellow-400' : 'text-slate-300' ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 00-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span>Dashboard</span>
            </a>

            <!-- Profil (Dropdown) -->
            <div x-data="{ open: <?= url_is('admin/profil*') ? 'true' : 'false' ?> }">
                <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-3 rounded-lg text-slate-200 hover:bg-white/5 transition <?= url_is('admin/profil*') ? 'bg-white/5 font-semibold' : '' ?>">
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span>Profil</span>
                    </div>
                    <svg :class="open ? 'rotate-180' : ''" class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="open" x-collapse class="pl-11 pr-4 py-1 space-y-1 text-xs text-slate-300">
                    <a href="<?= base_url('admin/profil/tentang-kami') ?>" class="block py-2 hover:text-white transition <?= url_is('admin/profil/tentang-kami') ? 'text-yellow-400 font-semibold' : '' ?>">Tentang Kami</a>
                    <a href="<?= base_url('admin/profil/sejarah') ?>" class="block py-2 hover:text-white transition <?= url_is('admin/profil/sejarah') ? 'text-yellow-400 font-semibold' : '' ?>">Sejarah</a>
                    <a href="<?= base_url('admin/profil/visi-misi') ?>" class="block py-2 hover:text-white transition <?= url_is('admin/profil/visi-misi') ? 'text-yellow-400 font-semibold' : '' ?>">Visi, Misi & Tujuan</a>
                    <a href="<?= base_url('admin/profil/struktur-organisasi') ?>" class="block py-2 hover:text-white transition <?= url_is('admin/profil/struktur-organisasi') ? 'text-yellow-400 font-semibold' : '' ?>">Struktur Organisasi</a>
                    <a href="<?= base_url('admin/profil/program-kerja') ?>" class="block py-2 hover:text-white transition <?= url_is('admin/profil/program-kerja') ? 'text-yellow-400 font-semibold' : '' ?>">Program Kerja</a>
                    <a href="<?= base_url('admin/profil/aum') ?>" class="block py-2 hover:text-white transition <?= url_is('admin/profil/aum') ? 'text-yellow-400 font-semibold' : '' ?>">Amal Usaha Muhammadiyah</a>
                    <a href="<?= base_url('admin/profil/kampus') ?>" class="block py-2 hover:text-white transition <?= url_is('admin/profil/kampus') ? 'text-yellow-400 font-semibold' : '' ?>">Perguruan Tinggi / Kampus</a>
                </div>
            </div>

            <!-- Berita -->
            <a href="<?= base_url('admin/berita') ?>" class="flex items-center space-x-3 px-4 py-3 rounded-lg transition <?= url_is('admin/berita*') ? 'bg-white/10 text-white font-semibold' : 'text-slate-200 hover:bg-white/5' ?>">
                <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                </svg>
                <span>Berita</span>
            </a>

            <!-- Slider -->
            <a href="<?= base_url('admin/slider') ?>" class="flex items-center space-x-3 px-4 py-3 rounded-lg transition <?= url_is('admin/slider*') ? 'bg-white/10 text-white font-semibold' : 'text-slate-200 hover:bg-white/5' ?>">
                <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                </svg>
                <span>Slider</span>
            </a>

            <!-- Banner Iklan -->
            <a href="<?= base_url('admin/banner') ?>" class="flex items-center space-x-3 px-4 py-3 rounded-lg transition <?= url_is('admin/banner*') ? 'bg-white/10 text-white font-semibold' : 'text-slate-200 hover:bg-white/5' ?>">
                <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span>Banner Iklan</span>
            </a>

            <!-- Refleksi -->
            <a href="<?= base_url('admin/refleksi') ?>" class="flex items-center space-x-3 px-4 py-3 rounded-lg transition <?= url_is('admin/refleksi*') ? 'bg-white/10 text-white font-semibold' : 'text-slate-200 hover:bg-white/5' ?>">
                <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                <span>Refleksi</span>
            </a>

            <!-- Sekolah -->
            <a href="<?= base_url('admin/sekolah') ?>" class="flex items-center space-x-3 px-4 py-3 rounded-lg transition <?= url_is('admin/sekolah*') ? 'bg-white/10 text-white font-semibold' : 'text-slate-200 hover:bg-white/5' ?>">
                <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0112 20.055a11.952 11.952 0 01-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                </svg>
                <span>Sekolah</span>
            </a>

            <!-- Kampus -->
            <a href="<?= base_url('admin/kampus') ?>" class="flex items-center space-x-3 px-4 py-3 rounded-lg transition <?= url_is('admin/kampus*') ? 'bg-white/10 text-white font-semibold' : 'text-slate-200 hover:bg-white/5' ?>">
                <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                </svg>
                <span>Kampus</span>
            </a>

            <!-- Organisasi -->
            <a href="<?= base_url('admin/organisasi') ?>" class="flex items-center space-x-3 px-4 py-3 rounded-lg transition <?= url_is('admin/organisasi*') ? 'bg-white/10 text-white font-semibold' : 'text-slate-200 hover:bg-white/5' ?>">
                <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <span>Organisasi</span>
            </a>

            <!-- Majelis dan Lembaga (Dropdown) -->
            <div x-data="{ open: <?= (url_is('admin/majelis*') || url_is('admin/ortom*')) ? 'true' : 'false' ?> }">
                <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-3 rounded-lg text-slate-200 hover:bg-white/5 transition <?= (url_is('admin/majelis*') || url_is('admin/ortom*')) ? 'bg-white/5 font-semibold' : '' ?>">
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        <span>Majelis dan Lembaga</span>
                    </div>
                    <svg :class="open ? 'rotate-180' : ''" class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="open" x-collapse class="pl-11 pr-4 py-1 space-y-1 text-xs text-slate-300">
                    <a href="<?= base_url('admin/majelis') ?>" class="block py-2 hover:text-white transition <?= url_is('admin/majelis*') ? 'text-yellow-400 font-semibold' : '' ?>">Majelis Atau Lembaga</a>
                    <a href="<?= base_url('admin/ortom') ?>" class="block py-2 hover:text-white transition <?= url_is('admin/ortom*') ? 'text-yellow-400 font-semibold' : '' ?>">Organisasi Otonom</a>
                </div>
            </div>

            <!-- PDM (Dropdown) -->
            <div x-data="{ open: <?= url_is('admin/pdm*') ? 'true' : 'false' ?> }">
                <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-3 rounded-lg text-slate-200 hover:bg-white/5 transition <?= url_is('admin/pdm*') ? 'bg-white/5 font-semibold' : '' ?>">
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span>PDM</span>
                    </div>
                    <svg :class="open ? 'rotate-180' : ''" class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="open" x-collapse class="pl-11 pr-4 py-1 space-y-1 text-xs text-slate-300">
                    <a href="<?= base_url('admin/pdm/sejarah') ?>" class="block py-2 hover:text-white transition <?= url_is('admin/pdm/sejarah') ? 'text-yellow-400 font-semibold' : '' ?>">Sejarah</a>
                    <a href="<?= base_url('admin/pdm/pengurus') ?>" class="block py-2 hover:text-white transition <?= url_is('admin/pdm/pengurus') ? 'text-yellow-400 font-semibold' : '' ?>">Pengurus</a>
                    <a href="<?= base_url('admin/pdm/website') ?>" class="block py-2 hover:text-white transition <?= url_is('admin/pdm/website') ? 'text-yellow-400 font-semibold' : '' ?>">Website PDM</a>
                </div>
            </div>

            <!-- Dokumen dan Arsip -->
            <a href="<?= base_url('admin/dokumen-arsip') ?>" class="flex items-center space-x-3 px-4 py-3 rounded-lg transition <?= url_is('admin/dokumen-arsip*') ? 'bg-white/10 text-white font-semibold' : 'text-slate-200 hover:bg-white/5' ?>">
                <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-2m-4-1v8m0 0l3-3m-3 3L9 8m-5 5h2.586a1 1 0 01.707.293l2.414 2.414a1 1 0 00.707.293h3.172a1 1 0 01.707-.293l2.414-2.414a1 1 0 01.707-.293H20" />
                </svg>
                <span>Dokumen dan Arsip</span>
            </a>

        </nav>
    </div>

    <!-- Red Logout Button -->
    <div class="p-4 border-t border-white/10 bg-pwm-sidebar shrink-0">
        <a href="<?= base_url('logout') ?>" class="w-full flex items-center justify-center space-x-2 py-3 px-4 bg-pwm-red hover:bg-red-700 text-white font-medium text-sm rounded-xl transition shadow-md">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
            </svg>
            <span>Keluar</span>
        </a>
    </div>

</aside>