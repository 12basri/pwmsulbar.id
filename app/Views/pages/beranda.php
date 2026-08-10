<?= $this->extend('pages/layout/main') ?>

<?= $this->section('content') ?>

<!-- ================= 1. SLIDER UTAMA / HERO SLIDER ================= -->
<?php if (!empty($sliders)): ?>
    <!-- Wrapper Full-Width Trik Tailwind -->
    <div class="relative w-screen left-1/2 right-1/2 -ml-[50vw] -mr-[50vw] -mt-6 mb-10 overflow-hidden bg-white group border-b border-slate-200/80">

        <!-- Container Slide (Wajib w-full & flex) -->
        <div id="heroSlider" class="flex transition-transform duration-700 ease-in-out w-full">
            <?php foreach ($sliders as $slide): ?>
                <?php $imgSlide = base_url('uploads/slider/' . $slide['gambar']); ?>

                <!-- Lebar full, tinggi h-auto mengikuti proporsi alami gambar -->
                <div class="w-screen w-full flex-shrink-0 relative h-auto">
                    <img src="<?= $imgSlide ?>"
                        alt="<?= esc($slide['judul'] ?? 'Slider') ?>"
                        onclick="openPreview('<?= $imgSlide ?>', '<?= esc($slide['judul'] ?? '') ?>')"
                        class="w-full h-auto max-h-[85vh] object-contain mx-auto cursor-pointer"
                        onerror="this.onerror=null; this.src='https://placehold.co/1200x500?text=Slider+Tidak+Ada';">

                    <!-- Tombol Link (Jika Ada) -->
                    <?php if (!empty($slide['link'])): ?>
                        <div class="absolute bottom-4 left-4 sm:bottom-8 sm:left-8 z-10">
                            <a href="<?= esc($slide['link']) ?>" target="_blank" class="inline-flex items-center gap-2 px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs sm:text-sm rounded-xl transition shadow-lg hover:scale-105">
                                Info Selengkapnya
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Tombol Navigasi Hero Slider -->
        <button onclick="moveHeroSlide(-1)" class="absolute left-3 sm:left-6 top-1/2 -translate-y-1/2 p-2.5 rounded-full bg-black/30 hover:bg-black/60 text-white transition opacity-0 group-hover:opacity-100 backdrop-blur-sm z-20">
            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </button>
        <button onclick="moveHeroSlide(1)" class="absolute right-3 sm:right-6 top-1/2 -translate-y-1/2 p-2.5 rounded-full bg-black/30 hover:bg-black/60 text-white transition opacity-0 group-hover:opacity-100 backdrop-blur-sm z-20">
            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </button>

        <!-- Indikator Hero Slider (Dots) -->
        <div class="absolute bottom-3 sm:bottom-4 left-1/2 -translate-x-1/2 flex gap-2 z-20">
            <?php foreach ($sliders as $index => $slide): ?>
                <button onclick="goToHeroSlide(<?= $index ?>)" class="hero-dot-indicator w-2.5 h-2.5 rounded-full bg-white/80 shadow-sm transition-all duration-300"></button>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>

