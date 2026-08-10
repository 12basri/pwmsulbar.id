<?php

/**
 * ============================================================================
 * KETERANGAN PERUBAHAN & OPTIMASI DI HEADER.PHP:
 * ============================================================================
 * 1. SANITASI XSS: Menambahkan esc() pada output data database ($k['nama_kampus']).
 * 2. AUTO-RESET MOBILE MENU: Menambahkan listener resize jendela pada Alpine JS
 *    agar drawer mobile otomatis tertutup jika browser di-resize ke layar besar.
 * 3. IMPLEMEN IKLIM MVC / VIEW CELL (Rekomendasi): 
 *    Blok query database di bawah tetap dipertahankan menggunakan try-catch
 *    agar header tidak error jika dimuat sebagai partial view mandiri.
 * 4. PENAMBAHAN MENU OPINI: Menambahkan tautan 'Opini' pada navigasi desktop
 *    serta drawer menu mobile.
 * ============================================================================
 */

try {
    $db = \Config\Database::connect();
    // PERUBAHAN: Menambahkan esc/sanitasi dasar atau fallback query aman
    $list_kampus = $db->table('tb_kampus')->get()->getResultArray();
} catch (\Throwable $e) {
    $list_kampus = [];
}
?>

<!-- CDN ALPINE JS & PLUGIN COLLAPSE -->
<script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<style>
    [x-cloak] {
        display: none !important;
    }
</style>

