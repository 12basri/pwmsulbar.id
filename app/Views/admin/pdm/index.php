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
                    <li class="font-medium text-slate-800">Kelola Data PDM</li>
                </ol>
            </nav>
            <h1 class="text-2xl font-bold text-slate-800">Kelola Data PDM (Lengkap)</h1>
        </div>

        <button onclick="openModalTambah()" class="inline-flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-medium px-4 py-2.5 rounded-lg shadow-sm transition-all duration-200">
            <i class="fa-solid fa-plus text-sm"></i>
            <span>Tambah Data PDM</span>
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
            <form action="<?= base_url('admin/pdm') ?>" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3">
                <div class="lg:col-span-10">
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </span>
                        <input type="text" name="q" value="<?= esc($keyword ?? '') ?>" placeholder="Cari Nama PDM, Pimpinan, atau Alamat..." class="w-full pl-9 pr-4 py-2 bg-white border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all">
                    </div>
                </div>

                <div class="lg:col-span-2 flex items-center gap-2">
                    <button type="submit" class="w-full py-2 px-4 bg-slate-800 hover:bg-slate-900 text-white rounded-lg text-sm font-medium transition-all flex items-center justify-center gap-2">
                        <i class="fa-solid fa-filter text-xs"></i>
                        <span>Cari</span>
                    </button>
                    <?php if (!empty($keyword)): ?>
                        <a href="<?= base_url('admin/pdm') ?>" class="py-2 px-3 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-lg text-sm font-medium transition-all" title="Reset Filter">
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
                        <th class="py-3.5 px-4">Nama PDM</th>
                        <th class="py-3.5 px-4">Pimpinan Utama</th>
                        <th class="py-3.5 px-4">Kontak & Alamat</th>
                        <th class="py-3.5 px-4 w-36 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">

                    <?php if (!empty($pdmList) && is_array($pdmList)) : ?>
                        <?php foreach ($pdmList as $index => $row) : ?>
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="py-4 px-4 text-center font-medium text-slate-400"><?= $index + 1 ?></td>
                                <td class="py-4 px-4 font-semibold text-slate-800">
                                    <div class="flex items-center gap-2">
                                        <i class="fa-solid fa-building-flag text-emerald-600"></i>
                                        <span><?= esc($row['nama_pdm']) ?></span>
                                    </div>
                                </td>
                                <td class="py-4 px-4">
                                    <span class="inline-block bg-slate-100 text-slate-700 text-xs px-2.5 py-1 rounded-md font-medium border border-slate-200">
                                        <?= esc($row['pimpinan'] ?? '-') ?>
                                    </span>
                                </td>
                                <td class="py-4 px-4 text-xs">
                                    <div class="text-slate-700"><i class="fa-solid fa-phone text-emerald-600 mr-1"></i><?= esc($row['telepon'] ?? '-') ?></div>
                                    <div class="text-slate-500 mt-0.5"><i class="fa-solid fa-envelope text-emerald-600 mr-1"></i><?= esc($row['email'] ?? '-') ?></div>
                                </td>

                                <!-- TOMBOL AKSI -->
                                <td class="py-4 px-4 text-center">
                                    <div class="inline-flex items-center justify-center gap-1">
                                        <!-- Tombol Detail -->
                                        <button type="button" onclick="fetchAndShowDetail('<?= $row['id_pdm'] ?>')" class="p-1.5 text-slate-500 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors" title="Lihat Detail Lengkap">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </button>

                                        <!-- Tombol Edit -->
                                        <button type="button" onclick="openModalEdit('<?= $row['id_pdm'] ?>')" class="p-1.5 text-amber-600 hover:text-amber-800 hover:bg-amber-50 rounded-lg transition-colors" title="Edit Data PDM">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>

                                        <!-- Tombol Hapus -->
                                        <button type="button" onclick="openModalHapus('<?= $row['id_pdm'] ?>')" class="p-1.5 text-rose-600 hover:text-rose-800 hover:bg-rose-50 rounded-lg transition-colors" title="Hapus Data">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6h4m-4-6h4m-6 0h8m-10 0a2 2 0 00-2 2v1" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="5" class="py-8 text-center text-slate-400 text-sm">
                                Belum ada data PDM yang terdaftar.
                            </td>
                        </tr>
                    <?php endif; ?>

                </tbody>
            </table>
        </div>

        <div class="px-5 py-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
            <span>Total data: <strong><?= count($pdmList ?? []) ?></strong> PDM</span>
        </div>

    </div>
