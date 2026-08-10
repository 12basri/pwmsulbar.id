<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<!-- Breadcrumb & Header -->
<div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between">
    <div>
        <div class="flex items-center space-x-2 text-xs text-slate-400 mb-1">
            <a href="<?= base_url('admin/profil/tentang-kami') ?>" class="hover:text-slate-600">Tentang Kami</a>
            <span>/</span>
            <span class="text-slate-600 font-medium">Edit Informasi</span>
        </div>
        <h2 class="text-2xl font-bold text-slate-800">Edit Profil Tentang Kami</h2>
    </div>
</div>

<!-- Flash Alert Error -->
<?php if (session()->getFlashdata('errors')) : ?>
    <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-sm flex items-start justify-between max-w-4xl">
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

<!-- Form Card -->
<div class="bg-white rounded-2xl p-6 md:p-8 border border-slate-200/80 shadow-sm max-w-4xl">
    <form action="<?= base_url('admin/profil/tentang-kami/update') ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
        <?= csrf_field() ?>

        <input type="hidden" name="id" value="<?= $tentangKami['id_tentang'] ?? '' ?>">

        <!-- Deskripsi -->
        <div>
            <label for="deskripsi" class="block text-sm font-semibold text-slate-700 mb-2">
                Gambaran Umum / Profil <span class="text-rose-500">*</span>
            </label>
            <textarea id="deskripsi" name="deskripsi" rows="6"
                class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:border-pwm-emerald focus:ring-1 focus:ring-pwm-emerald transition resize-y"
                placeholder="Tuliskan gambaran umum PWM Sulbar..." required><?= old('deskripsi', $tentangKami['deskripsi'] ?? '') ?></textarea>
        </div>

        <!-- Input Foto -->
        <div>
            <label for="foto" class="block text-sm font-semibold text-slate-700 mb-2">Foto / Gambar Sampul</label>
            
            <?php if (!empty($tentangKami['foto'])) : ?>
                <?php 
                $fotoPrev = str_contains($tentangKami['foto'], 'uploads/') 
                    ? $tentangKami['foto'] 
                    : 'uploads/profil/' . $tentangKami['foto'];
                ?>
                <div class="mb-3 flex items-center space-x-4">
                    <img src="<?= base_url($fotoPrev) ?>" alt="Foto Sekarang" class="w-24 h-24 object-cover rounded-xl border border-slate-200" onerror="this.onerror=null; this.src='https://placehold.co/100x100?text=Error';">
                    <span class="text-xs text-slate-500">Foto saat ini. Upload file baru untuk mengganti.</span>
                </div>
            <?php endif; ?>

            <input type="file" id="foto" name="foto" accept="image/png, image/jpeg, image/jpg, image/webp"
                class="w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200 transition cursor-pointer border border-slate-200 rounded-xl p-1">
            <p class="text-[11px] text-slate-400 mt-1.5">Format: JPG, JPEG, PNG, WEBP. Maksimal ukuran: 2MB.</p>
        </div>

        <hr class="border-slate-100 my-6">

        <!-- Action Buttons -->
        <div class="flex items-center justify-end space-x-3">
            <a href="<?= base_url('admin/profil/tentang-kami') ?>" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 font-medium text-sm rounded-xl transition">
                Batal
            </a>
            <button type="submit" class="px-6 py-2.5 bg-pwm-emerald hover:bg-emerald-700 text-white font-medium text-sm rounded-xl shadow-md transition flex items-center space-x-2 cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span>Simpan Perubahan</span>
            </button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>