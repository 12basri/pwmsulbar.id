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
                    <li><span class="text-slate-400">Direktori Website</span></li>
                    <li><span class="mx-1 text-slate-400">/</span></li>
                    <li class="font-medium text-slate-800">Website PDM</li>
                </ol>
            </nav>
            <h1 class="text-2xl font-bold text-slate-800">Kelola Website PDM</h1>
            <p class="text-xs text-slate-500 mt-0.5">Daftar tautan dan domain resmi Pimpinan Daerah Muhammadiyah.</p>
        </div>

        <button onclick="openModalTambah()" class="inline-flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-medium px-4 py-2.5 rounded-lg shadow-sm transition-all duration-200">
            <i class="fa-solid fa-plus text-sm"></i>
            <span>Tambah Website PDM</span>
        </button>
    </div>

    <!-- Alert Notifications -->
    <?php if (session()->getFlashdata('sukses')) : ?>
        <div class="mb-5 p-4 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-2.5">
                <i class="fa-solid fa-circle-check text-emerald-600 text-base"></i>
                <span><?= session()->getFlashdata('sukses') ?></span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 transition-colors"><i class="fa-solid fa-xmark"></i></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('gagal')) : ?>
        <div class="mb-5 p-4 rounded-lg bg-rose-50 border border-rose-200 text-rose-800 text-sm flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-2.5">
                <i class="fa-solid fa-triangle-exclamation text-rose-600 text-base"></i>
                <span><?= session()->getFlashdata('gagal') ?></span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-700 transition-colors"><i class="fa-solid fa-xmark"></i></button>
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

    <!-- Main Card Wrapper -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200/80 overflow-hidden">

        <!-- Search Bar -->
        <div class="p-5 border-b border-slate-100 bg-slate-50/50">
            <form action="<?= base_url('admin/website-pdm') ?>" method="GET" class="flex flex-col sm:flex-row items-center gap-3">
                <div class="relative w-full sm:w-96">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </span>
                    <input type="text" name="q" value="<?= esc($keyword ?? '') ?>" placeholder="Cari nama PDM atau URL website..." class="w-full pl-9 pr-4 py-2 bg-white border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all">
                </div>

                <div class="flex items-center gap-2 w-full sm:w-auto">
                    <button type="submit" class="py-2 px-4 bg-slate-800 hover:bg-slate-900 text-white rounded-lg text-sm font-medium transition-all flex items-center justify-center gap-2 shadow-sm w-full sm:w-auto">
                        <i class="fa-solid fa-filter text-xs"></i>
                        <span>Cari</span>
                    </button>
                    <?php if (!empty($keyword)): ?>
                        <a href="<?= base_url('admin/website-pdm') ?>" class="py-2 px-3 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-lg text-sm font-medium transition-all flex items-center justify-center" title="Reset Pencarian">
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
                        <th class="py-3.5 px-4">URL / Alamat Website</th>
                        <th class="py-3.5 px-4">Keterangan</th>
                        <th class="py-3.5 px-4 w-40">Tanggal Dibuat</th>
                        <th class="py-3.5 px-4 w-28 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">

                    <?php if (!empty($website_pdm) && is_array($website_pdm)) : ?>
                        <?php foreach ($website_pdm as $index => $row) : ?>
                            <?php
                            $idWebsite = $row['id_website'];
                            $jsonData = htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8');
                            ?>
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="py-4 px-4 text-center font-medium text-slate-400"><?= $index + 1 ?></td>
                                <td class="py-4 px-4 font-semibold text-slate-800">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0 font-bold text-xs">
                                            <i class="fa-solid fa-globe"></i>
                                        </div>
                                        <span><?= esc($row['nama_pdm']) ?></span>
                                    </div>
                                </td>
                                <td class="py-4 px-4">
                                    <?php if (!empty($row['url'])) : ?>
                                        <a href="<?= esc($row['url']) ?>" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 text-emerald-600 hover:text-emerald-700 hover:underline font-medium text-xs bg-emerald-50/60 px-2.5 py-1 rounded-md border border-emerald-100">
                                            <span><?= esc($row['url']) ?></span>
                                            <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                                        </a>
                                    <?php else : ?>
                                        <span class="text-slate-400 italic text-xs">- Belum ada URL -</span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-4 px-4 text-slate-600 max-w-xs truncate">
                                    <?= esc($row['keterangan'] ?? '-') ?>
                                </td>
                                <td class="py-4 px-4 text-xs text-slate-500">
                                    <?= !empty($row['created_at']) ? date('d M Y, H:i', strtotime($row['created_at'])) : '-' ?>
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
                                        <button type="button" onclick="openModalHapus('<?= $idWebsite ?>')" class="p-1.5 text-rose-600 hover:text-rose-800 hover:bg-rose-50 rounded-lg transition-colors" title="Hapus Data">
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
                            <td colspan="6" class="py-8 text-center text-slate-400 text-sm">
                                Belum ada data website PDM yang terdaftar.
                            </td>
                        </tr>
                    <?php endif; ?>

                </tbody>
            </table>
        </div>

        <!-- Table Summary Footer -->
        <div class="px-5 py-4 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-500">
            <span>Total data: <strong><?= count($website_pdm ?? []) ?></strong> website PDM</span>
        </div>

    </div>
</main>

