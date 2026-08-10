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
                    <li class="font-medium text-slate-800">Slider & Banner</li>
                </ol>
            </nav>
            <h1 class="text-2xl font-bold text-slate-800">Kelola Slider / Banner Beranda</h1>
        </div>

        <button onclick="openModalTambah()" class="inline-flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-medium px-4 py-2.5 rounded-lg shadow-sm transition-all duration-200">
            <i class="fa-solid fa-plus text-sm"></i>
            <span>Tambah Slider</span>
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
            <form action="<?= base_url('admin/slider') ?>" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3">

                <!-- Search Input -->
                <div class="lg:col-span-7">
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </span>
                        <input type="text" name="q" value="<?= esc($keyword ?? '') ?>" placeholder="Cari judul slider atau deskripsi..." class="w-full pl-9 pr-4 py-2 bg-white border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all">
                    </div>
                </div>

                <!-- Filter Status -->
                <div class="lg:col-span-3">
                    <select name="status" class="w-full py-2 px-3 bg-white border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none text-slate-700">
                        <option value="">-- Semua Status --</option>
                        <option value="aktif" <?= (($filterStatus ?? '') == 'aktif') ? 'selected' : '' ?>>Aktif</option>
                        <option value="nonaktif" <?= (($filterStatus ?? '') == 'nonaktif') ? 'selected' : '' ?>>Nonaktif</option>
                    </select>
                </div>

                <!-- Submit & Reset Button -->
                <div class="lg:col-span-2 flex items-center gap-2">
                    <button type="submit" class="w-full py-2 px-4 bg-slate-800 hover:bg-slate-900 text-white rounded-lg text-sm font-medium transition-all flex items-center justify-center gap-2">
                        <i class="fa-solid fa-filter text-xs"></i>
                        <span>Filter</span>
                    </button>
                    <?php if (!empty($keyword) || !empty($filterStatus)): ?>
                        <a href="<?= base_url('admin/slider') ?>" class="py-2 px-3 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-lg text-sm font-medium transition-all" title="Reset Filter">
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
                        <th class="py-3.5 px-4 w-28 text-center">Gambar</th>
                        <th class="py-3.5 px-4">Judul Slider</th>
                        <th class="py-3.5 px-4 w-24 text-center">Urutan</th>
                        <th class="py-3.5 px-4 w-28 text-center">Status</th>
                        <th class="py-3.5 px-4">Link Tautan</th>
                        <th class="py-3.5 px-4 w-32 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">

                    <?php if (!empty($sliders) && is_array($sliders)) : ?>
                        <?php foreach ($sliders as $index => $row) : ?>
                            <?php
                            $id = $row['id'];
                            $base64Data = base64_encode(json_encode($row));
                            ?>
                            <tr class="hover:bg-slate-50/80 transition-colors" data-slider="<?= $base64Data ?>">
                                <td class="py-4 px-4 text-center font-medium text-slate-400"><?= $index + 1 ?></td>

                                <!-- Gambar Thumbnail -->
                                <td class="py-4 px-4 text-center">
                                    <?php if (!empty($row['gambar'])) : ?>
                                        <img src="<?= base_url('uploads/slider/' . $row['gambar']) ?>" alt="Slider" class="w-16 h-10 rounded-lg object-cover border border-slate-200 mx-auto shadow-sm">
                                    <?php else : ?>
                                        <div class="w-16 h-10 rounded-lg bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-400 mx-auto">
                                            <i class="fa-solid fa-image text-xs"></i>
                                        </div>
                                    <?php endif; ?>
                                </td>

                                <td class="py-4 px-4">
                                    <div class="font-semibold text-slate-800"><?= esc($row['judul'] ?? '-') ?></div>
                                    <p class="text-xs text-slate-500 line-clamp-1 mt-0.5"><?= esc($row['deskripsi'] ?? '-') ?></p>
                                </td>

                                <td class="py-4 px-4 text-center font-medium text-slate-600">
                                    <?= esc($row['urutan'] ?? '0') ?>
                                </td>

                                <td class="py-4 px-4 text-center">
                                    <?php if (($row['status'] ?? 'aktif') === 'aktif') : ?>
                                        <span class="inline-block bg-emerald-50 text-emerald-700 text-xs px-2.5 py-1 rounded-md font-medium border border-emerald-200">
                                            Aktif
                                        </span>
                                    <?php else : ?>
                                        <span class="inline-block bg-slate-100 text-slate-600 text-xs px-2.5 py-1 rounded-md font-medium border border-slate-200">
                                            Nonaktif
                                        </span>
                                    <?php endif; ?>
                                </td>

                                <td class="py-4 px-4">
                                    <?php if (!empty($row['link'])) : ?>
                                        <a href="<?= esc($row['link']) ?>" target="_blank" rel="noopener noreferrer" class="text-xs text-blue-600 hover:underline flex items-center gap-1 font-medium">
                                            <i class="fa-solid fa-link text-[10px]"></i>
                                            <span class="max-w-[150px] truncate"><?= esc($row['link']) ?></span>
                                        </a>
                                    <?php else : ?>
                                        <span class="text-xs text-slate-400">-</span>
                                    <?php endif; ?>
                                </td>

                                <!-- TOMBOL AKSI -->
                                <td class="py-4 px-4 text-center">
                                    <div class="inline-flex items-center justify-center gap-1">
                                        <!-- Tombol Detail -->
                                        <button type="button" onclick="openModalDetailFromRow(this)" class="p-1.5 text-slate-500 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors" title="Lihat Detail">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </button>

                                        <!-- Tombol Edit -->
                                        <button type="button" onclick="openModalEditFromRow(this)" class="p-1.5 text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition-colors" title="Edit Data">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>

                                        <!-- Tombol Hapus -->
                                        <button type="button" onclick="openModalHapus('<?= $id ?>')" class="p-1.5 text-rose-600 hover:text-rose-800 hover:bg-rose-50 rounded-lg transition-colors" title="Hapus Data">
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
                            <td colspan="7" class="py-8 text-center text-slate-400 text-sm">
                                Belum ada data Slider / Banner yang ditemukan.
                            </td>
                        </tr>
                    <?php endif; ?>

                </tbody>
            </table>
        </div>

        <!-- Table Summary Footer -->
        <div class="px-5 py-4 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-500">
            <span>Total data: <strong><?= count($sliders ?? []) ?></strong> Slider</span>
        </div>

    </div>