<!-- ================= WIDGET JADWAL SALAT (FULL WIDTH) ================= -->
<div class="relative w-screen left-1/2 right-1/2 -ml-[50vw] -mr-[50vw] -mt-6 mb-10 overflow-hidden bg-gradient-to-r from-[#1e458e] via-[#1b6b55] to-[#0f533a] text-white border-b border-slate-200/80 shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 divide-y lg:divide-y-0 lg:divide-x divide-white/10">

            <!-- Sisi Kiri: Lokasi, Tanggal Realtime & Jam Digital Realtime -->
            <div class="lg:col-span-3 py-4 sm:py-6 pr-4 flex flex-col justify-center">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-1.5 text-amber-400 text-xs font-bold tracking-wider uppercase mb-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span>Jadwal Salat</span>
                    </div>
                    <!-- Jam Running Realtime -->
                    <div id="jam-running" class="bg-amber-400/20 text-amber-300 px-2 py-0.5 rounded text-xs font-mono font-bold border border-amber-400/30">
                        00:00:00
                    </div>
                </div>
                <h2 class="text-xl sm:text-2xl font-bold tracking-tight text-white">Mamuju dan sekitarnya</h2>
                
                <!-- Tanggal Masehi Realtime -->
                <p id="tanggal-masehi-realtime" class="text-xs sm:text-sm text-slate-200 font-medium mt-1">
                    <?= isset($jadwal['tanggal_masehi']) ? $jadwal['tanggal_masehi'] : 'Memuat tanggal...' ?>
                </p>
                
                <!-- Tanggal Hijriah Realtime -->
                <p id="tanggal-hijriah-realtime" class="text-xs font-semibold text-slate-300 mt-0.5">
                    <?= isset($jadwal['tanggal_hijriah']) ? $jadwal['tanggal_hijriah'] : '' ?>
                </p>
            </div>

            <!-- Sisi Kanan: Daftar Waktu Salat -->
            <div class="lg:col-span-9 grid grid-cols-3 sm:grid-cols-6 divide-x divide-white/10 items-center text-center py-4 lg:py-0">

                <!-- Subuh -->
                <div id="card-subuh" class="p-3 flex flex-col items-center justify-center space-y-1 h-full transition-all duration-300">
                    <span class="text-2xl">🌅</span>
                    <span class="label-salat text-[11px] font-bold text-slate-300 uppercase tracking-wider">Subuh</span>
                    <span class="waktu-salat text-lg sm:text-xl font-extrabold tracking-tight"><?= $jadwal['subuh'] ?? '05:01' ?></span>
                </div>

                <!-- Terbit -->
                <div id="card-terbit" class="p-3 flex flex-col items-center justify-center space-y-1 h-full transition-all duration-300">
                    <span class="text-2xl">🌄</span>
                    <span class="label-salat text-[11px] font-bold text-slate-300 uppercase tracking-wider">Terbit</span>
                    <span class="waktu-salat text-lg sm:text-xl font-extrabold tracking-tight"><?= $jadwal['terbit'] ?? '06:07' ?></span>
                </div>

                <!-- Zuhur -->
                <div id="card-zuhur" class="p-3 flex flex-col items-center justify-center space-y-1 h-full transition-all duration-300">
                    <span class="text-2xl">☀️</span>
                    <span class="label-salat text-[11px] font-bold text-slate-300 uppercase tracking-wider">Zuhur</span>
                    <span class="waktu-salat text-lg sm:text-xl font-extrabold tracking-tight"><?= $jadwal['zuhur'] ?? '12:10' ?></span>
                </div>

                <!-- Ashar -->
                <div id="card-ashar" class="p-3 flex flex-col items-center justify-center space-y-1 h-full transition-all duration-300">
                    <span class="text-2xl">⛅</span>
                    <span class="label-salat text-[11px] font-bold text-slate-300 uppercase tracking-wider">Ashar</span>
                    <span class="waktu-salat text-lg sm:text-xl font-extrabold tracking-tight"><?= $jadwal['ashar'] ?? '15:32' ?></span>
                </div>

                <!-- Maghrib -->
                <div id="card-maghrib" class="p-3 flex flex-col items-center justify-center space-y-1 h-full transition-all duration-300">
                    <span class="text-2xl">🌆</span>
                    <span class="label-salat text-[11px] font-bold text-slate-300 uppercase tracking-wider">Maghrib</span>
                    <span class="waktu-salat text-lg sm:text-xl font-extrabold tracking-tight"><?= $jadwal['maghrib'] ?? '18:08' ?></span>
                </div>

                <!-- Isya -->
                <div id="card-isya" class="p-3 flex flex-col items-center justify-center space-y-1 h-full transition-all duration-300">
                    <span class="text-2xl">🌙</span>
                    <span class="label-salat text-[11px] font-bold text-slate-300 uppercase tracking-wider">Isya</span>
                    <span class="waktu-salat text-lg sm:text-xl font-extrabold tracking-tight"><?= $jadwal['isya'] ?? '19:19' ?></span>
                </div>

            </div>
        </div>
    </div>

    <!-- Footnote Sumber -->
    <div class="bg-black/20 px-4 py-2 text-center text-[11px] text-slate-300/80 border-t border-white/5">
        Sumber jadwal: <strong>KHGT Muhammadiyah</strong>. Untuk fitur lengkap, gunakan <strong>MASA</strong>, aplikasi resmi Muhammadiyah. Waktu Subuh mengikuti keputusan MTT PP Muhammadiyah.
    </div>
