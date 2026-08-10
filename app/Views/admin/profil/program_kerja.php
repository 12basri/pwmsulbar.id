<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<main class="flex-1 p-6 md:p-8">

    <!-- Header & Breadcrumbs -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
        <div>
            <nav class="flex text-sm text-slate-500 mb-1" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2">
                    <li><a href="<?= base_url('admin/dashboard') ?>" class="hover:text-emerald-600">Admin</a></li>
                    <li><span class="mx-1 text-slate-400">/</span></li>
                    <li><span class="text-slate-400">Profil</span></li>
                    <li><span class="mx-1 text-slate-400">/</span></li>
                    <li class="font-medium text-slate-800">Program Kerja</li>
                </ol>
            </nav>
            <h1 class="text-2xl font-bold text-slate-800">Kelola Program Kerja Majelis / Lembaga</h1>
        </div>

        <button onclick="openModalTambah()" class="inline-flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-medium px-4 py-2.5 rounded-lg shadow-sm transition-all duration-200">
            <i class="fa-solid fa-plus text-sm"></i>
            <span>Tambah Program Kerja</span>
        </button>
    </div>

    <!-- Alert Notifications -->
    <?php if (session()->getFlashdata('sukses')) : ?>
        <div class="mb-5 p-4 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-center justify-between">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-circle-check text-emerald-600 text-base"></i>
                <span><?= session()->getFlashdata('sukses') ?></span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700"><i class="fa-solid fa-xmark"></i></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('gagal')) : ?>
        <div class="mb-5 p-4 rounded-lg bg-rose-50 border border-rose-200 text-rose-800 text-sm flex items-center justify-between">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-triangle-exclamation text-rose-600 text-base"></i>
                <span><?= session()->getFlashdata('gagal') ?></span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-700"><i class="fa-solid fa-xmark"></i></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('errors')) : ?>
        <div class="mb-5 p-4 rounded-lg bg-rose-50 border border-rose-200 text-rose-800 text-sm">
            <div class="font-semibold mb-1 flex items-center gap-2">
                <i class="fa-solid fa-triangle-exclamation text-rose-600"></i>
                <span>Gagal Menyimpan Data:</span>
            </div>
            <ul class="list-disc list-inside space-y-1 text-xs">
                <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <!-- Main Card Wrapper -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200/80 overflow-hidden">

        <!-- Filter & Search Bar -->
        <div class="p-5 border-b border-slate-100 bg-slate-50/50">
            <form action="<?= base_url('admin/profil/program-kerja') ?>" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3">

                <!-- Search Input -->
                <div class="lg:col-span-4">
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </span>
                        <input type="text" name="q" value="<?= esc($keyword ?? '') ?>" placeholder="Cari nama program..." class="w-full pl-9 pr-4 py-2 bg-white border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all">
                    </div>
                </div>

                <!-- Filter Majelis / Lembaga -->
                <div class="lg:col-span-4">
                    <select name="id_majelis" class="w-full py-2 px-3 bg-white border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none text-slate-700">
                        <option value="">-- Semua Majelis / Lembaga --</option>
                        <?php if (!empty($listMajelis) && is_array($listMajelis)) : ?>
                            <?php foreach ($listMajelis as $m) : ?>
                                <option value="<?= esc($m['id_majelis']) ?>" <?= (($filterMajelis ?? '') == $m['id_majelis']) ? 'selected' : '' ?>>
                                    <?= esc($m['nama_majelis'] ?? $m['nama_lembaga'] ?? 'Majelis ID: ' . $m['id_majelis']) ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <!-- Filter Status -->
                <div class="lg:col-span-2">
                    <select name="status" class="w-full py-2 px-3 bg-white border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none text-slate-700">
                        <option value="">-- Status --</option>
                        <option value="Aktif" <?= (($filterStatus ?? '') == 'Aktif') ? 'selected' : '' ?>>Aktif</option>
                        <option value="Perencanaan" <?= (($filterStatus ?? '') == 'Perencanaan') ? 'selected' : '' ?>>Perencanaan</option>
                        <option value="Selesai" <?= (($filterStatus ?? '') == 'Selesai') ? 'selected' : '' ?>>Selesai</option>
                    </select>
                </div>

                <!-- Submit & Reset Button -->
                <div class="lg:col-span-2 flex items-center gap-2">
                    <button type="submit" class="w-full py-2 px-4 bg-slate-800 hover:bg-slate-900 text-white rounded-lg text-sm font-medium transition-all flex items-center justify-center gap-2">
                        <i class="fa-solid fa-filter text-xs"></i>
                        <span>Filter</span>
                    </button>
                    <?php if (!empty($keyword) || !empty($filterMajelis) || !empty($filterStatus)): ?>
                        <a href="<?= base_url('admin/profil/program-kerja') ?>" class="py-2 px-3 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-lg text-sm font-medium transition-all" title="Reset Filter">
                            <i class="fa-solid fa-arrows-rotate"></i>
                        </a>
                    <?php endif; ?>
                </div>

            </form>
        </div>

        <!-- Data Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 text-slate-700 uppercase text-xs font-semibold tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="py-3.5 px-4 w-12 text-center">No</th>
                        <th class="py-3.5 px-4">Nama Program Kerja</th>
                        <th class="py-3.5 px-4">Induk Majelis / Lembaga</th>
                        <th class="py-3.5 px-4 w-24 text-center">Tahun</th>
                        <th class="py-3.5 px-4 w-28 text-center">Status</th>
                        <th class="py-3.5 px-4 w-32 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">

                    <?php if (!empty($program_kerja) && is_array($program_kerja)) : ?>
                        <?php foreach ($program_kerja as $index => $row) : ?>
                            <?php
                            $idProgram      = $row['id_program'];
                            $namaMajelisTbl = $row['nama_majelis'] ?? $row['nama_lembaga'] ?? 'Majelis / Lembaga Tidak Ditemukan';
                            ?>
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="py-4 px-4 text-center font-medium text-slate-400"><?= $index + 1 ?></td>
                                <td class="py-4 px-4">
                                    <div class="font-semibold text-slate-800"><?= esc($row['nama_program']) ?></div>
                                    <p class="text-xs text-slate-500 mt-0.5 line-clamp-1"><?= esc($row['deskripsi'] ?? '-') ?></p>
                                </td>
                                <td class="py-4 px-4">
                                    <div class="font-medium text-slate-700"><?= esc($namaMajelisTbl) ?></div>
                                    <?php if (!empty($row['kategori'])): ?>
                                        <span class="inline-block mt-0.5 text-[11px] bg-slate-100 text-slate-600 px-2 py-0.5 rounded font-normal border border-slate-200">
                                            <?= esc($row['kategori']) ?>
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-4 px-4 text-center font-medium text-slate-700"><?= esc($row['tahun'] ?? date('Y')) ?></td>
                                <td class="py-4 px-4 text-center">
                                    <?php
                                    $status = $row['status'] ?? 'Perencanaan';
                                    $badgeStyle = 'bg-slate-100 text-slate-600 border-slate-200';
                                    $dotStyle   = 'bg-slate-400';

                                    if ($status === 'Aktif') {
                                        $badgeStyle = 'bg-emerald-50 text-emerald-700 border-emerald-200';
                                        $dotStyle   = 'bg-emerald-500';
                                    } elseif ($status === 'Selesai') {
                                        $badgeStyle = 'bg-blue-50 text-blue-700 border-blue-200';
                                        $dotStyle   = 'bg-blue-500';
                                    } elseif ($status === 'Perencanaan') {
                                        $badgeStyle = 'bg-amber-50 text-amber-700 border-amber-200';
                                        $dotStyle   = 'bg-amber-500';
                                    }
                                    ?>
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium border <?= $badgeStyle ?>">
                                        <span class="w-1.5 h-1.5 rounded-full <?= $dotStyle ?>"></span>
                                        <?= esc($status) ?>
                                    </span>
                                </td>

                                <!-- TOMBOL AKSI -->
                                <td class="py-4 px-4 text-center">
                                    <div class="inline-flex items-center justify-center gap-1">
                                        <button type="button" data-item='<?= json_encode($row, JSON_HEX_APOS | JSON_HEX_QUOT) ?>' onclick="openModalDetail(this)" class="p-1.5 text-slate-500 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors" title="Lihat Detail">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </button>

                                        <button type="button" data-item='<?= json_encode($row, JSON_HEX_APOS | JSON_HEX_QUOT) ?>' onclick="openModalEdit(this)" class="p-1.5 text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition-colors" title="Edit Data">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>

                                        <button type="button" onclick="openModalHapus('<?= esc($idProgram) ?>')" class="p-1.5 text-rose-600 hover:text-rose-800 hover:bg-rose-50 rounded-lg transition-colors" title="Hapus Data">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6h4m-4-6h4m-6 0h8m-10 0a2 2 0 00-2 2v1m14-3a2 2 0 012 2v1" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400 text-sm">
                                Belum ada data program kerja yang terdaftar.
                            </td>
                        </tr>
                    <?php endif; ?>

                </tbody>
            </table>
        </div>

        <div class="px-5 py-4 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-500">
            <span>Total data: <strong><?= count($program_kerja ?? []) ?></strong> program kerja</span>
        </div>

    </div>
