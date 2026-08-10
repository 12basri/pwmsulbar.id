<?= $this->extend('pages/layout/main') ?>

<?= $this->section('content') ?>
<div class="bg-slate-50 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Halaman -->
        <div class="text-center max-w-2xl mx-auto mb-12">
            <h1 class="text-3xl font-extrabold text-slate-900 sm:text-4xl">Gagasan & Opini</h1>
            <p class="mt-3 text-base text-slate-600">Kumpulan pemikiran, gagasan, dan artikel dari para tokoh serta kader.</p>
        </div>

        <!-- Grid Cards Opini -->
        <?php if (!empty($opini) && is_array($opini)) : ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach ($opini as $item) : ?>
                    <article class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm hover:shadow-md transition flex flex-col">
                        <!-- Thumbnail -->
                        <a href="<?= base_url('opini/' . $item['slug']); ?>" class="block relative aspect-video overflow-hidden bg-slate-100">
                            <?php if ($item['gambar']) : ?>
                                <img src="<?= base_url('uploads/opini/' . $item['gambar']); ?>" alt="<?= esc($item['judul']); ?>" class="w-full h-full object-cover hover:scale-105 transition duration-300">
                            <?php else : ?>
                                <div class="w-full h-full flex items-center justify-center text-slate-400 bg-slate-100">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                    </svg>
                                </div>
                            <?php endif; ?>
                        </a>

                        <!-- Card Content -->
                        <div class="p-6 flex-1 flex flex-col justify-between">
                            <div>
                                <div class="flex items-center space-x-2 text-xs text-slate-500 mb-3">
                                    <span><?= date('d M Y', strtotime($item['tanggal'])); ?></span>
                                    <span>&bull;</span>
                                    <span><?= $item['views']; ?> views</span>
                                </div>
                                <h2 class="text-xl font-bold text-slate-800 hover:text-blue-600 transition line-clamp-2 mb-3">
                                    <a href="<?= base_url('opini/' . $item['slug']); ?>">
                                        <?= esc($item['judul']); ?>
                                    </a>
                                </h2>
                                <p class="text-slate-600 text-sm line-clamp-3 mb-4">
                                    <?= strip_tags($item['isi']); ?>
                                </p>
                            </div>

                            <!-- Penulis Info -->
                            <div class="pt-4 border-t border-slate-100 flex items-center space-x-3">
                                <div class="w-9 h-9 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-sm shrink-0">
                                    <?= strtoupper(substr($item['penulis'] ?? 'A', 0, 1)); ?>
                                </div>
                                <div class="truncate">
                                    <p class="text-xs font-semibold text-slate-800 truncate"><?= esc($item['penulis'] ?? 'Anonim'); ?></p>
                                    <p class="text-[11px] text-slate-500 truncate"><?= esc($item['profesi_penulis'] ?? '-'); ?></p>
                                </div>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>

            <!-- Pagination -->
            <div class="mt-12 flex justify-center">
                <?= $pager->links('opini', 'default_full') ?>
            </div>
        <?php else : ?>
            <div class="text-center py-16 bg-white rounded-2xl border border-slate-200">
                <p class="text-slate-500 font-medium">Belum ada opini yang dipublikasikan.</p>
            </div>
        <?php endif; ?>

    </div>
</div>
<?= $this->endSection() ?>