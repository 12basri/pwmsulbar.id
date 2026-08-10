<?= $this->extend('pages/layout/main') ?>

<?= $this->section('content') ?>

<section class="bg-slate-50 border-b border-slate-200 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto">
        <a href="<?= base_url('pdm') ?>" class="inline-flex items-center gap-2 text-xs font-medium text-emerald-600 hover:text-emerald-700 mb-4 transition-colors">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali ke Direktori PDM</span>
        </a>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-800"><?= esc($pdm['nama_pdm'] ?? '-') ?></h1>
    </div>
</section>

<section class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
    <!-- Informasi Utama -->
    <div class="bg-white rounded-xl p-6 border border-slate-200 shadow-sm grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <h3 class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-3">Kontak & Lokasi</h3>
            <div class="space-y-3 text-sm text-slate-700">
                <p class="flex items-start gap-3">
                    <i class="fa-solid fa-user-tie text-emerald-600 mt-1"></i>
                    <span><strong>Ketua Umum:</strong> <?= esc($pdm['ketua_umum'] ?? $pdm['pimpinan'] ?? '-') ?></span>
                </p>
                <p class="flex items-start gap-3">
                    <i class="fa-solid fa-location-dot text-emerald-600 mt-1"></i>
                    <span><strong>Alamat Kantor:</strong> <?= esc($pdm['alamat_kantor'] ?? $pdm['alamat'] ?? '-') ?></span>
                </p>
            </div>
        </div>
        <div>
            <h3 class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-3">Hubungi PDM</h3>
            <div class="space-y-3 text-sm text-slate-700">
                <p class="flex items-center gap-3">
                    <i class="fa-solid fa-phone text-emerald-600"></i>
                    <span><strong>Telepon:</strong> <?= esc($pdm['telepon'] ?? $pdm['no_telp'] ?? '-') ?></span>
                </p>
                <p class="flex items-center gap-3">
                    <i class="fa-solid fa-envelope text-emerald-600"></i>
                    <span><strong>Email:</strong> <?= esc($pdm['email'] ?? '-') ?></span>
                </p>
            </div>
        </div>
    </div>

    <!-- Susunan Pengurus -->
    <?php if (!empty($pengurus)): ?>
        <div class="bg-white rounded-xl p-6 border border-slate-200 shadow-sm">
            <h3 class="text-lg font-bold text-slate-800 mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
                <i class="fa-solid fa-users text-emerald-600"></i>
                <span>Susunan Pengurus</span>
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                <?php foreach ($pengurus as $p): ?>
                    <div class="bg-slate-50 p-3 rounded-lg border border-slate-100">
                        <p class="font-semibold text-slate-800 text-sm"><?= esc($p['nama_pengurus'] ?? $p['nama'] ?? '-') ?></p>
                        <p class="text-xs text-emerald-600 font-medium"><?= esc($p['jabatan'] ?? '-') ?></p>
                        <p class="text-[11px] text-slate-400 mt-0.5">Periode: <?= esc($p['periode'] ?? '-') ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Sejarah / Catatan -->
    <?php if (!empty($sejarah)): ?>
        <div class="bg-white rounded-xl p-6 border border-slate-200 shadow-sm">
            <h3 class="text-lg font-bold text-slate-800 mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
                <i class="fa-solid fa-clock-rotate-left text-emerald-600"></i>
                <span>Sejarah & Catatan Ringkas</span>
            </h3>
            <div class="space-y-3">
                <?php foreach ($sejarah as $s): ?>
                    <div class="border-l-2 border-emerald-500 pl-4 py-1">
                        <span class="text-xs font-bold bg-emerald-100 text-emerald-800 px-2 py-0.5 rounded"><?= esc($s['tahun_kejadian'] ?? $s['tahun'] ?? '-') ?></span>
                        <p class="text-sm text-slate-600 mt-1"><?= esc($s['deskripsi'] ?? $s['isi'] ?? '-') ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Website & Link Terkait -->
    <?php if (!empty($website)): ?>
        <div class="bg-white rounded-xl p-6 border border-slate-200 shadow-sm">
            <h3 class="text-lg font-bold text-slate-800 mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
                <i class="fa-solid fa-globe text-emerald-600"></i>
                <span>Tautan & Website Resmi</span>
            </h3>
            <ul class="space-y-2">
                <?php foreach ($website as $w): ?>
                    <?php $url = $w['url_website'] ?? $w['url'] ?? '#'; ?>
                    <li class="flex items-center gap-2 text-sm">
                        <i class="fa-solid fa-link text-xs text-slate-400"></i>
                        <a href="<?= esc($url) ?>" target="_blank" class="text-emerald-600 hover:underline font-medium"><?= esc($url) ?></a>
                        <span class="text-xs text-slate-400">(<?= esc($w['keterangan'] ?? 'Website') ?>)</span>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
</section>

<?= $this->endSection() ?>