</main>

<!-- MODAL DETAIL PDM KESELURUHAN -->
<div id="modalDetail" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm hidden">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-2xl overflow-hidden transform transition-all max-h-[90vh] flex flex-col">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100 bg-slate-50/50">
            <h3 class="font-bold text-slate-800 text-lg flex items-center gap-2">
                <i class="fa-solid fa-circle-info text-emerald-600"></i>
                <span>Detail Informasi PDM</span>
            </h3>
            <button type="button" onclick="closeModal('modalDetail')" class="text-slate-400 hover:text-slate-600 text-lg">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        
        <div class="p-6 space-y-6 overflow-y-auto text-sm text-slate-700">
            <!-- Profil PDM -->
            <div class="bg-slate-50 p-4 rounded-lg border border-slate-200">
                <h4 id="detailNamaPdm" class="text-lg font-bold text-slate-800"></h4>
                <p class="text-xs text-slate-500 mt-1"><i class="fa-solid fa-user-tie text-emerald-600 mr-1"></i>Pimpinan: <span id="detailPimpinan"></span></p>
                <p class="text-xs text-slate-500"><i class="fa-solid fa-location-dot text-emerald-600 mr-1"></i>Alamat: <span id="detailAlamat"></span></p>
            </div>

            <!-- List Pengurus -->
            <div>
                <h5 class="font-bold text-slate-800 border-b pb-1 mb-2">Pengurus PDM</h5>
                <ul id="detailListPengurus" class="list-disc list-inside text-xs space-y-1 text-slate-600"></ul>
            </div>

            <!-- List Sejarah -->
            <div>
                <h5 class="font-bold text-slate-800 border-b pb-1 mb-2">Sejarah & Catatan</h5>
                <div id="detailListSejarah" class="text-xs space-y-2 text-slate-600"></div>
            </div>

            <!-- List Website -->
            <div>
                <h5 class="font-bold text-slate-800 border-b pb-1 mb-2">Website / Tautan</h5>
                <ul id="detailListWebsite" class="list-disc list-inside text-xs space-y-1 text-emerald-600"></ul>
            </div>
        </div>

        <div class="px-6 py-3.5 bg-slate-50 border-t border-slate-100 text-right">
            <button type="button" onclick="closeModal('modalDetail')" class="px-4 py-2 bg-slate-800 hover:bg-slate-900 text-white rounded-lg text-xs font-medium transition-colors">Tutup</button>
        </div>
    </div>
</div>

