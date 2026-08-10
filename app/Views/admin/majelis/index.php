<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<main class="flex-1 p-6 md:p-8">

    <!-- Header & Breadcrumbs -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
        <div>
            <nav class="flex text-sm text-slate-500 mb-1" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2">
                    <li><a href="<?= base_url('admin/dashboard') ?>" class="hover:text-emerald-600 transition-colors">Admin</a></li>
                    <li><span class="mx-1 text-slate-400">/</span></li>
                    <li><span class="text-slate-400">Profil</span></li>
                    <li><span class="mx-1 text-slate-400">/</span></li>
                    <li class="font-medium text-slate-800">Majelis & Lembaga</li>
                </ol>
            </nav>
            <h1 class="text-2xl font-bold text-slate-800">Kelola Data Majelis & Lembaga</h1>
        </div>

        <button type="button" onclick="openModalTambah()" class="inline-flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-medium px-4 py-2.5 rounded-lg shadow-sm transition-all duration-200">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            <span>Tambah Majelis</span>
        </button>
    </div>

    <!-- Alert Flash Data -->
    <?php if (session()->getFlashdata('sukses')) : ?>
        <div class="mb-5 p-4 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-center justify-between">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span><?= session()->getFlashdata('sukses') ?></span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('gagal')) : ?>
        <div class="mb-5 p-4 rounded-lg bg-rose-50 border border-rose-200 text-rose-800 text-sm flex items-center justify-between">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span><?= session()->getFlashdata('gagal') ?></span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-700">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    <?php endif; ?>

    <!-- Main Card Wrapper -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200/80 overflow-hidden">

        <!-- Search Bar -->
        <div class="p-5 border-b border-slate-100 bg-slate-50/50">
            <form action="<?= base_url('admin/majelis') ?>" method="GET" class="flex gap-3">
                <div class="relative flex-1">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </span>
                    <input type="text" name="q" value="<?= esc($keyword ?? '') ?>" placeholder="Cari majelis, ketua, atau sekretaris..." class="w-full pl-9 pr-4 py-2 bg-white border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all">
                </div>
                <button type="submit" class="py-2 px-4 bg-slate-800 hover:bg-slate-900 text-white rounded-lg text-sm font-medium transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                    <span>Cari</span>
                </button>
                <?php if (!empty($keyword)): ?>
                    <a href="<?= base_url('admin/majelis') ?>" class="py-2 px-3 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-lg text-sm font-medium transition-all flex items-center justify-center" title="Reset">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                    </a>
                <?php endif; ?>
            </form>
        </div>

        <!-- Data Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 text-slate-700 uppercase text-xs font-semibold tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="py-3.5 px-4 w-12 text-center">No</th>
                        <th class="py-3.5 px-4">Jenis & Nama Majelis</th>
                        <th class="py-3.5 px-4">Ketua</th>
                        <th class="py-3.5 px-4">Sekretaris</th>
                        <th class="py-3.5 px-4 text-center">Status</th>
                        <th class="py-3.5 px-4 w-44 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php if (!empty($majelis) && is_array($majelis)) : ?>
                        <?php foreach ($majelis as $index => $row) : ?>
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="py-4 px-4 text-center font-medium text-slate-400">
                                    <?= isset($pager) ? $pager->getDetails()['currentPage'] * $pager->getDetails()['perPage'] - $pager->getDetails()['perPage'] + $index + 1 : $index + 1 ?>
                                </td>
                                <td class="py-4 px-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center text-xs font-bold shrink-0 border border-emerald-200">
                                            <?= strtoupper(substr($row['nama_majelis'] ?? 'M', 0, 1)) ?>
                                        </div>
                                        <div>
                                            <span class="text-[10px] uppercase tracking-wider font-semibold px-2 py-0.5 rounded bg-slate-100 text-slate-600 border border-slate-200"><?= esc($row['jenis'] ?? 'Majelis') ?></span>
                                            <div class="font-semibold text-slate-800 mt-1"><?= esc($row['nama_majelis']) ?></div>
                                            <p class="text-xs text-slate-500 line-clamp-1 mt-0.5"><?= esc($row['deskripsi_singkat'] ?? '-') ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-4 font-medium text-slate-700">
                                    <?= esc($row['ketua'] ?? '-') ?>
                                </td>
                                <td class="py-4 px-4 text-slate-600">
                                    <?= esc($row['sekretaris'] ?? '-') ?>
                                </td>
                                <td class="py-4 px-4 text-center">
                                    <span class="px-2.5 py-1 rounded-full text-xs font-medium <?= ($row['status'] ?? 'aktif') === 'aktif' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-600' ?>">
                                        <?= ucfirst(esc($row['status'] ?? 'aktif')) ?>
                                    </span>
                                </td>
                                <td class="py-4 px-4 text-center">
                                    <div class="inline-flex items-center justify-center gap-1.5">
                                        <!-- 1. Tombol Kelola Detail Struktur (Pimpinan, Pakar, Bidang) -->
                                        <a href="<?= base_url('admin/majelis/detail/' . $row['id_majelis']) ?>"
                                            class="w-8 h-8 inline-flex items-center justify-center rounded-lg bg-emerald-50 text-emerald-600 hover:bg-emerald-600 hover:text-white border border-emerald-200/80 transition-all duration-200"
                                            title="Kelola Pengurus & Pimpinan">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>

                                        <!-- 2. Tombol Kelola Anggota Bidang -->
                                        <a href="<?= base_url('admin/majelis/' . $row['id_majelis'] . '/anggota') ?>"
                                            class="w-8 h-8 inline-flex items-center justify-center rounded-lg bg-purple-50 text-purple-600 hover:bg-purple-600 hover:text-white border border-purple-200/80 transition-all duration-200"
                                            title="Kelola Anggota Bidang">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                        </a>

                                        <!-- 3. Tombol Edit Utama -->
                                        <button type="button"
                                            data-id="<?= esc($row['id_majelis']) ?>"
                                            data-jenis="<?= esc($row['jenis'] ?? 'Majelis') ?>"
                                            data-nama="<?= esc($row['nama_majelis']) ?>"
                                            data-deskripsi="<?= esc($row['deskripsi_singkat'] ?? '') ?>"
                                            data-sk="<?= esc($row['nomor_sk'] ?? '') ?>"
                                            data-periode="<?= esc($row['periode'] ?? '2022-2027') ?>"
                                            data-status="<?= esc($row['status'] ?? 'aktif') ?>"
                                            onclick="openModalEdit(this)"
                                            class="w-8 h-8 inline-flex items-center justify-center rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white border border-blue-200/80 transition-all duration-200"
                                            title="Edit Data Utama">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>

                                        <!-- 4. Tombol Hapus -->
                                        <button type="button" onclick="openModalHapus('<?= esc($row['id_majelis']) ?>')"
                                            class="w-8 h-8 inline-flex items-center justify-center rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white border border-rose-200/80 transition-all duration-200"
                                            title="Hapus Data">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400 text-sm">
                                Belum ada data majelis atau lembaga yang ditemukan.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="px-5 py-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
            <span>Total data: <strong><?= count($majelis ?? []) ?></strong> majelis/lembaga</span>
            <?php if (isset($pager)) : ?>
                <div><?= $pager->links('default', 'default_full') ?></div>
            <?php endif; ?>
        </div>

    </div>
