<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<!-- Header Section -->
<div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between">
    <div>
        <h2 class="text-2xl font-bold text-slate-800">Struktur Organisasi PWM</h2>
        <p class="text-sm text-slate-500">Kelola daftar pimpinan dan struktur kepengurusan PWM Sulawesi Barat.</p>
    </div>
    <div class="mt-4 md:mt-0">
        <button onclick="openModal('modalTambah')" class="px-4 py-2 text-sm font-medium text-white bg-pwm-emerald hover:bg-emerald-700 rounded-xl shadow-md transition flex items-center space-x-1.5 cursor-pointer">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            <span>Tambah Anggota</span>
        </button>
    </div>
</div>

<!-- Flash Alert Sukses / Gagal -->
<?php if (session()->getFlashdata('sukses')) : ?>
    <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-center justify-between">
        <span><?= session()->getFlashdata('sukses'); ?></span>
        <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">✕</button>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('gagal')) : ?>
    <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-sm flex items-center justify-between">
        <span><?= session()->getFlashdata('gagal'); ?></span>
        <button type="button" onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-700">✕</button>
    </div>
<?php endif; ?>

<!-- Main Table Card -->
<div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200 text-xs font-semibold text-slate-600 uppercase tracking-wider">
                    <th class="py-3 px-4 text-center w-16">Urutan</th>
                    <th class="py-3 px-4 w-20 text-center">Foto</th>
                    <th class="py-3 px-4">Nama Lengkap & Gelar</th>
                    <th class="py-3 px-4">Jabatan</th>
                    <th class="py-3 px-4 text-center w-28">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                <?php if (empty($struktur)) : ?>
                    <tr>
                        <td colspan="5" class="py-8 text-center text-slate-400">Belum ada data struktur organisasi.</td>
                    </tr>
                <?php else : ?>
                    <?php foreach ($struktur as $row) : ?>
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="py-3 px-4 text-center font-semibold text-slate-500"><?= $row['urutan']; ?></td>
                            <td class="py-3 px-4 text-center">
                                <?php if ($row['foto'] && is_file(FCPATH . 'uploads/struktur/' . $row['foto'])) : ?>
                                    <img src="<?= base_url('uploads/struktur/' . $row['foto']); ?>" alt="Foto" class="w-10 h-10 object-cover rounded-full mx-auto border border-slate-200">
                                <?php else : ?>
                                    <div class="w-10 h-10 rounded-full bg-slate-200 flex items-center justify-center text-slate-500 font-bold mx-auto text-xs">
                                        <?= strtoupper(substr($row['nama'], 0, 2)); ?>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td class="py-3 px-4 font-medium text-slate-800"><?= esc($row['nama']); ?></td>
                            <td class="py-3 px-4 text-slate-600"><?= esc($row['jabatan']); ?></td>
                            <td class="py-3 px-4 text-center space-x-2">
                                <button onclick="openEditModal(<?= htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8'); ?>)" class="p-1.5 bg-amber-50 text-amber-600 hover:bg-amber-100 rounded-lg transition" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                                <a href="<?= base_url('admin/profil/struktur-organisasi/hapus/' . $row['id_struktur']); ?>" onclick="return confirm('Yakin ingin menghapus data ini?')" class="p-1.5 bg-rose-50 text-rose-600 hover:bg-rose-100 rounded-lg transition inline-block" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah -->
<div id="modalTambah" class="fixed inset-0 bg-slate-900/50 hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl w-full max-w-lg overflow-hidden shadow-xl">
        <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center">
            <h3 class="font-bold text-slate-800">Tambah Anggota Struktur</h3>
            <button onclick="closeModal('modalTambah')" class="text-slate-400 hover:text-slate-600">✕</button>
        </div>
        <form action="<?= base_url('admin/profil/struktur-organisasi/simpan'); ?>" method="post" enctype="multipart/form-data" class="p-6 space-y-4">
            <?= csrf_field(); ?>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Lengkap & Gelar *</label>
                <input type="text" name="nama" required class="w-full px-3 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Jabatan *</label>
                <input type="text" name="jabatan" required class="w-full px-3 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20" placeholder="Misal: Ketua Wilayah">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Nomor Urut Tampil *</label>
                <input type="number" name="urutan" value="1" required class="w-full px-3 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Foto (Opsional, Max 2MB)</label>
                <input type="file" name="foto" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
            </div>
            <div class="flex justify-end space-x-2 pt-4 border-t border-slate-100">
                <button type="button" onclick="closeModal('modalTambah')" class="px-4 py-2 text-sm font-medium text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl">Batal</button>
                <button type="submit" class="px-5 py-2 text-sm font-medium text-white bg-pwm-emerald hover:bg-emerald-700 rounded-xl shadow-md">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit -->
<div id="modalEdit" class="fixed inset-0 bg-slate-900/50 hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl w-full max-w-lg overflow-hidden shadow-xl">
        <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center">
            <h3 class="font-bold text-slate-800">Edit Anggota Struktur</h3>
            <button onclick="closeModal('modalEdit')" class="text-slate-400 hover:text-slate-600">✕</button>
        </div>
        <form id="formEdit" method="post" enctype="multipart/form-data" class="p-6 space-y-4">
            <?= csrf_field(); ?>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Lengkap & Gelar *</label>
                <input type="text" name="nama" id="edit_nama" required class="w-full px-3 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Jabatan *</label>
                <input type="text" name="jabatan" id="edit_jabatan" required class="w-full px-3 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Nomor Urut Tampil *</label>
                <input type="number" name="urutan" id="edit_urutan" required class="w-full px-3 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Ganti Foto (Opsional)</label>
                <input type="file" name="foto" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                <span class="text-[11px] text-slate-400 block mt-1">Biarkan kosong jika tidak ingin mengubah foto.</span>
            </div>
            <div class="flex justify-end space-x-2 pt-4 border-t border-slate-100">
                <button type="button" onclick="closeModal('modalEdit')" class="px-4 py-2 text-sm font-medium text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl">Batal</button>
                <button type="submit" class="px-5 py-2 text-sm font-medium text-white bg-pwm-emerald hover:bg-emerald-700 rounded-xl shadow-md">Perbarui</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
    }

    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
    }

    function openEditModal(data) {
        document.getElementById('edit_nama').value = data.nama;
        document.getElementById('edit_jabatan').value = data.jabatan;
        document.getElementById('edit_urutan').value = data.urutan;
        document.getElementById('formEdit').action = "<?= base_url('admin/profil/struktur-organisasi/update/'); ?>" + data.id_struktur;
        openModal('modalEdit');
    }
</script>

<?= $this->endSection() ?>