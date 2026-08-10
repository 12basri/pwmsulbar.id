<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<!-- Header Section -->
<div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between">
    <div>
        <h2 class="text-2xl font-bold text-slate-800">Kelola Refleksi</h2>
        <p class="text-sm text-slate-500">Kelola data refleksi dan catat ide atau pemikiran Pimpinan Wilayah Muhammadiyah Sulawesi Barat.</p>
    </div>
    <div class="mt-4 md:mt-0">
        <button type="button" onclick="openModalTambah()" class="px-4 py-2 text-sm font-medium text-white bg-pwm-emerald hover:bg-emerald-700 rounded-xl shadow-md transition cursor-pointer flex items-center space-x-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            <span>Tambah Refleksi</span>
        </button>
    </div>
</div>

<!-- Flash Alert Sukses (Mendukung 'success' & 'sukses') -->
<?php if (session()->getFlashdata('success') || session()->getFlashdata('sukses')) : ?>
    <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-center justify-between">
        <div class="flex items-center space-x-2">
            <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span><?= session()->getFlashdata('success') ?? session()->getFlashdata('sukses'); ?></span>
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

<!-- Tabel Data Refleksi Card -->
<div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200 text-xs font-semibold text-slate-600 uppercase tracking-wider">
                    <th class="px-6 py-3.5 w-16">No</th>
                    <th class="px-6 py-3.5">Judul Refleksi</th>
                    <th class="px-6 py-3.5">Isi Ringkas</th>
                    <th class="px-6 py-3.5">Penulis</th>
                    <th class="px-6 py-3.5">Tanggal</th>
                    <th class="px-6 py-3.5 text-right w-36">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                <?php if (!empty($dataRefleksi)) : ?>
                    <?php foreach ($dataRefleksi as $index => $item) : ?>
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="px-6 py-4 font-medium text-slate-500"><?= $index + 1; ?></td>
                            <td class="px-6 py-4 font-semibold text-slate-800"><?= esc($item['judul']); ?></td>
                            <td class="px-6 py-4 text-slate-500 max-w-xs truncate"><?= esc(substr($item['isi'], 0, 90)); ?>...</td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 text-xs font-medium rounded-lg bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    <?= esc($item['penulis'] ?? 'Admin'); ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 text-slate-500 text-xs"><?= date('d M Y', strtotime($item['created_at'])); ?></td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end space-x-1">
                                    <!-- Tombol Edit Data (Memanggil modal yang sama) -->
                                    <button type="button"
                                        onclick="openModalEdit(<?= htmlspecialchars(json_encode($item)); ?>)"
                                        class="p-2 text-amber-600 hover:bg-amber-50 rounded-xl transition"
                                        title="Edit Data">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>

                                    <!-- Tombol Hapus Data (Diganti dari item['id'] menjadi item['id_refleksi']) -->
                                    <a href="<?= base_url('admin/refleksi/hapus/' . $item['id_refleksi']); ?>"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus data refleksi ini?')"
                                        class="p-2 text-rose-600 hover:bg-rose-50 rounded-xl transition" title="Hapus Data">
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
                        <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                            <svg class="w-12 h-12 mx-auto text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                            <span>Belum ada data refleksi yang ditambahkan.</span>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Form Tambah & Edit Refleksi -->
<div id="modalRefleksi" class="fixed inset-0 z-50 hidden overflow-y-auto bg-slate-900/40 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xl w-full max-w-xl overflow-hidden transform transition-all">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <h3 id="modalTitle" class="text-base font-bold text-slate-800">Tambah Refleksi Baru</h3>
            <button type="button" onclick="closeModal()" class="text-slate-400 hover:text-slate-600 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <form action="<?= base_url('admin/refleksi/simpan'); ?>" method="post" class="p-6 space-y-4">
            <?= csrf_field(); ?>

            <!-- Input Hidden ID untuk membedakan Insert / Update -->
            <input type="hidden" name="id_refleksi" id="id_refleksi" value="">

            <!-- Input Judul -->
            <div>
                <label for="judul" class="block text-xs font-semibold text-slate-700 mb-1">
                    Judul Refleksi <span class="text-rose-500">*</span>
                </label>
                <input type="text" name="judul" id="judul" required
                    class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-pwm-emerald transition"
                    placeholder="Masukkan judul refleksi...">
            </div>

            <!-- Input Isi Refleksi -->
            <div>
                <label for="isi" class="block text-xs font-semibold text-slate-700 mb-1">
                    Isi Refleksi <span class="text-rose-500">*</span>
                </label>
                <textarea name="isi" id="isi" rows="6" required
                    class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-pwm-emerald transition"
                    placeholder="Tuliskan isi refleksi di sini..."></textarea>
            </div>

            <!-- Tombol Aksi Modal -->
            <div class="flex justify-end space-x-3 pt-4 border-t border-slate-100">
                <button type="button" onclick="closeModal()" class="px-4 py-2 text-sm font-medium text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition cursor-pointer">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2 text-sm font-medium text-white bg-pwm-emerald hover:bg-emerald-700 rounded-xl shadow-md transition cursor-pointer flex items-center space-x-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>Simpan Data</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const modal = document.getElementById('modalRefleksi');
    const modalTitle = document.getElementById('modalTitle');
    const inputId = document.getElementById('id_refleksi');
    const inputJudul = document.getElementById('judul');
    const inputIsi = document.getElementById('isi');

    // Buka Modal Mode Tambah
    function openModalTambah() {
        modalTitle.textContent = 'Tambah Refleksi Baru';
        inputId.value = '';
        inputJudul.value = '';
        inputIsi.value = '';
        modal.classList.remove('hidden');
    }

    // Buka Modal Mode Edit (Otomatis Mengisi Form)
    function openModalEdit(data) {
        modalTitle.textContent = 'Edit Data Refleksi';
        inputId.value = data.id_refleksi;
        inputJudul.value = data.judul;
        inputIsi.value = data.isi;
        modal.classList.remove('hidden');
    }

    // Tutup Modal
    function closeModal() {
        modal.classList.add('hidden');
    }
</script>

<?= $this->endSection() ?>