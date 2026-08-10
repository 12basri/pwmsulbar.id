<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="p-6">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800"><?= esc($title) ?></h1>
            <p class="text-xs text-slate-500 mt-1">Kelola data sekolah dan madrasah Muhammadiyah se-Sulawesi Barat.</p>
        </div>
        <button onclick="openModalTambah()" class="inline-flex items-center gap-2 px-4 py-2.5 bg-pwm-emerald hover:bg-emerald-700 text-white text-sm font-semibold rounded-xl transition shadow-sm hover:shadow-md">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Sekolah
        </button>
    </div>

    <!-- Alert Flash Data -->
    <?php if (session()->getFlashdata('sukses')) : ?>
        <div class="mb-4 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm rounded-xl flex items-center justify-between">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                <span><?= session()->getFlashdata('sukses') ?></span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">&times;</button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('errors')) : ?>
        <div class="mb-4 p-4 bg-rose-50 border border-rose-200 text-rose-700 text-sm rounded-xl">
            <div class="font-semibold mb-1">Terjadi kesalahan input:</div>
            <ul class="list-disc list-inside text-xs space-y-1">
                <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <!-- Filter & Search Bar -->
    <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm mb-6">
        <form method="GET" action="<?= base_url('admin/sekolah') ?>" class="grid grid-cols-1 md:grid-cols-4 gap-3">
            <input type="text" name="q" value="<?= esc($keyword ?? '') ?>" placeholder="Cari sekolah, NPSN, kepsek..." class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-pwm-emerald transition">

            <select name="jenjang" class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-pwm-emerald transition">
                <option value="">-- Semua Jenjang --</option>
                <option value="SD" <?= ($filterJenjang ?? '') === 'SD' ? 'selected' : '' ?>>SD</option>
                <option value="MI" <?= ($filterJenjang ?? '') === 'MI' ? 'selected' : '' ?>>MI</option>
                <option value="SMP" <?= ($filterJenjang ?? '') === 'SMP' ? 'selected' : '' ?>>SMP</option>
                <option value="MTS" <?= ($filterJenjang ?? '') === 'MTS' ? 'selected' : '' ?>>MTs</option>
                <option value="SMA" <?= ($filterJenjang ?? '') === 'SMA' ? 'selected' : '' ?>>SMA</option>
                <option value="SMK" <?= ($filterJenjang ?? '') === 'SMK' ? 'selected' : '' ?>>SMK</option>
                <option value="MA" <?= ($filterJenjang ?? '') === 'MA' ? 'selected' : '' ?>>MA</option>
            </select>

            <select name="kabupaten" class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-pwm-emerald transition">
                <option value="">-- Semua Kabupaten --</option>
                <option value="Kab. Mamuju" <?= ($filterKabupaten ?? '') === 'Kab. Mamuju' ? 'selected' : '' ?>>Kab. Mamuju</option>
                <option value="Kab. Majene" <?= ($filterKabupaten ?? '') === 'Kab. Majene' ? 'selected' : '' ?>>Kab. Majene</option>
                <option value="Kab. Polewali Mandar" <?= ($filterKabupaten ?? '') === 'Kab. Polewali Mandar' ? 'selected' : '' ?>>Kab. Polewali Mandar</option>
                <option value="Kab. Pasangkayu" <?= ($filterKabupaten ?? '') === 'Kab. Pasangkayu' ? 'selected' : '' ?>>Kab. Pasangkayu</option>
                <option value="Kab. Mamuju Tengah" <?= ($filterKabupaten ?? '') === 'Kab. Mamuju Tengah' ? 'selected' : '' ?>>Kab. Mamuju Tengah</option>
                <option value="Kab. Mamasa" <?= ($filterKabupaten ?? '') === 'Kab. Mamasa' ? 'selected' : '' ?>>Kab. Mamasa</option>
            </select>

            <div class="flex items-center gap-2">
                <button type="submit" class="w-full py-2 px-4 bg-slate-800 hover:bg-slate-900 text-white text-sm font-medium rounded-xl transition">Filter</button>
                <a href="<?= base_url('admin/sekolah') ?>" class="py-2 px-3 bg-slate-100 hover:bg-slate-200 text-slate-600 text-sm font-medium rounded-xl transition">Reset</a>
            </div>
        </form>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-xs text-slate-500 uppercase tracking-wider">
                        <th class="py-3.5 px-4 font-semibold">Nama Sekolah</th>
                        <th class="py-3.5 px-4 font-semibold">Jenjang & Akreditasi</th>
                        <th class="py-3.5 px-4 font-semibold">Lokasi</th>
                        <th class="py-3.5 px-4 font-semibold">Kepala Sekolah</th>
                        <th class="py-3.5 px-4 font-semibold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php if (!empty($sekolahList)) : ?>
                        <?php foreach ($sekolahList as $row) : ?>
                            <?php $idSekolah = $row['id'] ?? $row['id_sekolah']; ?>
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="py-3 px-4">
                                    <div class="font-semibold text-slate-800"><?= esc($row['nama_sekolah']) ?></div>
                                    <div class="text-xs text-slate-400">NPSN: <?= esc($row['npsn'] ?? '-') ?></div>
                                </td>
                                <td class="py-3 px-4">
                                    <div class="flex items-center gap-1.5">
                                        <span class="px-2.5 py-0.5 text-xs font-semibold rounded-lg bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            <?= esc($row['jenjang']) ?>
                                        </span>
                                        <span class="px-2 py-0.5 text-[10px] font-semibold rounded bg-slate-100 text-slate-600">
                                            Akr: <?= esc($row['akreditasi'] ?? '-') ?>
                                        </span>
                                    </div>
                                </td>
                                <td class="py-3 px-4 text-xs text-slate-500 max-w-xs">
                                    <div class="font-medium text-slate-700"><?= esc($row['kabupaten_kota'] ?? '-') ?>, Kec. <?= esc($row['kecamatan'] ?? '-') ?></div>
                                    <div class="truncate text-slate-400"><?= esc($row['alamat'] ?? '-') ?></div>
                                </td>
                                <td class="py-3 px-4 font-medium text-slate-700 text-xs">
                                    <?= esc($row['kepala_sekolah'] ?? '-') ?>
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <button onclick='openModalEdit(<?= json_encode($row) ?>)' class="p-1.5 text-amber-600 hover:bg-amber-50 rounded-lg transition" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>
                                        <a href="<?= base_url('admin/sekolah/hapus/' . $idSekolah) ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus data sekolah ini?')" class="p-1.5 text-rose-600 hover:bg-rose-50 rounded-lg transition" title="Hapus">
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
                            <td colspan="5" class="py-8 text-center text-slate-400 text-sm">Belum ada data sekolah yang tersimpan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Paginasi Disertai Styling CSS Flexbox -->
        <?php if (isset($pager) && $pager->getPageCount('sekolah') > 1) : ?>
            <div class="p-4 border-t border-slate-100 flex justify-end pagination-wrapper">
                <?= $pager->links('sekolah', 'default_full') ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Modal Tambah -->
