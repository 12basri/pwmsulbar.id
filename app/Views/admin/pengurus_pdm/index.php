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
                    <li class="font-medium text-slate-800">Pengurus PDM</li>
                </ol>
            </nav>
            <h1 class="text-2xl font-bold text-slate-800">Kelola Pengurus PDM</h1>
        </div>

        <button onclick="openModalTambah()" class="inline-flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-medium px-4 py-2.5 rounded-lg shadow-sm transition-all duration-200">
            <i class="fa-solid fa-plus text-sm"></i>
            <span>Tambah Pengurus</span>
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
            <form action="<?= base_url('admin/pengurus-pdm') ?>" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3">

                <!-- Search Input -->
                <div class="lg:col-span-6">
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </span>
                        <input type="text" name="q" value="<?= esc($keyword ?? '') ?>" placeholder="Cari nama, jabatan, atau nama PDM..." class="w-full pl-9 pr-4 py-2 bg-white border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all">
                    </div>
                </div>

                <!-- Filter Periode -->
                <div class="lg:col-span-4">
                    <select name="periode" class="w-full py-2 px-3 bg-white border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none text-slate-700">
                        <option value="">-- Semua Periode --</option>
                        <?php if (!empty($listPeriode) && is_array($listPeriode)) : ?>
                            <?php foreach ($listPeriode as $p) : ?>
                                <option value="<?= esc($p) ?>" <?= (($filterPeriode ?? '') == $p) ? 'selected' : '' ?>><?= esc($p) ?></option>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <option value="2022-2027" <?= (($filterPeriode ?? '') == '2022-2027') ? 'selected' : '' ?>>2022 - 2027</option>
                            <option value="2015-2022" <?= (($filterPeriode ?? '') == '2015-2022') ? 'selected' : '' ?>>2015 - 2022</option>
                        <?php endif; ?>
                    </select>
                </div>

                <!-- Submit & Reset Button -->
                <div class="lg:col-span-2 flex items-center gap-2">
                    <button type="submit" class="w-full py-2 px-4 bg-slate-800 hover:bg-slate-900 text-white rounded-lg text-sm font-medium transition-all flex items-center justify-center gap-2">
                        <i class="fa-solid fa-filter text-xs"></i>
                        <span>Filter</span>
                    </button>
                    <?php if (!empty($keyword) || !empty($filterPeriode)): ?>
                        <a href="<?= base_url('admin/pengurus-pdm') ?>" class="py-2 px-3 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-lg text-sm font-medium transition-all" title="Reset Filter">
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
                        <th class="py-3.5 px-4">Nama Pengurus</th>
                        <th class="py-3.5 px-4">Jabatan</th>
                        <th class="py-3.5 px-4">PDM (Daerah)</th>
                        <th class="py-3.5 px-4 w-32">Periode</th>
                        <th class="py-3.5 px-4 w-32 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">

                    <?php if (!empty($pengurus) && is_array($pengurus)) : ?>
                        <?php foreach ($pengurus as $index => $row) : ?>
                            <?php
                            $jsonData = htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8');
                            $fotoPath = !empty($row['foto']) ? base_url('uploads/pengurus/' . $row['foto']) : '';
                            ?>
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="py-4 px-4 text-center font-medium text-slate-400"><?= $index + 1 ?></td>
                                <td class="py-4 px-4">
                                    <div class="flex items-center gap-3">
                                        <img src="<?= $fotoPath ?>" alt="<?= esc($row['nama']) ?>" class="w-10 h-10 rounded-full object-cover border border-slate-200 shadow-sm flex-shrink-0" onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($row['nama'] ?? 'Pengurus') ?>&background=0D9488&color=fff';">
                                        <div class="font-semibold text-slate-800"><?= esc($row['nama']) ?></div>
                                    </div>
                                </td>
                                <td class="py-4 px-4">
                                    <span class="inline-block bg-slate-100 text-slate-700 text-xs px-2.5 py-1 rounded-md font-medium border border-slate-200">
                                        <?= esc($row['jabatan']) ?>
                                    </span>
                                </td>
                                <td class="py-4 px-4 font-medium text-slate-800">
                                    <div class="flex items-center gap-1.5 text-slate-700">
                                        <i class="fa-solid fa-location-dot text-emerald-600 text-xs"></i>
                                        <span><?= esc($row['pdm'] ?? '-') ?></span>
                                    </div>
                                </td>
                                <td class="py-4 px-4 font-medium text-slate-700"><?= esc($row['periode']) ?></td>

                                <!-- TOMBOL AKSI -->
                                <td class="py-4 px-4 text-center">
                                    <div class="inline-flex items-center justify-center gap-1">
                                        <!-- Tombol Detail -->
                                        <button type="button" onclick="openModalDetail(<?= $jsonData ?>)" class="p-1.5 text-slate-500 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors" title="Lihat Detail">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </button>

                                        <!-- Tombol Edit -->
                                        <button type="button" onclick="openModalEdit(<?= $jsonData ?>)" class="p-1.5 text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition-colors" title="Edit Data">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>

                                        <!-- Tombol Hapus -->
                                        <button type="button" onclick="openModalHapus('<?= $row['id_pengurus'] ?>')" class="p-1.5 text-rose-600 hover:text-rose-800 hover:bg-rose-50 rounded-lg transition-colors" title="Hapus Data">
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
                                Belum ada data pengurus PDM yang ditemukan.
                            </td>
                        </tr>
                    <?php endif; ?>

                </tbody>
            </table>
        </div>

        <!-- Table Summary Footer -->
        <div class="px-5 py-4 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-500">
            <span>Total data: <strong><?= count($pengurus ?? []) ?></strong> pengurus PDM</span>
        </div>

    </div>
