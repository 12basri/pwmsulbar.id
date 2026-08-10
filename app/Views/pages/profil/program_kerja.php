<?= $this->extend('pages/layout/main') ?>

<?= $this->section('content') ?>

<div class="max-w-7xl mx-auto px-4 py-8 mb-16 space-y-10">

    <!-- ================= 1. HEADER HALAMAN ================= -->
    <div class="text-center max-w-3xl mx-auto space-y-4">
        <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
            Program Kerja
        </h1>

        <!-- Aksen Garis Dekorasi -->
        <div class="flex items-center justify-center gap-2">
            <span class="w-8 h-[2px] bg-emerald-500 rounded-full"></span>
            <span class="w-2.5 h-2.5 border-2 border-emerald-500 rounded-full"></span>
            <span class="w-8 h-[2px] bg-emerald-500 rounded-full"></span>
        </div>

        <p class="text-slate-600 text-sm sm:text-base leading-relaxed">
            Rencana aksi dan agenda strategis Pengurus Wilayah Muhammadiyah Sulawesi Barat
        </p>
    </div>

    <!-- ================= 2. DAFTAR PROGRAM KERJA ================= -->
    <?php if (!empty($program_kerja) && is_array($program_kerja)): ?>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <?php foreach ($program_kerja as $proker): ?>

                <!-- Card Item Program Kerja -->
                <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm hover:shadow-md transition space-y-4 flex flex-col justify-between">
                    <div class="space-y-3">

                        <!-- Header Card: Kategori & Status Badge -->
                        <div class="flex items-center justify-between gap-2">
                            <!-- Kategori -->
                            <span class="px-3 py-1 bg-emerald-50 text-emerald-700 text-xs font-semibold rounded-full border border-emerald-100 uppercase tracking-wider">
                                <?= esc($proker['kategori'] ?? 'Umum') ?>
                            </span>

                            <!-- Status Badge Dinamis -->
                            <?php
                            $status = $proker['status'] ?? 'Aktif';
                            $bgStatus = 'bg-slate-100 text-slate-600';
                            $dotStatus = 'bg-slate-400';

                            if ($status === 'Aktif') {
                                $bgStatus = 'bg-emerald-100 text-emerald-800';
                                $dotStatus = 'bg-emerald-500';
                            } elseif ($status === 'Perencanaan') {
                                $bgStatus = 'bg-amber-100 text-amber-800';
                                $dotStatus = 'bg-amber-500';
                            } elseif ($status === 'Selesai') {
                                $bgStatus = 'bg-blue-100 text-blue-800';
                                $dotStatus = 'bg-blue-500';
                            }
                            ?>
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium <?= $bgStatus ?>">
                                <span class="w-1.5 h-1.5 rounded-full <?= $dotStatus ?>"></span>
                                <?= esc($status) ?>
                            </span>
                        </div>

                        <!-- Judul Program Kerja -->
                        <h3 class="text-xl font-bold text-slate-800 leading-snug">
                            <?= esc($proker['nama_program']) ?>
                        </h3>

                        <!-- Deskripsi -->
                        <div class="prose prose-slate text-sm text-slate-600 leading-relaxed">
                            <?= nl2br(esc($proker['deskripsi'])) ?>
                        </div>
                    </div>

                    <!-- Footer Card: Tahun Pelaksanaan -->
                    <?php if (!empty($proker['tahun'])): ?>
                        <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Tahun Pelaksanaan: <strong class="text-slate-700"><?= esc($proker['tahun']) ?></strong>
                            </span>
                        </div>
                    <?php endif; ?>
                </div>

            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="p-12 bg-white rounded-3xl border border-slate-200/80 text-center space-y-3">
            <div class="p-4 bg-slate-100 text-slate-400 rounded-full w-16 h-16 mx-auto flex items-center justify-center">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
            </div>
            <h3 class="text-base font-bold text-slate-700">Program Kerja Belum Tersedia</h3>
            <p class="text-xs text-slate-500">Belum ada data program kerja yang diunggah ke dalam sistem.</p>
        </div>
    <?php endif; ?>

</div>

<?= $this->endSection() ?>