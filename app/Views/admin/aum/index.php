<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="p-6">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800"><?= esc($title) ?></h1>
            <p class="text-xs text-slate-500 mt-1">Kelola data Amal Usaha Muhammadiyah (Kesehatan, Ekonomi, Sosial, dll).</p>
        </div>
        <button onclick="openModalTambah()" class="inline-flex items-center gap-2 px-4 py-2.5 bg-pwm-emerald hover:bg-emerald-700 text-white text-sm font-semibold rounded-xl transition shadow-sm hover:shadow-md">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah AUM
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
                <?php foreach ((array) session()->getFlashdata('errors') as $error) : ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <!-- Filter Bar -->
    <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm mb-6">
        <form method="GET" action="<?= base_url('admin/aum') ?>" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
            <input type="text" name="q" value="<?= esc($keyword ?? '') ?>" placeholder="Cari nama AUM / pimpinan..." class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-pwm-emerald transition">

            <select name="jenis" class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-pwm-emerald transition">
                <option value="">-- Semua Jenis --</option>
                <?php if (!empty($jenisList)) : ?>
                    <?php foreach ($jenisList as $j) : ?>
                        <option value="<?= esc($j) ?>" <?= ($filterJenis ?? '') === $j ? 'selected' : '' ?>><?= esc($j) ?></option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>

            <select name="kabupaten_kota" class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-pwm-emerald transition">
                <option value="">-- Semua Kab/Kota --</option>
                <?php if (!empty($kabupatenList)) : ?>
                    <?php foreach ($kabupatenList as $kab) : ?>
                        <option value="<?= esc($kab) ?>" <?= ($filterKabupaten ?? '') === $kab ? 'selected' : '' ?>><?= esc($kab) ?></option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>

            <select name="kecamatan" class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-pwm-emerald transition">
                <option value="">-- Semua Kecamatan --</option>
                <?php if (!empty($kecamatanList)) : ?>
                    <?php foreach ($kecamatanList as $kec) : ?>
                        <option value="<?= esc($kec) ?>" <?= ($filterKecamatan ?? '') === $kec ? 'selected' : '' ?>><?= esc($kec) ?></option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>

            <div class="flex items-center gap-2">
                <button type="submit" class="w-full py-2 px-4 bg-slate-800 hover:bg-slate-900 text-white text-sm font-medium rounded-xl transition">Filter</button>
                <a href="<?= base_url('admin/aum') ?>" class="py-2 px-3 bg-slate-100 hover:bg-slate-200 text-slate-600 text-sm font-medium rounded-xl transition">Reset</a>
            </div>
        </form>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-xs text-slate-500 uppercase tracking-wider">
                        <th class="py-3.5 px-4 font-semibold">Foto & Nama AUM</th>
                        <th class="py-3.5 px-4 font-semibold">Jenis</th>
                        <th class="py-3.5 px-4 font-semibold">Pimpinan</th>
                        <th class="py-3.5 px-4 font-semibold">Wilayah & Alamat</th>
                        <th class="py-3.5 px-4 font-semibold">Kontak</th>
                        <th class="py-3.5 px-4 font-semibold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php if (!empty($aumList)) : ?>
                        <?php foreach ($aumList as $row) : ?>
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="py-3 px-4">
                                    <div class="flex items-center gap-3">
                                        <?php if (!empty($row['foto']) && file_exists(FCPATH . 'uploads/aum/' . $row['foto'])) : ?>
                                            <img src="<?= base_url('uploads/aum/' . $row['foto']) ?>" alt="Foto" class="w-10 h-10 rounded-xl object-cover border border-slate-200">
                                        <?php else : ?>
                                            <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-slate-400 font-bold text-xs">NO IMG</div>
                                        <?php endif; ?>
                                        <div>
                                            <div class="font-semibold text-slate-800"><?= esc($row['nama_aum']) ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="px-2.5 py-1 text-xs font-semibold rounded-lg bg-blue-50 text-blue-700 border border-blue-200">
                                        <?= esc($row['jenis'] ?? 'Belum Set') ?>
                                    </span>
                                </td>
                                <td class="py-3 px-4 font-medium text-slate-700 text-xs">
                                    <?= esc($row['pimpinan'] ?? '-') ?>
                                </td>
                                <td class="py-3 px-4 text-xs text-slate-500 max-w-xs">
                                    <?php if (!empty($row['kabupaten_kota']) || !empty($row['kecamatan'])) : ?>
                                        <div class="font-medium text-slate-700 mb-0.5">
                                            <?= esc($row['kecamatan'] ?? '') ?><?= (!empty($row['kecamatan']) && !empty($row['kabupaten_kota'])) ? ', ' : '' ?><?= esc($row['kabupaten_kota'] ?? '') ?>
                                        </div>
                                    <?php endif; ?>
                                    <div><?= esc($row['alamat'] ?? '-') ?></div>
                                    <?php if (!empty($row['maps'])) : ?>
                                        <a href="<?= esc($row['maps']) ?>" target="_blank" class="inline-flex items-center gap-1 text-xs text-blue-600 hover:underline mt-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            Buka Maps
                                        </a>
                                    <?php endif; ?>
                                </td>
                                <td class="py-3 px-4 text-xs text-slate-500">
                                    <div><?= esc($row['telepon'] ?? '-') ?></div>
                                    <div class="text-slate-400"><?= esc($row['email'] ?? '-') ?></div>
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <button type="button" onclick='openModalEdit(<?= json_encode($row) ?>)' class="p-1.5 text-amber-600 hover:bg-amber-50 rounded-lg transition" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>
                                        <a href="<?= base_url('admin/aum/hapus/' . $row['id_aum']) ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus data AUM ini?')" class="p-1.5 text-rose-600 hover:bg-rose-50 rounded-lg transition" title="Hapus">
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
                            <td colspan="6" class="py-8 text-center text-slate-400 text-sm">Belum ada data AUM yang tersimpan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah -->
