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
                    <li class="font-medium text-slate-800" aria-current="page">Struktur Organisasi</li>
                </ol>
            </nav>
            <h1 class="text-2xl font-bold text-slate-800">Kelola Struktur Organisasi</h1>
        </div>

        <button type="button" onclick="openModalTambah()" class="inline-flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-medium px-4 py-2.5 rounded-lg shadow-sm transition-all duration-200">
            <i class="fa-solid fa-plus text-sm"></i>
            <span>Tambah Anggota / Pengurus</span>
        </button>
    </div>

    <!-- Flash Notifications -->
    <?php if (session()->getFlashdata('sukses')) : ?>
        <div class="mb-5 p-4 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-circle-check text-emerald-600 text-base"></i>
                <span><?= session()->getFlashdata('sukses') ?></span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 p-1" aria-label="Tutup alert"><i class="fa-solid fa-xmark"></i></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('gagal')) : ?>
        <div class="mb-5 p-4 rounded-lg bg-rose-50 border border-rose-200 text-rose-800 text-sm flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-triangle-exclamation text-rose-600 text-base"></i>
                <span><?= session()->getFlashdata('gagal') ?></span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-700 p-1" aria-label="Tutup alert"><i class="fa-solid fa-xmark"></i></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('errors')) : ?>
        <div class="mb-5 p-4 rounded-lg bg-rose-50 border border-rose-200 text-rose-800 text-sm shadow-sm">
            <div class="font-semibold mb-1 flex items-center gap-2">
                <i class="fa-solid fa-triangle-exclamation text-rose-600"></i>
                <span>Gagal Menyimpan Data:</span>
            </div>
            <ul class="list-disc list-inside space-y-1 text-xs pl-2">
                <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <!-- Main Table Container -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200/80 overflow-hidden">

        <!-- Filter & Search Bar -->
        <div class="p-5 border-b border-slate-100 bg-slate-50/50">
            <form action="<?= base_url('admin/profil/organisasi') ?>" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3">

                <!-- Search Input -->
                <div class="lg:col-span-5">
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </span>
                        <input type="text" name="q" value="<?= esc($keyword ?? '') ?>" placeholder="Cari nama pengurus atau jabatan..." class="w-full pl-9 pr-4 py-2 bg-white border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all">
                    </div>
                </div>

                <!-- Filter Divisi / Kategori -->
                <div class="lg:col-span-3">
                    <select name="kategori" class="w-full py-2 px-3 bg-white border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none text-slate-700">
                        <option value="">-- Semua Divisi / Kategori --</option>
                        <option value="Pimpinan Harian" <?= (($filterKategori ?? '') === 'Pimpinan Harian') ? 'selected' : '' ?>>Pimpinan Harian</option>
                        <option value="Sekretariat" <?= (($filterKategori ?? '') === 'Sekretariat') ? 'selected' : '' ?>>Sekretariat</option>
                        <option value="Bendahara" <?= (($filterKategori ?? '') === 'Bendahara') ? 'selected' : '' ?>>Bendahara</option>
                        <option value="Divisi / Majelis" <?= (($filterKategori ?? '') === 'Divisi / Majelis') ? 'selected' : '' ?>>Divisi / Majelis</option>
                        <option value="Anggota" <?= (($filterKategori ?? '') === 'Anggota') ? 'selected' : '' ?>>Anggota</option>
                    </select>
                </div>

                <!-- Filter Status -->
                <div class="lg:col-span-2">
                    <select name="status" class="w-full py-2 px-3 bg-white border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none text-slate-700">
                        <option value="">-- Status --</option>
                        <option value="Aktif" <?= (($filterStatus ?? '') === 'Aktif') ? 'selected' : '' ?>>Aktif</option>
                        <option value="Demisioner" <?= (($filterStatus ?? '') === 'Demisioner') ? 'selected' : '' ?>>Demisioner</option>
                    </select>
                </div>

                <!-- Submit & Reset Buttons -->
                <div class="lg:col-span-2 flex items-center gap-2">
                    <button type="submit" class="w-full py-2 px-4 bg-slate-800 hover:bg-slate-900 text-white rounded-lg text-sm font-medium transition-all flex items-center justify-center gap-2">
                        <i class="fa-solid fa-filter text-xs"></i>
                        <span>Filter</span>
                    </button>
                    <?php if (!empty($keyword) || !empty($filterKategori) || !empty($filterStatus)): ?>
                        <a href="<?= base_url('admin/profil/organisasi') ?>" class="py-2 px-3 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-lg text-sm font-medium transition-all" title="Reset Filter">
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
                        <th class="py-3.5 px-4">Nama Lengkap</th>
                        <th class="py-3.5 px-4">Jabatan</th>
                        <th class="py-3.5 px-4">Kategori / Divisi</th>
                        <th class="py-3.5 px-4 w-28">Periode</th>
                        <th class="py-3.5 px-4 w-32">Status</th>
                        <th class="py-3.5 px-4 w-32 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">

                    <?php if (!empty($organisasi) && is_array($organisasi)) : ?>
                        <?php foreach ($organisasi as $index => $row) : ?>
                            <?php
                            $idOrganisasi = $row['id'] ?? $row['id_organisasi'] ?? $row['id_pengurus'] ?? '';
                            $jsonData = htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8');
                            ?>
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="py-4 px-4 text-center font-medium text-slate-400"><?= $index + 1 ?></td>
                                <td class="py-4 px-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-full bg-emerald-50 text-emerald-700 flex items-center justify-center font-bold text-xs border border-emerald-200 flex-shrink-0">
                                            <?= esc(mb_strtoupper(mb_substr($row['nama'] ?? 'A', 0, 2))) ?>
                                        </div>
                                        <div>
                                            <div class="font-semibold text-slate-800"><?= esc($row['nama']) ?></div>
                                            <p class="text-xs text-slate-400"><?= esc($row['nip'] ?? $row['kontak'] ?? '-') ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-4 font-medium text-slate-800">
                                    <?= esc($row['jabatan']) ?>
                                </td>
                                <td class="py-4 px-4">
                                    <span class="inline-block bg-slate-100 text-slate-700 text-xs px-2.5 py-1 rounded-md font-medium border border-slate-200">
                                        <?= esc($row['kategori']) ?>
                                    </span>
                                </td>
                                <td class="py-4 px-4 font-medium text-slate-700"><?= esc($row['periode'] ?? '-') ?></td>
                                <td class="py-4 px-4">
                                    <?php if (($row['status'] ?? 'Aktif') === 'Aktif') : ?>
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                            Aktif
                                        </span>
                                    <?php else : ?>
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-600 border border-slate-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                            Demisioner
                                        </span>
                                    <?php endif; ?>
                                </td>

                                <!-- TOMBOL AKSI -->
                                <td class="py-4 px-4 text-center">
                                    <div class="inline-flex items-center justify-center gap-1">
                                        <!-- Tombol Detail -->
                                        <button type="button"
                                            data-row="<?= $jsonData ?>"
                                            onclick="openModalDetail(this)"
                                            class="p-2 text-slate-500 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors"
                                            title="Lihat Detail">
                                            <i class="fa-regular fa-eye text-base"></i>
                                        </button>

                                        <!-- Tombol Edit -->
                                        <button type="button"
                                            data-row="<?= $jsonData ?>"
                                            onclick="openModalEdit(this)"
                                            class="p-2 text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition-colors"
                                            title="Edit Data">
                                            <i class="fa-regular fa-pen-to-square text-base"></i>
                                        </button>

                                        <!-- Tombol Hapus -->
                                        <button type="button"
                                            onclick="openModalHapus('<?= esc($idOrganisasi, 'js') ?>')"
                                            class="p-2 text-rose-600 hover:text-rose-800 hover:bg-rose-50 rounded-lg transition-colors"
                                            title="Hapus Data">
                                            <i class="fa-regular fa-trash-can text-base"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="7" class="py-8 text-center text-slate-400 text-sm">
                                Belum ada data anggota / pengurus organisasi yang ditemukan.
                            </td>
                        </tr>
                    <?php endif; ?>

                </tbody>
            </table>
        </div>

        <!-- Table Summary Footer -->
        <div class="px-5 py-4 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-500">
            <span>Total data: <strong><?= count($organisasi ?? []) ?></strong> pengurus</span>
        </div>

    </div>
