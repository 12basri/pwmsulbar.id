<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<!-- Welcome Banner -->
<div class="bg-pwm-emerald rounded-2xl p-6 text-white shadow-lg relative overflow-hidden mb-8">
    <div class="relative z-10">
        <h2 class="text-2xl font-bold flex items-center space-x-2">
            <span>Selamat Datang di Portal Admin!</span>
            <span>👋</span>
        </h2>
        <p class="text-emerald-100 text-sm mt-1">
            Sistem Informasi Pengelolaan Data Pimpinan Wilayah Muhammadiyah Sulawesi Barat.
        </p>
    </div>
    <!-- Ambient circle background accent -->
    <div class="absolute -right-12 -bottom-12 w-48 h-48 bg-white/10 rounded-full blur-xl pointer-events-none"></div>
</div>

<!-- Stat Cards (4 Columns) -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

    <!-- Card 1: Total Berita -->
    <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm flex items-center justify-between">
        <div>
            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">TOTAL BERITA</p>
            <h3 class="text-3xl font-extrabold text-slate-800 mt-1"><?= $total_berita ?? 0 ?></h3>
        </div>
        <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
            </svg>
        </div>
    </div>

    <!-- Card 2: Amal Usaha (AUM) -->
    <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm flex items-center justify-between">
        <div>
            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">AMAL USAHA (AUM)</p>
            <h3 class="text-3xl font-extrabold text-slate-800 mt-1"><?= $total_aum ?? 0 ?></h3>
        </div>
        <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
            </svg>
        </div>
    </div>

    <!-- Card 3: Sekolah & Madrasah -->
    <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm flex items-center justify-between">
        <div>
            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">SEKOLAH & MADRASAH</p>
            <h3 class="text-3xl font-extrabold text-slate-800 mt-1"><?= $total_sekolah ?? 0 ?></h3>
        </div>
        <div class="w-12 h-12 bg-amber-50 text-amber-500 rounded-xl flex items-center justify-center">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0112 20.055a11.952 11.952 0 01-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
            </svg>
        </div>
    </div>

    <!-- Card 4: Dokumen & Arsip -->
    <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm flex items-center justify-between">
        <div>
            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">DOKUMEN & ARSIP</p>
            <h3 class="text-3xl font-extrabold text-slate-800 mt-1"><?= $total_dokumen ?? 0 ?></h3>
        </div>
        <div class="w-12 h-12 bg-cyan-50 text-cyan-600 rounded-xl flex items-center justify-center">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
            </svg>
        </div>
    </div>

</div>

<!-- Quick Action Buttons Section -->
<div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm">
    <h3 class="font-bold text-slate-800 text-sm mb-5">Aksi Cepat Pengelolaan</h3>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

        <!-- Button 1 -->
        <a href="#" class="flex items-center justify-center p-4 border border-dashed border-slate-300 rounded-xl hover:border-emerald-500 hover:bg-emerald-50/50 text-slate-700 hover:text-emerald-700 transition font-medium text-xs">
            <span>+ Tambah Berita Baru</span>
        </a>

        <!-- Button 2 -->
        <a href="#" class="flex items-center justify-center p-4 border border-dashed border-slate-300 rounded-xl hover:border-emerald-500 hover:bg-emerald-50/50 text-slate-700 hover:text-emerald-700 transition font-medium text-xs">
            <span>+ Upload Dokumen</span>
        </a>

        <!-- Button 3 -->
        <a href="#" class="flex items-center justify-center p-4 border border-dashed border-slate-300 rounded-xl hover:border-emerald-500 hover:bg-emerald-50/50 text-slate-700 hover:text-emerald-700 transition font-medium text-xs">
            <span>+ Tambah Sekolah</span>
        </a>

        <!-- Button 4 -->
        <a href="#" class="flex items-center justify-center p-4 border border-dashed border-slate-300 rounded-xl hover:border-emerald-500 hover:bg-emerald-50/50 text-slate-700 hover:text-emerald-700 transition font-medium text-xs">
            <span>+ Program Kerja</span>
        </a>

    </div>
</div>

<?= $this->endSection() ?>