</main>

<!-- MODAL DETAIL -->
<div id="modalDetail" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm hidden">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-lg overflow-hidden transform transition-all">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100 bg-slate-50/50">
            <h3 class="font-bold text-slate-800 text-lg flex items-center gap-2">
                <i class="fa-solid fa-circle-info text-emerald-600"></i>
                <span>Detail Program Kerja</span>
            </h3>
            <button type="button" onclick="closeModal('modalDetail')" class="text-slate-400 hover:text-slate-600 text-lg">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div class="p-6 space-y-4 text-sm text-slate-700">
            <div>
                <h4 id="detailNamaProgram" class="font-bold text-slate-800 text-base"></h4>
                <p id="detailMajelis" class="text-xs text-emerald-600 font-semibold mt-1"></p>
                <p id="detailKategori" class="text-xs text-slate-500 mt-0.5"></p>
            </div>

            <div class="grid grid-cols-2 gap-4 pt-2 border-t border-slate-100">
                <div>
                    <span class="block text-xs font-semibold text-slate-400 uppercase mb-1">Tahun Pelaksanaan</span>
                    <span id="detailTahun" class="font-medium text-slate-800"></span>
                </div>
                <div>
                    <span class="block text-xs font-semibold text-slate-400 uppercase mb-1">Status</span>
                    <div id="detailStatus"></div>
                </div>
            </div>

            <div class="pt-2 border-t border-slate-100">
                <span class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Deskripsi / Rincian Program</span>
                <p id="detailDeskripsi" class="text-slate-600 bg-slate-50 p-3 rounded-lg text-xs leading-relaxed whitespace-pre-line"></p>
            </div>
        </div>
        <div class="px-6 py-3.5 bg-slate-50 border-t border-slate-100 text-right">
            <button type="button" onclick="closeModal('modalDetail')" class="px-4 py-2 bg-slate-800 hover:bg-slate-900 text-white rounded-lg text-xs font-medium transition-colors">Tutup</button>
        </div>
    </div>
