<?= $this->extend('pages/layout/main') ?>

<?= $this->section('content') ?>

<div class="max-w-7xl mx-auto px-4 py-8 mb-16 space-y-10">

    <!-- Header Halaman -->
    <div class="text-center max-w-3xl mx-auto space-y-4">
        <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
            Berita & Informasi Terkini
        </h1>
        <p class="text-slate-600 text-sm sm:text-base">
            Informasi, kegiatan, dan kabar terbaru seputar Pimpinan Wilayah Muhammadiyah Sulawesi Barat.
        </p>
    </div>

    <!-- Form Pencarian -->
    <div class="max-w-xl mx-auto">
        <form action="<?= base_url('berita') ?>" method="get" class="flex items-center gap-2">
            <div class="relative w-full">
                <input
                    type="text"
                    name="q"
                    value="<?= esc($keyword ?? '') ?>"
                    placeholder="Cari berita atau artikel..."
                    class="w-full pl-4 pr-10 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent text-sm">
            </div>
            <button
                type="submit"
                class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-medium text-sm rounded-xl transition duration-150 shrink-0">
                Cari
            </button>
        </form>
    </div>

    <!-- Grid Berita -->
    <?php if (!empty($berita) && is_array($berita)): ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($berita as $item): ?>
                <article class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex flex-col hover:shadow-md transition duration-200">
                    <!-- Sampul / Gambar Berita -->
                    <div class="h-48 w-full overflow-hidden bg-slate-100 relative">
                        <?php if (!empty($item['gambar'])): ?>
                            <img
                                src="<?= base_url('uploads/berita/' . $item['gambar']) ?>"
                                alt="<?= esc($item['judul']) ?>"
                                class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        <?php else: ?>
                            <div class="w-full h-full flex items-center justify-center text-slate-400 bg-slate-100">
                                <span class="text-xs">Tidak ada gambar</span>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Konten Berita -->
                    <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
                        <div class="space-y-2">
                            <div class="flex items-center gap-2 text-xs text-slate-500">
                                <?php if (!empty($item['penulis'])): ?>
                                    <span class="font-medium text-emerald-600">
                                        <?= esc($item['penulis']) ?>
                                    </span>
                                    <span>•</span>
                                <?php endif; ?>
                                <time datetime="<?= $item['tanggal'] ?? '' ?>">
                                    <?= !empty($item['tanggal']) ? date('d M Y', strtotime($item['tanggal'])) : '' ?>
                                </time>
                            </div>

                            <h2 class="text-lg font-bold text-slate-800 line-clamp-2 hover:text-emerald-600 transition">
                                <a href="<?= base_url('berita/' . ($item['slug'] ?? $item['id_berita'])) ?>">
                                    <?= esc($item['judul']) ?>
                                </a>
                            </h2>

                            <p class="text-xs text-slate-600 line-clamp-3 leading-relaxed">
                                <?= esc(strip_tags($item['isi'] ?? '')) ?>
                            </p>
                        </div>

                        <!-- Link Baca Selengkapnya -->
                        <div class="pt-2 border-t border-slate-100">
                            <a
                                href="<?= base_url('berita/' . ($item['slug'] ?? $item['id_berita'])) ?>"
                                class="inline-flex items-center text-xs font-semibold text-emerald-600 hover:text-emerald-700">
                                Baca Selengkapnya
                                <svg class="w-3.5 h-3.5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="p-12 bg-white rounded-2xl border border-slate-200 text-center max-w-lg mx-auto space-y-3">
            <p class="text-slate-600 text-sm font-medium">Belum ada berita yang diterbitkan.</p>
        </div>
    <?php endif; ?>

</div>

<?= $this->endSection() ?>