<!-- HEADER UTAMA (WRAPPER ALPINE JS STATE) -->
<!-- KETERANGAN: Ditambahkan x-on:resize.window untuk menutup menu mobile otomatis saat beralih ke desktop -->
<div x-data="{ 
    mobileOpen: false, 
    openProfilMobile: false, 
    openMajelisMobile: false,
    openAumMobile: false 
}" x-on:resize.window="if (window.innerWidth >= 1024) mobileOpen = false">

    <!-- 1. TOP BAR KONTAK & MEDSOS -->
    <div class="bg-[#0b2847] text-blue-100 text-[11px] py-2 px-4 hidden lg:block border-b border-blue-900/50">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div class="flex items-center space-x-6">
                <span class="flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                    Call center: (0426) 123456
                </span>
                <span class="flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    sekretariat@pwmsulbar.or.id
                </span>
            </div>
            <div class="flex items-center space-x-3 text-blue-200">
                <a href="https://facebook.com/pwmsulbar.or.id" target="_blank" rel="noopener noreferrer" class="p-1 rounded-full hover:bg-blue-900/60 hover:text-amber-400 transition" aria-label="Facebook">
                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24">
                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                    </svg>
                </a>
                <a href="https://instagram.com/pwmsulbar" target="_blank" rel="noopener noreferrer" class="p-1 rounded-full hover:bg-blue-900/60 hover:text-amber-400 transition" aria-label="Instagram">
                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24">
                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                    </svg>
                </a>
                <a href="https://youtube.com" target="_blank" rel="noopener noreferrer" class="p-1 rounded-full hover:bg-blue-900/60 hover:text-amber-400 transition" aria-label="YouTube">
                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24">
                        <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <!-- 2. BANNER BRAND UTAMA -->
    <div class="bg-gradient-to-r from-[#0b2d52] via-[#0c5963] to-[#058c54] text-white py-2 sm:py-3 px-4 sm:px-6 lg:px-8 border-b border-emerald-600/30">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <a href="<?= base_url('/') ?>" class="flex items-center space-x-4 sm:space-x-5">
                <img src="<?= base_url('assets/images/logo.png') ?>" alt="Logo PWM Sulbar" class="w-36 h-14 sm:w-56 sm:h-20 object-contain drop-shadow-md shrink-0">
            </a>
            <div class="hidden md:block text-right">
                <span class="text-2xl sm:text-3xl font-black italic tracking-tight text-white drop-shadow">pwm <span class="text-amber-300">sulbar</span></span>
                <p class="text-[10px] sm:text-xs tracking-widest uppercase text-emerald-200 font-semibold mt-0.5">Pimpinan Wilayah Muhammadiyah</p>
            </div>
        </div>
    </div>

    <!-- 3. NAVIGATION BAR UTAMA -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-14 sm:h-16">

                <!-- Menu Navigasi Desktop -->
                <nav class="hidden lg:flex items-center space-x-1 xl:space-x-2 text-sm font-bold text-slate-700">
                    <a href="<?= base_url('/') ?>" class="px-3.5 py-2.5 rounded-lg text-emerald-600 hover:bg-emerald-50 transition">Beranda</a>

                    <!-- Dropdown Profil -->
                    <div class="relative group">
                        <button type="button" class="flex items-center space-x-1.5 px-3.5 py-2.5 rounded-lg group-hover:text-emerald-600 group-hover:bg-emerald-50 transition focus:outline-none">
                            <span>Profil</span>
                            <svg class="w-4 h-4 text-slate-400 group-hover:rotate-180 group-hover:text-emerald-600 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div class="invisible opacity-0 group-hover:visible group-hover:opacity-100 absolute left-0 top-full w-60 pt-1 z-50 transition-all duration-200 ease-in-out">
                            <div class="bg-white rounded-xl shadow-xl border border-slate-100 py-2 text-xs font-medium space-y-0.5">
                                <a href="<?= base_url('profil/tentang-kami') ?>" class="block px-4 py-2.5 text-slate-700 hover:bg-emerald-50 hover:text-emerald-600 transition">Tentang Kami</a>
                                <a href="<?= base_url('profil/sejarah') ?>" class="block px-4 py-2.5 text-slate-700 hover:bg-emerald-50 hover:text-emerald-600 transition">Sejarah</a>
                                <a href="<?= base_url('profil/visi-misi') ?>" class="block px-4 py-2.5 text-slate-700 hover:bg-emerald-50 hover:text-emerald-600 transition">Visi, Misi & Tujuan</a>
                                <a href="<?= base_url('profil/struktur-organisasi') ?>" class="block px-4 py-2.5 text-slate-700 hover:bg-emerald-50 hover:text-emerald-600 transition">Struktur Organisasi</a>
                                <a href="<?= base_url('profil/program-kerja') ?>" class="block px-4 py-2.5 text-slate-700 hover:bg-emerald-50 hover:text-emerald-600 transition">Program Kerja</a>
                            </div>
                        </div>
                    </div>

                    <!-- Mega Menu AUM -->
                    <div class="relative group">
                        <button type="button" class="flex items-center space-x-1.5 px-3.5 py-2.5 rounded-lg group-hover:text-emerald-600 group-hover:bg-emerald-50 transition focus:outline-none">
                            <span>AUM</span>
                            <svg class="w-4 h-4 text-slate-400 group-hover:rotate-180 group-hover:text-emerald-600 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div class="invisible opacity-0 group-hover:visible group-hover:opacity-100 absolute -left-12 top-full w-[720px] max-w-[90vw] pt-1 z-50 transition-all duration-200 ease-in-out">
                            <div class="bg-white rounded-2xl shadow-2xl border border-slate-100 p-6 space-y-6 text-slate-700">
                                <div class="grid grid-cols-2 gap-8">
                                    <div class="space-y-3">
                                        <div class="flex justify-between items-center border-b border-slate-100 pb-2">
                                            <span class="text-xs font-extrabold uppercase tracking-wider text-emerald-700">Sekolah & Madrasah</span>
                                            <a href="<?= base_url('sekolah') ?>" class="text-[11px] text-slate-400 hover:text-emerald-600 font-semibold">Semua &rarr;</a>
                                        </div>
                                        <div class="grid grid-cols-2 gap-2 text-xs font-medium">
                                            <a href="<?= base_url('sekolah?tingkat=SD') ?>" class="p-2 rounded hover:bg-emerald-50 hover:text-emerald-600">SD</a>
                                            <a href="<?= base_url('sekolah?tingkat=MI') ?>" class="p-2 rounded hover:bg-emerald-50 hover:text-emerald-600">MI</a>
                                            <a href="<?= base_url('sekolah?tingkat=SMP') ?>" class="p-2 rounded hover:bg-emerald-50 hover:text-emerald-600">SMP</a>
                                            <a href="<?= base_url('sekolah?tingkat=MTS') ?>" class="p-2 rounded hover:bg-emerald-50 hover:text-emerald-600">MTs</a>
                                            <a href="<?= base_url('sekolah?tingkat=SMA') ?>" class="p-2 rounded hover:bg-emerald-50 hover:text-emerald-600">SMA</a>
                                            <a href="<?= base_url('sekolah?tingkat=MA') ?>" class="p-2 rounded hover:bg-emerald-50 hover:text-emerald-600">MA</a>
                                            <a href="<?= base_url('sekolah?tingkat=SMK') ?>" class="p-2 rounded hover:bg-emerald-50 hover:text-emerald-600">SMK</a>
                                            <a href="<?= base_url('sekolah?tingkat=SLB') ?>" class="p-2 rounded hover:bg-emerald-50 hover:text-emerald-600">SLB</a>
                                        </div>
                                    </div>

                                    <!-- Dynamic Loop Kampus dari Database -->
                                    <div class="space-y-3">
                                        <div class="flex justify-between items-center border-b border-slate-100 pb-2">
                                            <span class="text-xs font-extrabold uppercase tracking-wider text-emerald-700">Kampus</span>
                                            <a href="<?= base_url('aum/kampus') ?>" class="text-[11px] text-slate-400 hover:text-emerald-600 font-semibold">Semua &rarr;</a>
                                        </div>
                                        <div class="space-y-1 text-xs font-medium max-h-48 overflow-y-auto pr-1">
                                            <?php if (!empty($list_kampus)) : ?>
                                                <?php foreach ($list_kampus as $k) : ?>
                                                    <!-- KETERANGAN: Ditambahkan esc() untuk mencegah celah keamanan XSS -->
                                                    <a href="<?= base_url('aum/kampus/detail/' . ($k['slug'] ?? $k['id'])) ?>"
                                                        class="block p-2 rounded hover:bg-emerald-50 hover:text-emerald-600 transition truncate"
                                                        title="<?= esc($k['nama_kampus']) ?>">
                                                        <?= esc($k['nama_kampus']) ?>
                                                    </a>
                                                <?php endforeach; ?>
                                            <?php else : ?>
                                                <a href="<?= base_url('aum/kampus') ?>" class="block p-2 text-slate-400 italic">Lihat Semua Kampus</a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <!-- KETERANGAN: Bagian ini diubah untuk menggabungkan fasilitas/usaha lain (diluar Sekolah, Madrasah, & Kampus) menjadi 1 direktori tunggal yang mengarah ke controller/view 'usaha_detail.php' -->
                                <div class="pt-4 border-t border-slate-100 space-y-3">
                                    <!-- Label Keterangan Kategori Usaha Lainnya -->
                                    <div class="px-2">
                                        <span class="text-[10px] font-extrabold uppercase tracking-wider text-emerald-700 block">Usaha Lainnya</span>
                                        <p class="text-[11px] text-slate-400 font-normal">Fasilitas & unit usaha Muhammadiyah selain Sekolah, Madrasah, dan Perguruan Tinggi</p>
                                    </div>

                                    <!-- Link Tunggal Mengarah ke Halaman usaha_detail.php -->
                                    <a href="<?= base_url('aum/usaha-lain') ?>" class="group/item flex items-center justify-between p-2.5 rounded-lg hover:bg-slate-50 transition border border-transparent hover:border-slate-100">
                                        <div>
                                            <p class="text-xs font-bold text-slate-800 group-hover/item:text-emerald-600">DIREKTORI USAHA LAINNYA</p>
                                            <p class="text-[11px] text-slate-400 font-normal">Masjid, LKSA/Panti Asuhan, Rumah Sakit/Klinik, & Pesantren</p>
                                        </div>
                                        <span class="text-xs font-semibold text-emerald-600 opacity-0 group-hover/item:opacity-100 transition">Lihat Detail &rarr;</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <a href="<?= base_url('berita') ?>" class="px-3.5 py-2.5 rounded-lg hover:text-emerald-600 hover:bg-emerald-50 transition">Berita</a>

                    <!-- MENU OPINI (DESKTOP) -->
                    <a href="<?= base_url('opini') ?>" class="px-3.5 py-2.5 rounded-lg hover:text-emerald-600 hover:bg-emerald-50 transition">Opini</a>

                    <!-- Dropdown Majelis & PDM -->
                    <div class="relative group">
                        <button type="button" class="flex items-center space-x-1.5 px-3.5 py-2.5 rounded-lg group-hover:text-emerald-600 group-hover:bg-emerald-50 transition focus:outline-none">
                            <span>Majelis & PDM</span>
                            <svg class="w-4 h-4 text-slate-400 group-hover:rotate-180 group-hover:text-emerald-600 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div class="invisible opacity-0 group-hover:visible group-hover:opacity-100 absolute left-0 top-full w-60 pt-1 z-50 transition-all duration-200 ease-in-out">
                            <div class="bg-white rounded-xl shadow-xl border border-slate-100 py-2 text-xs font-medium space-y-0.5">
                                <a href="<?= base_url('majelis') ?>" class="block px-4 py-2.5 text-slate-700 hover:bg-emerald-50 hover:text-emerald-600 transition">Majelis & Lembaga</a>
                                <a href="<?= base_url('ortom') ?>" class="block px-4 py-2.5 text-slate-700 hover:bg-emerald-50 hover:text-emerald-600 transition">Organisasi Otonom (Ortom)</a>
                                <hr class="my-1 border-slate-100">
                                <a href="<?= base_url('pdm/profil') ?>" class="block px-4 py-2.5 text-slate-700 hover:bg-emerald-50 hover:text-emerald-600 transition">Pengurus Daerah Muhammadiyah</a>
                            </div>
                        </div>
                    </div>

                    <a href="<?= base_url('dokumen-arsip') ?>" class="px-3.5 py-2.5 rounded-lg hover:text-emerald-600 hover:bg-emerald-50 transition">Dokumen Dan Arsip</a>
                </nav>

                <!-- Kanan: Form Search & Toggle Mobile -->
                <div class="flex items-center space-x-2 sm:space-x-3 w-full lg:w-auto justify-between lg:justify-end">
                    <span class="text-xs font-bold text-slate-800 lg:hidden">MENU UTAMA</span>
                    <div class="flex items-center space-x-2">
                        <form action="<?= base_url('berita') ?>" method="get" class="hidden sm:flex items-center relative">
                            <input type="text" name="q" placeholder="Cari..." class="w-36 md:w-48 pl-8 pr-3 py-1.5 bg-slate-100 border border-slate-200 rounded-lg text-xs text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition">
                            <svg class="w-4 h-4 text-slate-400 absolute left-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </form>

                        <a href="<?= base_url('login') ?>" class="inline-flex items-center gap-1.5 px-3 sm:px-4 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-lg transition shadow-sm">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                            </svg>
                            <span>Login</span>
                        </a>

                        <button type="button" @click="mobileOpen = !mobileOpen" :aria-expanded="mobileOpen" class="p-2 rounded-lg text-slate-600 hover:bg-slate-100 focus:outline-none lg:hidden border border-slate-200" aria-label="Toggle Navigation">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path x-show="!mobileOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                <path x-show="mobileOpen" x-cloak stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

            </div>
        </div>

        <!-- 4. DRAWER MENU MOBILE -->
        <div x-show="mobileOpen" x-cloak x-collapse class="lg:hidden bg-white border-t border-slate-200 px-4 pt-3 pb-6 space-y-2 text-base font-semibold shadow-inner">

            <!-- Input Cari versi Mobile -->
            <form action="<?= base_url('berita') ?>" method="get" class="sm:hidden flex items-center relative mb-3">
                <input type="text" name="q" placeholder="Cari berita & informasi..." class="w-full pl-8 pr-3 py-2 bg-slate-100 border border-slate-200 rounded-lg text-xs text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition">
                <svg class="w-4 h-4 text-slate-400 absolute left-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </form>

            <a href="<?= base_url('/') ?>" class="block px-3.5 py-2.5 rounded-lg text-emerald-600 bg-emerald-50">Beranda</a>

            <!-- Submenu Mobile: Profil -->
            <div>
                <button type="button" @click="openProfilMobile = !openProfilMobile" :aria-expanded="openProfilMobile" class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-lg hover:bg-slate-50 text-slate-700">
                    <span>Profil</span>
                    <svg class="w-4 h-4 transition-transform duration-200" :class="openProfilMobile ? 'rotate-180 text-emerald-600' : 'text-slate-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="openProfilMobile" x-cloak x-collapse class="pl-4 pr-2 py-1.5 space-y-1 bg-slate-50 rounded-lg my-1 text-sm font-medium text-slate-600">
                    <a href="<?= base_url('profil/tentang-kami') ?>" class="block py-2 px-3 rounded hover:text-emerald-600">Tentang Kami</a>
                    <a href="<?= base_url('profil/sejarah') ?>" class="block py-2 px-3 rounded hover:text-emerald-600">Sejarah</a>
                    <a href="<?= base_url('profil/visi-misi') ?>" class="block py-2 px-3 rounded hover:text-emerald-600">Visi, Misi & Tujuan</a>
                    <a href="<?= base_url('profil/struktur-organisasi') ?>" class="block py-2 px-3 rounded hover:text-emerald-600">Struktur Organisasi</a>
                    <a href="<?= base_url('profil/program-kerja') ?>" class="block py-2 px-3 rounded hover:text-emerald-600">Program Kerja</a>
                </div>
            </div>

            <!-- Submenu Mobile: AUM Accordion -->
            <div>
                <button type="button" @click="openAumMobile = !openAumMobile" :aria-expanded="openAumMobile" class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-lg hover:bg-slate-50 text-slate-700">
                    <span>Amal Usaha (AUM)</span>
                    <svg class="w-4 h-4 transition-transform duration-200" :class="openAumMobile ? 'rotate-180 text-emerald-600' : 'text-slate-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="openAumMobile" x-cloak x-collapse class="pl-4 pr-2 py-1.5 space-y-1 bg-slate-50 rounded-lg my-1 text-sm font-medium text-slate-600">
                    <p class="font-bold text-emerald-700 pt-1.5 px-2 uppercase text-xs">Sekolah & Madrasah</p>
                    <a href="<?= base_url('sekolah') ?>" class="block py-1.5 px-3 rounded hover:text-emerald-600">Daftar Sekolah & Madrasah</a>

                    <!-- Dynamic Loop Kampus versi Mobile -->
                    <p class="font-bold text-emerald-700 pt-2 px-2 uppercase text-xs">Perguruan Tinggi</p>
                    <?php if (!empty($list_kampus)) : ?>
                        <?php foreach ($list_kampus as $k) : ?>
                            <!-- KETERANGAN: Sanitasi esc() ditambahkan pada output nama kampus -->
                            <a href="<?= base_url('aum/kampus/detail/' . ($k['slug'] ?? $k['id'])) ?>" class="block py-1.5 px-3 rounded hover:text-emerald-600 truncate">
                                <?= esc($k['nama_kampus']) ?>
                            </a>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <a href="<?= base_url('aum/kampus') ?>" class="block py-1.5 px-3 rounded hover:text-emerald-600">Daftar Kampus</a>
                    <?php endif; ?>

                    <p class="font-bold text-emerald-700 pt-2 px-2 uppercase text-xs">Fasilitas Lain</p>
                    <a href="<?= base_url('aum/masjid') ?>" class="block py-1.5 px-3 rounded hover:text-emerald-600">Masjid Muhammadiyah</a>
                    <a href="<?= base_url('aum/panti') ?>" class="block py-1.5 px-3 rounded hover:text-emerald-600">LKSA / Panti Asuhan</a>
                </div>
            </div>

            <a href="<?= base_url('berita') ?>" class="block px-3.5 py-2.5 rounded-lg hover:bg-slate-50 text-slate-700">Berita</a>

            <!-- MENU OPINI (MOBILE) -->
            <a href="<?= base_url('opini') ?>" class="block px-3.5 py-2.5 rounded-lg hover:bg-slate-50 text-slate-700">Opini</a>

            <!-- Submenu Mobile: Majelis & PDM -->
            <div>
                <button type="button" @click="openMajelisMobile = !openMajelisMobile" :aria-expanded="openMajelisMobile" class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-lg hover:bg-slate-50 text-slate-700">
                    <span>Majelis & PDM</span>
                    <svg class="w-4 h-4 transition-transform duration-200" :class="openMajelisMobile ? 'rotate-180 text-emerald-600' : 'text-slate-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="openMajelisMobile" x-cloak x-collapse class="pl-4 pr-2 py-1.5 space-y-1 bg-slate-50 rounded-lg my-1 text-sm font-medium text-slate-600">
                    <a href="<?= base_url('majelis') ?>" class="block py-2 px-3 rounded hover:text-emerald-600">Majelis & Lembaga</a>
                    <a href="<?= base_url('ortom') ?>" class="block py-2 px-3 rounded hover:text-emerald-600">Organisasi Otonom (Ortom)</a>
                    <a href="<?= base_url('pdm/profil') ?>" class="block py-2 px-3 rounded hover:text-emerald-600">Profil PDM</a>
                    <a href="<?= base_url('pdm/pengurus') ?>" class="block py-2 px-3 rounded hover:text-emerald-600">Pengurus Daerah</a>
                    <a href="<?= base_url('pdm/website') ?>" class="block py-2 px-3 rounded hover:text-emerald-600">Direktori Website PDM</a>
                </div>
            </div>

            <a href="<?= base_url('dokumen-arsip') ?>" class="block px-3.5 py-2.5 rounded-lg hover:bg-slate-50 text-slate-700">Dokumen dan Arsip</a>

            <!-- Footer Drawer Mobile -->
            <div class="pt-4 mt-2 border-t border-slate-200 space-y-3">
                <a href="<?= base_url('kontak') ?>" class="w-full block text-center py-2.5 bg-emerald-600 text-white font-bold rounded-lg text-sm hover:bg-emerald-700 transition shadow-sm">Hubungi Kami</a>
            </div>

        </div>
    </header>

</div>