</div>

<!-- MODAL FORM TAMBAH / EDIT -->
<div id="modalProgramKerja" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm hidden">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-2xl overflow-hidden transform transition-all">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
            <h3 id="modalTitle" class="font-bold text-slate-800 text-lg">Tambah Program Kerja</h3>
            <button type="button" onclick="closeModal('modalProgramKerja')" class="text-slate-400 hover:text-slate-600 text-lg">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form id="formProgramKerja" action="<?= base_url('admin/profil/program-kerja/simpan') ?>" method="POST">
            <?= csrf_field() ?>

            <div class="p-6 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                    <div class="md:col-span-8">
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Nama Program Kerja <span class="text-rose-500">*</span></label>
                        <input type="text" id="inputNamaProgram" name="nama_program" required placeholder="Contoh: Rakerwil Majelis Dikdasmen" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none">
                    </div>
                    <div class="md:col-span-4">
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Kategori Program</label>
                        <input type="text" id="inputKategori" name="kategori" placeholder="Contoh: Pendidikan / Cadre" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                    <div class="md:col-span-6">
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Pilih Majelis / Lembaga Induk <span class="text-rose-500">*</span></label>
                        <select id="selectIdMajelis" name="id_majelis" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none">
                            <option value="">-- Pilih Majelis / Lembaga --</option>
                            <?php if (!empty($listMajelis) && is_array($listMajelis)) : ?>
                                <?php foreach ($listMajelis as $m) : ?>
                                    <option value="<?= esc($m['id_majelis']) ?>">
                                        <?= esc($m['nama_majelis'] ?? $m['nama_lembaga'] ?? 'Majelis ID: ' . $m['id_majelis']) ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <p class="text-[11px] text-slate-400 mt-1">*Diperlukan sesuai relasi tabel parent `majelis_lembaga`</p>
                    </div>

                    <div class="md:col-span-3">
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Tahun <span class="text-rose-500">*</span></label>
                        <input type="number" id="inputTahun" name="tahun" required placeholder="<?= date('Y') ?>" value="<?= date('Y') ?>" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none">
                    </div>

                    <div class="md:col-span-3">
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Status <span class="text-rose-500">*</span></label>
                        <select id="selectStatus" name="status" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none">
                            <option value="Aktif">Aktif</option>
                            <option value="Perencanaan">Perencanaan</option>
                            <option value="Selesai">Selesai</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Deskripsi & Indikator Keberhasilan</label>
                    <textarea id="inputDeskripsi" name="deskripsi" rows="4" placeholder="Tuliskan rinci uraian kegiatan dan target pencapaian..." class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none"></textarea>
                </div>
            </div>

            <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-2">
                <button type="button" onclick="closeModal('modalProgramKerja')" class="px-4 py-2 bg-white border border-slate-300 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-50 transition-colors">Batal</button>
                <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-sm font-medium transition-colors inline-flex items-center gap-1.5">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Simpan Data</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL HAPUS -->
