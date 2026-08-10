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

<div class="bg-gray-50 min-h-screen font-sans text-gray-800">

    <!-- Header / Banner Section -->
    <section class="bg-mubaGreen text-white py-8 px-4 sm:px-8">
        <div class="max-w-6xl mx-auto">
            <!-- Breadcrumb Navigation -->
            <nav class="flex text-xs text-emerald-200 mb-4 gap-2 items-center flex-wrap">
                <a href="<?= base_url(); ?>" class="hover:underline opacity-80">Beranda</a>
                <span>&rsaquo;</span>
                <a href="<?= base_url('aum/usaha-lain'); ?>" class="hover:underline opacity-80">Usaha & Fasilitas</a>
                <span>&rsaquo;</span>
                <span class="text-white font-medium truncate max-w-[200px] sm:max-w-xs"><?= esc($aum['nama_aum']); ?></span>
            </nav>

            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                <div>
                    <span class="inline-block px-3 py-1 bg-emerald-800/60 border border-emerald-600/40 rounded-full text-[11px] font-bold uppercase tracking-wide text-emerald-200 mb-2">
                        <?= esc($aum['jenis'] ?? 'Usaha & Fasilitas'); ?>
                    </span>
                    <h1 class="text-2xl sm:text-3xl font-bold leading-tight">
                        <?= esc($aum['nama_aum']); ?>
                    </h1>
                    <p class="text-xs sm:text-sm text-emerald-100 mt-1 flex items-center gap-1.5 opacity-90">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <?= !empty($aum['kabupaten_kota']) ? 'Kab. ' . esc($aum['kabupaten_kota']) : 'Sulawesi Barat'; ?>
                        <?= !empty($aum['kecamatan']) ? ', Kec. ' . esc($aum['kecamatan']) : ''; ?>
                    </p>
                </div>

                <?php if (!empty($aum['maps'])) : ?>
                    <a href="<?= esc($aum['maps']); ?>" target="_blank" class="inline-flex items-center gap-2 bg-white text-mubaGreen hover:bg-emerald-50 font-bold text-xs px-4 py-2.5 rounded-lg shadow transition shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5-4V4l5 4m0 0l6-4 6 4v16l-6-4m-6 0v16" />
                        </svg>
                        Petunjuk Lokasi (Maps)
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Main Content Grid -->
    <section class="max-w-6xl mx-auto py-8 px-4 sm:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

            <!-- Detail Utama (Kolom Kiri - 8/12) -->
            <div class="lg:col-span-8 space-y-6">

                <!-- Card Foto & Profil Utama -->
                <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                    <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6 mb-6">
                        <div class="w-28 h-28 bg-gray-50 rounded-2xl p-2 border border-gray-200 flex items-center justify-center shrink-0 overflow-hidden shadow-inner">
                            <?php if (!empty($aum['foto'])) : ?>
                                <img src="<?= base_url('uploads/aum/' . $aum['foto']); ?>" alt="<?= esc($aum['nama_aum']); ?>" class="w-full h-full object-cover rounded-xl">
                            <?php else : ?>
                                <svg class="w-12 h-12 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h4m-4 0V9a2 2 0 012-2h2a2 2 0 012 2v12" />
                                </svg>
                            <?php endif; ?>
                        </div>

                        <div class="space-y-3 w-full text-center sm:text-left">
                            <h2 class="text-xl font-bold text-gray-900 leading-snug">
                                <?= esc($aum['nama_aum']); ?>
                            </h2>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs text-gray-600 pt-2 border-t border-gray-100">
                                <div>
                                    <span class="text-gray-400 block text-[10px] uppercase font-bold">Pimpinan / Pengelola</span>
                                    <span class="font-semibold text-gray-800"><?= esc($aum['pimpinan'] ?? '-'); ?></span>
                                </div>
                                <div>
                                    <span class="text-gray-400 block text-[10px] uppercase font-bold">Jenis Usaha</span>
                                    <span class="font-semibold text-gray-800"><?= esc($aum['jenis'] ?? '-'); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Informasi Deskripsi / Profil Singkat -->
                    <div class="pt-4 border-t border-gray-100">
                        <h3 class="text-xs font-bold text-gray-800 uppercase tracking-wider mb-2">Deskripsi / Informasi Profil</h3>
                        <div class="text-xs text-gray-600 leading-relaxed space-y-2">
                            <?php if (!empty($aum['deskripsi'])) : ?>
                                <?= nl2br(esc($aum['deskripsi'])); ?>
                            <?php elseif (!empty($aum['profil'])) : ?>
                                <?= nl2br(esc($aum['profil'])); ?>
                            <?php else : ?>
                                <p class="text-gray-400 italic">Belum ada deskripsi profil tambahan untuk amal usaha/fasilitas ini.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Card Informasi Kontak & Alamat Lengkap (Tautan Website Dihapus) -->
                <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                    <h3 class="text-xs font-bold text-gray-800 uppercase tracking-wider mb-4 border-b border-gray-100 pb-2">
                        Kontak & Informasi Lokasi
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-xs">
                        <div class="sm:col-span-2 space-y-1">
                            <span class="text-gray-400 block text-[10px] uppercase font-bold">Alamat Lengkap</span>
                            <p class="text-gray-700 font-medium leading-relaxed">
                                <?= esc($aum['alamat'] ?? 'Alamat belum diisi.'); ?>
                            </p>
                        </div>
                        <div class="space-y-1">
                            <span class="text-gray-400 block text-[10px] uppercase font-bold">Kabupaten / Kota</span>
                            <p class="text-gray-700 font-medium">
                                <?= esc($aum['kabupaten_kota'] ?? '-'); ?>
                            </p>
                        </div>
                        <div class="space-y-1">
                            <span class="text-gray-400 block text-[10px] uppercase font-bold">Nomor Telepon / HP</span>
                            <p class="text-gray-700 font-medium">
                                <?= esc($aum['telepon'] ?? '-'); ?>
                            </p>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Sidebar Usaha & Fasilitas Lainnya (Kolom Kanan - 4/12) -->
            <div class="lg:col-span-4 space-y-6">
                <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
                    <h3 class="text-xs font-bold text-gray-800 uppercase tracking-wider mb-4 border-b border-gray-100 pb-2">
                        Usaha & Fasilitas Lainnya
                    </h3>

                    <?php if (!empty($usahaLainnya) && is_array($usahaLainnya)) : ?>
                        <div class="space-y-3">
                            <?php foreach ($usahaLainnya as $item) : ?>
                                <a href="<?= base_url('aum/usaha-lain/detail/' . $item['id_aum']); ?>" class="flex items-center gap-3 p-2.5 rounded-lg hover:bg-emerald-50/60 border border-transparent hover:border-emerald-100 transition group">
                                    <div class="w-10 h-10 bg-gray-50 rounded-lg p-1 border border-gray-200 flex items-center justify-center shrink-0 overflow-hidden">
                                        <?php if (!empty($item['foto'])) : ?>
                                            <img src="<?= base_url('uploads/aum/' . $item['foto']); ?>" alt="<?= esc($item['nama_aum']); ?>" class="w-full h-full object-cover rounded">
                                        <?php else : ?>
                                            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h4m-4 0V9a2 2 0 012-2h2a2 2 0 012 2v12" />
                                            </svg>
                                        <?php endif; ?>
                                    </div>
                                    <div class="overflow-hidden">
                                        <h4 class="text-xs font-bold text-gray-800 group-hover:text-mubaGreen truncate">
                                            <?= esc($item['nama_aum']); ?>
                                        </h4>
                                        <p class="text-[11px] text-gray-500 truncate">
                                            <?= esc($item['jenis'] ?? 'Fasilitas'); ?> &bull; <?= esc($item['kabupaten_kota'] ?? 'Sulbar'); ?>
                                        </p>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php else : ?>
                        <p class="text-xs text-gray-400 italic">Tidak ada data terkait lainnya.</p>
                    <?php endif; ?>

                    <div class="mt-4 pt-3 border-t border-gray-100 text-center">
                        <a href="<?= base_url('aum/usaha-lain'); ?>" class="text-xs font-bold text-mubaGreen hover:underline inline-flex items-center gap-1">
                            Lihat Semua Direktori &rarr;
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </section>

</div>

<?= $this->endSection() ?>