</main>

<!-- MODAL DETAIL SLIDER -->
<div id="modalDetail" class="modal-backdrop fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm hidden" onclick="closeModalOnBackdrop(event, 'modalDetail')">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-lg overflow-hidden transform transition-all">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100 bg-slate-50/50">
            <h3 class="font-bold text-slate-800 text-lg flex items-center gap-2">
                <i class="fa-solid fa-image text-emerald-600"></i>
                <span>Detail Slider</span>
            </h3>
            <button type="button" onclick="closeModal('modalDetail')" class="text-slate-400 hover:text-slate-600 text-lg">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div class="p-6 space-y-4 text-sm text-slate-700">
            <!-- Gambar Preview -->
            <div id="detailGambarContainer" class="hidden mb-2">
                <img id="detailGambar" src="" alt="Gambar Slider" class="w-full h-52 object-cover rounded-lg border border-slate-200">
            </div>

            <div>
                <span class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Judul Slider</span>
                <p id="detailJudul" class="font-semibold text-slate-800 text-base"></p>
            </div>

            <div class="grid grid-cols-3 gap-4 pt-2 border-t border-slate-100">
                <div>
                    <span class="block text-xs font-semibold text-slate-400 uppercase mb-1">Urutan</span>
                    <span id="detailUrutan" class="font-medium text-slate-800"></span>
                </div>
                <div>
                    <span class="block text-xs font-semibold text-slate-400 uppercase mb-1">Status</span>
                    <span id="detailStatus" class="inline-block text-xs px-2.5 py-1 rounded-md font-medium border"></span>
                </div>
                <div>
                    <span class="block text-xs font-semibold text-slate-400 uppercase mb-1">Tautan Link</span>
                    <div id="detailLink"></div>
                </div>
            </div>

            <div class="pt-2 border-t border-slate-100">
                <span class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Deskripsi</span>
                <p id="detailDeskripsi" class="text-slate-600 bg-slate-50 p-3 rounded-lg text-xs leading-relaxed whitespace-pre-line"></p>
            </div>
        </div>
        <div class="px-6 py-3.5 bg-slate-50 border-t border-slate-100 text-right">
            <button type="button" onclick="closeModal('modalDetail')" class="px-4 py-2 bg-slate-800 hover:bg-slate-900 text-white rounded-lg text-xs font-medium transition-colors">Tutup</button>
        </div>
    </div>
</div>

