<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<!-- Header Section -->
<div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between">
    <div>
        <h2 class="text-2xl font-bold text-slate-800">Visi, Misi & Tujuan PWM</h2>
        <p class="text-sm text-slate-500">Kelola visi, misi, dan tujuan Pimpinan Wilayah Muhammadiyah Sulawesi Barat.</p>
    </div>
</div>

<!-- Flash Alert Sukses -->
<?php if (session()->getFlashdata('sukses')) : ?>
    <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-center justify-between">
        <div class="flex items-center space-x-2">
            <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span><?= session()->getFlashdata('sukses'); ?></span>
        </div>
        <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
<?php endif; ?>

<!-- Flash Alert Error Validasi / DB -->
<?php if (session()->getFlashdata('errors')) : ?>
    <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-sm flex items-start justify-between">
        <div class="flex items-start space-x-2">
            <svg class="w-5 h-5 text-rose-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <div>
                <span class="font-semibold block mb-1">Terjadi Kesalahan:</span>
                <ul class="list-disc list-inside space-y-0.5 text-xs">
                    <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                        <li><?= esc($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <button type="button" onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-700">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
<?php endif; ?>

<!-- Main Form Card -->
<div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden p-6">
    <form action="<?= base_url('admin/profil/update-visi-misi'); ?>" method="post" class="space-y-5">
        <?= csrf_field(); ?>

        <!-- Hidden input untuk ID Visi Misi -->
        <input type="hidden" name="id_visi" value="<?= $visiMisi['id_visi'] ?? ''; ?>">

        <!-- Input Visi -->
        <div>
            <label for="visi" class="block text-xs font-semibold text-slate-700 mb-1">
                Visi Organisasi <span class="text-rose-500">*</span>
            </label>
            <textarea
                name="visi"
                id="visi"
                rows="4"
                class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-pwm-emerald transition"
                placeholder="Tuliskan Visi PWM Sulbar di sini..."
                required><?= old('visi', $visiMisi['visi'] ?? ''); ?></textarea>
        </div>

        <!-- Input Misi -->
        <div>
            <label for="misi" class="block text-xs font-semibold text-slate-700 mb-1">
                Misi Organisasi <span class="text-rose-500">*</span>
            </label>
            <p class="text-[11px] text-slate-400 mb-1.5">Gunakan format poin-poin atau paragraf untuk menjabarkan Misi.</p>
            <textarea
                name="misi"
                id="misi"
                rows="6"
                class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-pwm-emerald transition"
                placeholder="Tuliskan Misi PWM Sulbar di sini..."
                required><?= old('misi', $visiMisi['misi'] ?? ''); ?></textarea>
        </div>

        <!-- Input Tujuan -->
        <div>
            <label for="tujuan" class="block text-xs font-semibold text-slate-700 mb-1">
                Tujuan Organisasi <span class="text-rose-500">*</span>
            </label>
            <p class="text-[11px] text-slate-400 mb-1.5">Gunakan format poin-poin atau paragraf untuk menjabarkan Tujuan.</p>
            <textarea
                name="tujuan"
                id="tujuan"
                rows="6"
                class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-pwm-emerald transition"
                placeholder="Tuliskan Tujuan PWM Sulbar di sini..."
                required><?= old('tujuan', $visiMisi['tujuan'] ?? ''); ?></textarea>
        </div>

        <!-- Tombol Aksi -->
        <div class="flex justify-end space-x-3 pt-4 border-t border-slate-100">
            <button type="reset" class="px-4 py-2 text-sm font-medium text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition cursor-pointer flex items-center space-x-1.5">
                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                <span>Reset</span>
            </button>
            <button type="submit" class="px-5 py-2 text-sm font-medium text-white bg-pwm-emerald hover:bg-emerald-700 rounded-xl shadow-md transition cursor-pointer flex items-center space-x-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span>Simpan Perubahan</span>
            </button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>