<div id="modalTambah" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 flex items-center justify-center hidden p-4">
    <div class="bg-white rounded-2xl max-w-xl w-full p-6 shadow-2xl max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between pb-4 border-b border-slate-100">
            <h3 class="text-lg font-bold text-slate-800">Tambah Data AUM</h3>
            <button onclick="closeModalTambah()" class="text-slate-400 hover:text-slate-600 text-xl font-bold">&times;</button>
        </div>
        <form action="<?= base_url('admin/aum/simpan') ?>" method="POST" enctype="multipart/form-data" class="space-y-4 mt-4">
            <?= csrf_field() ?>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Nama AUM <span class="text-rose-500">*</span></label>
                <input type="text" name="nama_aum" value="<?= old('nama_aum') ?>" required class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-pwm-emerald transition">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Jenis AUM <span class="text-rose-500">*</span></label>
                    <select name="jenis" required class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-pwm-emerald transition">
                        <option value="">-- Pilih Jenis AUM --</option>
                        <option value="Kesehatan" <?= old('jenis') === 'Kesehatan' ? 'selected' : '' ?>>Kesehatan (RS/Klinik)</option>
                        <option value="Sosial" <?= old('jenis') === 'Sosial' ? 'selected' : '' ?>>Sosial (Panti/LKSA)</option>
                        <option value="Ekonomi" <?= old('jenis') === 'Ekonomi' ? 'selected' : '' ?>>Ekonomi & Bisnis (BTM/Koperasi)</option>
                        <option value="Masjid" <?= old('jenis') === 'Masjid' ? 'selected' : '' ?>>Masjid</option>
                        <option value="Mushollah" <?= old('jenis') === 'Mushollah' ? 'selected' : '' ?>>Mushollah</option>
                        <option value="TK ABA" <?= old('jenis') === 'TK ABA' ? 'selected' : '' ?>>TK Aisyiyah Bustanul Athfal/ABA</option>
                        <option value="KB/PAUD" <?= old('jenis') === 'KB/PAUD' ? 'selected' : '' ?>>KB/PAUD</option>
                        <option value="Lainnya" <?= old('jenis') === 'Lainnya' ? 'selected' : '' ?>>Lainnya</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Pimpinan / Direktur</label>
                    <input type="text" name="pimpinan" value="<?= old('pimpinan') ?>" class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-pwm-emerald transition">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Kabupaten / Kota</label>
                    <input type="text" name="kabupaten_kota" value="<?= old('kabupaten_kota') ?>" placeholder="Contoh: Kab. Polewali Mandar" class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-pwm-emerald transition">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Kecamatan</label>
                    <input type="text" name="kecamatan" value="<?= old('kecamatan') ?>" placeholder="Contoh: Wonomulyo" class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-pwm-emerald transition">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Telepon</label>
                    <input type="text" name="telepon" value="<?= old('telepon') ?>" class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-pwm-emerald transition">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Email</label>
                    <input type="email" name="email" value="<?= old('email') ?>" class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-pwm-emerald transition">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Link URL Google Maps</label>
                <input type="url" name="maps" value="<?= old('maps') ?>" placeholder="https://maps.google.com/..." class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-pwm-emerald transition">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Alamat Lengkap</label>
                <textarea name="alamat" rows="2" class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-pwm-emerald transition"><?= old('alamat') ?></textarea>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Deskripsi</label>
                <textarea name="deskripsi" rows="3" class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-pwm-emerald transition"><?= old('deskripsi') ?></textarea>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Foto / Logo</label>
                <input type="file" name="foto" accept="image/*" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 transition">
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
            <h3 class="text-lg font-bold text-slate-800">Edit Data AUM</h3>
            <button onclick="closeModalEdit()" class="text-slate-400 hover:text-slate-600 text-xl font-bold">&times;</button>
        </div>
        <form id="formEdit" method="POST" enctype="multipart/form-data" class="space-y-4 mt-4">
            <?= csrf_field() ?>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Nama AUM <span class="text-rose-500">*</span></label>
                <input type="text" name="nama_aum" id="edit_nama_aum" required class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-pwm-emerald transition">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Jenis AUM <span class="text-rose-500">*</span></label>
                    <select name="jenis" id="edit_jenis" required class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-pwm-emerald transition">
                         <option value="">-- Pilih Jenis AUM --</option>
                        <option value="Kesehatan">Kesehatan (RS/Klinik)</option>
                        <option value="Sosial">Sosial (Panti/LKSA)</option>
                        <option value="Ekonomi">Ekonomi & Bisnis (BTM/Koperasi)</option>
                        <option value="Masjid">Masjid</option>
                        <option value="Mushollah">Mushollah</option>
                        <option value="TK ABA">TK Aisyiyah Bustanul Athfal/ABA</option>
                        <option value="KB/PAUD">KB/PAUD</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Pimpinan / Direktur</label>
                    <input type="text" name="pimpinan" id="edit_pimpinan" class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-pwm-emerald transition">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Kabupaten / Kota</label>
                    <input type="text" name="kabupaten_kota" id="edit_kabupaten_kota" placeholder="Contoh: Kab. Polewali Mandar" class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-pwm-emerald transition">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Kecamatan</label>
                    <input type="text" name="kecamatan" id="edit_kecamatan" placeholder="Contoh: Wonomulyo" class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-pwm-emerald transition">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Telepon</label>
                    <input type="text" name="telepon" id="edit_telepon" class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-pwm-emerald transition">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Email</label>
                    <input type="email" name="email" id="edit_email" class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-pwm-emerald transition">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Link URL Google Maps</label>
                <input type="url" name="maps" id="edit_maps" placeholder="https://maps.google.com/..." class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-pwm-emerald transition">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Alamat Lengkap</label>
                <textarea name="alamat" id="edit_alamat" rows="2" class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-pwm-emerald transition"></textarea>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Deskripsi</label>
                <textarea name="deskripsi" id="edit_deskripsi" rows="3" class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-pwm-emerald transition"></textarea>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Ganti Foto / Logo (Opsional)</label>
                <input type="file" name="foto" accept="image/*" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 transition">
            </div>

            <div class="flex justify-end gap-2 pt-4 border-t border-slate-100">
                <button type="button" onclick="closeModalEdit()" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-semibold rounded-xl transition">Batal</button>
                <button type="submit" class="px-4 py-2 bg-pwm-emerald hover:bg-emerald-700 text-white text-xs font-semibold rounded-xl transition">Update Data</button>
            </div>
        </form>
    </div>
