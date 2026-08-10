<?= $this->extend('pages/layout/main') ?>

<?= $this->section('content') ?>

<?php
// ==========================================
// 1. DATA MASTER & HITUNG DARI DATABASE
// ==========================================

// Daftar jenjang standar agar urutan tampilan konsisten
$listJenjangMaster = ['MA', 'MI', 'MTS', 'SD', 'SLB', 'SMA', 'SMK', 'SMP'];

// Parsing data jenjang dari database ($statJenjang dikirim dari Controller)
$countJenjang = [];
if (!empty($statJenjang) && is_array($statJenjang)) {
    foreach ($statJenjang as $jKey => $jVal) {
        $countJenjang[strtoupper(trim($jKey))] = (int)$jVal;
    }
}

// Parsing data kabupaten terbanyak dari database ($statKabupaten)
$dataKabupatenDisplay = [];
if (!empty($statKabupaten)) {
    foreach ($statKabupaten as $kab) {
        $item = (array)$kab;
        $nama = strtoupper(trim($item['kabupaten_kota'] ?? $item['kabupaten'] ?? ''));
        $tot  = (int)($item['total'] ?? $item['jumlah'] ?? 0);
        if (!empty($nama)) {
            $dataKabupatenDisplay[] = ['nama' => $nama, 'total' => $tot];
        }
    }
}
?>