</main>

<!-- MODAL DETAIL PENGURUS PDM -->
<div id="modalDetail" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm hidden">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-lg overflow-hidden transform transition-all">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100 bg-slate-50/50">
            <h3 class="font-bold text-slate-800 text-lg flex items-center gap-2">
                <i class="fa-solid fa-circle-info text-emerald-600"></i>
                <span>Detail Pengurus PDM</span>
            </h3>
            <button type="button" onclick="closeModal('modalDetail')" class="text-slate-400 hover:text-slate-600 text-lg">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div class="p-6 space-y-4 text-sm text-slate-700">
            <div class="flex items-center gap-4 p-3 bg-slate-50 rounded-lg border border-slate-100">
                <img id="detailFoto" src="" alt="Foto Pengurus" class="w-16 h-16 rounded-full object-cover border-2 border-emerald-500 shadow-sm flex-shrink-0">
                <div>
                    <h4 id="detailNama" class="font-bold text-slate-800 text-base"></h4>
                    <p class="text-xs text-slate-500 mt-1 flex items-center gap-1">
                        <i class="fa-solid fa-location-dot text-emerald-600"></i>
                        <span id="detailPdm" class="font-medium text-slate-700"></span>
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 pt-2 border-t border-slate-100">
                <div>
                    <span class="block text-xs font-semibold text-slate-400 uppercase mb-1">Jabatan</span>
                    <span id="detailJabatan" class="inline-block bg-slate-100 text-slate-700 text-xs px-2.5 py-1 rounded-md font-medium border border-slate-200"></span>
                </div>
                <div>
                    <span class="block text-xs font-semibold text-slate-400 uppercase mb-1">Periode</span>
                    <p id="detailPeriode" class="font-medium text-slate-800"></p>
                </div>
            </div>

            <div class="pt-2 border-t border-slate-100">
                <span class="block text-xs font-semibold text-slate-400 uppercase mb-1">Tanggal Dibuat</span>
                <p id="detailCreatedAt" class="text-xs text-slate-600"></p>
            </div>
        </div>
        <div class="px-6 py-3.5 bg-slate-50 border-t border-slate-100 text-right">
            <button type="button" onclick="closeModal('modalDetail')" class="px-4 py-2 bg-slate-800 hover:bg-slate-900 text-white rounded-lg text-xs font-medium transition-colors">Tutup</button>
        </div>
    </div>
</div>