<!-- MODAL DETAIL WEBSITE PDM -->
<div id="modalDetail" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm hidden">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-lg overflow-hidden transform transition-all">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100 bg-slate-50/50">
            <h3 class="font-bold text-slate-800 text-lg flex items-center gap-2">
                <i class="fa-solid fa-circle-info text-emerald-600"></i>
                <span>Detail Website PDM</span>
            </h3>
            <button type="button" onclick="closeModal('modalDetail')" class="text-slate-400 hover:text-slate-600 text-lg transition-colors">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div class="p-6 space-y-4 text-sm text-slate-700">
            <div>
                <span class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Nama PDM</span>
                <h4 id="detailNamaPdm" class="font-bold text-slate-800 text-base"></h4>
            </div>

            <div class="pt-2 border-t border-slate-100">
                <span class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">URL / Link Website</span>
                <div id="detailUrlWrapper"></div>
            </div>

            <div class="pt-2 border-t border-slate-100">
                <span class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Keterangan</span>
                <p id="detailKeterangan" class="text-slate-600 bg-slate-50 p-3 rounded-lg text-xs leading-relaxed whitespace-pre-line"></p>
            </div>

            <div class="pt-2 border-t border-slate-100">
                <span class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Tanggal Dibuat</span>
                <p id="detailCreatedAt" class="font-medium text-slate-700 text-xs"></p>
            </div>
        </div>
        <div class="px-6 py-3.5 bg-slate-50 border-t border-slate-100 text-right">
            <button type="button" onclick="closeModal('modalDetail')" class="px-4 py-2 bg-slate-800 hover:bg-slate-900 text-white rounded-lg text-xs font-medium transition-colors">Tutup</button>
        </div>
    </div>
</div>

<!-- MODAL FORM TAMBAH / EDIT -->
<div id="modalWebsite" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm hidden">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-lg overflow-hidden transform transition-all">
        <!-- Modal Header -->
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
            <h3 id="modalTitle" class="font-bold text-slate-800 text-lg">Tambah Website PDM</h3>
            <button type="button" onclick="closeModal('modalWebsite')" class="text-slate-400 hover:text-slate-600 text-lg transition-colors">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <!-- Modal Form Body -->
        <form id="formWebsite" action="<?= base_url('admin/website-pdm/simpan') ?>" method="POST">
            <?= csrf_field() ?>

            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Nama PDM <span class="text-rose-500">*</span></label>
                    <input type="text" id="inputNamaPdm" name="nama_pdm" required placeholder="Contoh: PDM Kota Yogyakarta" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">URL / Alamat Website <span class="text-rose-500">*</span></label>
                    <input type="url" id="inputUrl" name="url" required placeholder="https://pdm-jogja.or.id" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none">
                    <p class="text-[11px] text-slate-400 mt-1">Gunakan awalan http:// atau https://</p>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Keterangan</label>
                    <textarea id="inputKeterangan" name="keterangan" rows="4" placeholder="Tuliskan keterangan singkat mengenai website PDM ini..." class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none"></textarea>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-2">
                <button type="button" onclick="closeModal('modalWebsite')" class="px-4 py-2 bg-white border border-slate-300 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-50 transition-colors">Batal</button>
                <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-sm font-medium transition-colors inline-flex items-center gap-1.5 shadow-sm">
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
        <h3 class="text-lg font-bold text-slate-800 mb-1">Hapus Website PDM?</h3>
        <p class="text-sm text-slate-500 mb-6">Apakah Anda yakin ingin menghapus data website ini? Tindakan ini tidak dapat dibatalkan.</p>
        <div class="flex items-center justify-center gap-3">
            <button type="button" onclick="closeModal('modalHapus')" class="w-full py-2 bg-white border border-slate-300 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-50 transition-colors">Batal</button>
            <a id="btnConfirmHapus" href="#" class="w-full py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-sm font-medium transition-colors flex items-center justify-center">Ya, Hapus</a>
        </div>
    </div>
</div>

<!-- JAVASCRIPT AKSI & MODAL -->
<script>
    const baseUrl = "<?= base_url('admin/website-pdm') ?>";

    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }

    // Modal Detail Website PDM
    function openModalDetail(data) {
        document.getElementById('detailNamaPdm').innerText = data.nama_pdm || '-';
        document.getElementById('detailKeterangan').innerText = data.keterangan || 'Tidak ada keterangan tambahan.';
        document.getElementById('detailCreatedAt').innerText = data.created_at || '-';

        const urlWrapper = document.getElementById('detailUrlWrapper');
        if (data.url) {
            urlWrapper.innerHTML = `<a href="${data.url}" target="_blank" class="inline-flex items-center gap-1.5 text-emerald-600 hover:underline font-medium text-sm"><i class="fa-solid fa-link"></i> ${data.url} <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i></a>`;
        } else {
            urlWrapper.innerHTML = `<span class="text-slate-400 italic text-sm">- Tidak ada URL -</span>`;
        }

        document.getElementById('modalDetail').classList.remove('hidden');
    }

    // Modal Tambah Website
    function openModalTambah() {
        document.getElementById('modalTitle').innerText = 'Tambah Website PDM';
        document.getElementById('formWebsite').action = `${baseUrl}/simpan`;

        document.getElementById('formWebsite').reset();

        document.getElementById('modalWebsite').classList.remove('hidden');
    }

    // Modal Edit Website
    function openModalEdit(data) {
        document.getElementById('modalTitle').innerText = 'Edit Website PDM';

        const id = data.id_website;
        document.getElementById('formWebsite').action = `${baseUrl}/update/${id}`;

        document.getElementById('inputNamaPdm').value = data.nama_pdm || '';
        document.getElementById('inputUrl').value = data.url || '';
        document.getElementById('inputKeterangan').value = data.keterangan || '';

        document.getElementById('modalWebsite').classList.remove('hidden');
    }

    // Modal Hapus
    function openModalHapus(id) {
        document.getElementById('btnConfirmHapus').href = `${baseUrl}/hapus/${id}`;
        document.getElementById('modalHapus').classList.remove('hidden');
    }
</script>

<?= $this->endSection() ?>