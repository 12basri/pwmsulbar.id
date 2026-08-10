<?= $this->extend('pages/layout/main') ?>

<?= $this->section('content') ?>

<div class="max-w-7xl mx-auto px-4 py-8 mb-16 space-y-10">

    <!-- ================= 1. HEADER HALAMAN ================= -->
    <div class="text-center max-w-3xl mx-auto space-y-4">
        <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
            Visi, Misi & Tujuan
        </h1>

        <!-- Akses Dekorasi Line -->
        <div class="flex items-center justify-center gap-2">
            <span class="w-8 h-[2px] bg-emerald-500 rounded-full"></span>
            <span class="w-2.5 h-2.5 border-2 border-emerald-500 rounded-full"></span>
            <span class="w-8 h-[2px] bg-emerald-500 rounded-full"></span>
        </div>

        <p class="text-slate-600 text-sm sm:text-base leading-relaxed">
            Arah pandang strategis, komitmen pelaksanaan, dan sasaran utama Pimpinan Wilayah Muhammadiyah Sulawesi Barat.
        </p>
    </div>

    <!-- ================= 2. CARD VISI UTAMA (HERO SECTION) ================= -->
    <div class="bg-gradient-to-br from-emerald-600 to-teal-800 rounded-3xl p-8 sm:p-12 text-white shadow-lg relative overflow-hidden">
        <!-- Pattern background dekoratif -->
        <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-white/5 rounded-full blur-2xl pointer-events-none"></div>

        <div class="max-w-4xl mx-auto text-center space-y-4 relative z-10">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-xs font-semibold uppercase tracking-wider">
                <svg class="w-4 h-4 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
                Visi Utama
            </div>

            <div class="text-xl sm:text-2xl lg:text-3xl font-extrabold leading-relaxed tracking-wide italic">
                <?php if (!empty($visi_misi['visi'])): ?>
                    <?php
                    // Hilangkan awalan "VISI:" jika ada di database
                    $clean_visi = trim(preg_replace('/^VISI:\s*/i', '', $visi_misi['visi']));
                    ?>
                    "<?= esc($clean_visi) ?>"
                <?php else: ?>
                    <span class="opacity-75 font-normal not-italic text-lg">Data visi belum diisi.</span>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- ================= 3. GRID MISI & TUJUAN ================= -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

        <!-- CARD MISI -->
        <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200/80 shadow-sm space-y-6 flex flex-col justify-between hover:shadow-md transition">
            <div class="space-y-6">
                <div class="flex items-center gap-4 border-b border-slate-100 pb-5">
                    <div class="p-3.5 bg-emerald-50 text-emerald-600 rounded-2xl shrink-0">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-slate-800">Misi Organisasi</h2>
                        <p class="text-xs text-slate-500">Langkah dan strategi pencapaian</p>
                    </div>
                </div>

                <div class="text-slate-600 text-sm sm:text-base leading-relaxed">
                    <?php if (!empty($visi_misi['misi'])): ?>
                        <?php
                        // Hilangkan kata "MISI:" jika ada di database
                        $clean_misi = trim(preg_replace('/^MISI:\s*/i', '', $visi_misi['misi']));

                        // Pemisahan per baris
                        $misi_items = preg_split('/\r\n|\r|\n/', $clean_misi);
                        ?>
                        <ul class="space-y-3">
                            <?php foreach ($misi_items as $item): ?>
                                <?php if (!empty(trim($item))): ?>
                                    <li class="flex items-start gap-3">
                                        <span class="flex-shrink-0 w-2 h-2 mt-2 rounded-full bg-emerald-500"></span>
                                        <span><?= esc(preg_replace('/^\d+\.\s*/', '', trim($item))) ?></span>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p class="text-slate-400 italic">Data misi belum diisi.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- CARD TUJUAN -->
        <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200/80 shadow-sm space-y-6 flex flex-col justify-between hover:shadow-md transition">
            <div class="space-y-6">
                <div class="flex items-center gap-4 border-b border-slate-100 pb-5">
                    <div class="p-3.5 bg-blue-50 text-blue-600 rounded-2xl shrink-0">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-slate-800">Tujuan Strategis</h2>
                        <p class="text-xs text-slate-500">Target jangka panjang pelayanan</p>
                    </div>
                </div>

                <div class="text-slate-600 text-sm sm:text-base leading-relaxed">
                    <?php if (!empty($visi_misi['tujuan'])): ?>
                        <p><?= nl2br(esc($visi_misi['tujuan'])) ?></p>
                    <?php else: ?>
                        <p class="text-slate-400 italic">Data tujuan belum diisi.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </div>

</div>

<?= $this->endSection() ?>