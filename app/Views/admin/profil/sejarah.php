<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<!-- Header Section -->
<div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between">
    <div>
        <h2 class="text-2xl font-bold text-slate-800">Sejarah PWM</h2>
        <p class="text-sm text-slate-500">Kelola timeline dan riwayat sejarah Pimpinan Wilayah Muhammadiyah Sulawesi Barat.</p>
    </div>
    <div class="mt-4 md:mt-0">
        <button type="button" onclick="openModal('modalTambah')" class="px-5 py-2.5 bg-pwm-emerald hover:bg-emerald-700 text-white font-medium text-sm rounded-xl shadow-md transition flex items-center space-x-2 cursor-pointer">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            <span>Tambah Sejarah</span>
        </button>
    </div>
</div>

<!-- Flash Alert Notification -->
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

<!-- Main Table Card -->
<div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-slate-600">
            <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wider text-slate-500 border-b border-slate-200/80">
                <tr>
                    <th class="px-6 py-4 w-12">No</th>
                    <th class="px-6 py-4">Gambar</th>
                    <th class="px-6 py-4">Tahun / Periode</th>
                    <th class="px-6 py-4">Judul Sejarah</th>
                    <th class="px-6 py-4">Tanggal Buat</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php if (!empty($sejarah)) : ?>
                    <?php $no = 1;
                    foreach ($sejarah as $row) : ?>
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="px-6 py-4 font-semibold text-slate-700"><?= $no++; ?></td>
                            <td class="px-6 py-4">
                                <?php if (!empty($row['gambar'])) : ?>
                                    <?php
                                    // LOGIKA PERBAIKAN: Menangani data lama & baru
                                    $srcGambar = (strpos($row['gambar'], 'uploads/') !== false)
                                        ? base_url($row['gambar'])
                                        : base_url('uploads/sejarah/' . $row['gambar']);
                                    ?>
                                    <img src="<?= $srcGambar; ?>" alt="Gambar Sejarah" class="w-14 h-10 object-cover rounded-lg border border-slate-200">
                                <?php else : ?>
                                    <span class="px-2.5 py-1 text-xs font-medium text-slate-400 bg-slate-100 rounded-md border border-slate-200">No Image</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 text-xs font-mono font-semibold text-emerald-800 bg-emerald-50 rounded-lg border border-emerald-200/60">
                                    <?= htmlspecialchars($row['tahun']); ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 font-medium text-slate-800">
                                <?= htmlspecialchars($row['judul']); ?>
                            </td>
                            <td class="px-6 py-4 text-xs text-slate-500">
                                <?= date('d M Y', strtotime($row['created_at'])); ?>
                            </td>
                            <td class="px-6 py-4 text-right space-x-1">
                                <!-- Edit Button -->
                                <button type="button" onclick="openModal('modalEdit<?= $row['id_sejarah']; ?>')" class="p-2 text-amber-600 hover:bg-amber-50 rounded-lg transition inline-flex items-center justify-center cursor-pointer" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                </button>
                                <!-- Delete Button -->
                                <a href="<?= base_url('admin/profil/sejarah/hapus/' . $row['id_sejarah']); ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus data sejarah ini?')" class="p-2 text-rose-600 hover:bg-rose-50 rounded-lg transition inline-flex items-center justify-center" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </a>
                            </td>
                        </tr>

                        <!-- MODAL EDIT DATA SEJARAH -->
                        <div id="modalEdit<?= $row['id_sejarah']; ?>" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
                            <div class="bg-white rounded-2xl max-w-2xl w-full p-6 shadow-xl border border-slate-200 space-y-5">
                                <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                                    <h3 class="text-lg font-bold text-slate-800">Edit Sejarah PWM</h3>
                                    <button type="button" onclick="closeModal('modalEdit<?= $row['id_sejarah']; ?>')" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                                <form action="<?= base_url('admin/profil/sejarah/update/' . $row['id_sejarah']); ?>" method="post" enctype="multipart/form-data" class="space-y-4">
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <div class="md:col-span-2">
                                            <label class="block text-xs font-semibold text-slate-700 mb-1">Judul Sejarah <span class="text-rose-500">*</span></label>
                                            <input type="text" name="judul" value="<?= htmlspecialchars($row['judul']); ?>" class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-pwm-emerald transition" required>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold text-slate-700 mb-1">Tahun / Periode <span class="text-rose-500">*</span></label>
                                            <input type="text" name="tahun" value="<?= htmlspecialchars($row['tahun']); ?>" class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-pwm-emerald transition" placeholder="Contoh: 1912" required>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700 mb-1">Isi / Detail Sejarah <span class="text-rose-500">*</span></label>
                                        <textarea name="isi" rows="5" class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-pwm-emerald transition" required><?= $row['isi']; ?></textarea>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700 mb-1">Gambar Utama</label>
                                        <input type="file" name="gambar" accept="image/*" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 transition cursor-pointer">
                                        <p class="text-[11px] text-slate-400 mt-1">Biarkan kosong jika tidak ingin mengubah gambar.</p>

                                        <?php if (!empty($row['gambar'])) : ?>
                                            <?php
                                            // LOGIKA PERBAIKAN: Menangani gambar modal edit
                                            $srcGambarEdit = (strpos($row['gambar'], 'uploads/') !== false)
                                                ? base_url($row['gambar'])
                                                : base_url('uploads/sejarah/' . $row['gambar']);
                                            ?>
                                            <div class="mt-2 flex items-center space-x-3">
                                                <span class="text-xs text-slate-500">Gambar saat ini:</span>
                                                <img src="<?= $srcGambarEdit; ?>" class="w-12 h-10 object-cover rounded-lg border border-slate-200">
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="flex justify-end space-x-3 pt-4 border-t border-slate-100">
                                        <button type="button" onclick="closeModal('modalEdit<?= $row['id_sejarah']; ?>')" class="px-4 py-2 text-sm font-medium text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition cursor-pointer">Batal</button>
                                        <button type="submit" class="px-5 py-2 text-sm font-medium text-white bg-amber-500 hover:bg-amber-600 rounded-xl shadow-md transition cursor-pointer">Simpan Perubahan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- END MODAL EDIT -->

                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-slate-400 text-sm">
                            Belum ada data sejarah yang ditambahkan.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- MODAL TAMBAH DATA SEJARAH -->
