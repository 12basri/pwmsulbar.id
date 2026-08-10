<!-- Meta Tags untuk Share Sosial Media (WhatsApp, FB, Twitter/X) -->
<?= $this->section('head') ?>
    <?php 
        $shareImg = !empty($berita['gambar']) 
            ? base_url('uploads/berita/' . $berita['gambar']) 
            : base_url('assets/images/default-share.jpg'); 

        // Ringkasan isi berita untuk deskripsi
        $shareDesc = character_limiter(strip_tags($berita['isi'] ?? ''), 150);
    ?>
    <!-- Open Graph Basic -->
    <meta property="og:type" content="article" />
    <meta property="og:site_name" content="PWM Sulawesi Barat" />
    <meta property="og:title" content="<?= esc($berita['judul']) ?>" />
    <meta property="og:description" content="<?= esc($shareDesc) ?>" />
    
    <!-- Open Graph Image (Wajib Absolut HTTPS & Ukuran Ideal) -->
    <meta property="og:image" content="<?= $shareImg ?>" />
    <meta property="og:image:secure_url" content="<?= $shareImg ?>" />
    <meta property="og:image:type" content="image/jpeg" />
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="630" />
    <meta property="og:url" content="<?= current_url() ?>" />

    <!-- Twitter / X Card -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="<?= esc($berita['judul']) ?>" />
    <meta name="twitter:description" content="<?= esc($shareDesc) ?>" />
    <meta name="twitter:image" content="<?= $shareImg ?>" />
<?= $this->endSection() ?>

<?= $this->extend('pages/layout/main') ?>

<?= $this->section('content') ?>

<div class="max-w-7xl mx-auto px-4 py-8 mb-16">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

        <!-- Konten Utama Berita -->
        <article class="lg:col-span-2 bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-sm space-y-6">

            <!-- Breadcrumb -->
            <nav class="text-xs text-slate-500 flex items-center gap-2">
                <a href="<?= base_url() ?>" class="hover:text-emerald-600">Beranda</a>
                <span>/</span>
                <a href="<?= base_url('berita') ?>" class="hover:text-emerald-600">Berita</a>
                <span>/</span>
                <span class="text-slate-800 line-clamp-1"><?= esc($berita['judul']) ?></span>
            </nav>

            <!-- Judul & Meta Data -->
            <div class="space-y-3 border-b border-slate-100 pb-6">
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 leading-tight">
                    <?= esc($berita['judul']) ?>
                </h1>

                <div class="flex flex-wrap items-center gap-4 text-xs text-slate-500">
                    <?php if (!empty($berita['penulis'])): ?>
                        <div class="flex items-center gap-1.5 font-medium text-emerald-700">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span><?= esc($berita['penulis']) ?></span>
                        </div>
                    <?php endif; ?>

                    <div class="flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <time datetime="<?= $berita['tanggal'] ?? '' ?>">
                            <?= !empty($berita['tanggal']) ? date('d F Y', strtotime($berita['tanggal'])) : '' ?>
                        </time>
                    </div>
                </div>
            </div>

            <!-- Gambar Utama -->
            <?php if (!empty($berita['gambar'])): ?>
                <div class="rounded-xl overflow-hidden bg-slate-100 max-h-[420px] w-full">
                    <img
                        src="<?= base_url('uploads/berita/' . $berita['gambar']) ?>"
                        alt="<?= esc($berita['judul']) ?>"
                        class="w-full h-full object-cover">
                </div>
            <?php endif; ?>

            <!-- Isi Berita (Rata Kanan-Kiri) -->
            <div class="prose prose-slate max-w-none text-slate-700 leading-relaxed text-sm sm:text-base space-y-4 text-justify">
                <?= nl2br(esc($berita['isi'])) ?>
            </div>

            <!-- Tombol Kembali -->
            <div class="pt-6 border-t border-slate-100">
                <a href="<?= base_url('berita') ?>" class="inline-flex items-center text-xs font-semibold text-emerald-600 hover:text-emerald-700">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Kembali ke Daftar Berita
                </a>
            </div>
        </article>

        <!-- Sidebar Berita Terkini -->
        <aside class="space-y-6">
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm space-y-4">
                <h3 class="text-base font-bold text-slate-800 border-b border-slate-100 pb-3">
                    Berita Terkini
                </h3>

                <?php if (!empty($beritaTerkini) && is_array($beritaTerkini)): ?>
                    <div class="space-y-4 divide-y divide-slate-100">
                        <?php foreach ($beritaTerkini as $item): ?>
                            <div class="pt-3 first:pt-0 space-y-1">
                                <time class="text-[11px] text-slate-400">
                                    <?= !empty($item['tanggal']) ? date('d M Y', strtotime($item['tanggal'])) : '' ?>
                                </time>
                                <h4 class="text-xs sm:text-sm font-semibold text-slate-800 hover:text-emerald-600 transition line-clamp-2">
                                    <a href="<?= base_url('berita/' . ($item['slug'] ?? $item['id_berita'])) ?>">
                                        <?= esc($item['judul']) ?>
                                    </a>
                                </h4>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="text-xs text-slate-500">Belum ada berita lainnya.</p>
                <?php endif; ?>
            </div>
        </aside>

    </div>
</div>

<?= $this->endSection() ?>