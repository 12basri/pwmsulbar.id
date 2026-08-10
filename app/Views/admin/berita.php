<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<!-- Header Section -->
<div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
        <h2 class="text-2xl font-bold text-slate-800">Manajemen Berita</h2>
        <p class="text-sm text-slate-500">Kelola berita dan artikel Pimpinan Wilayah Muhammadiyah Sulawesi Barat.</p>
    </div>
    <div>
        <button type="button" onclick="openModalTambah()" class="px-4 py-2.5 text-sm font-medium text-white bg-pwm-emerald hover:bg-emerald-700 rounded-xl shadow-md transition cursor-pointer flex items-center space-x-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            <span>Tambah Berita</span>
        </button>
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

<!-- Flash Alert Error Validasi -->
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

<!-- Main Table Card -->
<div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200/80 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                    <th class="py-3.5 px-4 text-center w-12">#</th>
                    <th class="py-3.5 px-4">Gambar</th>
                    <th class="py-3.5 px-4">Judul & Slug</th>
                    <th class="py-3.5 px-4">Penulis</th>
                    <th class="py-3.5 px-4">Tanggal</th>
                    <th class="py-3.5 px-4">Status</th>
                    <th class="py-3.5 px-4 text-center w-32">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm">
                <?php if (!empty($beritaList)) : ?>
                    <?php foreach ($beritaList as $index => $row) : ?>
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="py-3 px-4 text-center text-slate-400 font-medium"><?= $index + 1 ?></td>
                            <td class="py-3 px-4">
                                <img src="<?= base_url('uploads/berita/' . esc($row['gambar'] ?? 'default.jpg')) ?>"
                                    alt="Gambar Berita"
                                    class="w-12 h-12 rounded-lg object-cover border border-slate-200">
                            </td>
                            <td class="py-3 px-4">
                                <span class="font-medium text-slate-800 line-clamp-1"><?= esc($row['judul']) ?></span>
                                <span class="text-xs text-slate-400 block mt-0.5">/<?= esc($row['slug'] ?? '') ?></span>
                            </td>
                            <td class="py-3 px-4 text-slate-600 font-medium"><?= esc($row['penulis']) ?></td>
                            <td class="py-3 px-4 text-slate-500 text-xs"><?= date('d M Y', strtotime($row['tanggal'])) ?></td>
                            <td class="py-3 px-4">
                                <?php if ($row['status'] === 'Publish') : ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                        Publish
                                    </span>
                                <?php else : ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-600">
                                        Draft
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="py-3 px-4 text-center">
                                <div class="flex items-center justify-center space-x-2">
                                    <!-- Tombol Edit -->
                                    <button type="button"
                                        onclick="openModalEdit(<?= htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8') ?>)"
                                        class="p-1.5 text-slate-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition"
                                        title="Edit Berita">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>

                                    <!-- Tombol Hapus -->
                                    <a href="<?= base_url('admin/berita/hapus/' . $row['id_berita']); ?>"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus berita ini?')"
                                        class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition"
                                        title="Hapus Berita">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="7" class="py-8 text-center text-slate-400 text-sm">
                            Belum ada data berita yang ditambahkan.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah Berita -->
<div id="modalTambah" class="fixed inset-0 z-50 hidden overflow-y-auto bg-slate-900/50 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="relative w-full max-w-2xl bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden my-8">
        <div class="flex items-center justify-between p-5 border-b border-slate-100 bg-slate-50/50">
            <h3 class="text-base font-bold text-slate-800">Tambah Berita Baru</h3>
            <button type="button" onclick="closeModalTambah()" class="text-slate-400 hover:text-slate-600 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <form action="<?= base_url('admin/berita/simpan'); ?>" method="post" enctype="multipart/form-data" class="p-6 space-y-4">
            <?= csrf_field(); ?>

            <div>
                <label for="judul" class="block text-xs font-semibold text-slate-700 mb-1">
                    Judul Berita <span class="text-rose-500">*</span>
                </label>
                <input type="text" name="judul" id="judul" required placeholder="Tuliskan judul berita..."
                    class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-pwm-emerald transition">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="penulis" class="block text-xs font-semibold text-slate-700 mb-1">
                        Penulis / Redaksi <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="penulis" id="penulis" required placeholder="Nama penulis..."
                        class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-pwm-emerald transition">
                </div>

                <div>
                    <label for="tanggal" class="block text-xs font-semibold text-slate-700 mb-1">
                        Tanggal Terbit <span class="text-rose-500">*</span>
                    </label>
                    <input type="date" name="tanggal" id="tanggal" value="<?= date('Y-m-d'); ?>" required
                        class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-pwm-emerald transition">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="status" class="block text-xs font-semibold text-slate-700 mb-1">
                        Status Terbit <span class="text-rose-500">*</span>
                    </label>
                    <select name="status" id="status" class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-pwm-emerald transition">
                        <option value="Draft">Draft</option>
                        <option value="Publish">Publish</option>
                    </select>
                </div>

                <div>
                    <label for="gambar" class="block text-xs font-semibold text-slate-700 mb-1">
                        Gambar Utama
                    </label>
                    <input type="file" name="gambar" id="gambar" accept="image/*"
                        class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-pwm-emerald hover:file:bg-emerald-100 transition border border-slate-200 rounded-xl bg-slate-50">
                </div>
            </div>

            <div>
                <label for="isi" class="block text-xs font-semibold text-slate-700 mb-1">
                    Isi Berita <span class="text-rose-500">*</span>
                </label>
                <textarea name="isi" id="isi" rows="5" required placeholder="Tuliskan artikel/berita lengkap di sini..."
                    class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-pwm-emerald transition"></textarea>
            </div>

            <div class="flex justify-end space-x-3 pt-4 border-t border-slate-100">
                <button type="button" onclick="closeModalTambah()" class="px-4 py-2 text-sm font-medium text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition cursor-pointer">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2 text-sm font-medium text-white bg-pwm-emerald hover:bg-emerald-700 rounded-xl shadow-md transition cursor-pointer flex items-center space-x-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>Simpan Berita</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Berita -->
