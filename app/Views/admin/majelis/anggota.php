<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<!-- Script CDN Tailwind CSS -->
<script src="https://cdn.tailwindcss.com"></script>

<div class="p-4 sm:p-6 space-y-6">
    <!-- Header & Tombol Kembali -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800"><?= esc($title) ?></h1>
            <p class="text-sm text-gray-500 mt-1">Kelola daftar anggota per bidang untuk majelis ini</p>
        </div>
        <a href="<?= base_url('admin/majelis/detail/' . $majelis['id_majelis']) ?>"
            class="inline-flex items-center justify-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-lg transition duration-200 shadow-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Detail
        </a>
    </div>

    <!-- Alert Notifikasi Flashdata -->
    <?php if (session()->getFlashdata('sukses')) : ?>
        <div class="p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 rounded-r-lg shadow-sm flex items-center justify-between">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <span><?= session()->getFlashdata('sukses') ?></span>
            </div>
        </div>
    <?php endif; ?>

    <!-- Wrapper Kartu Utama -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="bg-slate-800 px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-white">
                Daftar Anggota - <span class="text-emerald-400"><?= esc($majelis['nama_majelis']) ?></span>
            </h2>
        </div>

        <div class="p-6 space-y-6">
            <?php if (empty($bidang)) : ?>
                <div class="p-4 bg-amber-50 border-l-4 border-amber-400 text-amber-800 rounded-r-lg">
                    <p class="font-medium">Belum ada Bidang yang terdaftar.</p>
                    <p class="text-sm">Buat bidang terlebih dahulu di menu Detail Majelis sebelum menambahkan anggota.</p>
                </div>
            <?php else : ?>
                <?php foreach ($bidang as $b) : ?>
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-5 shadow-sm space-y-4">
                        <!-- Header Bidang -->
                        <div class="flex flex-wrap items-center justify-between pb-3 border-b border-gray-200 gap-2">
                            <h3 class="text-base font-bold text-gray-800">
                                Bidang: <span class="text-blue-600"><?= esc($b['nama_bidang']) ?></span>
                            </h3>
                            <span class="text-xs bg-blue-50 text-blue-700 px-3 py-1 rounded-full border border-blue-200 font-medium">
                                Ketua: <?= esc($b['ketua_bidang'] ?? '-') ?>
                            </span>
                        </div>

                        <!-- Form Input Anggota Baru -->
                        <form action="<?= base_url('admin/majelis/anggota/simpan/' . $b['id_bidang']) ?>" method="post" class="flex flex-col sm:flex-row gap-3 items-end">
                            <?= csrf_field() ?>
                            <div class="w-full sm:flex-1">
                                <label class="block text-xs font-semibold text-gray-600 mb-1">Nama Anggota</label>
                                <input type="text" name="nama" class="w-full bg-white border border-gray-300 text-gray-800 text-sm rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition" placeholder="Masukkan nama anggota..." required>
                            </div>
                            <div class="w-full sm:w-28">
                                <label class="block text-xs font-semibold text-gray-600 mb-1">Urutan</label>
                                <input type="number" name="urutan" value="1" min="1" class="w-full bg-white border border-gray-300 text-gray-800 text-sm rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition" required>
                            </div>
                            <button type="submit" class="w-full sm:w-auto px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition duration-200 shadow-sm flex items-center justify-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Tambah
                            </button>
                        </form>

                        <!-- Tabel / List Anggota Bidang -->
                        <div class="mt-4">
                            <?php if (!empty($b['anggota'])) : ?>
                                <div class="divide-y divide-gray-200 bg-white rounded-lg border border-gray-200 overflow-hidden">
                                    <?php foreach ($b['anggota'] as $a) : ?>
                                        <div class="flex items-center justify-between p-3 hover:bg-gray-50 transition">
                                            <div class="flex items-center space-x-3">
                                                <span class="inline-flex items-center justify-center w-6 h-6 bg-slate-100 text-slate-700 text-xs font-bold rounded-full border border-slate-300">
                                                    <?= esc($a['urutan']) ?>
                                                </span>
                                                <span class="text-sm font-medium text-gray-800"><?= esc($a['nama']) ?></span>
                                            </div>
                                            <a href="<?= base_url('admin/majelis/anggota/hapus/' . $a['id_anggota']) ?>"
                                                class="px-3 py-1 bg-red-50 hover:bg-red-100 text-red-600 text-xs font-semibold rounded-md border border-red-200 transition"
                                                onclick="return confirm('Yakin ingin menghapus anggota ini?')">
                                                Hapus
                                            </a>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else : ?>
                                <p class="text-xs text-gray-500 italic bg-white p-3 rounded-lg border border-gray-200 text-center">
                                    Belum ada anggota di bidang ini.
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>