</main>

<!-- MODAL FORM TAMBAH / EDIT -->
<div id="modalMajelis" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm hidden" onclick="handleBackdropClick(event, 'modalMajelis')">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-xl overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
            <h3 id="modalTitle" class="font-bold text-slate-800 text-lg">Tambah Majelis / Lembaga</h3>
            <button type="button" onclick="closeModal('modalMajelis')" class="text-slate-400 hover:text-slate-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <form id="formMajelis" action="<?= base_url('admin/majelis/simpan') ?>" method="POST">
            <?= csrf_field() ?>

            <div class="p-6 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Jenis <span class="text-rose-500">*</span></label>
                        <select id="inputJenis" name="jenis" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                            <option value="Majelis">Majelis</option>
                            <option value="Lembaga">Lembaga</option>
                            <option value="Biro">Biro</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Periode <span class="text-rose-500">*</span></label>
                        <input type="text" id="inputPeriode" name="periode" required placeholder="Contoh: 2022-2027" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Nama Majelis / Lembaga <span class="text-rose-500">*</span></label>
                    <input type="text" id="inputNamaMajelis" name="nama_majelis" required placeholder="Contoh: Majelis Tarjih dan Tajdid" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Nomor SK</label>
                        <input type="text" id="inputNomorSK" name="nomor_sk" placeholder="Contoh: 01/SK/2023" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Status</label>
                        <select id="inputStatus" name="status" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                            <option value="aktif">Aktif</option>
                            <option value="nonaktif">Nonaktif</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Deskripsi Singkat</label>
                    <textarea id="inputDeskripsi" name="deskripsi_singkat" rows="3" placeholder="Deskripsi tugas atau gambaran umum..." class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 outline-none"></textarea>
                </div>
            </div>

            <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-2">
                <button type="button" onclick="closeModal('modalMajelis')" class="px-4 py-2 bg-white border border-slate-300 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-50">Batal</button>
                <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-sm font-medium inline-flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                    </svg>
                    <span>Simpan</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL HAPUS -->