</div>

<!-- ================= 2. CONTAINER UTAMA (BERITA & BANNER SAMPING) ================= -->
<div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mb-12 items-start">

    <!-- BANNER SLIDER (Pindah ke Bawah di Mobile dengan 'order-2', Sticky hanya di Desktop) -->
    <?php if (!empty($banners)): ?>
        <div class="lg:col-span-5 order-2 lg:order-1 lg:sticky lg:top-6">
            <div class="relative overflow-hidden rounded-3xl shadow-md bg-slate-900 group border border-slate-200/80">
                <div id="bannerSlider" class="flex transition-transform duration-500 ease-in-out w-full">
                    <?php foreach ($banners as $banner): ?>
                        <?php $imagePath = base_url('uploads/banner/' . $banner['gambar']); ?>

                        <!-- Menggunakan aspect ratio responsif di mobile agar gambar tidak terpotong kaku -->
                        <div class="w-full flex-shrink-0 relative h-auto aspect-[4/5] sm:aspect-square lg:h-[620px]">
                            <!-- DITAMBAHKAN: onclick="openPreview(...)" & cursor-pointer untuk membuka Preview Gambar -->
                            <img src="<?= $imagePath ?>"
                                alt="<?= esc($banner['judul']) ?>"
                                onclick="openPreview('<?= $imagePath ?>', '<?= esc($banner['judul']) ?>')"
                                class="w-full h-full object-cover cursor-pointer"
                                onerror="this.onerror=null; this.src='https://placehold.co/800x600?text=Banner+Tidak+Ada';">

                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/40 to-transparent flex items-end pointer-events-none">
                                <div class="p-4 sm:p-6 text-white space-y-2 sm:space-y-3 pointer-events-auto w-full">
                                    <div class="flex items-center justify-between">
                                        <span class="px-2.5 py-0.5 sm:px-3 sm:py-1 bg-blue-600/80 backdrop-blur-md text-[10px] sm:text-[11px] font-semibold uppercase tracking-wider rounded-lg border border-blue-400/30 inline-block">
                                            <?= esc($banner['posisi']) ?>
                                        </span>
                                    </div>
                                    <h2 class="text-base sm:text-2xl font-extrabold text-white leading-snug line-clamp-2">
                                        <?= esc($banner['judul']) ?>
                                    </h2>
                                    <?php if (!empty($banner['link'])): ?>
                                        <a href="<?= esc($banner['link']) ?>" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium text-xs rounded-xl transition shadow-md w-full justify-center mt-2">
                                            Selengkapnya
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                            </svg>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Navigasi Banner Slider -->
                <button id="prevBtn" onclick="moveSlide(-1)" class="absolute left-3 top-1/2 -translate-y-1/2 p-2 rounded-full bg-black/40 hover:bg-black/70 text-white transition opacity-0 group-hover:opacity-100 backdrop-blur-sm z-10">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button id="nextBtn" onclick="moveSlide(1)" class="absolute right-3 top-1/2 -translate-y-1/2 p-2 rounded-full bg-black/40 hover:bg-black/70 text-white transition opacity-0 group-hover:opacity-100 backdrop-blur-sm z-10">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>

                <!-- Indikator Banner Slider -->
                <div class="absolute bottom-3 right-4 flex gap-1.5 z-10">
                    <?php foreach ($banners as $index => $banner): ?>
                        <button onclick="goToSlide(<?= $index ?>)" class="dot-indicator w-2 h-2 rounded-full bg-white/50 transition-all duration-300"></button>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- KONTEN UTAMA BERANDA (Tampil Pertama di Mobile dengan 'order-1') -->
    <div class="<?= !empty($banners) ? 'lg:col-span-7' : 'lg:col-span-12' ?> order-1 lg:order-2 space-y-8">

        <!-- STATISTIK KUNCI -->
        <section class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm flex items-center gap-3">
                <div class="p-2.5 bg-blue-50 text-blue-600 rounded-xl">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 v5m-4 0h4" />
                    </svg>
                </div>
                <div>
                    <span class="block text-xl font-bold text-slate-800"><?= $total_pdm ?? 0 ?></span>
                    <span class="text-[11px] text-slate-500 font-medium">PDM Kab/Kota</span>
                </div>
            </div>

            <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm flex items-center gap-3">
                <div class="p-2.5 bg-emerald-50 text-emerald-600 rounded-xl">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0112 20.055a11.952 11.952 0 01-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                    </svg>
                </div>
                <div>
                    <span class="block text-xl font-bold text-slate-800"><?= $total_sekolah ?? 0 ?></span>
                    <span class="text-[11px] text-slate-500 font-medium">Sekolah/Pesantren</span>
                </div>
            </div>

            <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm flex items-center gap-3">
                <div class="p-2.5 bg-amber-50 text-amber-600 rounded-xl">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div>
                    <span class="block text-xl font-bold text-slate-800"><?= $total_majelis ?? 0 ?></span>
                    <span class="text-[11px] text-slate-500 font-medium">Majelis/Lembaga</span>
                </div>
            </div>

            <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm flex items-center gap-3">
                <div class="p-2.5 bg-rose-50 text-rose-600 rounded-xl">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
                <div>
                    <span class="block text-xl font-bold text-slate-800"><?= $total_aum ?? 0 ?></span>
                    <span class="text-[11px] text-slate-500 font-medium">Amal Usaha Utama</span>
                </div>
            </div>
        </section>

        <!-- KONTEN BERITA TERKINI -->
        <section class="space-y-4">
            <!-- Kepala Berita -->
            <div class="flex items-center justify-between border-b-2 border-blue-600 pb-2">
                <h2 class="text-lg font-extrabold text-slate-800 uppercase tracking-wider flex items-center gap-2">
                    <span class="w-3 h-3 bg-blue-600 rounded-full inline-block"></span>
                    Berita Terkini
                </h2>
                <a href="<?= base_url('berita') ?>" class="text-xs font-semibold text-blue-600 hover:underline flex items-center gap-1">
                    Lihat Semua Berita &rarr;
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <?php if (!empty($berita)): ?>
                    <?php
                    usort($berita, function ($a, $b) {
                        return strtotime($b['tanggal']) - strtotime($a['tanggal']);
                    });
                    $beritaTerbaru = array_slice($berita, 0, 4);
                    ?>

                    <?php foreach ($beritaTerbaru as $item): ?>
                        <?php
                        $urlDetail = base_url('berita/detail/' . ($item['slug'] ?? $item['id_berita'] ?? ''));
                        $imgBerita = !empty($item['gambar'])
                            ? base_url('uploads/berita/' . $item['gambar'])
                            : 'https://placehold.co/600x400?text=Gambar+Kosong';
                        ?>
                        <article class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden hover:shadow-md transition group flex flex-col justify-between">
                            <div>
                                <div class="relative h-44 overflow-hidden bg-slate-100">
                                    <img src="<?= $imgBerita ?>"
                                        alt="<?= esc($item['judul']) ?>"
                                        onclick="openPreview('<?= $imgBerita ?>', '<?= esc($item['judul']) ?>')"
                                        class="w-full h-full object-cover cursor-pointer group-hover:scale-105 transition duration-300"
                                        onerror="this.onerror=null; this.src='https://placehold.co/600x400?text=Gambar+Tidak+Ada';">
                                    <span class="absolute top-3 left-3 px-2.5 py-1 bg-blue-600 text-white text-[10px] font-bold rounded-lg uppercase tracking-wider shadow">
                                        <?= esc($item['penulis'] ?? 'Admin') ?>
                                    </span>
                                </div>
                                <div class="p-4 space-y-2">
                                    <span class="text-xs text-slate-400 font-medium">
                                        <?= date('d M Y', strtotime($item['tanggal'])) ?>
                                    </span>
                                    <h3 class="font-bold text-slate-800 text-sm group-hover:text-blue-600 transition line-clamp-2">
                                        <a href="<?= $urlDetail ?>">
                                            <?= esc($item['judul']) ?>
                                        </a>
                                    </h3>
                                    <p class="text-slate-600 text-xs line-clamp-3 leading-relaxed">
                                        <?= strip_tags($item['isi']) ?>
                                    </p>
                                </div>
                            </div>
                            <div class="p-4 pt-0">
                                <a href="<?= $urlDetail ?>" class="inline-flex items-center text-xs font-semibold text-blue-600 hover:underline gap-1">
                                    Baca Selengkapnya &rarr;
                                </a>
                            </div>
                        </article>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-span-2 p-6 text-center text-slate-500 bg-white rounded-2xl border border-slate-200">
                        Belum ada berita dipublikasikan.
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <!-- KONTEN OPINI TERKINI -->
        <section class="space-y-4 pt-4">
            <!-- Kepala Opini -->
            <div class="flex items-center justify-between border-b-2 border-emerald-600 pb-2">
                <h2 class="text-lg font-extrabold text-slate-800 uppercase tracking-wider flex items-center gap-2">
                    <span class="w-3 h-3 bg-emerald-600 rounded-full inline-block"></span>
                    Opini Terkini
                </h2>
                <a href="<?= base_url('opini') ?>" class="text-xs font-semibold text-emerald-600 hover:underline flex items-center gap-1">
                    Lihat Semua Opini &rarr;
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <?php if (!empty($opini)): ?>
                    <?php
                    usort($opini, function ($a, $b) {
                        return strtotime($b['tanggal']) - strtotime($a['tanggal']);
                    });
                    $opiniTerbaru = array_slice($opini, 0, 4);
                    ?>

                    <?php foreach ($opiniTerbaru as $item): ?>
                        <?php
                        $urlDetail = base_url('opini/detail/' . ($item['slug'] ?? $item['id_opini'] ?? $item['id'] ?? ''));
                        $imgOpini  = !empty($item['gambar'])
                            ? base_url('uploads/opini/' . $item['gambar'])
                            : 'https://placehold.co/600x400?text=Gambar+Kosong';
                        ?>
                        <article class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden hover:shadow-md transition group flex flex-col justify-between">
                            <div>
                                <div class="relative h-44 overflow-hidden bg-slate-100">
                                    <img src="<?= $imgOpini ?>"
                                        alt="<?= esc($item['judul']) ?>"
                                        onclick="openPreview('<?= $imgOpini ?>', '<?= esc($item['judul']) ?>')"
                                        class="w-full h-full object-cover cursor-pointer group-hover:scale-105 transition duration-300"
                                        onerror="this.onerror=null; this.src='https://placehold.co/600x400?text=Gambar+Tidak+Ada';">
                                    <span class="absolute top-3 left-3 px-2.5 py-1 bg-emerald-600 text-white text-[10px] font-bold rounded-lg uppercase tracking-wider shadow">
                                        <?= esc($item['penulis'] ?? 'Penulis') ?>
                                    </span>
                                </div>
                                <div class="p-4 space-y-2">
                                    <span class="text-xs text-slate-400 font-medium">
                                        <?= date('d M Y', strtotime($item['tanggal'])) ?>
                                    </span>
                                    <h3 class="font-bold text-slate-800 text-sm group-hover:text-emerald-600 transition line-clamp-2">
                                        <a href="<?= $urlDetail ?>">
                                            <?= esc($item['judul']) ?>
                                        </a>
                                    </h3>
                                    <p class="text-slate-600 text-xs line-clamp-3 leading-relaxed">
                                        <?= strip_tags($item['isi']) ?>
                                    </p>
                                </div>
                            </div>
                            <div class="p-4 pt-0">
                                <a href="<?= $urlDetail ?>" class="inline-flex items-center text-xs font-semibold text-emerald-600 hover:underline gap-1">
                                    Baca Selengkapnya &rarr;
                                </a>
                            </div>
                        </article>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-span-2 p-6 text-center text-slate-500 bg-white rounded-2xl border border-slate-200">
                        Belum ada opini dipublikasikan.
                    </div>
                <?php endif; ?>
            </div>
        </section>

    </div>