<div id="modalTambah" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 flex items-center justify-center hidden p-4">
    <div class="bg-white rounded-2xl max-w-xl w-full p-6 shadow-2xl max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between pb-4 border-b border-slate-100">
            <h3 class="text-lg font-bold text-slate-800">Tambah Data Sekolah</h3>
            <button onclick="closeModalTambah()" class="text-slate-400 hover:text-slate-600 text-xl font-bold">&times;</button>
        </div>
        <form action="<?= base_url('admin/sekolah/simpan') ?>" method="POST" class="space-y-4 mt-4">
            <?= csrf_field() ?>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Sekolah <span class="text-rose-500">*</span></label>
                <input type="text" name="nama_sekolah" required class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-pwm-emerald transition">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">NPSN</label>
                    <input type="text" name="npsn" placeholder="Contoh: 10801234" class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-pwm-emerald transition">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Jenjang <span class="text-rose-500">*</span></label>
                    <select name="jenjang" required class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-pwm-emerald transition">
                        <option value="" disabled selected>Pilih Jenjang</option>
                        <option value="SD">SD</option>
                        <option value="MI">MI</option>
                        <option value="SMP">SMP</option>
                        <option value="SMP">MTs</option>
                        <option value="SMA">SMA</option>
                        <option value="SMK">SMK</option>
                        <option value="MA">MA</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Akreditasi</label>
                    <select name="akreditasi" class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-pwm-emerald transition">
                        <option value="A">A (Unggul)</option>
                        <option value="B">B (Baik)</option>
                        <option value="C">C (Cukup)</option>
                        <option value="Belum Akreditasi" selected>Belum Akreditasi</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Kabupaten / Kota <span class="text-rose-500">*</span></label>
                    <select name="kabupaten_kota" required class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-pwm-emerald transition">
                        <option value="" disabled selected>Pilih Kabupaten/Kota</option>
                        <option value="Kab. Mamuju">Kab. Mamuju</option>
                        <option value="Kab. Majene">Kab. Majene</option>
                        <option value="Kab. Polewali Mandar">Kab. Polewali Mandar</option>
                        <option value="Kab. Pasangkayu">Kab. Pasangkayu</option>
                        <option value="Kab. Mamuju Tengah">Kab. Mamuju Tengah</option>
                        <option value="Kab. Mamasa">Kab. Mamasa</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Kecamatan <span class="text-rose-500">*</span></label>
                    <input type="text" name="kecamatan" required placeholder="Contoh: Simboro" class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-pwm-emerald transition">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Kepala Sekolah</label>
                <input type="text" name="kepala_sekolah" class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-pwm-emerald transition">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Alamat Lengkap</label>
                <textarea name="alamat" rows="2" class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-pwm-emerald transition"></textarea>
            </div>

            <div class="flex justify-end gap-2 pt-4 border-t border-slate-100">
                <button type="button" onclick="closeModalTambah()" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-semibold rounded-xl transition">Batal</button>
                <button type="submit" class="px-4 py-2 bg-pwm-emerald hover:bg-emerald-700 text-white text-xs font-semibold rounded-xl transition">Simpan Data</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit -->