<!-- MODAL FORM TAMBAH / EDIT -->
<div id="modalPengurus" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm hidden">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-xl overflow-hidden transform transition-all">
        <!-- Modal Header -->
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
            <h3 id="modalTitle" class="font-bold text-slate-800 text-lg">Tambah Pengurus PDM</h3>
            <button type="button" onclick="closeModal('modalPengurus')" class="text-slate-400 hover:text-slate-600 text-lg">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <!-- Modal Form Body -->
        <form id="formPengurus" action="<?= base_url('admin/pengurus-pdm/simpan') ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Nama Lengkap & Gelar</label>
                    <input type="text" id="inputNama" name="nama" required placeholder="Contoh: Dr. H. Ahmad Dahlan, M.A." class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                    <div class="md:col-span-6">
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Jabatan</label>
                        <input type="text" id="inputJabatan" name="jabatan" required placeholder="Contoh: Ketua Umum / Sekretaris" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none">
                    </div>

                    <div class="md:col-span-6">
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Periode</label>
                        <input type="text" id="inputPeriode" name="periode" required placeholder="Contoh: 2022-2027" value="2022-2027" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">PDM (Daerah)</label>
                    <input type="text" id="inputPdm" name="pdm" required placeholder="Contoh: PDM Kota Surakarta / PDM Kabupaten Sleman" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Foto Pengurus</label>
                    <input type="file" id="inputFoto" name="foto" accept="image/*" class="w-full px-3 py-1.5 border border-slate-300 rounded-lg text-sm bg-white file:mr-3 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 transition-all">
                    <p class="text-[11px] text-slate-400 mt-1">Format: JPG, JPEG, PNG, WEBP. Maksimal 2MB.</p>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-2">
                <button type="button" onclick="closeModal('modalPengurus')" class="px-4 py-2 bg-white border border-slate-300 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-50 transition-colors">Batal</button>
                <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-sm font-medium transition-colors inline-flex items-center gap-1.5">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Simpan Data</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL KONFIRMASI HAPUS -->
<div id="modalHapus" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm hidden">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md overflow-hidden p-6 text-center">
        <div class="w-12 h-12 bg-rose-100 text-rose-600 rounded-full flex items-center justify-center mx-auto mb-4 text-xl">
            <i class="fa-solid fa-triangle-exclamation"></i>
        </div>
        <h3 class="text-lg font-bold text-slate-800 mb-1">Hapus Pengurus PDM?</h3>
        <p class="text-sm text-slate-500 mb-6">Apakah Anda yakin ingin menghapus data pengurus ini? Data yang dihapus tidak dapat dikembalikan.</p>
        <div class="flex items-center justify-center gap-3">
            <button type="button" onclick="closeModal('modalHapus')" class="w-full py-2 bg-white border border-slate-300 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-50 transition-colors">Batal</button>
            <a id="btnConfirmHapus" href="#" class="w-full py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-sm font-medium transition-colors">Ya, Hapus</a>
        </div>
    </div>
</div>

<!-- JAVASCRIPT AKSI & MODAL -->
<script>
    const baseUrl = "<?= base_url('admin/pengurus-pdm') ?>";
    const uploadsUrl = "<?= base_url('uploads/pengurus/') ?>";

    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }

    // Modal Detail Pengurus
    function openModalDetail(data) {
        document.getElementById('detailNama').innerText = data.nama || '-';
        document.getElementById('detailJabatan').innerText = data.jabatan || '-';
        document.getElementById('detailPdm').innerText = data.pdm || '-';
        document.getElementById('detailPeriode').innerText = data.periode || '-';
        document.getElementById('detailCreatedAt').innerText = data.created_at || '-';

        // Foto Detail
        const fotoEl = document.getElementById('detailFoto');
        if (data.foto) {
            fotoEl.src = uploadsUrl + '/' + data.foto;
        } else {
            fotoEl.src = `https://ui-avatars.com/api/?name=${encodeURIComponent(data.nama || 'Pengurus')}&background=0D9488&color=fff`;
        }

        document.getElementById('modalDetail').classList.remove('hidden');
    }

    // Modal Tambah
    function openModalTambah() {
        document.getElementById('modalTitle').innerText = 'Tambah Pengurus PDM';
        document.getElementById('formPengurus').action = `${baseUrl}/simpan`;

        document.getElementById('formPengurus').reset();
        document.getElementById('inputPeriode').value = "2022-2027";

        document.getElementById('modalPengurus').classList.remove('hidden');
    }

    // Modal Edit
    function openModalEdit(data) {
        document.getElementById('modalTitle').innerText = 'Edit Pengurus PDM';
        document.getElementById('formPengurus').action = `${baseUrl}/update/${data.id_pengurus}`;

        document.getElementById('inputNama').value = data.nama || '';
        document.getElementById('inputJabatan').value = data.jabatan || '';
        document.getElementById('inputPdm').value = data.pdm || '';
        document.getElementById('inputPeriode').value = data.periode || '2022-2027';

        document.getElementById('modalPengurus').classList.remove('hidden');
    }

    // Modal Hapus
    function openModalHapus(idPengurus) {
        document.getElementById('btnConfirmHapus').href = `${baseUrl}/hapus/${idPengurus}`;
        document.getElementById('modalHapus').classList.remove('hidden');
    }
</script>

<?= $this->endSection() ?>