</div>

<!-- PDM DAERAH SULAWESI BARAT -->
<section class="bg-white p-6 md:p-8 rounded-3xl border border-slate-200/80 shadow-sm mb-10">
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 gap-2">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Pimpinan Daerah Muhammadiyah (PDM)</h2>
            <p class="text-xs text-slate-500">Jaringan pimpinan daerah Muhammadiyah se-Kabupaten Sulawesi Barat</p>
        </div>
        <a href="<?= base_url('pdm') ?>" class="text-xs font-semibold text-blue-600 hover:underline">
            Lihat Portal PDM &rarr;
        </a>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-4 text-center">
        <?php if (!empty($pdm_list)): ?>
            <?php foreach ($pdm_list as $pdm): ?>
                <a href="<?= base_url('pdm/detail/' . $pdm['id_pdm']) ?>" class="p-4 rounded-xl border border-slate-100 bg-slate-50/50 hover:bg-blue-50 hover:border-blue-200 transition group">
                    <div class="w-10 h-10 mx-auto mb-2 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-xs group-hover:bg-blue-600 group-hover:text-white transition">
                        <?= strtoupper(substr(str_replace('PDM Kabupaten ', '', $pdm['nama_pdm']), 0, 3)) ?>
                    </div>
                    <span class="block text-xs font-bold text-slate-700 group-hover:text-blue-700">
                        <?= esc($pdm['nama_pdm']) ?>
                    </span>
                </a>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</section>