<!-- Header Banner Hijau Tua -->
<div class="bg-[#0b3c26] text-white py-10 px-4 mb-8">
    <div class="max-w-7xl mx-auto">
        <!-- Breadcrumb -->
        <nav class="mb-4">
            <ol class="flex items-center space-x-2 text-xs text-emerald-100 opacity-80">
                <li>
                    <a href="<?= base_url(); ?>" class="hover:text-amber-400 transition-colors">Beranda</a>
                </li>
                <li><span class="mx-1 text-emerald-300">/</span></li>
                <li class="text-amber-400 font-medium" aria-current="page">Sekolah & Madrasah</li>
            </ol>
        </nav>

        <span class="text-amber-400 text-xs font-bold uppercase tracking-wider block mb-1">AMAL USAHA MUHAMMADIYAH</span>
        <h1 class="text-3xl md:text-4xl font-serif font-bold mb-3 leading-tight">Direktori Sekolah & Madrasah</h1>
        <p class="text-emerald-100/80 text-sm md:text-base max-w-3xl mb-8 leading-relaxed">
            <?= $totalSekolah ?? 0; ?> sekolah dan madrasah Muhammadiyah yang tersebar di <?= $totalKabupaten ?? 0; ?> kabupaten/kota, dikelola oleh Majelis Pendidikan Dasar Menengah & Pendidikan Nonformal (Dikdasmen PNF) PWM Sulbar.
        </p>

        <!-- Card Statistik Header -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="p-4 rounded-xl bg-white/10 backdrop-blur-sm border border-white/10">
                <span class="text-[11px] font-bold text-amber-400 uppercase block tracking-wider">TOTAL</span>
                <h2 class="text-2xl md:text-3xl font-bold text-white my-0.5"><?= $totalSekolah ?? 0; ?></h2>
                <span class="text-[11px] text-emerald-100/60 block">sekolah/madrasah</span>
            </div>
            <div class="p-4 rounded-xl bg-white/10 backdrop-blur-sm border border-white/10">
                <span class="text-[11px] font-bold text-amber-400 uppercase block tracking-wider">KABUPATEN</span>
                <h2 class="text-2xl md:text-3xl font-bold text-white my-0.5"><?= $totalKabupaten ?? 0; ?></h2>
                <span class="text-[11px] text-emerald-100/60 block">se-Sulbar</span>
            </div>
            <div class="p-4 rounded-xl bg-white/10 backdrop-blur-sm border border-white/10">
                <span class="text-[11px] font-bold text-amber-400 uppercase block tracking-wider">AKREDITASI A</span>
                <h2 class="text-2xl md:text-3xl font-bold text-white my-0.5"><?= $totalAkreA ?? 0; ?></h2>
                <span class="text-[11px] text-emerald-100/60 block">dari <?= $totalSekolah ?? 0; ?></span>
            </div>
            <div class="p-4 rounded-xl bg-white/10 backdrop-blur-sm border border-white/10">
                <span class="text-[11px] font-bold text-amber-400 uppercase block tracking-wider">AKREDITASI B</span>
                <h2 class="text-2xl md:text-3xl font-bold text-white my-0.5"><?= $totalAkreB ?? 0; ?></h2>
                <span class="text-[11px] text-emerald-100/60 block">terbanyak</span>
            </div>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 mb-12">

    <!-- Section 1: PER TINGKAT -->
    <div class="mb-8">
        <h6 class="font-serif font-bold text-[#0b3c26] uppercase text-sm tracking-wider mb-4">PER TINGKAT</h6>
        <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-8 gap-3">
            <?php foreach ($listJenjangMaster as $jCode) : ?>
                <?php
                $jCount = $countJenjang[$jCode] ?? 0;

                // Handle toggle filter parameter URL
                $queryParams = $_GET;
                if (isset($queryParams['tingkat']) && strtoupper($queryParams['tingkat']) === $jCode) {
                    unset($queryParams['tingkat']);
                } else {
                    $queryParams['tingkat'] = $jCode;
                }
                $urlTingkat = base_url('sekolah') . (!empty($queryParams) ? '?' . http_build_query($queryParams) : '');
                $isActive   = (isset($filterTingkat) && strtoupper($filterTingkat) === $jCode);
                ?>
                <a href="<?= $urlTingkat; ?>" class="block group">
                    <div class="text-center py-4 px-2 rounded-xl border border-gray-200/80 transition-all h-full <?= $isActive ? 'ring-2 ring-emerald-600 bg-white shadow-md' : 'bg-gray-50/70 hover:bg-white hover:shadow-sm hover:border-emerald-300'; ?>">
                        <span class="font-bold text-xl block text-[#0b3c26] group-hover:text-emerald-700 mb-1"><?= $jCount; ?></span>
                        <span class="font-semibold text-gray-400 text-xs block uppercase tracking-wider"><?= $jCode; ?></span>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Section 2: KABUPATEN TERBANYAK -->
    <div class="mb-8">
        <h6 class="font-serif font-bold text-[#0b3c26] uppercase text-sm tracking-wider mb-4">KABUPATEN TERBANYAK</h6>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
            <?php if (!empty($dataKabupatenDisplay)) : ?>
                <?php foreach ($dataKabupatenDisplay as $kab) : ?>
                    <?php
                    $kabNama  = $kab['nama'];
                    $kabTotal = $kab['total'];

                    // Handle toggle filter parameter URL
                    $queryParams = $_GET;
                    if (isset($queryParams['kabupaten']) && strtoupper($queryParams['kabupaten']) === $kabNama) {
                        unset($queryParams['kabupaten']);
                    } else {
                        $queryParams['kabupaten'] = $kabNama;
                    }
                    $urlKab     = base_url('sekolah') . (!empty($queryParams) ? '?' . http_build_query($queryParams) : '');
                    $isKabActive = (isset($filterKab) && strtoupper($filterKab) === $kabNama);
                    ?>
                    <a href="<?= $urlKab; ?>" class="block group">
                        <div class="text-center py-4 px-2 rounded-xl border border-gray-200/80 transition-all h-full <?= $isKabActive ? 'ring-2 ring-emerald-600 bg-white shadow-md' : 'bg-gray-50/70 hover:bg-white hover:shadow-sm hover:border-emerald-300'; ?>">
                            <span class="font-bold text-xl block text-[#0b3c26] group-hover:text-emerald-700 mb-1"><?= $kabTotal; ?></span>
                            <span class="font-semibold text-gray-400 text-xs block uppercase truncate tracking-wider" title="<?= esc($kabNama); ?>"><?= esc($kabNama); ?></span>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php else : ?>
                <div class="col-span-full text-center text-xs text-gray-400 py-3">Tidak ada data kabupaten.</div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Form Filter & Search Box -->
    <div class="bg-gray-50 border border-gray-200/80 rounded-xl p-4 mb-8 shadow-sm">
        <form action="<?= base_url('sekolah'); ?>" method="GET">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-3 mb-4">
                <!-- Search Box -->
                <div>
                    <label class="block text-gray-500 font-bold uppercase text-[10px] mb-1">CARI</label>
                    <div class="flex rounded-md shadow-sm">
                        <input type="text" name="q" class="flex-1 min-w-0 w-full px-3 py-1.5 text-xs text-gray-800 border border-gray-300 rounded-l-md focus:ring-1 focus:ring-emerald-600 focus:border-emerald-600 outline-none" placeholder="Nama sekolah, NPSN, alamat..." value="<?= esc($keyword ?? ''); ?>">
                        <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-medium rounded-r-md transition-colors">
                            <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            Cari
                        </button>
                    </div>
                </div>

                <!-- Select Tingkat -->
                <div>
                    <label class="block text-gray-500 font-bold uppercase text-[10px] mb-1">TINGKAT</label>
                    <select name="tingkat" class="w-full px-2.5 py-1.5 text-xs text-gray-800 border border-gray-300 rounded-md focus:ring-1 focus:ring-emerald-600 focus:border-emerald-600 bg-white outline-none" onchange="this.form.submit()">
                        <option value="">Semua tingkat</option>
                        <?php foreach ($listJenjangMaster as $jCode): ?>
                            <option value="<?= $jCode; ?>" <?= (isset($filterTingkat) && strtoupper($filterTingkat) === $jCode) ? 'selected' : ''; ?>>
                                <?= $jCode; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Select Kabupaten -->
                <div>
                    <label class="block text-gray-500 font-bold uppercase text-[10px] mb-1">KABUPATEN</label>
                    <select name="kabupaten" class="w-full px-2.5 py-1.5 text-xs text-gray-800 border border-gray-300 rounded-md focus:ring-1 focus:ring-emerald-600 focus:border-emerald-600 bg-white outline-none" onchange="this.form.submit()">
                        <option value="">Semua Kabupaten</option>
                        <?php if (!empty($listKabupaten)): ?>
                            <?php foreach ($listKabupaten as $kRow): ?>
                                <?php
                                $kabVal = strtoupper(trim($kRow['kabupaten_kota'] ?? ''));
                                if (empty($kabVal)) continue;
                                ?>
                                <option value="<?= esc($kabVal); ?>" <?= (isset($filterKab) && strtoupper($filterKab) === $kabVal) ? 'selected' : ''; ?>>
                                    <?= esc($kabVal); ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <!-- Select Akreditasi -->
                <div>
                    <label class="block text-gray-500 font-bold uppercase text-[10px] mb-1">AKREDITASI</label>
                    <select name="akreditasi" class="w-full px-2.5 py-1.5 text-xs text-gray-800 border border-gray-300 rounded-md focus:ring-1 focus:ring-emerald-600 focus:border-emerald-600 bg-white outline-none" onchange="this.form.submit()">
                        <option value="">Semua akreditasi</option>
                        <option value="A" <?= (isset($filterAkre) && strtoupper($filterAkre) === 'A') ? 'selected' : ''; ?>>A</option>
                        <option value="B" <?= (isset($filterAkre) && strtoupper($filterAkre) === 'B') ? 'selected' : ''; ?>>B</option>
                        <option value="C" <?= (isset($filterAkre) && strtoupper($filterAkre) === 'C') ? 'selected' : ''; ?>>C</option>
                        <option value="Belum Akreditasi" <?= (isset($filterAkre) && in_array(strtolower($filterAkre), ['belum akreditasi', 'tt', 'belum'])) ? 'selected' : ''; ?>>Belum Akreditasi</option>
                    </select>
                </div>
            </div>

            <!-- Footer Filter (Sorting & Reset) -->
            <div class="flex flex-col sm:flex-row justify-between items-center pt-3 border-t border-gray-200 gap-2">
                <div class="flex items-center space-x-2">
                    <label class="text-gray-500 font-bold text-[10px] uppercase">URUTKAN:</label>
                    <select name="urutan" class="px-2 py-1 text-xs text-gray-800 border border-gray-300 rounded-md focus:ring-1 focus:ring-emerald-600 bg-white outline-none" onchange="this.form.submit()">
                        <option value="nama" <?= (isset($filterUrutan) && $filterUrutan === 'nama') ? 'selected' : ''; ?>>Nama Sekolah (A-Z)</option>
                        <option value="kabupaten" <?= (isset($filterUrutan) && $filterUrutan === 'kabupaten') ? 'selected' : ''; ?>>Per kabupaten (A-Z)</option>
                    </select>
                </div>
                <div class="flex items-center space-x-3">
                    <span class="text-xs font-semibold text-gray-500">
                        Menampilkan <?= !empty($sekolahList) ? count($sekolahList) : 0; ?> dari <?= $totalSekolah ?? 0; ?> sekolah
                    </span>
                    <a href="<?= base_url('sekolah'); ?>" class="inline-flex items-center px-2.5 py-1 text-xs font-semibold text-rose-600 hover:text-white border border-rose-300 hover:bg-rose-600 rounded transition-colors">
                        Reset Filter
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Grid List Card Sekolah -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <?php if (!empty($sekolahList)) : ?>
            <?php foreach ($sekolahList as $row) : ?>
                <?php
                $namaSekolah = $row['nama_sekolah'] ?? 'Sekolah Muhammadiyah';
                $jenjang     = strtoupper(trim($row['jenjang'] ?? 'SD'));
                $kabupaten   = trim($row['kabupaten_kota'] ?? '-');
                $kecamatan   = !empty($row['kecamatan']) && trim($row['kecamatan']) !== '-' ? trim($row['kecamatan']) : '';

                $npsn   = (!empty($row['npsn']) && trim($row['npsn']) !== '-' && trim($row['npsn']) !== '0') ? trim($row['npsn']) : null;
                $kepala = (!empty($row['kepala_sekolah']) && trim($row['kepala_sekolah']) !== '-') ? trim($row['kepala_sekolah']) : null;

                $rawAkre = strtoupper(trim($row['akreditasi'] ?? ''));
                if (in_array($rawAkre, ['A', 'B', 'C'])) {
                    $akreditasiLabel = $rawAkre;
                } elseif (!empty($rawAkre) && $rawAkre !== '-') {
                    $akreditasiLabel = 'TT';
                } else {
                    $akreditasiLabel = '-';
                }

                $badgeBg = ($akreditasiLabel === 'A')
                    ? 'bg-emerald-600 text-white'
                    : (($akreditasiLabel === 'B')
                        ? 'bg-amber-400 text-gray-900'
                        : (($akreditasiLabel === 'C')
                            ? 'bg-sky-500 text-white'
                            : 'bg-gray-300 text-gray-700'));
                ?>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 flex flex-col justify-between hover:shadow-md transition-shadow">
                    <div>
                        <div class="flex items-start justify-between gap-3 mb-3">
                            <div class="flex items-center justify-center bg-emerald-100/70 text-emerald-800 font-bold rounded-lg w-10 h-10 text-xs flex-shrink-0">
                                <?= esc($jenjang); ?>
                            </div>

                            <div class="flex-1 min-w-0">
                                <h6 class="font-bold text-gray-900 text-sm truncate mb-1" title="<?= esc($namaSekolah); ?>">
                                    <?= esc($namaSekolah); ?>
                                </h6>
                                <div class="flex items-center text-gray-500 text-[11px] uppercase truncate">
                                    <svg class="w-3 h-3 text-rose-500 mr-1 flex-shrink-0" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A31.493 31.493 0 0 1 8 14.58a31.481 31.481 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94zM8 16s6-5.686 6-10 A6 6 0 0 0 2 6c0 4.314 6 10 6 10z" />
                                        <path d="M8 8a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm0 1a3 3 0 1 1 0-6 3 3 0 0 1 0 6z" />
                                    </svg>
                                    <span class="truncate">
                                        <?= esc($kabupaten); ?>
                                        <?php if (!empty($kecamatan)): ?>
                                            · Kec. <?= esc($kecamatan); ?>
                                        <?php endif; ?>
                                    </span>
                                </div>
                            </div>

                            <div class="flex-shrink-0">
                                <span class="w-7 h-7 rounded-full flex items-center justify-center font-bold text-[10px] shadow-sm <?= $badgeBg; ?>" title="Akreditasi: <?= esc($akreditasiLabel); ?>">
                                    <?= esc($akreditasiLabel); ?>
                                </span>
                            </div>
                        </div>
                    </div>

                    <?php if ($npsn !== null || $kepala !== null) : ?>
                        <div class="pt-3 border-t border-gray-100 mt-2 text-[11px] text-gray-500 space-y-1">
                            <?php if ($npsn !== null) : ?>
                                <div class="flex justify-between">
                                    <span>NPSN:</span>
                                    <span class="font-semibold text-gray-800"><?= esc($npsn); ?></span>
                                </div>
                            <?php endif; ?>

                            <?php if ($kepala !== null) : ?>
                                <div class="flex justify-between items-center">
                                    <span class="flex-shrink-0">Kepala:</span>
                                    <span class="font-semibold text-gray-800 truncate ml-2 max-w-[180px]" title="<?= esc($kepala); ?>"><?= esc($kepala); ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php else: ?>
                        <div class="pt-2"></div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <div class="col-span-full text-center py-12 bg-gray-50 rounded-xl border border-dashed border-gray-200">
                <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <p class="text-gray-600 font-medium text-sm mb-1">Data sekolah atau madrasah tidak ditemukan.</p>
                <span class="text-gray-400 text-xs">Coba sesuaikan kata kunci pencarian atau reset filter Anda.</span>
            </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection(); ?>