<div id="modalEdit" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 flex items-center justify-center hidden p-4">
    <div class="bg-white rounded-2xl max-w-xl w-full p-6 shadow-2xl max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between pb-4 border-b border-slate-100">
            <h3 class="text-lg font-bold text-slate-800">Edit Data Sekolah</h3>
            <button onclick="closeModalEdit()" class="text-slate-400 hover:text-slate-600 text-xl font-bold">&times;</button>
        </div>
        <form id="formEdit" method="POST" class="space-y-4 mt-4">
            <?= csrf_field() ?>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Sekolah <span class="text-rose-500">*</span></label>
                <input type="text" name="nama_sekolah" id="edit_nama_sekolah" required class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-pwm-emerald transition">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">NPSN</label>
                    <input type="text" name="npsn" id="edit_npsn" class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-pwm-emerald transition">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Jenjang <span class="text-rose-500">*</span></label>
                    <select name="jenjang" id="edit_jenjang" required class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-pwm-emerald transition">
                        <option value="SD">SD</option>
                        <option value="SD">MI</option>
                        <option value="SMP">SMP</option>
                        <option value="MTS">MTs</option>
                        <option value="SMA">SMA</option>
                        <option value="SMK">SMK</option>
                        <option value="MA">MA</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Akreditasi</label>
                    <select name="akreditasi" id="edit_akreditasi" class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-pwm-emerald transition">
                        <option value="A">A (Unggul)</option>
                        <option value="B">B (Baik)</option>
                        <option value="C">C (Cukup)</option>
                        <option value="Belum Akreditasi">Belum Akreditasi</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Kabupaten / Kota <span class="text-rose-500">*</span></label>
                    <select name="kabupaten_kota" id="edit_kabupaten_kota" required class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-pwm-emerald transition">
                        <option value="Kab. Mamuju">Kab. Mamuju</option>
                        <option value="Kab. Majene">Kab. Majene</option>
                        <option value="Kab. Polewali Mandar">Kab. Polewali Mandar</option>
                        <option value="Kab. Pasangkayu">Kab. Pasangkayu</option>
                        <option value="Kab. Mamuju Tengah">Kab. Mamuju Tengah</option>
                        <option value="Kab. Mamasa">Kab. Mamasa</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Kecamatan <span class="text-rose-500">*</span></label>
                    <input type="text" name="kecamatan" id="edit_kecamatan" required class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-pwm-emerald transition">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Kepala Sekolah</label>
                <input type="text" name="kepala_sekolah" id="edit_kepala_sekolah" class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-pwm-emerald transition">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Alamat Lengkap</label>
                <textarea name="alamat" id="edit_alamat" rows="2" class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-pwm-emerald transition"></textarea>
            </div>

            <div class="flex justify-end gap-2 pt-4 border-t border-slate-100">
                <button type="button" onclick="closeModalEdit()" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-semibold rounded-xl transition">Batal</button>
                <button type="submit" class="px-4 py-2 bg-pwm-emerald hover:bg-emerald-700 text-white text-xs font-semibold rounded-xl transition">Update Data</button>
            </div>
        </form>
    </div>