<!-- MODAL FORM TAMBAH / EDIT -->
<div id="modalSlider" class="modal-backdrop fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm hidden" onclick="closeModalOnBackdrop(event, 'modalSlider')">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-xl overflow-hidden transform transition-all max-h-[90vh] flex flex-col">
        <!-- Modal Header -->
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
            <h3 id="modalTitle" class="font-bold text-slate-800 text-lg">Tambah Slider</h3>
            <button type="button" onclick="closeModal('modalSlider')" class="text-slate-400 hover:text-slate-600 text-lg">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <!-- Modal Form Body -->
        <form id="formSlider" action="<?= base_url('admin/slider/simpan') ?>" method="POST" enctype="multipart/form-data" class="overflow-y-auto flex-1">
            <?= csrf_field() ?>
            <input type="hidden" name="id" id="inputId" value="">

            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Judul Slider</label>
                    <input type="text" id="inputJudul" name="judul" placeholder="Masukkan judul slider..." class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Urutan</label>
                        <input type="number" id="inputUrutan" name="urutan" value="0" min="0" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Status <span class="text-rose-500">*</span></label>
                        <select id="selectStatus" name="status" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none">
                            <option value="aktif">Aktif</option>
                            <option value="nonaktif">Nonaktif</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Link Tautan</label>
                        <input type="url" id="inputLink" name="link" placeholder="https://..." class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Gambar Slider <span id="gambarRequiredNotice" class="text-rose-500">*</span></label>
                    <input type="file" name="gambar" id="inputGambar" accept="image/*" onchange="previewImage(event)" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 border border-slate-300 rounded-lg">
                    <p class="text-[11px] text-slate-400 mt-1">Format: JPG, PNG, JPEG, WEBP. Maksimal 2MB.</p>

                    <!-- Live Image Preview Container -->
                    <div id="formPreviewContainer" class="hidden mt-3">
                        <span class="block text-xs font-medium text-slate-500 mb-1">Pratinjau Gambar:</span>
                        <img id="formPreviewImg" src="" alt="Preview Gambar" class="w-full h-36 object-cover rounded-lg border border-slate-200">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Deskripsi / Keterangan</label>
                    <textarea id="inputDeskripsi" name="deskripsi" rows="3" placeholder="Deskripsi singkat mengenai slider..." class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none"></textarea>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-2">
                <button type="button" onclick="closeModal('modalSlider')" class="px-4 py-2 bg-white border border-slate-300 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-50 transition-colors">Batal</button>
                <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-sm font-medium transition-colors inline-flex items-center gap-1.5">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Simpan Data</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL KONFIRMASI HAPUS -->
<div id="modalHapus" class="modal-backdrop fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm hidden" onclick="closeModalOnBackdrop(event, 'modalHapus')">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md overflow-hidden p-6 text-center">
        <div class="w-12 h-12 bg-rose-100 text-rose-600 rounded-full flex items-center justify-center mx-auto mb-4 text-xl">
            <i class="fa-solid fa-triangle-exclamation"></i>
        </div>
        <h3 class="text-lg font-bold text-slate-800 mb-1">Hapus Slider?</h3>
        <p class="text-sm text-slate-500 mb-6">Apakah Anda yakin ingin menghapus data Slider ini? Data yang dihapus tidak dapat dikembalikan.</p>

        <form id="formHapus" action="" method="POST" class="flex items-center justify-center gap-3">
            <?= csrf_field() ?>
            <input type="hidden" name="_method" value="DELETE">
            <button type="button" onclick="closeModal('modalHapus')" class="w-full py-2 bg-white border border-slate-300 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-50 transition-colors">Batal</button>
            <button type="submit" class="w-full py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-sm font-medium transition-colors">Ya, Hapus</button>
        </form>
    </div>
</div>

