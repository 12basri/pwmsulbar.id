<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Pimpinan Wilayah' ?></title>

    <!-- Render Section Head dari View (Detail Berita) -->
    <?= $this->renderSection('head') ?>

    <!-- Fallback Open Graph jika section head di view kosong -->
    <?php if (isset($berita) && !empty($berita['gambar'])): ?>
        <?php 
            $imgUrl = base_url('uploads/berita/' . $berita['gambar']);
            $desc   = character_limiter(strip_tags($berita['isi'] ?? ''), 150);
        ?>
        <meta property="og:type" content="article" />
        <meta property="og:site_name" content="PWM Sulawesi Barat" />
        <meta property="og:title" content="<?= esc($berita['judul']) ?>" />
        <meta property="og:description" content="<?= esc($desc) ?>" />
        <meta property="og:image" content="<?= $imgUrl ?>" />
        <meta property="og:image:secure_url" content="<?= $imgUrl ?>" />
        <meta property="og:url" content="<?= current_url() ?>" />
    <?php endif; ?>

    <!-- Google Fonts: El Messiri -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=El+Messiri:wght@400..700&display=swap" rel="stylesheet">

    <!-- CDN Alpine.js & Plugin Collapse -->
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Tailwind CSS / Asset CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-50 text-slate-800 flex flex-col min-h-screen">

    <!-- Panggilan Header / Navbar -->
    <?= $this->include('pages/layout/header') ?>

    <div class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-6 flex gap-6">

        <!-- Panggilan Sidebar (Opsional jika halaman menggunakan sidebar) -->
        <?php if (file_exists(APPPATH . 'views/pages/layout/sidebar.php')) : ?>
            <?= $this->include('pages/layout/sidebar') ?>
        <?php endif; ?>

        <!-- Main Content Area -->
        <main class="flex-1 w-full">
            <?= $this->renderSection('content') ?>
        </main>
    </div>

    <!-- Panggilan Footer -->
    <?= $this->include('pages/layout/footer') ?>

</body>

</html>