<div id="modalTambah" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-2xl w-full p-6 shadow-xl border border-slate-200 space-y-5">
        <div class="flex items-center justify-between pb-4 border-b border-slate-100">
            <h3 class="text-lg font-bold text-slate-800">Tambah Sejarah PWM Baru</h3>
            <button type="button" onclick="closeModal('modalTambah')" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <form action="<?= base_url('admin/profil/sejarah/simpan') ?>" method="post" enctype="multipart/form-data">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Judul Sejarah <span class="text-rose-500">*</span></label>
                    <input type="text" name="judul" class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-pwm-emerald transition" placeholder="Masukkan judul periode/peristiwa" required>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Tahun / Periode <span class="text-rose-500">*</span></label>
                    <input type="text" name="tahun" class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-pwm-emerald transition" placeholder="Contoh: 1912" required>
                </div>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Isi / Detail Sejarah <span class="text-rose-500">*</span></label>
                <textarea name="isi" rows="5" class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-pwm-emerald transition" placeholder="Tuliskan cerita/sejarah di sini..."></textarea>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Upload Gambar</label>
                <input type="file" name="gambar" accept="image/*" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 transition cursor-pointer">
                <p class="text-[11px] text-slate-400 mt-1">Format: JPG, JPEG, PNG, WEBP (Max 2MB)</p>
            </div>
            <div class="flex justify-end space-x-3 pt-4 border-t border-slate-100">
                <button type="button" onclick="closeModal('modalTambah')" class="px-4 py-2 text-sm font-medium text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition cursor-pointer">Batal</button>
                <button type="submit" class="px-5 py-2 text-sm font-medium text-white bg-pwm-emerald hover:bg-emerald-700 rounded-xl shadow-md transition cursor-pointer">Simpan Sejarah</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Toggle JavaScript -->
<script>
    function openModal(id) {
        const modal = document.getElementById(id);
        if (modal) modal.classList.remove('hidden');
    }

    function closeModal(id) {
        const modal = document.getElementById(id);
        if (modal) modal.classList.add('hidden');
    }
</script>

<?= $this->endSection() ?>