<!-- MODAL FORM INPUT ALL-IN-ONE (TAMBAH / EDIT) -->
<div id="modalPdm" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm hidden">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-3xl overflow-hidden transform transition-all max-h-[90vh] flex flex-col">
        
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
            <h3 id="modalTitle" class="font-bold text-slate-800 text-lg">Form Input Data PDM Terpadu</h3>
            <button type="button" onclick="closeModal('modalPdm')" class="text-slate-400 hover:text-slate-600 text-lg">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form id="formPdm" action="<?= base_url('admin/pdm/store') ?>" method="POST" class="overflow-y-auto flex-1">
            <?= csrf_field() ?>
            <input type="hidden" name="id_pdm" id="pdm_id">

            <div class="p-6 space-y-6">
                <!-- SECTION 1: DATA INDUK PDM -->
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-emerald-600 bg-emerald-50 p-2 rounded mb-3">1. Informasi Utama PDM</h4>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Nama PDM</label>
                            <input type="text" name="nama_pdm" required placeholder="Contoh: PDM Kota Surakarta" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Nama Pimpinan Utama</label>
                                <input type="text" name="pimpinan" placeholder="Nama Ketua Umum PDM" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Telepon/HP</label>
                                <input type="text" name="telepon" placeholder="Nomor Telepon Kontak" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Email</label>
                                <input type="email" name="email" placeholder="email@pdm.or.id" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Alamat Kantor</label>
                                <input type="text" name="alamat" placeholder="Jl. Ahmad Dahlan No..." class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SECTION 2: DINAMIS PENGURUS -->
                <div>
                    <div class="flex items-center justify-between bg-slate-100 p-2 rounded mb-3">
                        <h4 class="text-xs font-bold uppercase tracking-wider text-slate-700">2. Data Pengurus PDM</h4>
                        <button type="button" onclick="addPengurusRow()" class="text-xs bg-emerald-600 text-white px-2.5 py-1 rounded hover:bg-emerald-700"><i class="fa-solid fa-plus mr-1"></i>Tambah Pengurus</button>
                    </div>
                    <div id="containerPengurus" class="space-y-2"></div>
                </div>

                <!-- SECTION 3: DINAMIS SEJARAH -->
                <div>
                    <div class="flex items-center justify-between bg-slate-100 p-2 rounded mb-3">
                        <h4 class="text-xs font-bold uppercase tracking-wider text-slate-700">3. Data Sejarah / Catatan</h4>
                        <button type="button" onclick="addSejarahRow()" class="text-xs bg-emerald-600 text-white px-2.5 py-1 rounded hover:bg-emerald-700"><i class="fa-solid fa-plus mr-1"></i>Tambah Sejarah</button>
                    </div>
                    <div id="containerSejarah" class="space-y-2"></div>
                </div>

                <!-- SECTION 4: DINAMIS WEBSITE -->
                <div>
                    <div class="flex items-center justify-between bg-slate-100 p-2 rounded mb-3">
                        <h4 class="text-xs font-bold uppercase tracking-wider text-slate-700">4. Data Website / Link</h4>
                        <button type="button" onclick="addWebsiteRow()" class="text-xs bg-emerald-600 text-white px-2.5 py-1 rounded hover:bg-emerald-700"><i class="fa-solid fa-plus mr-1"></i>Tambah Link</button>
                    </div>
                    <div id="containerWebsite" class="space-y-2"></div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-2 sticky bottom-0">
                <button type="button" onclick="closeModal('modalPdm')" class="px-4 py-2 bg-white border border-slate-300 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-50 transition-colors">Batal</button>
                <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-sm font-medium transition-colors inline-flex items-center gap-1.5">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Simpan Semua Data</span>
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
        <h3 class="text-lg font-bold text-slate-800 mb-1">Hapus Data PDM?</h3>
        <p class="text-sm text-slate-500 mb-6">Apakah Anda yakin? Seluruh data pengurus, sejarah, dan website yang terikat pada PDM ini juga akan terhapus secara otomatis.</p>
        <div class="flex items-center justify-center gap-3">
            <button type="button" onclick="closeModal('modalHapus')" class="w-full py-2 bg-white border border-slate-300 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-50 transition-colors">Batal</button>
            <a id="btnConfirmHapus" href="#" class="w-full py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-sm font-medium transition-colors">Ya, Hapus</a>
        </div>
    </div>
</div>

