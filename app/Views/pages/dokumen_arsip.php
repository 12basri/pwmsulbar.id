<?= $this->extend('pages/layout/main') ?>

<?= $this->section('content') ?>

<!-- Header Section -->
<section class="bg-gradient-to-r from-blue-900 to-blue-700 text-white py-12 mb-8 shadow-md">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl md:text-4xl font-bold mb-2">Dokumen & Arsip</h1>
        <p class="text-blue-100 text-base md:text-lg">Layanan pengunduhan dokumen resmi, SK, dan arsip PWM Sulawesi Barat.</p>
    </div>
</section>

<!-- Main Content -->
<div class="container mx-auto px-4 mb-12">
    
    <!-- Filter & Search Bar -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8">
        <form method="GET" action="<?= base_url('dokumen-arsip') ?>" class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
            
            <!-- Input Cari -->
            <div class="md:col-span-5">
                <div class="relative">
                    <input type="text" name="q" class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition" placeholder="Cari judul atau nomor dokumen..." value="<?= esc($keyword ?? '') ?>">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </div>
            </div>

            <!-- Dropdown Kategori -->
            <div class="md:col-span-4">
                <select name="kategori" class="w-full py-2.5 px-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm text-gray-700 transition">
                    <option value="">-- Semua Kategori --</option>
                    <option value="SK & Peraturan" <?= ($filterKategori ?? '') === 'SK & Peraturan' ? 'selected' : '' ?>>SK & Peraturan</option>
                    <option value="Surat Edaran" <?= ($filterKategori ?? '') === 'Surat Edaran' ? 'selected' : '' ?>>Surat Edaran</option>
                    <option value="Panduan & Laporan" <?= ($filterKategori ?? '') === 'Panduan & Laporan' ? 'selected' : '' ?>>Panduan & Laporan</option>
                    <option value="Formulir" <?= ($filterKategori ?? '') === 'Formulir' ? 'selected' : '' ?>>Formulir</option>
                </select>
            </div>

            <!-- Tombol Aksi -->
            <div class="md:col-span-3 flex gap-2">
                <button type="submit" class="flex-1 bg-blue-700 hover:bg-blue-800 text-white font-medium py-2.5 px-4 rounded-lg text-sm transition flex items-center justify-center gap-2 shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    Cari
                </button>
                <?php if (!empty($keyword) || !empty($filterKategori)): ?>
                    <a href="<?= base_url('dokumen-arsip') ?>" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-2.5 px-4 rounded-lg text-sm transition text-center">
                        Reset
                    </a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <!-- Tabel Dokumen -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        <th class="py-3.5 px-4 text-center w-12">No</th>
                        <th class="py-3.5 px-4">Judul / Nama Dokumen</th>
                        <th class="py-3.5 px-4">Nomor Dokumen</th>
                        <th class="py-3.5 px-4">Kategori</th>
                        <th class="py-3.5 px-4 text-center">Tanggal</th>
                        <th class="py-3.5 px-4 text-center w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-sm">
                    <?php if (!empty($dokumen) && is_array($dokumen)): ?>
                        <?php $no = 1; foreach ($dokumen as $row): ?>
                            <tr class="hover:bg-gray-50/80 transition">
                                <td class="py-4 px-4 text-center font-medium text-gray-500"><?= $no++ ?></td>
                                <td class="py-4 px-4">
                                    <div class="font-semibold text-gray-900"><?= esc($row['judul'] ?? 'Tanpa Judul') ?></div>
                                    <?php if (!empty($row['deskripsi'])): ?>
                                        <p class="text-xs text-gray-500 mt-1 line-clamp-2"><?= esc($row['deskripsi']) ?></p>
                                    <?php endif; ?>
                                </td>
                                <td class="py-4 px-4">
                                    <span class="inline-block px-2.5 py-1 text-xs font-mono bg-gray-100 text-gray-700 rounded border border-gray-200">
                                        <?= esc($row['nomor_dokumen'] ?? '-') ?>
                                    </span>
                                </td>
                                <td class="py-4 px-4">
                                    <span class="inline-block px-2.5 py-1 text-xs font-semibold bg-blue-50 text-blue-700 rounded-full border border-blue-100">
                                        <?= esc($row['kategori'] ?? 'Umum') ?>
                                    </span>
                                </td>
                                <td class="py-4 px-4 text-center text-xs text-gray-500">
                                    <?= !empty($row['tanggal_upload']) ? date('d/m/Y', strtotime($row['tanggal_upload'])) : '-' ?>
                                </td>
                                <td class="py-4 px-4 text-center">
                                    <?php if (!empty($row['nama_file'])): ?>
                                        <a href="<?= base_url('uploads/dokumen/' . $row['nama_file']) ?>" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-700 font-medium text-xs rounded-lg border border-blue-200 transition">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                            Unduh
                                        </a>
                                    <?php else: ?>
                                        <span class="inline-block px-3 py-1.5 bg-gray-100 text-gray-400 font-medium text-xs rounded-lg cursor-not-allowed">
                                            Tidak ada file
                                        </span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="py-8 px-4 text-center text-gray-500 italic">
                                Tidak ada dokumen atau arsip yang ditemukan.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <?php if (isset($pager)): ?>
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end">
                <?= $pager->links('dokumen', 'default_full') ?>
            </div>
        <?php endif; ?>
    </div>

</div>

<?= $this->endSection() ?>