<!-- JAVASCRIPT AKSI & MODAL -->
<script>
    const baseUrl = "<?= base_url('admin/slider') ?>";
    const uploadUrl = "<?= base_url('uploads/slider') ?>/";

    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }

    function closeModalOnBackdrop(e, modalId) {
        if (e.target.id === modalId) {
            closeModal(modalId);
        }
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            ['modalDetail', 'modalSlider', 'modalHapus'].forEach(closeModal);
        }
    });

    function getRowData(btn) {
        const tr = btn.closest('tr');
        const encodedData = tr.getAttribute('data-slider');
        try {
            return JSON.parse(atob(encodedData));
        } catch (err) {
            console.error("Gagal melakukan parse data JSON:", err);
            return {};
        }
    }

    function sanitizeUrl(url) {
        if (!url) return '';
        if (!/^https?:\/\//i.test(url)) {
            return 'https://' + url;
        }
        return url;
    }

    // Modal Detail Slider
    function openModalDetailFromRow(btn) {
        const data = getRowData(btn);

        document.getElementById('detailJudul').innerText = data.judul || '-';
        document.getElementById('detailUrutan').innerText = data.urutan ?? '0';

        const statusBadge = document.getElementById('detailStatus');
        if ((data.status || 'aktif') === 'aktif') {
            statusBadge.innerText = 'Aktif';
            statusBadge.className = 'inline-block bg-emerald-50 text-emerald-700 text-xs px-2.5 py-1 rounded-md font-medium border border-emerald-200';
        } else {
            statusBadge.innerText = 'Nonaktif';
            statusBadge.className = 'inline-block bg-slate-100 text-slate-600 text-xs px-2.5 py-1 rounded-md font-medium border border-slate-200';
        }

        const linkContainer = document.getElementById('detailLink');
        if (data.link) {
            const formattedUrl = sanitizeUrl(data.link);
            linkContainer.innerHTML = `<a href="${formattedUrl}" target="_blank" rel="noopener noreferrer" class="text-emerald-600 hover:underline font-medium text-xs break-all">${data.link}</a>`;
        } else {
            linkContainer.innerHTML = `<span class="font-medium text-slate-700 text-xs">-</span>`;
        }

        document.getElementById('detailDeskripsi').innerText = data.deskripsi || 'Tidak ada deskripsi.';

        const gambarContainer = document.getElementById('detailGambarContainer');
        const gambarImg = document.getElementById('detailGambar');
        if (data.gambar) {
            gambarImg.src = uploadUrl + data.gambar;
            gambarContainer.classList.remove('hidden');
        } else {
            gambarContainer.classList.add('hidden');
        }

        document.getElementById('modalDetail').classList.remove('hidden');
    }

    // Modal Tambah Slider
    function openModalTambah() {
        document.getElementById('modalTitle').innerText = 'Tambah Slider';
        document.getElementById('formSlider').action = `${baseUrl}/simpan`;

        document.getElementById('formSlider').reset();
        document.getElementById('inputId').value = '';
        document.getElementById('inputGambar').value = '';
        document.getElementById('inputGambar').required = true;
        document.getElementById('gambarRequiredNotice').classList.remove('hidden');
        document.getElementById('selectStatus').value = "aktif";
        document.getElementById('inputUrutan').value = "0";
        document.getElementById('formPreviewContainer').classList.add('hidden');

        document.getElementById('modalSlider').classList.remove('hidden');
    }

    // Modal Edit Slider
    function openModalEditFromRow(btn) {
        const data = getRowData(btn);
        const id = data.id;

        document.getElementById('modalTitle').innerText = 'Edit Slider';
        document.getElementById('formSlider').action = `${baseUrl}/update/${id}`;
        document.getElementById('inputId').value = id || '';
        document.getElementById('inputGambar').value = '';
        document.getElementById('inputGambar').required = false;
        document.getElementById('gambarRequiredNotice').classList.add('hidden');

        document.getElementById('inputJudul').value = data.judul || '';
        document.getElementById('inputUrutan').value = data.urutan ?? 0;
        document.getElementById('selectStatus').value = data.status || 'aktif';
        document.getElementById('inputLink').value = data.link || '';
        document.getElementById('inputDeskripsi').value = data.deskripsi || '';

        // Live Image Preview
        const previewContainer = document.getElementById('formPreviewContainer');
        const previewImg = document.getElementById('formPreviewImg');
        if (data.gambar) {
            previewImg.src = uploadUrl + data.gambar;
            previewContainer.classList.remove('hidden');
        } else {
            previewContainer.classList.add('hidden');
        }

        document.getElementById('modalSlider').classList.remove('hidden');
    }

    // Modal Hapus Slider
    function openModalHapus(id) {
        document.getElementById('formHapus').action = `${baseUrl}/hapus/${id}`;
        document.getElementById('modalHapus').classList.remove('hidden');
    }

    // Handler Preview Gambar
    function previewImage(e) {
        const file = e.target.files[0];
        const previewContainer = document.getElementById('formPreviewContainer');
        const previewImg = document.getElementById('formPreviewImg');

        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                previewImg.src = event.target.result;
                previewContainer.classList.remove('hidden');
            }
            reader.readAsDataURL(file);
        }
    }
</script>

<?= $this->endSection() ?>