<!-- JAVASCRIPT AKSI & MODAL -->
<script>
    const baseUrl = "<?= base_url('admin/pdm') ?>";

    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }

    function openModalTambah() {
        document.getElementById('formPdm').reset();
        document.getElementById('modalTitle').innerText = 'Form Input Data PDM Terpadu';
        document.getElementById('pdm_id').value = '';

        document.getElementById('containerPengurus').innerHTML = '';
        document.getElementById('containerSejarah').innerHTML = '';
        document.getElementById('containerWebsite').innerHTML = '';
        
        // Inisialisasi awal 1 baris kosong
        addPengurusRow();
        addSejarahRow();
        addWebsiteRow();

        document.getElementById('modalPdm').classList.remove('hidden');
    }

    function openModalEdit(idPdm) {
        document.getElementById('formPdm').reset();
        document.getElementById('modalTitle').innerText = 'Edit Data PDM Terpadu';
        document.getElementById('pdm_id').value = idPdm;

        document.getElementById('containerPengurus').innerHTML = '';
        document.getElementById('containerSejarah').innerHTML = '';
        document.getElementById('containerWebsite').innerHTML = '';

        fetch(`${baseUrl}/detail/${idPdm}`)
            .then(res => res.json())
            .then(res => {
                const pdm = res.pdm || res; // antisipasi format response JSON
                if (pdm) {
                    document.querySelector('input[name="nama_pdm"]').value = pdm.nama_pdm || '';
                    document.querySelector('input[name="pimpinan"]').value = pdm.pimpinan || '';
                    document.querySelector('input[name="telepon"]').value = pdm.telepon || '';
                    document.querySelector('input[name="email"]').value = pdm.email || '';
                    document.querySelector('input[name="alamat"]').value = pdm.alamat || '';

                    // Populasikan Pengurus
                    if (res.pengurus && res.pengurus.length > 0) {
                        res.pengurus.forEach(p => addPengurusRow(p.nama, p.jabatan, p.periode));
                    } else {
                        addPengurusRow();
                    }

                    // Populasikan Sejarah
                    if (res.sejarah && res.sejarah.length > 0) {
                        res.sejarah.forEach(s => addSejarahRow(s.tahun, s.isi));
                    } else {
                        addSejarahRow();
                    }

                    // Populasikan Website
                    if (res.website && res.website.length > 0) {
                        res.website.forEach(w => addWebsiteRow(w.url, w.keterangan));
                    } else {
                        addWebsiteRow();
                    }

                    document.getElementById('modalPdm').classList.remove('hidden');
                }
            });
    }

    // Modal Hapus
    function openModalHapus(idPdm) {
        document.getElementById('btnConfirmHapus').href = `${baseUrl}/delete/${idPdm}`;
        document.getElementById('modalHapus').classList.remove('hidden');
    }

    // Fetch detail dari Controller & tampilkan di modal
    function fetchAndShowDetail(idPdm) {
        fetch(`${baseUrl}/detail/${idPdm}`)
            .then(res => res.json())
            .then(res => {
                const pdm = res.pdm || res;
                if(pdm) {
                    document.getElementById('detailNamaPdm').innerText = pdm.nama_pdm || '-';
                    document.getElementById('detailPimpinan').innerText = pdm.pimpinan || '-';
                    document.getElementById('detailAlamat').innerText = pdm.alamat || '-';

                    // Rendering List Pengurus
                    const pengurusEl = document.getElementById('detailListPengurus');
                    const pengurusList = res.pengurus || [];
                    pengurusEl.innerHTML = pengurusList.length ? '' : '<li>Tidak ada data pengurus</li>';
                    pengurusList.forEach(p => {
                        pengurusEl.innerHTML += `<li><strong>${p.nama}</strong> - ${p.jabatan} (${p.periode || '-'})</li>`;
                    });

                    // Rendering List Sejarah
                    const sejarahEl = document.getElementById('detailListSejarah');
                    const sejarahList = res.sejarah || [];
                    sejarahEl.innerHTML = sejarahList.length ? '' : '<p>Tidak ada catatan sejarah</p>';
                    sejarahList.forEach(s => {
                        sejarahEl.innerHTML += `<div class="p-2 bg-slate-100 rounded"><strong>Tahun ${s.tahun || '-'}:</strong> ${s.isi || '-'}</div>`;
                    });

                    // Rendering List Website
                    const websiteEl = document.getElementById('detailListWebsite');
                    const websiteList = res.website || [];
                    websiteEl.innerHTML = websiteList.length ? '' : '<li>Tidak ada link website</li>';
                    websiteList.forEach(w => {
                        websiteEl.innerHTML += `<li><a href="${w.url}" target="_blank" class="underline">${w.url}</a> (${w.keterangan || '-'})</li>`;
                    });

                    document.getElementById('modalDetail').classList.remove('hidden');
                }
            });
    }

    // Dynamic Row Generators
    let pengurusIdx = 0;
    function addPengurusRow(nama = '', jabatan = '', periode = '2022-2027') {
        const div = document.createElement('div');
        div.className = "grid grid-cols-1 md:grid-cols-12 gap-2 items-center bg-slate-50 p-2 rounded border border-slate-200";
        div.innerHTML = `
            <div class="md:col-span-5"><input type="text" name="pengurus[${pengurusIdx}][nama]" value="${nama}" placeholder="Nama Pengurus" class="w-full px-2 py-1 border rounded text-xs"></div>
            <div class="md:col-span-4"><input type="text" name="pengurus[${pengurusIdx}][jabatan]" value="${jabatan}" placeholder="Jabatan" class="w-full px-2 py-1 border rounded text-xs"></div>
            <div class="md:col-span-2"><input type="text" name="pengurus[${pengurusIdx}][periode]" value="${periode}" placeholder="Periode" class="w-full px-2 py-1 border rounded text-xs"></div>
            <div class="md:col-span-1 text-center"><button type="button" onclick="this.parentElement.parentElement.remove()" class="text-rose-600 hover:text-rose-800"><i class="fa-solid fa-trash"></i></button></div>
        `;
        document.getElementById('containerPengurus').appendChild(div);
        pengurusIdx++;
    }

    let sejarahIdx = 0;
    function addSejarahRow(tahun = '', isi = '') {
        const div = document.createElement('div');
        div.className = "grid grid-cols-1 md:grid-cols-12 gap-2 items-center bg-slate-50 p-2 rounded border border-slate-200";
        div.innerHTML = `
            <div class="md:col-span-3"><input type="text" name="sejarah[${sejarahIdx}][tahun]" value="${tahun}" placeholder="Tahun" class="w-full px-2 py-1 border rounded text-xs"></div>
            <div class="md:col-span-8"><input type="text" name="sejarah[${sejarahIdx}][isi]" value="${isi}" placeholder="Rincian Sejarah/Catatan" class="w-full px-2 py-1 border rounded text-xs"></div>
            <div class="md:col-span-1 text-center"><button type="button" onclick="this.parentElement.parentElement.remove()" class="text-rose-600 hover:text-rose-800"><i class="fa-solid fa-trash"></i></button></div>
        `;
        document.getElementById('containerSejarah').appendChild(div);
        sejarahIdx++;
    }

    let websiteIdx = 0;
    function addWebsiteRow(url = '', keterangan = '') {
        const div = document.createElement('div');
        div.className = "grid grid-cols-1 md:grid-cols-12 gap-2 items-center bg-slate-50 p-2 rounded border border-slate-200";
        div.innerHTML = `
            <div class="md:col-span-6"><input type="text" name="website[${websiteIdx}][url]" value="${url}" placeholder="URL / Link Website" class="w-full px-2 py-1 border rounded text-xs"></div>
            <div class="md:col-span-5"><input type="text" name="website[${websiteIdx}][keterangan]" value="${keterangan}" placeholder="Keterangan Site" class="w-full px-2 py-1 border rounded text-xs"></div>
            <div class="md:col-span-1 text-center"><button type="button" onclick="this.parentElement.parentElement.remove()" class="text-rose-600 hover:text-rose-800"><i class="fa-solid fa-trash"></i></button></div>
        `;
        document.getElementById('containerWebsite').appendChild(div);
        websiteIdx++;
    }
</script>

<?= $this->endSection() ?>