<?= $this->extend('pages/layout/main') ?>

<?= $this->section('content') ?>

<!-- HERO / HEADER KAMPUS -->
<section class="bg-emerald-900 text-white py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Breadcrumbs -->
        <nav class="text-xs text-emerald-200 mb-6 flex items-center space-x-2">
            <a href="<?= base_url() ?>" class="hover:underline">Beranda</a>
            <span>&rsaquo;</span>
            <a href="<?= base_url('aum/kampus') ?>" class="hover:underline">Perguruan Tinggi</a>
            <span>&rsaquo;</span>
            <span class="text-emerald-100 font-medium"><?= $kampus['nama_kampus'] ?></span>
        </nav>

        <div class="flex flex-col md:flex-row items-start md:items-center gap-6">
            <!-- LOGO KAMPUS DI HERO -->
            <div class="w-24 h-24 sm:w-28 sm:h-28 bg-white/10 rounded-2xl p-3 backdrop-blur-sm border border-white/20 flex items-center justify-center shrink-0 shadow-lg">
                <?php
                $logoHero = !empty($kampus['logo']) && is_file(FCPATH . 'uploads/kampus/' . $kampus['logo'])
                    ? base_url('uploads/kampus/' . $kampus['logo'])
                    : (!empty($kampus['logo']) && is_file(FCPATH . 'public/uploads/kampus/' . $kampus['logo']) ? base_url('public/uploads/kampus/' . $kampus['logo']) : null);
                ?>

                <?php if ($logoHero) : ?>
                    <img src="<?= $logoHero ?>" alt="Logo <?= $kampus['nama_kampus'] ?>" class="w-full h-full object-contain">
                <?php else : ?>
                    <span class="text-2xl font-extrabold text-amber-400 uppercase tracking-wider">
                        <?= $kampus['singkatan'] ?? 'PTMA' ?>
                    </span>
                <?php endif; ?>
            </div>

            <!-- DETAIL KAMPUS DI HERO -->
            <div>
                <!-- Kategori / Jenis & Lokasi -->
                <p class="text-[11px] font-bold tracking-widest uppercase text-emerald-300">
                    <?= strtoupper($kampus['bentuk'] ?? 'UNIVERSITAS') ?> &bull; <?= strtoupper($kampus['kabupaten_kota'] ?? 'SULAWESI BARAT') ?>
                </p>

                <!-- Nama Kampus Utama -->
                <h1 class="text-2xl sm:text-4xl font-extrabold text-white mt-1">
                    <?= $kampus['nama_kampus'] ?>
                </h1>

                <!-- Singkatan / Tagline -->
                <?php if (!empty($kampus['singkatan'])) : ?>
                    <p class="text-sm text-emerald-100 mt-1">
                        Dikenal sebagai <span class="font-bold text-amber-300"><?= $kampus['singkatan'] ?></span>
                    </p>
                <?php endif; ?>

                <!-- Badges / Tags -->
                <div class="mt-4 flex flex-wrap gap-2 text-xs font-medium">
                    <span class="bg-emerald-800/80 text-emerald-100 px-3 py-1 rounded-full border border-emerald-700/50">
                        <?= $kampus['bentuk'] ?? 'Universitas' ?>
                    </span>
                    <?php if (!empty($kampus['akreditasi'])) : ?>
                        <span class="bg-amber-400 text-emerald-950 font-bold px-3 py-1 rounded-full">
                            Akreditasi: <?= $kampus['akreditasi'] ?>
                        </span>
                    <?php endif; ?>
                    <?php if (!empty($kampus['kabupaten_kota'])) : ?>
                        <span class="bg-emerald-800/80 text-emerald-100 px-3 py-1 rounded-full border border-emerald-700/50">
                            <?= $kampus['kabupaten_kota'] ?>
                        </span>
                    <?php endif; ?>
                    <?php if (!empty($kampus['website'])) : ?>
                        <a href="<?= (strpos($kampus['website'], 'http') === 0) ? $kampus['website'] : 'https://' . $kampus['website'] ?>" target="_blank" class="bg-emerald-700 hover:bg-emerald-600 text-white font-bold px-3 py-1 rounded-full transition inline-flex items-center gap-1 border border-emerald-600">
                            <?= str_replace(['http://', 'https://'], '', $kampus['website']) ?> &nearr;
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- MAIN CONTENT -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">

        <!-- KONTEN KIRI (DETAIL KAMPUS) -->
        <div class="lg:col-span-8 space-y-10">

            <!-- INFORMASI PERGURUAN TINGGI -->
            <div>
                <h2 class="text-xl font-extrabold text-slate-800 pb-2 border-b-2 border-emerald-600 mb-6">
                    Informasi Perguruan Tinggi
                </h2>
                <div class="space-y-5 text-sm">
                    <div>
                        <p class="text-[11px] font-bold tracking-wider text-slate-400 uppercase">NAMA LENGKAP</p>
                        <p class="font-semibold text-slate-800 text-base mt-0.5"><?= $kampus['nama_kampus'] ?></p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <p class="text-[11px] font-bold tracking-wider text-slate-400 uppercase">SINGKATAN</p>
                            <p class="font-semibold text-slate-800 mt-0.5"><?= $kampus['singkatan'] ?? '-' ?></p>
                        </div>
                        <div>
                            <p class="text-[11px] font-bold tracking-wider text-slate-400 uppercase">BENTUK / JENIS</p>
                            <p class="font-semibold text-slate-800 mt-0.5"><?= $kampus['bentuk'] ?? '-' ?></p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <p class="text-[11px] font-bold tracking-wider text-slate-400 uppercase">KOTA / KABUPATEN</p>
                            <p class="font-semibold text-slate-800 mt-0.5"><?= $kampus['kabupaten_kota'] ?? '-' ?></p>
                        </div>
                        <div>
                            <p class="text-[11px] font-bold tracking-wider text-slate-400 uppercase">KECAMATAN</p>
                            <p class="font-semibold text-slate-800 mt-0.5"><?= $kampus['kecamatan'] ?? '-' ?></p>
                        </div>
                    </div>

                    <div>
                        <p class="text-[11px] font-bold tracking-wider text-slate-400 uppercase">REKTOR / KETUA</p>
                        <p class="font-semibold text-slate-800 mt-0.5"><?= !empty($kampus['rektor_ketua']) ? $kampus['rektor_ketua'] : '-' ?></p>
                    </div>

                    <div>
                        <p class="text-[11px] font-bold tracking-wider text-slate-400 uppercase">ALAMAT LENGKAP</p>
                        <p class="font-semibold text-slate-800 mt-0.5"><?= $kampus['alamat'] ?? '-' ?></p>
                    </div>

                    <div>
                        <p class="text-[11px] font-bold tracking-wider text-slate-400 uppercase">NAUNGAN</p>
                        <p class="font-semibold text-slate-800 mt-0.5">Pimpinan Pusat Muhammadiyah</p>
                        <p class="text-xs text-slate-500">Majelis Diktilitbang</p>
                    </div>
                </div>
            </div>

            <!-- TENTANG KAMPUS -->
            <div>
                <h2 class="text-xl font-extrabold text-slate-800 pb-2 border-b-2 border-emerald-600 mb-4">
                    Tentang
                </h2>
                <div class="text-sm text-slate-600 leading-relaxed space-y-3">
                    <?php if (!empty($kampus['deskripsi'])) : ?>
                        <?= nl2br($kampus['deskripsi']) ?>
                    <?php else : ?>
                        <p>Salah satu Perguruan Tinggi Muhammadiyah dan 'Aisyiyah (PTMA) yang berada di wilayah Sulawesi Barat, dikelola di bawah naungan Majelis Pendidikan Tinggi, Penelitian, dan Pengembangan (Diktilitbang) Pimpinan Pusat Muhammadiyah.</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- SUMBER RESMI -->
            <div>
                <h2 class="text-xl font-extrabold text-slate-800 pb-2 border-b-2 border-emerald-600 mb-4">
                    Sumber Resmi
                </h2>
                <div class="space-y-3">
                    <?php if (!empty($kampus['website'])) : ?>
                        <a href="<?= (strpos($kampus['website'], 'http') === 0) ? $kampus['website'] : 'https://' . $kampus['website'] ?>" target="_blank" class="block border border-slate-200 rounded-lg p-4 bg-white hover:border-emerald-500 hover:shadow-sm transition flex justify-between items-center group">
                            <div>
                                <p class="text-[10px] font-bold tracking-wider text-slate-400 uppercase">WEBSITE RESMI</p>
                                <p class="font-bold text-emerald-800 group-hover:underline text-sm"><?= str_replace(['http://', 'https://'], '', $kampus['website']) ?></p>
                                <p class="text-xs text-slate-500 mt-0.5">Pendaftaran, prodi, akreditasi, kontak</p>
                            </div>
                            <span class="text-slate-400 group-hover:text-emerald-600 font-bold">&nearr;</span>
                        </a>
                    <?php endif; ?>

                    <?php if (!empty($kampus['link_pddikti'])) : ?>
                        <a href="<?= (strpos($kampus['link_pddikti'], 'http') === 0) ? $kampus['link_pddikti'] : 'https://' . $kampus['link_pddikti'] ?>" target="_blank" class="block border border-slate-200 rounded-lg p-4 bg-white hover:border-emerald-500 hover:shadow-sm transition flex justify-between items-center group">
                            <div>
                                <p class="text-[10px] font-bold tracking-wider text-slate-400 uppercase">VERIFIKASI PEMERINTAH</p>
                                <p class="font-bold text-slate-800 group-hover:text-emerald-800 text-sm">PDDIKTI Kemendiktisaintek</p>
                                <p class="text-xs text-slate-500 mt-0.5">Status akreditasi, jumlah mahasiswa, profil resmi</p>
                            </div>
                            <span class="text-slate-400 group-hover:text-emerald-600 font-bold">&nearr;</span>
                        </a>
                    <?php endif; ?>
                </div>
            </div>

        </div>

        <!-- SIDEBAR KANAN -->
        <div class="lg:col-span-4 space-y-4">
            <!-- Informational Card Box -->
            <div class="bg-emerald-50/80 border border-emerald-200 rounded-lg p-5">
                <h3 class="font-bold text-emerald-900 text-sm mb-2">
                    Perguruan Tinggi Muhammadiyah/'Aisyiyah
                </h3>
                <p class="text-xs text-slate-600 leading-relaxed">
                    <span class="font-semibold text-slate-800"><?= $kampus['nama_kampus'] ?></span> adalah salah satu Perguruan Tinggi Muhammadiyah dan 'Aisyiyah (PTMA) di Sulawesi Barat, dikelola di bawah Majelis Pendidikan Tinggi, Penelitian, dan Pengembangan (Diktilitbang) PP Muhammadiyah.
                </p>
            </div>

            <!-- Tombol Kembali -->
            <a href="<?= base_url('aum/kampus') ?>" class="block w-full text-center bg-emerald-900 hover:bg-emerald-800 text-white font-bold py-3 px-4 rounded-md transition text-xs sm:text-sm shadow-sm">
                &larr; Semua perguruan tinggi
            </a>
        </div>

    </div>

    <!-- SECTION PTMA LAINNYA DI SULBAR -->
    <div class="mt-16 pt-10 border-t border-slate-200">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-extrabold text-slate-800 pb-1 border-b-2 border-emerald-600">
                PTMA LAINNYA DI SULAWESI BARAT
            </h2>
            <a href="<?= base_url('aum/kampus') ?>" class="text-xs font-semibold text-emerald-800 hover:underline">
                Lihat semua &rarr;
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php if (!empty($ptma_lainnya)) : ?>
                <?php foreach ($ptma_lainnya as $item) : ?>
                    <div class="bg-white border border-slate-200 rounded-lg p-5 hover:border-emerald-500 hover:shadow-md transition flex flex-col justify-between">
                        <div>
                            <!-- Header Card dengan Logo PTMA Lainnya -->
                            <div class="flex items-start gap-3 mb-3">
                                <div class="w-12 h-12 bg-slate-50 border border-slate-200 rounded-lg flex items-center justify-center p-1 shrink-0 overflow-hidden">
                                    <?php
                                    // Pengecekan lokasi berkas logo PTMA Lainnya
                                    $pathDirect = FCPATH . 'uploads/kampus/' . ($item['logo'] ?? '');
                                    $pathPublic = FCPATH . 'public/uploads/kampus/' . ($item['logo'] ?? '');

                                    $logoItemUrl = null;
                                    if (!empty($item['logo'])) {
                                        if (is_file($pathDirect)) {
                                            $logoItemUrl = base_url('uploads/kampus/' . $item['logo']);
                                        } elseif (is_file($pathPublic)) {
                                            $logoItemUrl = base_url('public/uploads/kampus/' . $item['logo']);
                                        }
                                    }
                                    ?>

                                    <?php if ($logoItemUrl) : ?>
                                        <img src="<?= $logoItemUrl ?>" alt="Logo <?= esc($item['nama_kampus']) ?>" class="w-full h-full object-contain">
                                    <?php else : ?>
                                        <span class="text-[10px] font-extrabold text-emerald-800 uppercase text-center">
                                            <?= esc($item['singkatan'] ?? 'PTMA') ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold tracking-wider text-slate-400 uppercase">
                                        <?= strtoupper($item['bentuk'] ?? 'UNIVERSITAS') ?>
                                    </p>
                                    <h3 class="font-bold text-slate-800 text-sm leading-tight">
                                        <?= esc($item['nama_kampus']) ?>
                                    </h3>
                                    <p class="text-xs text-slate-500 mt-1">
                                        <?= esc($item['kabupaten_kota'] ?? '-') ?>
                                    </p>
                                </div>
                            </div>

                            <!-- Rektor / Pimpinan -->
                            <div class="text-xs text-slate-600 border-t border-slate-100 pt-3 mt-3">
                                <span class="font-semibold text-slate-700">Rektor/Ketua:</span>
                                <?= esc($item['rektor_ketua'] ?? '-') ?>
                            </div>
                        </div>

                        <!-- Footer Card -->
                        <div class="flex justify-between items-center text-xs mt-4 pt-3 border-t border-slate-100">
                            <span class="text-slate-400 truncate max-w-[150px]">
                                <?= !empty($item['website']) ? esc(str_replace(['http://', 'https://'], '', $item['website'])) : '' ?>
                            </span>
                            <a href="<?= base_url('aum/kampus/detail/' . ($item['slug'] ?? $item['id'])) ?>" class="font-bold text-slate-700 hover:text-emerald-700 flex items-center gap-1">
                                Lihat &rarr;
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p class="text-xs text-slate-400 italic col-span-full">Belum ada data PTMA lainnya.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<?= $this->endSection(); ?>