</div>

<!-- Styling Tambahan untuk Menyusun Tombol Paginasi Horizontal -->
<style>
    .pagination-wrapper ul {
        display: flex;
        list-style: none;
        gap: 0.25rem;
        align-items: center;
        padding: 0;
        margin: 0;
    }

    .pagination-wrapper ul li a,
    .pagination-wrapper ul li span {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 2rem;
        height: 2rem;
        padding: 0 0.5rem;
        font-size: 0.75rem;
        font-weight: 600;
        border-radius: 0.5rem;
        border: 1px solid #e2e8f0;
        color: #475569;
        text-decoration: none;
        transition: all 0.2s;
    }

    .pagination-wrapper ul li.active a,
    .pagination-wrapper ul li.active span {
        background-color: #059669;
        color: white;
        border-color: #059669;
    }

    .pagination-wrapper ul li a:hover {
        background-color: #f1f5f9;
    }
</style>

<script>
    const baseUrl = '<?= base_url() ?>';

    function openModalTambah() {
        document.getElementById('modalTambah').classList.remove('hidden');
    }

    function closeModalTambah() {
        document.getElementById('modalTambah').classList.add('hidden');
    }

    function openModalEdit(data) {
        const id = data.id || data.id_sekolah;
        document.getElementById('formEdit').action = baseUrl + 'admin/sekolah/update/' + id;

        document.getElementById('edit_nama_sekolah').value = data.nama_sekolah || '';
        document.getElementById('edit_npsn').value = data.npsn || '';
        document.getElementById('edit_jenjang').value = data.jenjang || '';
        document.getElementById('edit_akreditasi').value = data.akreditasi || 'Belum Akreditasi';
        document.getElementById('edit_kabupaten_kota').value = data.kabupaten_kota || '';
        document.getElementById('edit_kecamatan').value = data.kecamatan || '';
        document.getElementById('edit_kepala_sekolah').value = data.kepala_sekolah || '';
        document.getElementById('edit_alamat').value = data.alamat || '';

        document.getElementById('modalEdit').classList.remove('hidden');
    }

    function closeModalEdit() {
        document.getElementById('modalEdit').classList.add('hidden');
    }
</script>
<?= $this->endSection() ?>