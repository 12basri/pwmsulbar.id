<?= $this->extend('pages/layout/main') ?>

<?= $this->section('content') ?>

<div class="max-w-7xl mx-auto px-4 py-8 mb-16 space-y-10">
    <div class="text-center max-w-3xl mx-auto space-y-4">
        <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
            Amal Usaha Muhammadiyah (AUM)
        </h1>
        <p class="text-slate-600 text-sm sm:text-base">
            Daftar Amal Usaha Muhammadiyah Sulawesi Barat di berbagai bidang.
        </p>
    </div>

    <?php if (!empty($amalUsaha) && is_array($amalUsaha)): ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($amalUsaha as $item): ?>
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex flex-col justify-between">
                    <div>
                        <!-- Foto AUM -->
                        <?php if (!empty($item['foto'])): ?>
                            <div class="h-48 w-full overflow-hidden bg-slate-100">
                                <img src="<?= base_url($item['foto']) ?>" alt="<?= esc($item['nama_aum']) ?>" class="w-full h-full object-cover">
                            </div>
                        <?php endif; ?>

                        <div class="p-6 space-y-3">
                            <span class="inline-block px-2.5 py-1 text-xs font-semibold text-emerald-700 bg-emerald-50 rounded-full uppercase">
                                <?= esc($item['jenis'] ?? 'Lembaga') ?>
                            </span>

                            <h3 class="text-lg font-bold text-slate-800">
                                <?= esc($item['nama_aum']) ?>
                            </h3>

                            <?php if (!empty($item['pimpinan'])): ?>
                                <p class="text-xs text-slate-500 font-medium">
                                    Pimpinan: <span class="text-slate-700"><?= esc($item['pimpinan']) ?></span>
                                </p>
                            <?php endif; ?>

                            <?php if (!empty($item['alamat'])): ?>
                                <p class="text-sm text-slate-600">
                                    <?= esc($item['alamat']) ?>
                                </p>
                            <?php endif; ?>

                            <?php if (!empty($item['deskripsi'])): ?>
                                <p class="text-xs text-slate-500 line-clamp-2">
                                    <?= esc($item['deskripsi']) ?>
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Footer Kartu (Kontak & Website) -->
                    <?php if (!empty($item['telepon']) || !empty($item['website'])): ?>
                        <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex items-center justify-between text-xs">
                            <?php if (!empty($item['telepon'])): ?>
                                <span class="text-slate-600 font-medium">
                                    📞 <?= esc($item['telepon']) ?>
                                </span>
                            <?php endif; ?>

                            <?php if (!empty($item['website'])): ?>
                                <a href="<?= esc($item['website']) ?>" target="_blank" rel="noopener noreferrer" class="text-emerald-600 hover:underline font-semibold ml-auto">
                                    Kunjungi Website &rarr;
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="p-8 bg-white rounded-2xl border border-slate-200 text-center">
            <p class="text-slate-500 text-sm">Data Amal Usaha belum tersedia.</p>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>