</main>

<!-- MODAL DETAIL ORGANISASI -->
<div id="modalDetail" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm hidden" onclick="handleBackdropClick(event, 'modalDetail')">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-lg overflow-hidden transform transition-all">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100 bg-slate-50/50">
            <h3 class="font-bold text-slate-800 text-lg flex items-center gap-2">
                <i class="fa-solid fa-address-card text-emerald-600"></i>
                <span>Detail Pengurus</span>
            </h3>
            <button type="button" onclick="closeModal('modalDetail')" class="text-slate-400 hover:text-slate-600 text-lg">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div class="p-6 space-y-4 text-sm text-slate-700">
            <div>
                <span class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Nama Lengkap</span>
                <p id="detailNama" class="font-semibold text-slate-800 text-base"></p>
            </div>
            <div class="grid grid-cols-2 gap-4 pt-2 border-t border-slate-100">
                <div>
                    <span class="block text-xs font-semibold text-slate-400 uppercase mb-1">Jabatan</span>
                    <p id="detailJabatan" class="font-medium text-slate-800"></p>
                </div>
                <div>
                    <span class="block text-xs font-semibold text-slate-400 uppercase mb-1">Kategori / Divisi</span>
                    <span id="detailKategori" class="inline-block bg-slate-100 text-slate-700 text-xs px-2.5 py-1 rounded-md font-medium border border-slate-200"></span>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4 pt-2 border-t border-slate-100">
                <div>
                    <span class="block text-xs font-semibold text-slate-400 uppercase mb-1">Periode</span>
                    <p id="detailPeriode" class="font-medium text-slate-800"></p>
                </div>
                <div>
                    <span class="block text-xs font-semibold text-slate-400 uppercase mb-1">Status</span>
                    <span id="detailStatus"></span>
                </div>
            </div>
            <div class="pt-2 border-t border-slate-100">
                <span class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Tugas & Tanggung Jawab / Catatan</span>
                <p id="detailDeskripsi" class="text-slate-600 bg-slate-50 p-3 rounded-lg text-xs leading-relaxed whitespace-pre-line"></p>
            </div>
        </div>
        <div class="px-6 py-3.5 bg-slate-50 border-t border-slate-100 text-right">
            <button type="button" onclick="closeModal('modalDetail')" class="px-4 py-2 bg-slate-800 hover:bg-slate-900 text-white rounded-lg text-xs font-medium transition-colors">Tutup</button>
        </div>
    </div>
