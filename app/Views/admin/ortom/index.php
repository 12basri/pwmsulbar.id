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
                    <li><span class="text-slate-400">Organisasi</span></li>
                    <li><span class="mx-1 text-slate-400">/</span></li>
                    <li class="font-medium text-slate-800">Ortom</li>
                </ol>
            </nav>
            <h1 class="text-2xl font-bold text-slate-800">Kelola Organisasi Otonom (Ortom)</h1>
        </div>

        <button onclick="openModalTambah()" class="inline-flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-medium px-4 py-2.5 rounded-lg shadow-sm transition-all duration-200">
            <i class="fa-solid fa-plus text-sm"></i>
            <span>Tambah Ortom</span>
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
            <form action="<?= base_url('admin/ortom') ?>" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3">
                <div class="lg:col-span-12">
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </span>
                        <input type="text" name="q" value="<?= esc($keyword ?? '') ?>" placeholder="Cari nama ortom, ketua, sekretaris, atau bendahara..." class="w-full pl-9 pr-4 py-2 bg-white border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all">
                    </div>
                </div>
            </form>
        </div>

        <!-- Data Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 text-slate-700 uppercase text-xs font-semibold tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="py-3.5 px-4 w-12 text-center">No</th>
                        <th class="py-3.5 px-4">Organisasi Otonom</th>
                        <th class="py-3.5 px-4">Ketua</th>
                        <th class="py-3.5 px-4">Sekretaris</th>
                        <th class="py-3.5 px-4">Bendahara</th>
                        <th class="py-3.5 px-4 w-32 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">

                    <?php if (!empty($ortom) && is_array($ortom)) : ?>
                        <?php foreach ($ortom as $index => $row) : ?>
                            <?php
                            $idOrtom = $row['id_ortom'] ?? $row['id'] ?? '';
                            $jsonData = htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8');
                            ?>
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="py-4 px-4 text-center font-medium text-slate-400"><?= $index + 1 ?></td>
                                <td class="py-4 px-4">
                                    <div class="flex items-center gap-3">
                                        <?php if (!empty($row['logo']) && file_exists('uploads/ortom/' . $row['logo'])) : ?>
                                            <img src="<?= base_url('uploads/ortom/' . $row['logo']) ?>" alt="Logo <?= esc($row['nama_ortom']) ?>" class="w-10 h-10 rounded-lg object-contain bg-slate-50 border border-slate-200 p-1 shrink-0">
                                        <?php else : ?>
                                            <div class="w-10 h-10 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-xs shrink-0">
                                                <i class="fa-solid fa-flag text-base"></i>
                                            </div>
                                        <?php endif; ?>

                                        <div>
                                            <div class="font-semibold text-slate-800"><?= esc($row['nama_ortom']) ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-4 font-medium text-slate-700">
                                    <?= esc($row['ketua'] ?? '-') ?>
                                </td>
                                <td class="py-4 px-4 text-slate-600">
                                    <?= esc($row['sekretaris'] ?? '-') ?>
                                </td>
                                <td class="py-4 px-4 text-slate-600">
                                    <?= esc($row['bendahara'] ?? '-') ?>
                                </td>

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
                                        <button type="button" onclick="openModalHapus('<?= $idOrtom ?>')" class="p-1.5 text-rose-600 hover:text-rose-800 hover:bg-rose-50 rounded-lg transition-colors" title="Hapus Data">
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
                                Belum ada data organisasi otonom (Ortom) yang ditemukan.
                            </td>
                        </tr>
                    <?php endif; ?>

                </tbody>
            </table>
        </div>

        <div class="px-5 py-4 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-500">
            <span>Total data: <strong><?= count($ortom ?? []) ?></strong> organisasi otonom</span>
        </div>

    </div>
</main>

