<?= $this->extend('pages/layout/main') ?>

<?= $this->section('content') ?>

<!-- CDN Tailwind CSS Online -->
<script src="https://cdn.tailwindcss.com"></script>

<script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    mubaGreen: '#0d4d3a',
                    mubaGreenLight: '#146a51',
                    mubaBgLight: '#e8f5e9',
                }
            }
        }
    }
</script>

<?php
// Mengambil daftar jenis & kabupaten secara dinamis jika tidak dikirim dari Controller
if (!isset($kategoriList) || empty($kategoriList)) {
    $kategoriList = [];
    if (!empty($listUsaha) && is_array($listUsaha)) {
        foreach ($listUsaha as $u) {
            if (!empty($u['jenis']) && !in_array($u['jenis'], $kategoriList)) {
                $kategoriList[] = $u['jenis'];
            }
        }
    }
}

if (!isset($kabupatenList) || empty($kabupatenList)) {
    $kabupatenList = [];
    if (!empty($listUsaha) && is_array($listUsaha)) {
        foreach ($listUsaha as $u) {
            if (!empty($u['kabupaten_kota']) && !in_array($u['kabupaten_kota'], $kabupatenList)) {
                $kabupatenList[] = $u['kabupaten_kota'];
            }
        }
    }
}
?>