</div>

<!-- MODAL FORM TAMBAH / EDIT -->
<div id="modalOrganisasi" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm hidden" onclick="handleBackdropClick(event, 'modalOrganisasi')">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-2xl overflow-hidden transform transition-all">
        <!-- Modal Header -->
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
            <h3 id="modalTitle" class="font-bold text-slate-800 text-lg">Tambah Anggota / Pengurus</h3>
            <button type="button" onclick="closeModal('modalOrganisasi')" class="text-slate-400 hover:text-slate-600 text-lg">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <!-- Modal Form Body -->
        <form id="formOrganisasi" action="<?= base_url('admin/profil/organisasi/simpan') ?>" method="POST">
            <?= csrf_field() ?>

            <div class="p-6 space-y-4">
                <div>
                    <label for="inputNama" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Nama Lengkap & Gelar</label>
                    <input type="text" id="inputNama" name="nama" required placeholder="Contoh: Dr. H. Ahmad Dahlan, M.Ag." class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                    <div class="md:col-span-6">
                        <label for="inputJabatan" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Jabatan</label>
                        <input type="text" id="inputJabatan" name="jabatan" required placeholder="Contoh: Ketua Umum / Sekretaris" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none">
                    </div>

                    <div class="md:col-span-6">
                        <label for="selectKategori" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Kategori / Divisi</label>
                        <select id="selectKategori" name="kategori" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none">
                            <option value="Pimpinan Harian">Pimpinan Harian</option>
                            <option value="Sekretariat">Sekretariat</option>
                            <option value="Bendahara">Bendahara</option>
                            <option value="Divisi / Majelis">Divisi / Majelis</option>
                            <option value="Anggota">Anggota</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                    <div class="md:col-span-4">
                        <label for="inputPeriode" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Periode</label>
                        <input type="text" id="inputPeriode" name="periode" placeholder="Contoh: 2022 - 2027" value="2022 - 2027" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none">
                    </div>

                    <div class="md:col-span-4">
                        <label for="inputUrutan" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Urutan Tampil</label>
                        <input type="number" id="inputUrutan" name="urutan" value="1" min="1" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none">
                    </div>

                    <div class="md:col-span-4">
                        <label for="selectStatus" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Status</label>
                        <select id="selectStatus" name="status" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none">
                            <option value="Aktif">Aktif</option>
                            <option value="Demisioner">Demisioner</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label for="inputDeskripsi" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Tugas & Deskripsi</label>
                    <textarea id="inputDeskripsi" name="deskripsi" rows="3" placeholder="Tuliskan tugas pokok, fungsi, atau deskripsi singkat..." class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none"></textarea>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-2">
                <button type="button" onclick="closeModal('modalOrganisasi')" class="px-4 py-2 bg-white border border-slate-300 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-50 transition-colors">Batal</button>
                <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-sm font-medium transition-colors inline-flex items-center gap-1.5">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Simpan Data</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL KONFIRMASI HAPUS -->