<!-- SECTION BANNER APLIKASI MASA -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="relative overflow-hidden rounded-3xl shadow-xl group">
        <a href="https://masa.muhammadiyah.or.id/" target="_blank" rel="noopener noreferrer" class="block w-full">
            <img src="<?= base_url('assets/images/masa-banner.webp') ?>" 
                 alt="Aplikasi MASA Muhammadiyah" 
                 class="w-full h-auto object-cover block transition-transform duration-300 group-hover:scale-[1.01]">
        </a>

        <div class="absolute inset-0 pointer-events-none">
            <a href="https://masa.muhammadiyah.or.id/" 
               target="_blank" 
               rel="noopener noreferrer" 
               aria-label="Download Aplikasi MASA"
               class="pointer-events-auto absolute bottom-[15%] left-[4%] w-[18%] h-[20%] rounded-lg hidden sm:block">
            </a>
            <a href="https://play.google.com/store/apps/details?id=id.or.muhammadiyah.masa" 
               target="_blank" 
               rel="noopener noreferrer" 
               aria-label="Get it on Google Play"
               class="pointer-events-auto absolute bottom-[15%] left-[23%] w-[18%] h-[20%] rounded-lg hidden sm:block">
            </a>
        </div>
    </div>
</section>

<!-- ================= MODAL PREVIEW GAMBAR (BERITA, HERO SLIDER, & BANNER) ================= -->
<div id="imagePreviewModal" class="fixed inset-0 z-50 hidden bg-black/90 backdrop-blur-md flex items-center justify-center p-4 transition-opacity duration-300">
    <button onclick="closePreview()" class="absolute top-5 right-5 p-2 bg-white/10 hover:bg-white/20 text-white rounded-full transition z-10" title="Tutup (ESC)">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>
    <div class="max-w-4xl max-h-[90vh] flex flex-col items-center">
        <img id="previewImage" src="" alt="Preview Gambar" class="max-w-full max-h-[80vh] rounded-2xl object-contain shadow-2xl">
        <p id="previewTitle" class="mt-4 text-white font-semibold text-sm sm:text-base text-center"></p>
    </div>