<!-- MODAL DETAIL ORTOM -->
<div id="modalDetail" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm hidden">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-lg overflow-hidden transform transition-all">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100 bg-slate-50/50">
            <h3 class="font-bold text-slate-800 text-lg flex items-center gap-2">
                <i class="fa-solid fa-circle-info text-emerald-600"></i>
                <span>Detail Ortom</span>
            </h3>
            <button type="button" onclick="closeModal('modalDetail')" class="text-slate-400 hover:text-slate-600 text-lg">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div class="p-6 space-y-4 text-sm text-slate-700">
            <div class="flex items-center gap-4 pb-3 border-b border-slate-100">
                <div id="detailLogoContainer" class="w-16 h-16 rounded-xl bg-slate-50 border border-slate-200 flex items-center justify-center overflow-hidden shrink-0">
                    <!-- Logo diinjeksikan lewat JS -->
                </div>
                <div>
                    <h4 id="detailNamaOrtom" class="font-bold text-slate-800 text-lg"></h4>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <span class="block text-xs font-semibold text-slate-400 uppercase mb-1">Ketua</span>
                    <p id="detailKetua" class="font-medium text-slate-800"></p>
                </div>
                <div>
                    <span class="block text-xs font-semibold text-slate-400 uppercase mb-1">Sekretaris</span>
                    <p id="detailSekretaris" class="font-medium text-slate-800"></p>
                </div>
                <div>
                    <span class="block text-xs font-semibold text-slate-400 uppercase mb-1">Bendahara</span>
                    <p id="detailBendahara" class="font-medium text-slate-800"></p>
                </div>
            </div>

            <div class="pt-2 border-t border-slate-100">
                <span class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Deskripsi / Profil</span>
                <p id="detailDeskripsi" class="text-slate-600 bg-slate-50 p-3 rounded-lg text-xs leading-relaxed whitespace-pre-line"></p>
            </div>
        </div>
        <div class="px-6 py-3.5 bg-slate-50 border-t border-slate-100 text-right">
            <button type="button" onclick="closeModal('modalDetail')" class="px-4 py-2 bg-slate-800 hover:bg-slate-900 text-white rounded-lg text-xs font-medium transition-colors">Tutup</button>
        </div>
    </div>
</div>

<!-- MODAL FORM TAMBAH / EDIT -->
<div id="modalOrtom" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm hidden">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-2xl overflow-hidden transform transition-all">
        <!-- Modal Header -->
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
            <h3 id="modalTitle" class="font-bold text-slate-800 text-lg">Tambah Ortom</h3>
            <button type="button" onclick="closeModal('modalOrtom')" class="text-slate-400 hover:text-slate-600 text-lg">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <!-- Modal Form Body -->
        <form id="formOrtom" action="<?= base_url('admin/ortom/simpan') ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Nama Ortom <span class="text-rose-500">*</span></label>
                    <input type="text" id="inputNamaOrtom" name="nama_ortom" required placeholder="Contoh: Pemuda Muhammadiyah" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Ketua</label>
                        <input type="text" id="inputKetua" name="ketua" placeholder="Nama Ketua" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Sekretaris</label>
                        <input type="text" id="inputSekretaris" name="sekretaris" placeholder="Nama Sekretaris" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Bendahara</label>
                        <input type="text" id="inputBendahara" name="bendahara" placeholder="Nama Bendahara" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none">
                    </div>
                </div>

                <!-- Input Upload Logo -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Logo Ortom</label>
                    <input type="file" id="inputLogo" name="logo" accept="image/png, image/jpeg, image/jpg, image/webp" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 border border-slate-300 rounded-lg cursor-pointer">
                    <span class="text-[11px] text-slate-400 mt-1 block">*Format: PNG, JPG, JPEG, WEBP (Maksimal 5 MB)</span>

                    <!-- Preview Logo jika Edit -->
                    <div id="previewLogoContainer" class="mt-3 hidden flex items-center gap-3 bg-slate-50 p-2.5 rounded-lg border border-slate-200">
                        <img id="previewLogoImg" src="" alt="Logo Saat Ini" class="w-12 h-12 object-contain rounded bg-white p-1 border">
                        <div class="text-xs text-slate-600">
                            <span class="font-medium block">Logo Saat Ini</span>
                            <span class="text-[11px] text-slate-400">Biarkan kosong jika tidak ingin mengubah logo.</span>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Deskripsi / Profil</label>
                    <textarea id="inputDeskripsi" name="deskripsi" rows="3" placeholder="Tuliskan deskripsi ringkas ortom..." class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none"></textarea>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-2">
                <button type="button" onclick="closeModal('modalOrtom')" class="px-4 py-2 bg-white border border-slate-300 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-50 transition-colors">Batal</button>
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
        <h3 class="text-lg font-bold text-slate-800 mb-1">Hapus Data Ortom?</h3>
        <p class="text-sm text-slate-500 mb-6">Apakah Anda yakin ingin menghapus ortom ini? Logo dan data terkait akan dihapus secara permanen.</p>
        <div class="flex items-center justify-center gap-3">
            <button type="button" onclick="closeModal('modalHapus')" class="w-full py-2 bg-white border border-slate-300 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-50 transition-colors">Batal</button>
            <a id="btnConfirmHapus" href="#" class="w-full py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-sm font-medium transition-colors">Ya, Hapus</a>
        </div>
    </div>