<div id="modalHapus" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm hidden" onclick="handleBackdropClick(event, 'modalHapus')">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md overflow-hidden p-6 text-center">
        <div class="w-12 h-12 bg-rose-100 text-rose-600 rounded-full flex items-center justify-center mx-auto mb-4 text-xl">
            <i class="fa-solid fa-triangle-exclamation"></i>
        </div>
        <h3 class="text-lg font-bold text-slate-800 mb-1">Hapus Data Pengurus?</h3>
        <p class="text-sm text-slate-500 mb-6">Apakah Anda yakin ingin menghapus data pengurus ini? Data yang dihapus tidak dapat dikembalikan.</p>

        <form id="formHapus" action="#" method="POST">
            <?= csrf_field() ?>
            <div class="flex items-center justify-center gap-3">
                <button type="button" onclick="closeModal('modalHapus')" class="w-full py-2 bg-white border border-slate-300 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-50 transition-colors">Batal</button>
                <button type="submit" class="w-full py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-sm font-medium transition-colors">Ya, Hapus</button>
            </div>
        </form>
    </div>
</div>

<!-- JAVASCRIPT AKSI & MODAL -->
<script>
    const baseUrl = "<?= base_url('admin/profil/organisasi') ?>";

    function closeModal(modalId) {
        const target = document.getElementById(modalId);
        if (target) target.classList.add('hidden');
    }

    function handleBackdropClick(event, modalId) {
        if (event.target === document.getElementById(modalId)) {
            closeModal(modalId);
        }
    }

    // Close on Escape key press
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            ['modalDetail', 'modalOrganisasi', 'modalHapus'].forEach(closeModal);
        }
    });

    // Helper safely parse data-row attribute
    function getRowData(btnElement) {
        try {
            return JSON.parse(btnElement.getAttribute('data-row'));
        } catch (e) {
            console.error("Gagal membaca data pengurus:", e);
            return {};
        }
    }

    // Modal Detail Organisasi
    function openModalDetail(btnElement) {
        const data = getRowData(btnElement);

        document.getElementById('detailNama').innerText = data.nama || '-';
        document.getElementById('detailJabatan').innerText = data.jabatan || '-';
        document.getElementById('detailKategori').innerText = data.kategori || '-';
        document.getElementById('detailPeriode').innerText = data.periode || '-';
        document.getElementById('detailDeskripsi').innerText = data.deskripsi || 'Tidak ada deskripsi.';

        // Format Status Badge
        const statusEl = document.getElementById('detailStatus');
        if (data.status === 'Aktif') {
            statusEl.innerHTML = `<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-200"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>Aktif</span>`;
        } else {
            statusEl.innerHTML = `<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-600 border border-slate-200"><span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>Demisioner</span>`;
        }

        document.getElementById('modalDetail').classList.remove('hidden');
    }

    // Modal Tambah
    function openModalTambah() {
        document.getElementById('modalTitle').innerText = 'Tambah Anggota / Pengurus';
        document.getElementById('formOrganisasi').action = `${baseUrl}/simpan`;

        document.getElementById('formOrganisasi').reset();
        document.getElementById('selectKategori').value = "Pimpinan Harian";
        document.getElementById('selectStatus').value = "Aktif";
        document.getElementById('inputUrutan').value = "1";

        document.getElementById('modalOrganisasi').classList.remove('hidden');
    }

    // Modal Edit
    function openModalEdit(btnElement) {
        const data = getRowData(btnElement);

        document.getElementById('modalTitle').innerText = 'Edit Data Pengurus';

        const id = data.id || data.id_organisasi || data.id_pengurus;
        document.getElementById('formOrganisasi').action = `${baseUrl}/update/${id}`;

        document.getElementById('inputNama').value = data.nama || '';
        document.getElementById('inputJabatan').value = data.jabatan || '';
        document.getElementById('selectKategori').value = data.kategori || 'Pimpinan Harian';
        document.getElementById('inputPeriode').value = data.periode || '';
        document.getElementById('inputUrutan').value = data.urutan || '1';
        document.getElementById('selectStatus').value = data.status || 'Aktif';
        document.getElementById('inputDeskripsi').value = data.deskripsi || '';

        document.getElementById('modalOrganisasi').classList.remove('hidden');
    }

    // Modal Hapus
    function openModalHapus(id) {
        document.getElementById('formHapus').action = `${baseUrl}/hapus/${id}`;
        document.getElementById('modalHapus').classList.remove('hidden');
    }
</script>

<?= $this->endSection() ?>