<div id="modalEdit" class="fixed inset-0 z-50 hidden overflow-y-auto bg-slate-900/50 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="relative w-full max-w-2xl bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden my-8">
        <div class="flex items-center justify-between p-5 border-b border-slate-100 bg-slate-50/50">
            <h3 class="text-base font-bold text-slate-800">Edit Berita</h3>
            <button type="button" onclick="closeModalEdit()" class="text-slate-400 hover:text-slate-600 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <form id="formEdit" method="post" enctype="multipart/form-data" class="p-6 space-y-4">
            <?= csrf_field(); ?>

            <div>
                <label for="edit_judul" class="block text-xs font-semibold text-slate-700 mb-1">
                    Judul Berita <span class="text-rose-500">*</span>
                </label>
                <input type="text" name="judul" id="edit_judul" required
                    class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-pwm-emerald transition">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="edit_penulis" class="block text-xs font-semibold text-slate-700 mb-1">
                        Penulis / Redaksi <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="penulis" id="edit_penulis" required
                        class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-pwm-emerald transition">
                </div>

                <div>
                    <label for="edit_tanggal" class="block text-xs font-semibold text-slate-700 mb-1">
                        Tanggal Terbit <span class="text-rose-500">*</span>
                    </label>
                    <input type="date" name="tanggal" id="edit_tanggal" required
                        class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-pwm-emerald transition">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="edit_status" class="block text-xs font-semibold text-slate-700 mb-1">
                        Status Terbit <span class="text-rose-500">*</span>
                    </label>
                    <select name="status" id="edit_status" class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-pwm-emerald transition">
                        <option value="Draft">Draft</option>
                        <option value="Publish">Publish</option>
                    </select>
                </div>

                <div>
                    <label for="edit_gambar" class="block text-xs font-semibold text-slate-700 mb-1">
                        Ganti Gambar <span class="text-xs font-normal text-slate-400">(Opsional)</span>
                    </label>
                    <input type="file" name="gambar" id="edit_gambar" accept="image/*"
                        class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-pwm-emerald hover:file:bg-emerald-100 transition border border-slate-200 rounded-xl bg-slate-50">
                </div>
            </div>

            <div>
                <label for="edit_isi" class="block text-xs font-semibold text-slate-700 mb-1">
                    Isi Berita <span class="text-rose-500">*</span>
                </label>
                <textarea name="isi" id="edit_isi" rows="5" required
                    class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-pwm-emerald transition"></textarea>
            </div>

            <div class="flex justify-end space-x-3 pt-4 border-t border-slate-100">
                <button type="button" onclick="closeModalEdit()" class="px-4 py-2 text-sm font-medium text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition cursor-pointer">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2 text-sm font-medium text-white bg-pwm-emerald hover:bg-emerald-700 rounded-xl shadow-md transition cursor-pointer flex items-center space-x-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>Perbarui Berita</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Script Toggle Modal & Population Data -->
<script>
    function openModalTambah() {
        document.getElementById('modalTambah').classList.remove('hidden');
    }

    function closeModalTambah() {
        document.getElementById('modalTambah').classList.add('hidden');
    }

    function openModalEdit(data) {
        // Mengisi nilai form edit berdasarkan data row yang diklik
        document.getElementById('formEdit').action = "<?= base_url('admin/berita/update/'); ?>" + data.id_berita;
        document.getElementById('edit_judul').value = data.judul;
        document.getElementById('edit_penulis').value = data.penulis;
        document.getElementById('edit_tanggal').value = data.tanggal;
        document.getElementById('edit_status').value = data.status;
        document.getElementById('edit_isi').value = data.isi;

        document.getElementById('modalEdit').classList.remove('hidden');
    }

    function closeModalEdit() {
        document.getElementById('modalEdit').classList.add('hidden');
    }
</script>

<?= $this->endSection() ?>