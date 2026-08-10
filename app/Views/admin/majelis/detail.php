<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<!-- Script CDN Tailwind CSS -->
<script src="https://cdn.tailwindcss.com"></script>

<div class="p-4 sm:p-6 space-y-6">
    <!-- Header & Tombol Kembali -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800"><?= esc($title) ?></h1>
            <p class="text-sm text-gray-500 mt-1">Kelola pimpinan, dewan pakar, dan bidang struktur majelis</p>
        </div>
        <div class="flex gap-2">
            <a href="<?= base_url('admin/majelis/' . $majelis['id_majelis'] . '/anggota') ?>"
                class="inline-flex items-center justify-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-lg transition shadow-sm">
                Kelola Anggota Bidang
            </a>
            <a href="<?= base_url('admin/majelis') ?>"
                class="inline-flex items-center justify-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-lg transition shadow-sm">
                Kembali
            </a>
        </div>
    </div>

    <!-- Alert Flashdata -->
    <?php if (session()->getFlashdata('sukses')) : ?>
        <div class="p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 rounded-r-lg shadow-sm">
            <?= session()->getFlashdata('sukses') ?>
        </div>
    <?php endif; ?>

    <!-- 1. KELOLA PIMPINAN MAJELIS -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="bg-slate-800 px-6 py-4">
            <h2 class="text-lg font-semibold text-white">1. Kelola Pimpinan Majelis</h2>
        </div>
        <div class="p-6 space-y-4">
            <!-- Form Input Pimpinan -->
            <form action="<?= base_url('admin/majelis/pimpinan/simpan/' . $majelis['id_majelis']) ?>" method="post" class="grid grid-cols-1 md:grid-cols-12 gap-3 items-end bg-gray-50 p-4 rounded-lg border border-gray-200">
                <?= csrf_field() ?>
                <div class="md:col-span-4">
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Jabatan</label>
                    <input type="text" name="jabatan" class="w-full bg-white border border-gray-300 text-sm rounded-lg px-3 py-2 outline-none focus:ring-2 focus:ring-blue-500" placeholder="Contoh: Ketua / Sekretaris" required>
                </div>
                <div class="md:col-span-5">
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Nama Pimpinan</label>
                    <input type="text" name="nama" class="w-full bg-white border border-gray-300 text-sm rounded-lg px-3 py-2 outline-none focus:ring-2 focus:ring-blue-500" placeholder="Nama lengkap..." required>
                </div>
                <div class="md:col-span-1">
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Urutan</label>
                    <input type="number" name="urutan" value="1" min="1" class="w-full bg-white border border-gray-300 text-sm rounded-lg px-3 py-2 outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div class="md:col-span-2">
                    <button type="submit" class="w-full py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition">+ Simpan</button>
                </div>
            </form>

            <!-- Tabel Pimpinan -->
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-600 border border-gray-200 rounded-lg">
                    <thead class="bg-gray-100 text-gray-700 font-semibold border-b">
                        <tr>
                            <th class="p-3 w-16 text-center">No</th>
                            <th class="p-3">Jabatan</th>
                            <th class="p-3">Nama</th>
                            <th class="p-3 w-24 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php if (!empty($pimpinan)) : ?>
                            <?php foreach ($pimpinan as $p) : ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="p-3 text-center font-bold"><?= esc($p['urutan']) ?></td>
                                    <td class="p-3 font-medium text-gray-800"><?= esc($p['jabatan']) ?></td>
                                    <td class="p-3"><?= esc($p['nama']) ?></td>
                                    <td class="p-3 text-center">
                                        <a href="<?= base_url('admin/majelis/pimpinan/hapus/' . $p['id_pimpinan']) ?>" class="px-3 py-1 bg-red-50 text-red-600 border border-red-200 rounded text-xs font-semibold hover:bg-red-100" onclick="return confirm('Hapus pimpinan ini?')">Hapus</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="4" class="p-3 text-center text-gray-400 italic">Belum ada data pimpinan.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- 2. KELOLA DEWAN PAKAR -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="bg-slate-800 px-6 py-4">
            <h2 class="text-lg font-semibold text-white">2. Kelola Dewan Pakar</h2>
        </div>
        <div class="p-6 space-y-4">
            <!-- Form Input Pakar -->
            <form action="<?= base_url('admin/majelis/pakar/simpan/' . $majelis['id_majelis']) ?>" method="post" class="grid grid-cols-1 md:grid-cols-12 gap-3 items-end bg-gray-50 p-4 rounded-lg border border-gray-200">
                <?= csrf_field() ?>
                <div class="md:col-span-9">
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Nama Pakar / Penasihat</label>
                    <input type="text" name="nama" class="w-full bg-white border border-gray-300 text-sm rounded-lg px-3 py-2 outline-none focus:ring-2 focus:ring-blue-500" placeholder="Nama anggota dewan pakar..." required>
                </div>
                <div class="md:col-span-1">
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Urutan</label>
                    <input type="number" name="urutan" value="1" min="1" class="w-full bg-white border border-gray-300 text-sm rounded-lg px-3 py-2 outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div class="md:col-span-2">
                    <button type="submit" class="w-full py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition">+ Simpan</button>
                </div>
            </form>

            <!-- Tabel Pakar -->
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-600 border border-gray-200 rounded-lg">
                    <thead class="bg-gray-100 text-gray-700 font-semibold border-b">
                        <tr>
                            <th class="p-3 w-16 text-center">No</th>
                            <th class="p-3">Nama Dewan Pakar</th>
                            <th class="p-3 w-24 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php if (!empty($pakar)) : ?>
                            <?php foreach ($pakar as $pk) : ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="p-3 text-center font-bold"><?= esc($pk['urutan']) ?></td>
                                    <td class="p-3 font-medium text-gray-800"><?= esc($pk['nama']) ?></td>
                                    <td class="p-3 text-center">
                                        <a href="<?= base_url('admin/majelis/pakar/hapus/' . $pk['id_pakar']) ?>" class="px-3 py-1 bg-red-50 text-red-600 border border-red-200 rounded text-xs font-semibold hover:bg-red-100" onclick="return confirm('Hapus pakar ini?')">Hapus</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="3" class="p-3 text-center text-gray-400 italic">Belum ada data dewan pakar.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- 3. KELOLA BIDANG MAJELIS -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="bg-slate-800 px-6 py-4">
            <h2 class="text-lg font-semibold text-white">3. Kelola Bidang Majelis</h2>
        </div>
        <div class="p-6 space-y-4">
            <!-- Form Input Bidang -->
            <form action="<?= base_url('admin/majelis/bidang/simpan/' . $majelis['id_majelis']) ?>" method="post" class="grid grid-cols-1 md:grid-cols-12 gap-3 items-end bg-gray-50 p-4 rounded-lg border border-gray-200">
                <?= csrf_field() ?>
                <div class="md:col-span-5">
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Nama Bidang</label>
                    <input type="text" name="nama_bidang" class="w-full bg-white border border-gray-300 text-sm rounded-lg px-3 py-2 outline-none focus:ring-2 focus:ring-blue-500" placeholder="Contoh: Bidang Usaha & Ekonomi" required>
                </div>
                <div class="md:col-span-4">
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Ketua Bidang</label>
                    <input type="text" name="ketua_bidang" class="w-full bg-white border border-gray-300 text-sm rounded-lg px-3 py-2 outline-none focus:ring-2 focus:ring-blue-500" placeholder="Nama ketua bidang..." required>
                </div>
                <div class="md:col-span-1">
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Urutan</label>
                    <input type="number" name="urutan" value="1" min="1" class="w-full bg-white border border-gray-300 text-sm rounded-lg px-3 py-2 outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div class="md:col-span-2">
                    <button type="submit" class="w-full py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition">+ Simpan Bidang</button>
                </div>
            </form>

            <!-- Tabel Bidang -->
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-600 border border-gray-200 rounded-lg">
                    <thead class="bg-gray-100 text-gray-700 font-semibold border-b">
                        <tr>
                            <th class="p-3 w-16 text-center">No</th>
                            <th class="p-3">Nama Bidang</th>
                            <th class="p-3">Ketua Bidang</th>
                            <th class="p-3 w-24 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php if (!empty($bidang)) : ?>
                            <?php foreach ($bidang as $bd) : ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="p-3 text-center font-bold"><?= esc($bd['urutan']) ?></td>
                                    <td class="p-3 font-medium text-gray-800"><?= esc($bd['nama_bidang']) ?></td>
                                    <td class="p-3"><?= esc($bd['ketua_bidang']) ?></td>
                                    <td class="p-3 text-center">
                                        <a href="<?= base_url('admin/majelis/bidang/hapus/' . $bd['id_bidang']) ?>" class="px-3 py-1 bg-red-50 text-red-600 border border-red-200 rounded text-xs font-semibold hover:bg-red-100" onclick="return confirm('Hapus bidang ini beserta anggotanya?')">Hapus</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="4" class="p-3 text-center text-gray-400 italic">Belum ada data bidang.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>