<!-- Meta Tags Open Graph untuk Share Sosial Media -->
<?= $this->section('head') ?>
    <?php 
        // 1. Pastikan URL Gambar Absolut & Bersih
        $shareImg = !empty($opini['gambar']) 
            ? base_url('uploads/opini/' . $opini['gambar']) 
            : base_url('assets/images/default.jpg'); 

        // 2. Potong Deskripsi secara Manual tanpa helper
        $cleanText = strip_tags($opini['isi'] ?? '');
        $shareDesc = (strlen($cleanText) > 150) ? substr($cleanText, 0, 150) . '...' : $cleanText;
    ?>
    <meta property="og:type" content="article" />
    <meta property="og:site_name" content="PWM Sulawesi Barat" />
    <meta property="og:title" content="<?= esc($opini['judul']); ?>" />
    <meta property="og:description" content="<?= esc($shareDesc); ?>" />
    <meta property="og:image" content="<?= $shareImg; ?>" />
    <meta property="og:image:secure_url" content="<?= $shareImg; ?>" />
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="630" />
    <meta property="og:url" content="<?= current_url(); ?>" />

    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="<?= esc($opini['judul']); ?>" />
    <meta name="twitter:description" content="<?= esc($shareDesc); ?>" />
    <meta name="twitter:image" content="<?= $shareImg; ?>" />
<?= $this->endSection() ?>

<?= $this->extend('pages/layout/main') ?>

<?= $this->section('content') ?>
<div class="bg-slate-50 min-h-screen py-12">
    <article class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Breadcrumb / Back Button -->
        <div class="mb-6">
            <a href="<?= base_url('opini'); ?>" class="inline-flex items-center space-x-2 text-sm font-medium text-slate-500 hover:text-blue-600 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span>Kembali ke Daftar Opini</span>
            </a>
        </div>

        <!-- Article Container -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-10">
            <!-- Header artikel -->
            <header class="mb-8">
                <h1 class="text-2xl sm:text-4xl font-extrabold text-slate-900 leading-tight mb-6">
                    <?= esc($opini['judul']); ?>
                </h1>

                <!-- Profile Penulis & Meta Data -->
                <div class="flex items-center space-x-4 pb-6 border-b border-slate-200">
                    <div class="w-12 h-12 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-lg shrink-0">
                        <?= strtoupper(substr($opini['penulis'] ?? 'A', 0, 1)); ?>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-slate-800"><?= esc($opini['penulis'] ?? 'Anonim'); ?></h3>
                        <p class="text-xs text-slate-500"><?= esc($opini['profesi_penulis'] ?? '-'); ?></p>
                        <div class="flex items-center space-x-2 text-xs text-slate-400 mt-1">
                            <span><?= date('d F Y', strtotime($opini['tanggal'])); ?></span>
                            <span>&bull;</span>
                            <span>Dibaca <?= $opini['views']; ?> kali</span>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Gambar Utama / Header -->
            <?php if (!empty($opini['gambar'])) : ?>
                <div class="mb-8 rounded-xl overflow-hidden border border-slate-100">
                    <img src="<?= base_url('uploads/opini/' . $opini['gambar']); ?>" alt="<?= esc($opini['judul']); ?>" class="w-full max-h-[450px] object-cover">
                </div>
            <?php endif; ?>

            <!-- Isi Artikel (Rata Kanan Kiri & Paragraf) -->
            <div class="prose prose-slate max-w-none text-slate-800 leading-relaxed text-base sm:text-lg text-justify space-y-4">
                <?= nl2br(esc($opini['isi'])); ?>
            </div>
        </div>

    </article>
</div>
<?= $this->endSection() ?>