<?= $this->extend('pages/layout/main') ?>

<?= $this->section('content') ?>

<!-- Hero Section -->
<section class="bg-gradient-to-r from-emerald-800 to-teal-900 text-white py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto text-center">
        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Direktori PDM Sulawesi Barat</h1>
        <p class="mt-3 text-base sm:text-lg text-emerald-100 max-w-2xl mx-auto">
            Daftar Pimpinan Daerah Muhammadiyah (PDM) se-Wilayah Sulawesi Barat beserta informasi kontak dan pimpinan.
        </p>
    </div>
</section>

<!-- Filter & Search Section -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-6">
    <div class="bg-white rounded-xl shadow-md p-4 sm:p-6 border border-slate-100">
        <form action="<?= base_url('pdm') ?>" method="GET" class="flex flex-col sm:flex-row gap-3">
            <div class="relative flex-1">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </span>
                <input type="text" name="q" value="<?= esc($keyword ?? '') ?>" placeholder="Cari PDM, Pimpinan, atau Kota/Kabupaten..." class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
            </div>
            <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-lg text-sm transition-colors flex items-center justify-center gap-2">
                <i class="fa-solid fa-filter"></i>
                <span>Cari PDM</span>
            </button>
            <?php if (!empty($keyword)): ?>
                <a href="<?= base_url('pdm') ?>" class="px-4 py-2.5 bg-slate-200 hover:bg-slate-300 text-slate-700 font-medium rounded-lg text-sm transition-colors flex items-center justify-center">
                    Reset
                </a>
            <?php endif; ?>
        </form>
    </div>
</section>

<!-- Grid Directory PDM -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <?php if (!empty($pdmList) && is_array($pdmList)): ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($pdmList as $item): ?>
                <div class="bg-white rounded-xl border border-slate-200/80 shadow-sm hover:shadow-md transition-all duration-200 flex flex-col overflow-hidden group">
                    <div class="p-6 flex-1 flex flex-col">
                        <div class="flex items-start gap-4 mb-4">
                            <div class="w-12 h-12 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl shrink-0 group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                                <i class="fa-solid fa-building-flag"></i>
                            </div>
                            <div>
                                <h2 class="font-bold text-slate-800 text-lg leading-snug group-hover:text-emerald-600 transition-colors">
                                    <?= esc($item['nama_pdm']) ?>
                                </h2>
                                <?php if (!empty($item['pimpinan'])): ?>
                                    <p class="text-xs text-slate-500 mt-1 flex items-center gap-1">
                                        <i class="fa-solid fa-user-tie text-emerald-600"></i>
                                        <span>Ketua: <strong><?= esc($item['pimpinan']) ?></strong></span>
                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <hr class="border-slate-100 my-2">

                        <div class="space-y-2 mt-2 text-xs text-slate-600 flex-1">
                            <?php if (!empty($item['alamat'])): ?>
                                <p class="flex items-start gap-2">
                                    <i class="fa-solid fa-location-dot text-emerald-600 mt-0.5 shrink-0"></i>
                                    <span><?= esc($item['alamat']) ?></span>
                                </p>
                            <?php endif; ?>

                            <?php if (!empty($item['telepon'])): ?>
                                <p class="flex items-center gap-2">
                                    <i class="fa-solid fa-phone text-emerald-600 shrink-0"></i>
                                    <span><?= esc($item['telepon']) ?></span>
                                </p>
                            <?php endif; ?>

                            <?php if (!empty($item['email'])): ?>
                                <p class="flex items-center gap-2">
                                    <i class="fa-solid fa-envelope text-emerald-600 shrink-0"></i>
                                    <span><?= esc($item['email']) ?></span>
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="px-6 py-3.5 bg-slate-50 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-xs font-semibold text-emerald-700 uppercase tracking-wider">Muhammadiyah</span>
                        <a href="<?= base_url('pdm/detail/' . $item['id_pdm']) ?>" class="text-xs font-medium text-slate-700 hover:text-emerald-600 inline-flex items-center gap-1 transition-colors">
                            <span>Detail Profil</span>
                            <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="bg-white rounded-xl p-12 text-center border border-slate-200">
            <i class="fa-solid fa-folder-open text-4xl text-slate-300 mb-3"></i>
            <h3 class="text-lg font-bold text-slate-700">Data PDM Tidak Ditemukan</h3>
            <p class="text-slate-500 text-sm mt-1">Belum ada data PDM yang terdaftar atau pencarian Anda tidak cocok.</p>
        </div>
    <?php endif; ?>
</section>

<?= $this->endSection() ?>