<div id="modalHapus" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm hidden" onclick="handleBackdropClick(event, 'modalHapus')">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-6 text-center">
        <div class="w-12 h-12 bg-rose-100 text-rose-600 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
        </div>
        <h3 class="text-lg font-bold text-slate-800 mb-1">Hapus Data Majelis?</h3>
        <p class="text-sm text-slate-500 mb-6">Apakah Anda yakin ingin menghapus majelis/lembaga ini? Tindakan ini tidak dapat dibatalkan.</p>

        <form id="formHapus" method="POST" action="">
            <?= csrf_field() ?>
            <div class="flex items-center justify-center gap-3">
                <button type="button" onclick="closeModal('modalHapus')" class="w-full py-2 bg-white border border-slate-300 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-50">Batal</button>
                <button type="submit" class="w-full py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-sm font-medium">Ya, Hapus</button>
            </div>
        </form>
    </div>
</div>

<script>
    const baseUrl = "<?= rtrim(base_url('admin/majelis'), '/') ?>";

    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
    }

    function handleBackdropClick(event, id) {
        if (event.target.id === id) {
            closeModal(id);
        }
    }

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeModal('modalMajelis');
            closeModal('modalHapus');
        }
    });

    function openModalTambah() {
        document.getElementById('modalTitle').innerText = 'Tambah Majelis / Lembaga';
        document.getElementById('formMajelis').action = `${baseUrl}/simpan`;

        document.getElementById('formMajelis').reset();
        document.getElementById('inputPeriode').value = '2022-2027';
        document.getElementById('modalMajelis').classList.remove('hidden');
    }

    function openModalEdit(btn) {
        const ds = btn.dataset;

        document.getElementById('modalTitle').innerText = 'Edit Majelis / Lembaga';
        document.getElementById('formMajelis').action = `${baseUrl}/update/${ds.id}`;

        document.getElementById('inputJenis').value = ds.jenis || 'Majelis';
        document.getElementById('inputNamaMajelis').value = ds.nama || '';
        document.getElementById('inputNomorSK').value = ds.sk || '';
        document.getElementById('inputPeriode').value = ds.periode || '2022-2027';
        document.getElementById('inputStatus').value = ds.status || 'aktif';
        document.getElementById('inputDeskripsi').value = ds.deskripsi || '';

        document.getElementById('modalMajelis').classList.remove('hidden');
    }

    function openModalHapus(id) {
        document.getElementById('formHapus').action = `${baseUrl}/hapus/${id}`;
        document.getElementById('modalHapus').classList.remove('hidden');
    }
</script>

<?= $this->endSection() ?>