</div>

<!-- Script Auto Slider, Tanggal & Waktu Real-Time -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // --- 1. LOGIK WAKTU & TANGGAL REALTIME ---
        function updateTanggalMasehi(sekarang) {
            const opsiHari = { weekday: 'long', timeZone: 'Asia/Makassar' };
            const opsiTanggal = { day: 'numeric', month: 'long', year: 'numeric', timeZone: 'Asia/Makassar' };
            
            const hari = new Intl.DateTimeFormat('id-ID', opsiHari).format(sekarang);
            const tgl = new Intl.DateTimeFormat('id-ID', opsiTanggal).format(sekarang);
            
            const elemMasehi = document.getElementById('tanggal-masehi-realtime');
            if (elemMasehi) {
                elemMasehi.innerText = `${hari}, ${tgl}`;
            }
        }

        function updateTanggalHijriah(sekarang) {
            try {
                const opsiHijriah = { day: 'numeric', month: 'long', year: 'numeric' };
                const formatterHijriah = new Intl.DateTimeFormat('id-ID-u-ca-islamic-umalqura', opsiHijriah);
                const hijriahStr = formatterHijriah.format(sekarang);
                
                const elemHijriah = document.getElementById('tanggal-hijriah-realtime');
                if (elemHijriah && !elemHijriah.innerText.trim()) {
                    elemHijriah.innerText = `${hijriahStr} H`;
                }
            } catch (e) {
                console.log("Browser tidak mendukung kalender Hijriah otomatis.");
            }
        }

        function updateWaktuSalatAktif() {
            const sekarang = new Date();
            
            // Update Tanggal Masehi & Hijriah Realtime
            updateTanggalMasehi(sekarang);
            updateTanggalHijriah(sekarang);

            const jam = String(sekarang.getHours()).padStart(2, '0');
            const menit = String(sekarang.getMinutes()).padStart(2, '0');
            const detik = String(sekarang.getSeconds()).padStart(2, '0');
            
            // Update jam running
            const jamElem = document.getElementById('jam-running');
            if (jamElem) jamElem.innerText = `${jam}:${menit}:${detik}`;

            const waktuSekarang = `${jam}:${menit}`;

            const jadwalList = [{
                    id: 'card-subuh',
                    waktu: document.querySelector('#card-subuh .waktu-salat')?.innerText.trim() || '05:01'
                },
                {
                    id: 'card-terbit',
                    waktu: document.querySelector('#card-terbit .waktu-salat')?.innerText.trim() || '06:07'
                },
                {
                    id: 'card-zuhur',
                    waktu: document.querySelector('#card-zuhur .waktu-salat')?.innerText.trim() || '12:10'
                },
                {
                    id: 'card-ashar',
                    waktu: document.querySelector('#card-ashar .waktu-salat')?.innerText.trim() || '15:32'
                },
                {
                    id: 'card-maghrib',
                    waktu: document.querySelector('#card-maghrib .waktu-salat')?.innerText.trim() || '18:08'
                },
                {
                    id: 'card-isya',
                    waktu: document.querySelector('#card-isya .waktu-salat')?.innerText.trim() || '19:19'
                }
            ];

            let aktifId = 'card-isya';

            if (waktuSekarang >= jadwalList[0].waktu && waktuSekarang < jadwalList[1].waktu) {
                aktifId = 'card-subuh';
            } else if (waktuSekarang >= jadwalList[1].waktu && waktuSekarang < jadwalList[2].waktu) {
                aktifId = 'card-terbit';
            } else if (waktuSekarang >= jadwalList[2].waktu && waktuSekarang < jadwalList[3].waktu) {
                aktifId = 'card-zuhur';
            } else if (waktuSekarang >= jadwalList[3].waktu && waktuSekarang < jadwalList[4].waktu) {
                aktifId = 'card-ashar';
            } else if (waktuSekarang >= jadwalList[4].waktu && waktuSekarang < jadwalList[5].waktu) {
                aktifId = 'card-maghrib';
            } else if (waktuSekarang >= jadwalList[5].waktu || waktuSekarang < jadwalList[0].waktu) {
                aktifId = 'card-isya';
            }

            jadwalList.forEach(item => {
                const card = document.getElementById(item.id);
                if (!card) return;
                const label = card.querySelector('.label-salat');
                const waktu = card.querySelector('.waktu-salat');

                if (item.id === aktifId) {
                    card.className = "p-3 flex flex-col items-center justify-center space-y-1 bg-white/15 border-t-2 border-amber-400 lg:border-t-4 h-full transition-all duration-300";
                    label.className = "label-salat text-[11px] font-bold text-amber-300 uppercase tracking-wider";
                    waktu.className = "waktu-salat text-xl sm:text-2xl font-black text-amber-300 tracking-tight";
                } else {
                    card.className = "p-3 flex flex-col items-center justify-center space-y-1 h-full transition-all duration-300";
                    label.className = "label-salat text-[11px] font-bold text-slate-300 uppercase tracking-wider";
                    waktu.className = "waktu-salat text-lg sm:text-xl font-extrabold tracking-tight";
                }
            });
        }

        updateWaktuSalatAktif();
        setInterval(updateWaktuSalatAktif, 1000); // Perbarui jam dan tanggal setiap detik

        // --- 2. LOGIK HERO SLIDER ---
        updateHeroSlider();
        startHeroTimer();

        // --- 3. LOGIK BANNER SLIDER ---
        updateSlider();
        startTimer();
    });

    // --- LOGIK HERO SLIDER (PALING ATAS) ---
    let currentHeroSlide = 0;
    const heroSlider = document.getElementById('heroSlider');
    const heroSlides = heroSlider ? heroSlider.children : [];
    const heroDots = document.querySelectorAll('.hero-dot-indicator');
    let autoHeroInterval;

    function updateHeroSlider() {
        if (!heroSlider || heroSlides.length === 0) return;
        heroSlider.style.transform = `translateX(-${currentHeroSlide * 100}%)`;

        heroDots.forEach((dot, index) => {
            if (index === currentHeroSlide) {
                dot.classList.add('bg-white', 'w-6');
                dot.classList.remove('bg-white/50', 'w-3');
            } else {
                dot.classList.add('bg-white/50', 'w-3');
                dot.classList.remove('bg-white', 'w-6');
            }
        });
    }

    function moveHeroSlide(direction) {
        if (heroSlides.length === 0) return;
        currentHeroSlide = (currentHeroSlide + direction + heroSlides.length) % heroSlides.length;
        updateHeroSlider();
        resetHeroTimer();
    }

    function goToHeroSlide(index) {
        currentHeroSlide = index;
        updateHeroSlider();
        resetHeroTimer();
    }

    function startHeroTimer() {
        if (heroSlides.length > 1) {
            autoHeroInterval = setInterval(() => {
                moveHeroSlide(1);
            }, 6000);
        }
    }

    function resetHeroTimer() {
        clearInterval(autoHeroInterval);
        startHeroTimer();
    }

    // --- LOGIK BANNER SLIDER (KIRI) ---
    let currentSlide = 0;
    const slider = document.getElementById('bannerSlider');
    const slides = slider ? slider.children : [];
    const dots = document.querySelectorAll('.dot-indicator');
    let autoSlideInterval;

    function updateSlider() {
        if (!slider || slides.length === 0) return;
        slider.style.transform = `translateX(-${currentSlide * 100}%)`;

        dots.forEach((dot, index) => {
            if (index === currentSlide) {
                dot.classList.add('bg-white', 'w-5');
                dot.classList.remove('bg-white/50', 'w-2');
            } else {
                dot.classList.add('bg-white/50', 'w-2');
                dot.classList.remove('bg-white', 'w-5');
            }
        });
    }

    function moveSlide(direction) {
        if (slides.length === 0) return;
        currentSlide = (currentSlide + direction + slides.length) % slides.length;
        updateSlider();
        resetTimer();
    }

    function goToSlide(index) {
        currentSlide = index;
        updateSlider();
        resetTimer();
    }

    function startTimer() {
        if (slides.length > 1) {
            autoSlideInterval = setInterval(() => {
                moveSlide(1);
            }, 5000);
        }
    }

    function resetTimer() {
        clearInterval(autoSlideInterval);
        startTimer();
    }

    // --- LOGIK MODAL PREVIEW GAMBAR ---
    function openPreview(src, title) {
        document.getElementById('previewImage').src = src;
        document.getElementById('previewTitle').innerText = title;
        document.getElementById('imagePreviewModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        clearInterval(autoSlideInterval);
        clearInterval(autoHeroInterval);
    }

    function closePreview() {
        document.getElementById('imagePreviewModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
        startTimer();
        startHeroTimer();
    }

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closePreview();
    });
</script>

<?= $this->endSection() ?>