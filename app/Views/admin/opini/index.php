<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="p-6">
    <!-- Header Section -->
    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Daftar Opini</h1>
            <p class="text-xs text-slate-500 mt-1">Kelola artikel opini dan pemikiran dari pengurus maupun kontributor.</p>
        </div>
        <a href="<?= base_url('admin/opini/tambah'); ?>" class="inline-flex items-center justify-center space-x-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2.5 rounded-lg transition shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            <span>Tambah Opini</span>
        </a>
    </div>

    <!-- Alert Flash Data -->
    <?php if (session()->getFlashdata('pesan')) : ?>
        <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-center justify-between" role="alert">
            <div class="flex items-center space-x-2">
                <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span><?= session()->getFlashdata('pesan'); ?></span>
            </div>
        </div>
    <?php endif; ?>

    <!-- Table Card Container -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-xs font-semibold uppercase tracking-wider text-slate-500">
                        <th class="py-3.5 px-4 text-center w-12">No</th>
                        <th class="py-3.5 px-4">Gambar</th>
                        <th class="py-3.5 px-4">Judul Opini</th>
                        <th class="py-3.5 px-4">Penulis / Profesi</th>
                        <th class="py-3.5 px-4">Tanggal</th>
                        <th class="py-3.5 px-4">Status</th>
                        <th class="py-3.5 px-4 text-center">Dibaca</th>
                        <th class="py-3.5 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 text-sm text-slate-700">
                    <?php $no = 1; foreach ($opini as $row) : ?>
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="py-4 px-4 text-center text-slate-500 font-medium"><?= $no++; ?></td>
                            <td class="py-4 px-4">
                                <?php if ($row['gambar']) : ?>
                                    <img src="<?= base_url('uploads/opini/' . $row['gambar']); ?>" alt="Gambar" class="w-14 h-14 object-cover rounded-lg border border-slate-200 shadow-xs">
                                <?php else : ?>
                                    <span class="inline-block px-2.5 py-1 text-xs font-medium bg-slate-100 text-slate-500 rounded-md">Tidak ada</span>
                                <?php endif; ?>
                            </td>
                            <td class="py-4 px-4 max-w-xs">
                                <div class="font-semibold text-slate-800 line-clamp-2"><?= esc($row['judul']); ?></div>
                                <div class="text-xs text-slate-400 mt-1 truncate">Slug: <?= esc($row['slug']); ?></div>
                            </td>
                            <td class="py-4 px-4">
                                <div class="font-medium text-slate-800"><?= esc($row['penulis'] ?? '-'); ?></div>
                                <div class="text-xs text-slate-500 mt-0.5"><?= esc($row['profesi_penulis'] ?? '-'); ?></div>
                            </td>
                            <td class="py-4 px-4 whitespace-nowrap text-slate-600">
                                <?= date('d/m/Y', strtotime($row['tanggal'])); ?>
                            </td>
                            <td class="py-4 px-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold <?= $row['status'] == 'Publish' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800'; ?>">
                                    <?= $row['status']; ?>
                                </span>
                            </td>
                            <td class="py-4 px-4 text-center whitespace-nowrap text-slate-500 font-medium">
                                <?= $row['views']; ?>x
                            </td>
                            <td class="py-4 px-4 text-center whitespace-nowrap">
                                <div class="flex items-center justify-center space-x-2">
                                    <a href="<?= base_url('admin/opini/edit/' . $row['id_opini']); ?>" class="inline-flex items-center space-x-1 px-3 py-1.5 bg-sky-500 hover:bg-sky-600 text-white text-xs font-medium rounded-md transition shadow-xs">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        <span>Edit</span>
                                    </a>
                                    <a href="<?= base_url('admin/opini/hapus/' . $row['id_opini']); ?>" class="inline-flex items-center space-x-1 px-3 py-1.5 bg-rose-600 hover:bg-rose-700 text-white text-xs font-medium rounded-md transition shadow-xs" onclick="return confirm('Apakah Anda yakin ingin menghapus opini ini?');">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        <span>Hapus</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                    <?php if (empty($opini)) : ?>
                        <tr>
                            <td colspan="8" class="py-8 text-center text-slate-400 font-medium">
                                Belum ada data opini.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>