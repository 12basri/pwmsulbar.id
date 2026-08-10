<?= $this->extend('pages/layout/main') ?>

<?= $this->section('content') ?>
<?php helper('text'); ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <!-- Header & Search Bar -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10 border-b border-slate-100 pb-8">
        <div class="max-w-2xl">
            <span class="text-xs font-semibold uppercase tracking-wider text-emerald-600 bg-emerald-50 px-3 py-1 rounded-full border border-emerald-100">
                Direktori
            </span>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight mt-3">Direktori Majelis & Lembaga</h1>
            <p class="text-slate-600 mt-2 text-base leading-relaxed">
                Daftar Majelis dan Lembaga Pimpinan Wilayah Muhammadiyah Sulawesi Barat.
            </p>
        </div>
        <div class="w-full md:w-80">
            <form action="<?= base_url('majelis') ?>" method="get">
                <div class="relative flex items-center">
                    <input type="text"
                        name="q"
                        class="w-full pl-4 pr-24 py-2.5 rounded-xl border border-slate-200 bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent text-sm text-slate-800 placeholder-slate-400 shadow-sm transition"
                        placeholder="Cari majelis/lembaga..."
                        value="<?= esc($keyword ?? '') ?>">
                    <button type="submit"
                        class="absolute right-1.5 px-4 py-1.5 bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white font-medium text-xs rounded-lg transition duration-200 shadow-sm">
                        Cari
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php if (!empty($majelis) && is_array($majelis)): ?>
            <?php foreach ($majelis as $item): ?>
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-300 flex flex-col justify-between overflow-hidden group">
                    <div class="p-6">
                        <div class="mb-3">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/60">
                                <?= esc($item['jenis'] ?? 'Majelis/Lembaga') ?>
                            </span>
                        </div>
                        <h2 class="text-lg font-bold text-slate-800 group-hover:text-emerald-600 transition-colors duration-200 mb-2 leading-snug">
                            <?= esc($item['nama_majelis']) ?>
                        </h2>
                        <p class="text-slate-600 text-sm leading-relaxed line-clamp-3">
                            <?= esc(character_limiter(strip_tags($item['deskripsi_singkat'] ?? $item['deskripsi'] ?? ''), 100)) ?>
                        </p>
                    </div>
                    <div class="px-6 pb-6 pt-0">
                        <a href="<?= base_url('majelis/detail/' . ($item['id_majelis'] ?? $item['id'])) ?>"
                            class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-slate-50 hover:bg-emerald-600 text-slate-700 hover:text-white font-semibold text-xs rounded-xl transition duration-200 group/btn border border-slate-200/80 hover:border-emerald-600 shadow-sm">
                            <span>Lihat Profil & Pengurus</span>
                            <svg class="w-4 h-4 transition-transform group-hover/btn:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-span-full bg-slate-50 border border-dashed border-slate-300 rounded-2xl p-12 text-center">
                <div class="w-12 h-12 mx-auto bg-slate-100 rounded-full flex items-center justify-center text-slate-400 mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <h3 class="text-base font-semibold text-slate-800">Data Tidak Ditemukan</h3>
                <p class="text-sm text-slate-500 mt-1">Data majelis atau lembaga yang Anda cari tidak tersedia.</p>
            </div>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>