<div class="bg-gray-50 min-h-screen font-sans text-gray-800">

    <!-- Header / Banner Section -->
    <section class="bg-mubaGreen text-white py-8 px-4 sm:px-8">
        <div class="max-w-6xl mx-auto">
            <!-- Breadcrumb Navigation -->
            <nav class="flex text-xs text-emerald-200 mb-4 gap-2 items-center flex-wrap">
                <a href="<?= base_url(); ?>" class="hover:underline opacity-80">Beranda</a>
                <span>&rsaquo;</span>
                <span class="text-white font-medium">Usaha & Fasilitas</span>
            </nav>

            <div class="space-y-2">
                <h1 class="text-2xl sm:text-3xl font-bold leading-tight">
                    Direktori Usaha & Fasilitas
                </h1>
                <p class="text-xs sm:text-sm text-emerald-100 max-w-3xl leading-relaxed opacity-90">
                    Daftar Amal Usaha Muhammadiyah (AUM) bidang Ekonomi, Kesehatan, Sosial, Pemberdayaan, dan Fasilitas Lainnya di bawah naungan Pimpinan Wilayah Muhammadiyah Sulawesi Barat.
                </p>
            </div>
        </div>
    </section>

    <!-- Main Content Section -->
    <section class="max-w-6xl mx-auto py-8 px-4 sm:px-8">

        <!-- Form Filter & Pencarian -->
        <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm mb-6">
            <form action="<?= base_url('aum/usaha-lain'); ?>" method="get">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">

                    <!-- Input Keyword -->
                    <div class="md:col-span-5 space-y-1">
                        <label for="q" class="text-xs font-bold text-gray-600 uppercase tracking-wider block">
                            Cari Usaha / Fasilitas
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </span>
                            <input type="text" id="q" name="q" value="<?= esc($keyword ?? ''); ?>"
                                placeholder="Cari nama AUM, pimpinan, atau alamat..."
                                class="w-full text-xs pl-9 pr-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 focus:outline-none transition">
                        </div>
                    </div>

                    <!-- Dropdown Jenis AUM -->
                    <div class="md:col-span-3 space-y-1">
                        <label for="jenis" class="text-xs font-bold text-gray-600 uppercase tracking-wider block">
                            Jenis / Kategori
                        </label>
                        <select id="jenis" name="jenis" class="w-full text-xs px-3 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 focus:outline-none transition">
                            <option value="">-- Semua Jenis --</option>
                            <?php foreach ($kategoriList as $kat) : ?>
                                <option value="<?= esc($kat); ?>" <?= (isset($filterJenis) && $filterJenis == $kat) ? 'selected' : ''; ?>>
                                    <?= esc($kat); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Dropdown Kabupaten/Kota -->
                    <div class="md:col-span-2 space-y-1">
                        <label for="kabupaten_kota" class="text-xs font-bold text-gray-600 uppercase tracking-wider block">
                            Kabupaten/Kota
                        </label>
                        <select id="kabupaten_kota" name="kabupaten_kota" class="w-full text-xs px-3 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 focus:outline-none transition">
                            <option value="">-- Semua --</option>
                            <?php foreach ($kabupatenList as $kab) : ?>
                                <option value="<?= esc($kab); ?>" <?= (isset($filterKabupaten) && $filterKabupaten == $kab) ? 'selected' : ''; ?>>
                                    <?= esc($kab); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Tombol Action -->
                    <div class="md:col-span-2 flex gap-2">
                        <button type="submit" class="w-full bg-mubaGreen hover:bg-mubaGreenLight text-white text-xs font-bold py-2.5 px-4 rounded-lg shadow transition flex items-center justify-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            Cari
                        </button>

                        <?php if (!empty($keyword) || !empty($filterJenis) || !empty($filterKabupaten)) : ?>
                            <a href="<?= base_url('aum/usaha-lain'); ?>" class="bg-gray-100 hover:bg-gray-200 text-gray-600 text-xs font-semibold p-2.5 rounded-lg border border-gray-300 transition flex items-center justify-center" title="Reset Filter">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </a>
                        <?php endif; ?>
                    </div>

                </div>
            </form>
        </div>

        <!-- Quick Filter Pills Jenis/Kategori -->
        <?php if (!empty($kategoriList)) : ?>
            <div class="flex items-center gap-2 overflow-x-auto pb-2 text-xs no-scrollbar">
                <span class="text-gray-400 font-semibold text-[11px] shrink-0">Kategori:</span>
                <a href="<?= base_url('aum/usaha-lain' . (!empty($filterKabupaten) ? '?kabupaten_kota=' . urlencode($filterKabupaten) : '')); ?>"
                    class="px-3 py-1 rounded-full font-medium whitespace-nowrap transition <?= empty($filterJenis) ? 'bg-mubaGreen text-white shadow-sm' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-100'; ?>">
                    Semua
                </a>
                <?php foreach ($kategoriList as $kat) : ?>
                    <a href="<?= base_url('aum/usaha-lain?jenis=' . urlencode($kat) . (!empty($keyword) ? '&q=' . urlencode($keyword) : '') . (!empty($filterKabupaten) ? '&kabupaten_kota=' . urlencode($filterKabupaten) : '')); ?>"
                        class="px-3 py-1 rounded-full font-medium whitespace-nowrap transition <?= (isset($filterJenis) && $filterJenis == $kat) ? 'bg-mubaGreen text-white shadow-sm' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-100'; ?>">
                        <?= esc($kat); ?>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- Quick Filter Pills Kabupaten/Kota -->
        <?php if (!empty($kabupatenList)) : ?>
            <div class="flex items-center gap-2 overflow-x-auto pb-4 mb-4 text-xs no-scrollbar">
                <span class="text-gray-400 font-semibold text-[11px] shrink-0">Wilayah:</span>
                <a href="<?= base_url('aum/usaha-lain' . (!empty($filterJenis) ? '?jenis=' . urlencode($filterJenis) : '')); ?>"
                    class="px-3 py-1 rounded-full font-medium whitespace-nowrap transition <?= empty($filterKabupaten) ? 'bg-emerald-700 text-white shadow-sm' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-100'; ?>">
                    Semua Wilayah
                </a>
                <?php foreach ($kabupatenList as $kab) : ?>
                    <a href="<?= base_url('aum/usaha-lain?kabupaten_kota=' . urlencode($kab) . (!empty($keyword) ? '&q=' . urlencode($keyword) : '') . (!empty($filterJenis) ? '&jenis=' . urlencode($filterJenis) : '')); ?>"
                        class="px-3 py-1 rounded-full font-medium whitespace-nowrap transition <?= (isset($filterKabupaten) && $filterKabupaten == $kab) ? 'bg-emerald-700 text-white shadow-sm' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-100'; ?>">
                        <?= esc($kab); ?>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- Daftar Card Grid -->
        <?php if (!empty($listUsaha) && is_array($listUsaha)) : ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                <?php foreach ($listUsaha as $item) : ?>
                    <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm hover:shadow-md transition flex flex-col justify-between">

                        <div>
                            <!-- Header Card dengan Logo/Foto -->
                            <div class="flex items-start gap-3.5 mb-3">
                                <div class="w-12 h-12 bg-gray-50 rounded-full p-1 border border-gray-200 flex items-center justify-center shrink-0 overflow-hidden">
                                    <?php if (!empty($item['foto'])) : ?>
                                        <img src="<?= base_url('uploads/aum/' . $item['foto']); ?>" alt="<?= esc($item['nama_aum']); ?>" class="w-full h-full object-cover rounded-full">
                                    <?php else : ?>
                                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h4m-4 0V9a2 2 0 012-2h2a2 2 0 012 2v12" />
                                        </svg>
                                    <?php endif; ?>
                                </div>

                                <div class="overflow-hidden">
                                    <!-- Jenis AUM dari Database -->
                                    <span class="text-[10px] font-bold text-emerald-800 uppercase tracking-wide block mb-0.5">
                                        <?= esc($item['jenis'] ?? 'FASILITAS'); ?>
                                    </span>

                                    <!-- Nama AUM -->
                                    <h3 class="text-sm font-bold text-gray-900 leading-snug line-clamp-2" title="<?= esc($item['nama_aum']); ?>">
                                        <?= esc($item['nama_aum']); ?>
                                    </h3>

                                    <!-- Lokasi Kabupaten/Kota & Kecamatan -->
                                    <p class="text-xs text-gray-500 mt-0.5">
                                        <?php if (!empty($item['kabupaten_kota'])) : ?>
                                            Kab. <?= esc($item['kabupaten_kota']); ?>
                                        <?php else : ?>
                                            Sulawesi Barat
                                        <?php endif; ?>

                                        <?php if (!empty($item['kecamatan'])) : ?>
                                            , Kec. <?= esc($item['kecamatan']); ?>
                                        <?php endif; ?>
                                    </p>
                                </div>
                            </div>

                            <!-- Detail Info Pimpinan, Telepon, Alamat -->
                            <div class="my-2 pt-2 border-t border-gray-100 text-xs text-gray-600 space-y-1">
                                <?php if (!empty($item['pimpinan'])) : ?>
                                    <p class="truncate">
                                        <span class="font-semibold text-gray-800">Pimpinan:</span> <?= esc($item['pimpinan']); ?>
                                    </p>
                                <?php endif; ?>

                                <?php if (!empty($item['telepon'])) : ?>
                                    <p class="truncate text-gray-600">
                                        <span class="font-semibold text-gray-800">Telp:</span> <?= esc($item['telepon']); ?>
                                    </p>
                                <?php endif; ?>

                                <?php if (!empty($item['alamat'])) : ?>
                                    <p class="line-clamp-2 text-gray-500 text-[11px] pt-0.5">
                                        <span class="font-medium text-gray-700">Alamat:</span> <?= esc($item['alamat']); ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Footer Card dengan Google Maps & Link Detail (Tautan Website Dihapus) -->
                        <div class="flex justify-between items-center text-xs pt-3 mt-3 border-t border-gray-100">
                            <div>
                                <?php if (!empty($item['maps'])) : ?>
                                    <a href="<?= esc($item['maps']); ?>" target="_blank" class="inline-flex items-center gap-1 text-xs text-emerald-700 hover:underline" title="Buka Google Maps">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        Petunjuk Lokasi
                                    </a>
                                <?php endif; ?>
                            </div>

                            <a href="<?= base_url('aum/usaha-lain/detail/' . $item['id_aum']); ?>" class="font-bold text-gray-800 hover:text-emerald-700 flex items-center gap-1 transition">
                                Lihat &rsaquo;
                            </a>
                        </div>

                    </div>
                <?php endforeach; ?>
            </div>
        <?php else : ?>
            <!-- State Data Kosong -->
            <div class="bg-white border border-gray-200 rounded-xl p-10 text-center shadow-sm">
                <div class="w-16 h-16 bg-emerald-50 rounded-full flex items-center justify-center mx-auto mb-4 text-emerald-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
                <h3 class="text-base font-bold text-gray-900 mb-1">Data Tidak Ditemukan</h3>
                <p class="text-xs text-gray-500 max-w-md mx-auto mb-5">
                    <?php if (!empty($keyword) || !empty($filterJenis) || !empty($filterKabupaten)) : ?>
                        Tidak ada data fasilitas/usaha yang sesuai dengan kriteria pencarian Anda.
                    <?php else : ?>
                        Belum ada data usaha atau fasilitas yang terdaftar saat ini.
                    <?php endif; ?>
                </p>
                <a href="<?= base_url('aum/usaha-lain'); ?>" class="inline-flex items-center gap-1 bg-mubaGreen hover:bg-mubaGreenLight text-white text-xs font-semibold px-4 py-2 rounded-lg shadow transition">
                    Tampilkan Semua Data
                </a>
            </div>
        <?php endif; ?>

    </section>

</div>

<?= $this->endSection() ?>