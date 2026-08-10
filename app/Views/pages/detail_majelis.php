<?= $this->extend('pages/layout/main') ?>

<?= $this->section('content') ?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <!-- Breadcrumb -->
    <nav class="flex mb-6" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-2 text-sm text-slate-500">
            <li class="inline-flex items-center">
                <a href="<?= base_url() ?>" class="inline-flex items-center hover:text-emerald-600 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Beranda
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-4 h-4 text-slate-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <a href="<?= base_url('majelis') ?>" class="ml-1 md:ml-2 hover:text-emerald-600 transition-colors">Majelis & Lembaga</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-4 h-4 text-slate-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="ml-1 md:ml-2 font-medium text-slate-800 line-clamp-1"><?= esc($majelis['nama_majelis'] ?? 'Detail Majelis') ?></span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Content Layout Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

        <!-- Main Content (Left Column) -->
        <div class="lg:col-span-8 space-y-8">

            <!-- 1. Header & Deskripsi Utama -->
            <div class="bg-white rounded-2xl border border-slate-200/80 p-6 md:p-8 shadow-sm">
                <div class="mb-6 pb-6 border-b border-slate-100">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/60 mb-3">
                        <?= esc($majelis['jenis'] ?? 'Majelis/Lembaga') ?>
                    </span>
                    <h1 class="text-2xl md:text-3xl font-extrabold text-slate-900 tracking-tight leading-snug">
                        <?= esc($majelis['nama_majelis'] ?? 'Tanpa Nama') ?>
                    </h1>
                </div>

                <div class="prose prose-slate max-w-none text-slate-700 leading-relaxed">
                    <?php
                    $deskripsi = $majelis['deskripsi'] ?? $majelis['deskripsi_singkat'] ?? null;
                    echo $deskripsi ? esc($deskripsi) : '<p class="italic text-slate-400">Belum ada deskripsi untuk majelis/lembaga ini.</p>';
                    ?>
                </div>
            </div>

            <!-- 2. Pimpinan Majelis -->
            <div class="bg-white rounded-2xl border border-slate-200/80 p-6 md:p-8 shadow-sm overflow-hidden">
                <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-100">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-emerald-50 rounded-xl text-emerald-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-slate-900">Pimpinan Majelis</h2>
                            <p class="text-xs text-slate-500">Susunan pimpinan utama majelis/lembaga</p>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-slate-600">
                        <thead class="text-xs text-slate-700 uppercase bg-slate-50 border-b border-slate-200">
                            <tr>
                                <th scope="col" class="px-4 py-3.5 rounded-l-lg w-12 text-center">No</th>
                                <th scope="col" class="px-4 py-3.5">Jabatan</th>
                                <th scope="col" class="px-4 py-3.5 rounded-r-lg">Nama Lengkap</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <?php if (!empty($pimpinan) && is_array($pimpinan)): ?>
                                <?php $no = 1;
                                foreach ($pimpinan as $p): ?>
                                    <tr class="hover:bg-slate-50/80 transition-colors">
                                        <td class="px-4 py-3.5 text-center font-medium text-slate-400"><?= $no++ ?></td>
                                        <td class="px-4 py-3.5 font-semibold text-emerald-700"><?= esc($p['jabatan'] ?? '-') ?></td>
                                        <td class="px-4 py-3.5 font-medium text-slate-900"><?= esc($p['nama'] ?? '-') ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="3" class="px-4 py-8 text-center text-slate-400 italic bg-slate-50/50 rounded-lg">
                                        Data pimpinan belum tersedia.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- 3. Bidang & Anggota -->
            <div class="bg-white rounded-2xl border border-slate-200/80 p-6 md:p-8 shadow-sm">
                <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-100">
                    <div class="p-2 bg-emerald-50 rounded-xl text-emerald-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-slate-900">Bidang & Anggota</h2>
                        <p class="text-xs text-slate-500">Pembagian bidang kerja beserta anggotanya</p>
                    </div>
                </div>

                <?php if (!empty($bidang) && is_array($bidang)): ?>
                    <div class="space-y-4">
                        <?php foreach ($bidang as $b): ?>
                            <div class="border border-slate-200 rounded-xl p-4 bg-slate-50/50">
                                <h3 class="font-bold text-slate-800 text-base mb-1"><?= esc($b['nama_bidang'] ?? '-') ?></h3>
                                <?php if (!empty($b['ketua_bidang'])): ?>
                                    <p class="text-xs font-semibold text-emerald-600 mb-3">Ketua: <?= esc($b['ketua_bidang']) ?></p>
                                <?php endif; ?>

                                <div class="mt-2 pl-2 border-l-2 border-emerald-500 space-y-1">
                                    <span class="text-xs font-semibold text-slate-500 block mb-1">Anggota:</span>
                                    <?php if (!empty($b['anggota']) && is_array($b['anggota'])): ?>
                                        <ul class="grid grid-cols-1 md:grid-cols-2 gap-2 text-sm text-slate-700">
                                            <?php foreach ($b['anggota'] as $a): ?>
                                                <li class="flex items-center gap-2">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                    <?= esc(is_array($a) ? ($a['nama'] ?? '-') : $a) ?>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php else: ?>
                                        <p class="text-xs text-slate-400 italic">Belum ada anggota di bidang ini.</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="text-center text-slate-400 italic py-4">Data bidang belum tersedia.</p>
                <?php endif; ?>
            </div>

            <!-- 4. Tabel Program Kerja -->
            <div class="bg-white rounded-2xl border border-slate-200/80 p-6 md:p-8 shadow-sm overflow-hidden">
                <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-100">
                    <div class="p-2 bg-emerald-50 rounded-xl text-emerald-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-slate-900">Program Kerja Utama</h2>
                        <p class="text-xs text-slate-500">Agenda dan program prioritas majelis/lembaga</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-slate-600">
                        <thead class="text-xs text-slate-700 uppercase bg-slate-50 border-b border-slate-200">
                            <tr>
                                <th scope="col" class="px-4 py-3.5 rounded-l-lg w-12 text-center">No</th>
                                <th scope="col" class="px-4 py-3.5">Nama Program</th>
                                <th scope="col" class="px-4 py-3.5 text-center rounded-r-lg">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <?php if (!empty($program_kerja) && is_array($program_kerja)): ?>
                                <?php $no = 1;
                                foreach ($program_kerja as $prog): ?>
                                    <tr class="hover:bg-slate-50/80 transition-colors">
                                        <td class="px-4 py-3.5 text-center font-medium text-slate-400"><?= $no++ ?></td>
                                        <td class="px-4 py-3.5 font-medium text-slate-900">
                                            <div><?= esc($prog['nama_program'] ?? '-') ?></div>
                                            <?php if (!empty($prog['deskripsi'])): ?>
                                                <div class="text-xs text-slate-400 font-normal mt-0.5"><?= esc($prog['deskripsi']) ?></div>
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-4 py-3.5 text-center">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                                                <?= esc($prog['status'] ?? 'Terencana') ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="3" class="px-4 py-8 text-center text-slate-400 italic bg-slate-50/50 rounded-lg">
                                        Data program kerja belum ditambahkan.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <!-- Sidebar Information Card (Right Column) -->
        <div class="lg:col-span-4 space-y-6">

            <!-- Dewan Pakar / Penasihat Card -->
            <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-sm">
                <h2 class="text-lg font-bold text-slate-900 mb-4 pb-3 border-b border-slate-100 flex items-center gap-2">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0112 20.055a11.952 11.952 0 01-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                    </svg>
                    Dewan Pakar / Penasihat
                </h2>
                <?php if (!empty($pakar) && is_array($pakar)): ?>
                    <ul class="space-y-2 text-sm text-slate-700">
                        <?php foreach ($pakar as $pk): ?>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span><?= esc(is_array($pk) ? ($pk['nama'] ?? '-') : $pk) ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p class="text-xs text-slate-400 italic">Belum ada dewan pakar.</p>
                <?php endif; ?>
            </div>

            <!-- Informasi Organisasi Card -->
            <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-sm sticky top-6">
                <h2 class="text-lg font-bold text-slate-900 mb-4 pb-3 border-b border-slate-100 flex items-center gap-2">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Informasi Organisasi
                </h2>

                <ul class="space-y-4 text-sm">
                    <li class="flex flex-col gap-1 pb-3 border-b border-slate-100">
                        <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Nomor SK</span>
                        <span class="font-medium text-slate-800"><?= esc($majelis['nomor_sk'] ?? '-') ?></span>
                    </li>
                    <li class="flex flex-col gap-1 pb-3 border-b border-slate-100">
                        <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Ditetapkan Oleh</span>
                        <span class="font-medium text-slate-800"><?= esc($majelis['ditetapkan_oleh'] ?? '-') ?></span>
                    </li>
                    <li class="flex flex-col gap-1 pb-3 border-b border-slate-100">
                        <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Masa Jabatan</span>
                        <span class="font-medium text-slate-800"><?= esc($majelis['periode'] ?? '-') ?></span>
                    </li>
                    <li class="flex flex-col gap-1 pb-3 border-b border-slate-100">
                        <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Status</span>
                        <div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                                <?= esc($majelis['status'] ?? 'Aktif') ?>
                            </span>
                        </div>
                    </li>
                </ul>

                <div class="mt-6 pt-4 border-t border-slate-100">
                    <a href="<?= base_url('majelis') ?>" class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs rounded-xl transition duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        <span>Kembali ke Daftar Majelis</span>
                    </a>
                </div>
            </div>

        </div>

    </div>
</div>
<?= $this->endSection() ?>