</div>

<script>
    const baseUrl = '<?= base_url() ?>';

    function openModalTambah() {
        document.getElementById('modalTambah').classList.remove('hidden');
    }

    function closeModalTambah() {
        document.getElementById('modalTambah').classList.add('hidden');
    }

    function openModalEdit(data) {
        document.getElementById('formEdit').action = baseUrl + 'admin/aum/update/' + data.id_aum;

        document.getElementById('edit_nama_aum').value = data.nama_aum || '';
        document.getElementById('edit_jenis').value = data.jenis || '';
        document.getElementById('edit_pimpinan').value = data.pimpinan || '';
        document.getElementById('edit_kabupaten_kota').value = data.kabupaten_kota || '';
        document.getElementById('edit_kecamatan').value = data.kecamatan || '';
        document.getElementById('edit_telepon').value = data.telepon || '';
        document.getElementById('edit_email').value = data.email || '';
        document.getElementById('edit_maps').value = data.maps || '';
        document.getElementById('edit_alamat').value = data.alamat || '';
        document.getElementById('edit_deskripsi').value = data.deskripsi || '';

        document.getElementById('modalEdit').classList.remove('hidden');
    }

    function closeModalEdit() {
        document.getElementById('modalEdit').classList.add('hidden');
    }
</script>
<?= $this->endSection() ?>