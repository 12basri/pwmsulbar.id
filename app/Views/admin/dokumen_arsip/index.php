<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="p-6 bg-slate-50 min-h-screen">
    <!-- Header Page -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-800"><?= $title ?? 'Manajemen Dokumen Arsip'; ?></h1>
            <p class="text-sm text-slate-500">Kelola dan arsipkan dokumen resmi PDM / PWM</p>
        </div>
        <button type="button" onclick="openModal('modalTambah')" class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm rounded-lg shadow-sm transition-all duration-150">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Dokumen
        </button>
    </div>

    <!-- Alert Flashdata -->
    <?php if (session()->getFlashdata('sukses')) : ?>
        <div class="mb-4 p-4 text-sm text-emerald-800 bg-emerald-50 border border-emerald-200 rounded-lg flex items-center justify-between" role="alert">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                <span><?= session()->getFlashdata('sukses'); ?></span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">&times;</button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('gagal')) : ?>
        <div class="mb-4 p-4 text-sm text-rose-800 bg-rose-50 border border-rose-200 rounded-lg flex items-center justify-between" role="alert">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-rose-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                <span><?= session()->getFlashdata('gagal'); ?></span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-700">&times;</button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('errors')) : ?>
        <div class="mb-4 p-4 text-sm text-amber-800 bg-amber-50 border border-amber-200 rounded-lg">
            <strong class="font-semibold block mb-1">Terjadi Kesalahan:</strong>
            <ul class="list-disc list-inside space-y-1">
                <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                    <li><?= esc($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <!-- Filter & Search Panel -->
    <div class="bg-white p-4 rounded-xl shadow-sm border border-slate-200 mb-6">
      <form action="<?= base_url('admin/dokumen-arsip/simpan'); ?>" method="post" enctype="multipart/form-data">
            <div class="lg:col-span-5">
                <input type="text" name="q" placeholder="Cari judul, nomor, atau deskripsi..." value="<?= esc($keyword ?? ''); ?>" class="w-full px-3 py-2 text-sm border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
            </div>
            <div class="lg:col-span-3">
                <select name="kategori" class="w-full px-3 py-2 text-sm border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none bg-white transition">
                    <option value="">-- Semua Kategori --</option>
                    <option value="SK & Peraturan" <?= ($filterKategori ?? '') == 'SK & Peraturan' ? 'selected' : ''; ?>>SK & Peraturan</option>
                    <option value="Surat Edaran" <?= ($filterKategori ?? '') == 'Surat Edaran' ? 'selected' : ''; ?>>Surat Edaran</option>
                    <option value="Laporan" <?= ($filterKategori ?? '') == 'Laporan' ? 'selected' : ''; ?>>Laporan</option>
                    <option value="Panduan & Pedoman" <?= ($filterKategori ?? '') == 'Panduan & Pedoman' ? 'selected' : ''; ?>>Panduan & Pedoman</option>
                    <option value="Lainnya" <?= ($filterKategori ?? '') == 'Lainnya' ? 'selected' : ''; ?>>Lainnya</option>
                </select>
            </div>
            <div class="lg:col-span-2">
                <select name="akses" class="w-full px-3 py-2 text-sm border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none bg-white transition">
                    <option value="">-- Semua Akses --</option>
                    <option value="Publik" <?= ($filterAkses ?? '') == 'Publik' ? 'selected' : ''; ?>>Publik</option>
                    <option value="Internal" <?= ($filterAkses ?? '') == 'Internal' ? 'selected' : ''; ?>>Internal</option>
                    <option value="Rahasia" <?= ($filterAkses ?? '') == 'Rahasia' ? 'selected' : ''; ?>>Rahasia</option>
                </select>
            </div>
            <div class="lg:col-span-2 flex gap-2">
                <button type="submit" class="flex-1 bg-slate-700 hover:bg-slate-800 text-white font-medium text-sm py-2 px-3 rounded-lg transition text-center">Filter</button>
                <a href="<?= base_url('admin/dokumen-arsip'); ?>" class="p-2 border border-slate-300 hover:bg-slate-100 text-slate-600 rounded-lg transition" title="Reset">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                </a>
            </div>
        </form>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-100 text-slate-600 uppercase text-xs font-semibold tracking-wider border-b border-slate-200">
                        <th class="py-3 px-4 w-12 text-center">No</th>
                        <th class="py-3 px-4">Judul & Nomor Dokumen</th>
                        <th class="py-3 px-4">Kategori</th>
                        <th class="py-3 px-4">Tanggal Dokumen</th>
                        <th class="py-3 px-4">Ukuran</th>
                        <th class="py-3 px-4">Akses</th>
                        <th class="py-3 px-4 text-center w-36">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 text-sm">
                    <?php if (!empty($dokumen) && is_array($dokumen)) : ?>
                        <?php $no = 1; foreach ($dokumen as $d) : ?>
                            <tr class="hover:bg-slate-50 transition">
                                <td class="py-3 px-4 text-center font-medium text-slate-400"><?= $no++; ?></td>
                                <td class="py-3 px-4">
                                    <div class="font-semibold text-slate-800"><?= esc($d['judul'] ?: '-'); ?></div>
                                    <div class="text-xs text-slate-500 font-mono">#<?= esc($d['nomor_dokumen'] ?: '-'); ?></div>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="inline-block bg-slate-100 text-slate-700 text-xs px-2.5 py-1 rounded-md font-medium border border-slate-200"><?= esc($d['kategori'] ?: '-'); ?></span>
                                </td>
                                <td class="py-3 px-4 text-slate-600">
                                    <?= !empty($d['tanggal_upload']) ? date('d M Y', strtotime($d['tanggal_upload'])) : '-'; ?>
                                </td>
                                <td class="py-3 px-4 text-slate-500 text-xs">
                                    <?= esc($d['ukuran_file'] ?: '-'); ?>
                                </td>
                                <td class="py-3 px-4">
                                    <?php 
                                        $badgeAkses = 'bg-emerald-100 text-emerald-800 border-emerald-200';
                                        if (($d['akses'] ?? '') == 'Internal') $badgeAkses = 'bg-amber-100 text-amber-800 border-amber-200';
                                        if (($d['akses'] ?? '') == 'Rahasia') $badgeAkses = 'bg-rose-100 text-rose-800 border-rose-200';
                                    ?>
                                    <span class="inline-block border text-xs px-2.5 py-0.5 rounded-full font-semibold <?= $badgeAkses; ?>"><?= esc($d['akses'] ?? 'Publik'); ?></span>
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <div class="inline-flex items-center gap-1">
                                        <!-- Detail -->
                                        <button type="button" onclick="openModal('modalDetail<?= $d['id_dokumen']; ?>')" class="p-1.5 text-sky-600 hover:bg-sky-50 rounded-lg transition" title="Detail">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        </button>
                                        <!-- Edit -->
                                        <button type="button" onclick="openModal('modalEdit<?= $d['id_dokumen']; ?>')" class="p-1.5 text-amber-600 hover:bg-amber-50 rounded-lg transition" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </button>
                                        <!-- Download -->
                                        <a href="<?= base_url('admin/dokumen-arsip/download/' . $d['id_dokumen']); ?>" class="p-1.5 text-emerald-600 hover:bg-emerald-50 rounded-lg transition" title="Unduh">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                        </a>
                                        <!-- Hapus -->
                                        <a href="<?= base_url('admin/dokumen-arsip/hapus/' . $d['id_dokumen']); ?>" onclick="return confirm('Yakin ingin menghapus dokumen ini?')" class="p-1.5 text-rose-600 hover:bg-rose-50 rounded-lg transition" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="7" class="py-8 text-center text-slate-400">
                                <svg class="w-12 h-12 mx-auto mb-2 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 01-2 2z"/></svg>
                                Belum ada data dokumen arsip.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- LOOP MODAL DETAIL & EDIT (Ditaruh diluar table agar struktur HTML valid) -->
<?php if (!empty($dokumen) && is_array($dokumen)) : ?>
    <?php foreach ($dokumen as $d) : ?>
        <?php 
            $badgeAkses = 'bg-emerald-100 text-emerald-800 border-emerald-200';
            if (($d['akses'] ?? '') == 'Internal') $badgeAkses = 'bg-amber-100 text-amber-800 border-amber-200';
            if (($d['akses'] ?? '') == 'Rahasia') $badgeAkses = 'bg-rose-100 text-rose-800 border-rose-200';
        ?>

        <!-- MODAL DETAIL -->
        <div id="modalDetail<?= $d['id_dokumen']; ?>" class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-sm flex items-center justify-center p-4">
            <div class="bg-white rounded-2xl shadow-xl max-w-lg w-full overflow-hidden transform transition-all">
                <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="font-bold text-slate-800 text-lg">Detail Dokumen Arsip</h3>
                    <button type="button" onclick="closeModal('modalDetail<?= $d['id_dokumen']; ?>')" class="text-slate-400 hover:text-slate-600 text-xl font-bold">&times;</button>
                </div>
                <div class="p-5 space-y-4">
                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                        <h4 class="font-bold text-slate-900 text-base mb-1"><?= esc($d['judul'] ?: '-'); ?></h4>
                        <p class="text-xs text-slate-500 font-mono mb-2">Nomor: <?= esc($d['nomor_dokumen'] ?: '-'); ?></p>
                        <span class="inline-block border text-xs px-2.5 py-0.5 rounded-full font-semibold <?= $badgeAkses; ?>"><?= esc($d['akses'] ?? 'Publik'); ?></span>
                    </div>
                    <div class="grid grid-cols-2 gap-4 text-xs">
                        <div>
                            <span class="text-slate-400 font-semibold uppercase block mb-1">Kategori</span>
                            <span class="text-slate-700 font-medium"><?= esc($d['kategori'] ?: '-'); ?></span>
                        </div>
                        <div>
                            <span class="text-slate-400 font-semibold uppercase block mb-1">Tanggal Dokumen</span>
                            <span class="text-slate-700 font-medium"><?= !empty($d['tanggal_upload']) ? date('d F Y', strtotime($d['tanggal_upload'])) : '-'; ?></span>
                        </div>
                    </div>
                    <div class="text-xs">
                        <span class="text-slate-400 font-semibold uppercase block mb-1">Berkas File</span>
                        <div class="flex items-center justify-between p-3 border border-slate-200 rounded-xl bg-white">
                            <div class="truncate mr-2">
                                <span class="font-semibold text-slate-700"><?= esc($d['nama_file'] ?: 'Tidak ada berkas terlampir'); ?></span>
                                <?php if (!empty($d['ukuran_file'])) : ?>
                                    <span class="text-slate-400"> (<?= esc($d['ukuran_file']); ?>)</span>
                                <?php endif; ?>
                            </div>
                            <?php if (!empty($d['nama_file'])) : ?>
                                <a href="<?= base_url('admin/dokumen-arsip/download/' . $d['id_dokumen']); ?>" class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-medium whitespace-nowrap transition">Unduh / Lihat</a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="text-xs">
                        <span class="text-slate-400 font-semibold uppercase block mb-1">Keterangan / Deskripsi</span>
                        <div class="p-3 border border-slate-200 rounded-xl bg-slate-50 text-slate-700 leading-relaxed">
                            <?= nl2br(esc($d['deskripsi'] ?: 'Tidak ada keterangan tambahan.')); ?>
                        </div>
                    </div>
                </div>
                <div class="p-4 bg-slate-50 border-t border-slate-100 flex justify-end">
                    <button type="button" onclick="closeModal('modalDetail<?= $d['id_dokumen']; ?>')" class="px-4 py-2 bg-slate-800 text-white text-xs font-medium rounded-lg hover:bg-slate-900 transition">Tutup</button>
                </div>
            </div>
        </div>

        <!-- MODAL EDIT -->
        <div id="modalEdit<?= $d['id_dokumen']; ?>" class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-sm flex items-center justify-center p-4">
            <div class="bg-white rounded-2xl shadow-xl max-w-lg w-full overflow-hidden transform transition-all">
                <form action="<?= base_url('admin/dokumen-arsip/update/' . $d['id_dokumen']); ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field(); ?>
                    <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                        <h3 class="font-bold text-slate-800 text-lg">Edit Dokumen Arsip</h3>
                        <button type="button" onclick="closeModal('modalEdit<?= $d['id_dokumen']; ?>')" class="text-slate-400 hover:text-slate-600 text-xl font-bold">&times;</button>
                    </div>
                    <div class="p-5 space-y-4 text-xs">
                        <div>
                            <label class="block font-semibold text-slate-700 mb-1">Judul Dokumen <span class="text-rose-500">*</span></label>
                            <input type="text" name="judul_dokumen" value="<?= esc($d['judul']); ?>" required class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                        </div>
                        <div>
                            <label class="block font-semibold text-slate-700 mb-1">Nomor Dokumen</label>
                            <input type="text" name="nomor_dokumen" value="<?= esc($d['nomor_dokumen']); ?>" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block font-semibold text-slate-700 mb-1">Kategori <span class="text-rose-500">*</span></label>
                                <select name="kategori" required class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none bg-white">
                                    <option value="SK & Peraturan" <?= $d['kategori'] == 'SK & Peraturan' ? 'selected' : ''; ?>>SK & Peraturan</option>
                                    <option value="Surat Edaran" <?= $d['kategori'] == 'Surat Edaran' ? 'selected' : ''; ?>>Surat Edaran</option>
                                    <option value="Laporan" <?= $d['kategori'] == 'Laporan' ? 'selected' : ''; ?>>Laporan</option>
                                    <option value="Panduan & Pedoman" <?= $d['kategori'] == 'Panduan & Pedoman' ? 'selected' : ''; ?>>Panduan & Pedoman</option>
                                    <option value="Lainnya" <?= $d['kategori'] == 'Lainnya' ? 'selected' : ''; ?>>Lainnya</option>
                                </select>
                            </div>
                            <div>
                                <label class="block font-semibold text-slate-700 mb-1">Tanggal Dokumen <span class="text-rose-500">*</span></label>
                                <input type="date" name="tanggal_dokumen" value="<?= esc($d['tanggal_upload']); ?>" required class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                            </div>
                        </div>
                        <div>
                            <label class="block font-semibold text-slate-700 mb-1">Hak Akses</label>
                            <select name="akses" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none bg-white">
                                <option value="Publik" <?= ($d['akses'] ?? '') == 'Publik' ? 'selected' : ''; ?>>Publik</option>
                                <option value="Internal" <?= ($d['akses'] ?? '') == 'Internal' ? 'selected' : ''; ?>>Internal</option>
                                <option value="Rahasia" <?= ($d['akses'] ?? '') == 'Rahasia' ? 'selected' : ''; ?>>Rahasia</option>
                            </select>
                        </div>
                        <div>
                            <label class="block font-semibold text-slate-700 mb-1">Ganti Berkas File <span class="text-slate-400 font-normal">(Kosongkan jika tidak diubah)</span></label>
                            <input type="file" name="file_dokumen" class="w-full px-3 py-1.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                            <span class="text-slate-400 mt-1 block">File saat ini: <?= esc($d['nama_file'] ?: '-'); ?></span>
                        </div>
                        <div>
                            <label class="block font-semibold text-slate-700 mb-1">Keterangan / Deskripsi</label>
                            <textarea name="keterangan" rows="3" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none"><?= esc($d['deskripsi']); ?></textarea>
                        </div>
                    </div>
                    <div class="p-4 bg-slate-50 border-t border-slate-100 flex justify-end gap-2">
                        <button type="button" onclick="closeModal('modalEdit<?= $d['id_dokumen']; ?>')" class="px-4 py-2 border border-slate-300 text-slate-600 rounded-lg text-xs font-medium hover:bg-slate-100 transition">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-xs font-medium transition">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<!-- MODAL TAMBAH DOKUMEN -->
<div id="modalTambah" class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-xl max-w-lg w-full overflow-hidden transform transition-all">
        <form action="<?= base_url('admin/dokumen-arsip/simpan'); ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field(); ?>
            <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                <h3 class="font-bold text-slate-800 text-lg">Tambah Dokumen Arsip</h3>
                <button type="button" onclick="closeModal('modalTambah')" class="text-slate-400 hover:text-slate-600 text-xl font-bold">&times;</button>
            </div>
            <div class="p-5 space-y-4 text-xs">
                <div>
                    <label class="block font-semibold text-slate-700 mb-1">Judul Dokumen <span class="text-rose-500">*</span></label>
                    <input type="text" name="judul_dokumen" placeholder="Masukkan judul dokumen" value="<?= old('judul_dokumen'); ?>" required class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                <div>
                    <label class="block font-semibold text-slate-700 mb-1">Nomor Dokumen</label>
                    <input type="text" name="nomor_dokumen" placeholder="Contoh: 012/SK/PWM/2026" value="<?= old('nomor_dokumen'); ?>" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Kategori <span class="text-rose-500">*</span></label>
                        <select name="kategori" required class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none bg-white">
                            <option value="">-- Pilih --</option>
                            <option value="SK & Peraturan" <?= old('kategori') == 'SK & Peraturan' ? 'selected' : ''; ?>>SK & Peraturan</option>
                            <option value="Surat Edaran" <?= old('kategori') == 'Surat Edaran' ? 'selected' : ''; ?>>Surat Edaran</option>
                            <option value="Laporan" <?= old('kategori') == 'Laporan' ? 'selected' : ''; ?>>Laporan</option>
                            <option value="Panduan & Pedoman" <?= old('kategori') == 'Panduan & Pedoman' ? 'selected' : ''; ?>>Panduan & Pedoman</option>
                            <option value="Lainnya" <?= old('kategori') == 'Lainnya' ? 'selected' : ''; ?>>Lainnya</option>
                        </select>
                    </div>
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Tanggal Dokumen <span class="text-rose-500">*</span></label>
                        <input type="date" name="tanggal_dokumen" value="<?= old('tanggal_dokumen', date('Y-m-d')); ?>" required class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                </div>
                <div>
                    <label class="block font-semibold text-slate-700 mb-1">Hak Akses</label>
                    <select name="akses" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none bg-white">
                        <option value="Publik" <?= old('akses') == 'Publik' ? 'selected' : ''; ?>>Publik</option>
                        <option value="Internal" <?= old('akses') == 'Internal' ? 'selected' : ''; ?>>Internal</option>
                        <option value="Rahasia" <?= old('akses') == 'Rahasia' ? 'selected' : ''; ?>>Rahasia</option>
                    </select>
                </div>
                <div>
                    <label class="block font-semibold text-slate-700 mb-1">Berkas File <span class="text-rose-500">*</span></label>
                    <input type="file" name="file_dokumen" required class="w-full px-3 py-1.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                    <span class="text-slate-400 mt-1 block">Format: PDF, DOC, DOCX, XLS, XLSX, ZIP, RAR (Maks 10MB)</span>
                </div>
                <div>
                    <label class="block font-semibold text-slate-700 mb-1">Keterangan / Deskripsi</label>
                    <textarea name="keterangan" rows="3" placeholder="Tambahkan keterangan singkat..." class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none"><?= old('keterangan'); ?></textarea>
                </div>
            </div>
            <div class="p-4 bg-slate-50 border-t border-slate-100 flex justify-end gap-2">
                <button type="button" onclick="closeModal('modalTambah')" class="px-4 py-2 border border-slate-300 text-slate-600 rounded-lg text-xs font-medium hover:bg-slate-100 transition">Batal</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-medium transition">Simpan Dokumen</button>
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
</script>
<?= $this->endSection(); ?>