</div>

<!-- JAVASCRIPT AKSI & MODAL -->
<script>
    const baseUrl = "<?= base_url('admin/ortom') ?>";
    const uploadUrl = "<?= base_url('uploads/ortom/') ?>";

    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }

    // Modal Detail Ortom
    function openModalDetail(data) {
        document.getElementById('detailNamaOrtom').innerText = data.nama_ortom || '-';
        document.getElementById('detailKetua').innerText = data.ketua || '-';
        document.getElementById('detailSekretaris').innerText = data.sekretaris || '-';
        document.getElementById('detailBendahara').innerText = data.bendahara || '-';
        document.getElementById('detailDeskripsi').innerText = data.deskripsi || 'Tidak ada deskripsi.';

        const logoContainer = document.getElementById('detailLogoContainer');
        if (data.logo) {
            logoContainer.innerHTML = `<img src="${uploadUrl + data.logo}" alt="Logo ${data.nama_ortom || ''}" class="w-full h-full object-contain p-1">`;
        } else {
            logoContainer.innerHTML = `<i class="fa-solid fa-flag text-2xl text-slate-300"></i>`;
        }

        document.getElementById('modalDetail').classList.remove('hidden');
    }

    // Modal Tambah
    function openModalTambah() {
        document.getElementById('modalTitle').innerText = 'Tambah Ortom';
        document.getElementById('formOrtom').action = `${baseUrl}/simpan`;

        document.getElementById('formOrtom').reset();
        document.getElementById('previewLogoContainer').classList.add('hidden');

        document.getElementById('modalOrtom').classList.remove('hidden');
    }

    // Modal Edit
    function openModalEdit(data) {
        document.getElementById('modalTitle').innerText = 'Edit Data Ortom';

        const id = data.id_ortom || data.id;
        document.getElementById('formOrtom').action = `${baseUrl}/update/${id}`;

        document.getElementById('inputNamaOrtom').value = data.nama_ortom || '';
        document.getElementById('inputKetua').value = data.ketua || '';
        document.getElementById('inputSekretaris').value = data.sekretaris || '';
        document.getElementById('inputBendahara').value = data.bendahara || '';
        document.getElementById('inputDeskripsi').value = data.deskripsi || '';

        // Reset file input
        document.getElementById('inputLogo').value = '';

        // Tampilkan Preview Logo jika ada
        const previewContainer = document.getElementById('previewLogoContainer');
        const previewImg = document.getElementById('previewLogoImg');
        if (data.logo) {
            previewImg.src = uploadUrl + data.logo;
            previewContainer.classList.remove('hidden');
        } else {
            previewContainer.classList.add('hidden');
        }

        document.getElementById('modalOrtom').classList.remove('hidden');
    }

    // Modal Hapus
    function openModalHapus(id) {
        document.getElementById('btnConfirmHapus').href = `${baseUrl}/hapus/${id}`;
        document.getElementById('modalHapus').classList.remove('hidden');
    }

    // Tutup Modal dengan tombol ESC
    window.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeModal('modalDetail');
            closeModal('modalOrtom');
            closeModal('modalHapus');
        }
    });

    // Tutup Modal dengan klik area luar (Backdrop)
    ['modalDetail', 'modalOrtom', 'modalHapus'].forEach(id => {
        const modal = document.getElementById(id);
        if (modal) {
            modal.addEventListener('click', function(e) {
                if (e.target === this) {
                    closeModal(id);
                }
            });
        }
    });
</script>

<?= $this->endSection() ?>