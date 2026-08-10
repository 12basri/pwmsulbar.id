<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<!-- Header Section -->
<div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between">
    <div>
        <h2 class="text-2xl font-bold text-slate-800">Tentang Kami</h2>
        <p class="text-sm text-slate-500">Kelola informasi profil Pimpinan Wilayah Muhammadiyah Sulawesi Barat.</p>
    </div>
    <div class="mt-4 md:mt-0">
        <a href="<?= base_url('admin/profil/tentang-kami/edit') ?>" class="px-5 py-2.5 bg-pwm-emerald hover:bg-emerald-700 text-white font-medium text-sm rounded-xl shadow-md transition flex items-center space-x-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
            </svg>
            <span>Edit Informasi</span>
        </a>
    </div>
</div>

<!-- Pesan Sukses -->
<?php if (session()->getFlashdata('sukses')) : ?>
    <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm flex items-center justify-between">
        <span><?= session()->getFlashdata('sukses') ?></span>
        <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
<?php endif; ?>

<!-- Main Content Card -->
<div class="bg-white rounded-2xl p-6 md:p-8 border border-slate-200/80 shadow-sm space-y-6">

    <!-- Tampilkan Foto jika ada -->
    <?php if (!empty($tentangKami['foto'])) : ?>
        <?php 
        $fotoPath = str_contains($tentangKami['foto'], 'uploads/') 
            ? $tentangKami['foto'] 
            : 'uploads/profil/' . $tentangKami['foto'];
        ?>
        <div class="overflow-hidden rounded-xl max-h-96 border border-slate-100 flex justify-center bg-slate-50">
            <img src="<?= base_url($fotoPath) ?>" alt="Foto Tentang Kami" class="w-full max-h-96 object-cover" onerror="this.onerror=null; this.src='https://placehold.co/800x400?text=Gambar+Tidak+Ditemukan';">
        </div>
    <?php endif; ?>

    <div>
        <h3 class="text-lg font-bold text-slate-800 mb-2">Gambaran Umum</h3>
        <div class="text-slate-600 text-sm leading-relaxed space-y-3">
            <?= !empty($tentangKami['deskripsi']) ? nl2br(esc($tentangKami['deskripsi'])) : '<p class="italic text-slate-400">Belum ada deskripsi yang diisi.</p>' ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>