<div id="modalHapus" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm hidden">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md overflow-hidden p-6 text-center">
        <div class="w-12 h-12 bg-rose-100 text-rose-600 rounded-full flex items-center justify-center mx-auto mb-4 text-xl">
            <i class="fa-solid fa-triangle-exclamation"></i>
        </div>
        <h3 class="text-lg font-bold text-slate-800 mb-1">Hapus Program Kerja?</h3>
        <p class="text-sm text-slate-500 mb-6">Apakah Anda yakin ingin menghapus data ini? Aksi ini tidak dapat dibatalkan.</p>
        <form id="formHapus" action="" method="POST" class="flex items-center justify-center gap-3">
            <?= csrf_field() ?>
            <button type="button" onclick="closeModal('modalHapus')" class="w-full py-2 bg-white border border-slate-300 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-50 transition-colors">Batal</button>
            <button type="submit" class="w-full py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-sm font-medium transition-colors">Ya, Hapus</button>
        </form>
    </div>
</div>

<!-- JAVASCRIPT AKSI & MODAL -->
<script>
    const baseUrl = "<?= base_url('admin/profil/program-kerja') ?>";

    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }

    function openModalDetail(btn) {
        const data = JSON.parse(btn.getAttribute('data-item'));
        const namaMajelis = data.nama_majelis || data.nama_lembaga || 'Tidak Terikat Majelis Spesifik';

        document.getElementById('detailNamaProgram').innerText = data.nama_program || '-';
        document.getElementById('detailMajelis').innerText = `Majelis / Lembaga: ${namaMajelis}`;
        document.getElementById('detailKategori').innerText = data.kategori ? `Kategori: ${data.kategori}` : '';
        document.getElementById('detailTahun').innerText = data.tahun || '<?= date('Y') ?>';
        document.getElementById('detailDeskripsi').innerText = data.deskripsi || 'Tidak ada uraian deskripsi.';

        const statusEl = document.getElementById('detailStatus');
        const status = data.status || 'Aktif';

        if (status === 'Aktif') {
            statusEl.innerHTML = `<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-200"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>Aktif</span>`;
        } else if (status === 'Selesai') {
            statusEl.innerHTML = `<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200"><span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>Selesai</span>`;
        } else {
            statusEl.innerHTML = `<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-amber-50 text-amber-700 border border-amber-200"><span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>Perencanaan</span>`;
        }

        document.getElementById('modalDetail').classList.remove('hidden');
    }

    function openModalTambah() {
        document.getElementById('modalTitle').innerText = 'Tambah Program Kerja';
        document.getElementById('formProgramKerja').action = `${baseUrl}/simpan`;

        document.getElementById('formProgramKerja').reset();
        document.getElementById('inputTahun').value = "<?= date('Y') ?>";
        document.getElementById('selectStatus').value = "Aktif";

        document.getElementById('modalProgramKerja').classList.remove('hidden');
    }

    function openModalEdit(btn) {
        const data = JSON.parse(btn.getAttribute('data-item'));

        document.getElementById('modalTitle').innerText = 'Edit Program Kerja';
        document.getElementById('formProgramKerja').action = `${baseUrl}/update/${data.id_program}`;
        document.getElementById('inputNamaProgram').value = data.nama_program || '';
        document.getElementById('inputKategori').value = data.kategori || '';
        document.getElementById('selectIdMajelis').value = data.id_majelis || '';
        document.getElementById('inputTahun').value = data.tahun || '<?= date('Y') ?>';
        document.getElementById('selectStatus').value = data.status || 'Aktif';
        document.getElementById('inputDeskripsi').value = data.deskripsi || '';

        document.getElementById('modalProgramKerja').classList.remove('hidden');
    }

    function openModalHapus(id) {
        document.getElementById('formHapus').action = `${baseUrl}/hapus/${id}`;
        document.getElementById('modalHapus').classList.remove('hidden');
    }
</script>

<?= $this->endSection() ?>