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
                    <li class="font-medium text-slate-800">Amal Usaha</li>
                </ol>
            </nav>
            <h1 class="text-2xl font-bold text-slate-800">Kelola Amal Usaha Muhammadiyah</h1>
        </div>

        <button onclick="openModalTambah()" class="inline-flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-medium px-4 py-2.5 rounded-lg shadow-sm transition-all duration-200">
            <i class="fa-solid fa-plus text-sm"></i>
            <span>Tambah Amal Usaha</span>
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
            <form action="<?= base_url('admin/profil/amal-usaha') ?>" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3">

                <!-- Search Input -->
                <div class="lg:col-span-7">
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </span>
                        <input type="text" name="q" value="<?= esc($keyword ?? '') ?>" placeholder="Cari nama AUM, pimpinan, telepon, atau alamat..." class="w-full pl-9 pr-4 py-2 bg-white border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all">
                    </div>
                </div>

                <!-- Filter Jenis AUM -->
                <div class="lg:col-span-3">
                    <select name="jenis" class="w-full py-2 px-3 bg-white border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none text-slate-700">
                        <option value="">-- Semua Jenis AUM --</option>
                        <option value="Kesehatan" <?= (($filterJenis ?? '') == 'Kesehatan') ? 'selected' : '' ?>>Kesehatan</option>
                        <option value="Pendidikan" <?= (($filterJenis ?? '') == 'Pendidikan') ? 'selected' : '' ?>>Pendidikan</option>
                        <option value="Sosial" <?= (($filterJenis ?? '') == 'Sosial') ? 'selected' : '' ?>>Sosial</option>
                        <option value="Ekonomi" <?= (($filterJenis ?? '') == 'Ekonomi') ? 'selected' : '' ?>>Ekonomi</option>
                        <option value="Keagamaan" <?= (($filterJenis ?? '') == 'Keagamaan') ? 'selected' : '' ?>>Keagamaan</option>
                    </select>
                </div>

                <!-- Submit & Reset Button -->
                <div class="lg:col-span-2 flex items-center gap-2">
                    <button type="submit" class="w-full py-2 px-4 bg-slate-800 hover:bg-slate-900 text-white rounded-lg text-sm font-medium transition-all flex items-center justify-center gap-2">
                        <i class="fa-solid fa-filter text-xs"></i>
                        <span>Filter</span>
                    </button>
                    <?php if (!empty($keyword) || !empty($filterJenis)): ?>
                        <a href="<?= base_url('admin/profil/amal-usaha') ?>" class="py-2 px-3 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-lg text-sm font-medium transition-all" title="Reset Filter">
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
                        <th class="py-3.5 px-4 w-16 text-center">Foto</th>
                        <th class="py-3.5 px-4">Nama Amal Usaha</th>
                        <th class="py-3.5 px-4">Jenis</th>
                        <th class="py-3.5 px-4">Pimpinan & Kontak</th>
                        <th class="py-3.5 px-4 w-32 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">

                    <?php if (!empty($amalUsaha) && is_array($amalUsaha)) : ?>
                        <?php foreach ($amalUsaha as $index => $row) : ?>
                            <?php
                            $idAum = $row['id_aum'];
                            $safeJson = htmlspecialchars(json_encode($row, JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_AMP), ENT_QUOTES, 'UTF-8');
                            ?>
                            <tr class="hover:bg-slate-50/80 transition-colors" data-aum='<?= $safeJson ?>'>
                                <td class="py-4 px-4 text-center font-medium text-slate-400"><?= $index + 1 ?></td>

                                <!-- Foto Thumbnail -->
                                <td class="py-4 px-4 text-center">
                                    <?php if (!empty($row['foto'])) : ?>
                                        <img src="<?= base_url($row['foto']) ?>" alt="AUM" class="w-10 h-10 rounded-lg object-cover border border-slate-200 mx-auto">
                                    <?php else : ?>
                                        <div class="w-10 h-10 rounded-lg bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-400 mx-auto">
                                            <i class="fa-solid fa-building text-xs"></i>
                                        </div>
                                    <?php endif; ?>
                                </td>

                                <td class="py-4 px-4">
                                    <div class="font-semibold text-slate-800"><?= esc($row['nama_aum']) ?></div>
                                    <p class="text-xs text-slate-500 line-clamp-1 mt-0.5"><?= esc($row['alamat'] ?? '-') ?></p>
                                </td>

                                <td class="py-4 px-4">
                                    <span class="inline-block bg-emerald-50 text-emerald-700 text-xs px-2.5 py-1 rounded-md font-medium border border-emerald-200">
                                        <?= esc($row['jenis'] ?? '-') ?>
                                    </span>
                                </td>

                                <td class="py-4 px-4">
                                    <div class="font-medium text-slate-700"><?= esc($row['pimpinan'] ?? '-') ?></div>
                                    <div class="text-xs text-slate-500 mt-0.5 space-y-0.5">
                                        <?php if (!empty($row['telepon'])): ?>
                                            <div><i class="fa-solid fa-phone text-[10px] text-slate-400 mr-1"></i><?= esc($row['telepon']) ?></div>
                                        <?php endif; ?>
                                        <?php if (!empty($row['email'])): ?>
                                            <div><i class="fa-solid fa-envelope text-[10px] text-slate-400 mr-1"></i><?= esc($row['email']) ?></div>
                                        <?php endif; ?>
                                    </div>
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
                                        <button type="button" onclick="openModalHapus('<?= $idAum ?>')" class="p-1.5 text-rose-600 hover:text-rose-800 hover:bg-rose-50 rounded-lg transition-colors" title="Hapus Data">
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
                                Belum ada data Amal Usaha Muhammadiyah yang ditemukan.
                            </td>
                        </tr>
                    <?php endif; ?>

                </tbody>
            </table>
        </div>

        <!-- Table Summary Footer -->
        <div class="px-5 py-4 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-500">
            <span>Total data: <strong><?= count($amalUsaha ?? []) ?></strong> Amal Usaha</span>
        </div>

    </div>
</main>

<!-- MODAL DETAIL AMAL USAHA -->
<div id="modalDetail" class="modal-backdrop fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm hidden" onclick="closeModalOnBackdrop(event, 'modalDetail')">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-lg overflow-hidden transform transition-all">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100 bg-slate-50/50">
            <h3 class="font-bold text-slate-800 text-lg flex items-center gap-2">
                <i class="fa-solid fa-building text-emerald-600"></i>
                <span>Detail Amal Usaha</span>
            </h3>
            <button type="button" onclick="closeModal('modalDetail')" class="text-slate-400 hover:text-slate-600 text-lg">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div class="p-6 space-y-4 text-sm text-slate-700">
            <!-- Foto Preview -->
            <div id="detailFotoContainer" class="hidden mb-2">
                <img id="detailFoto" src="" alt="Foto AUM" class="w-full h-48 object-cover rounded-lg border border-slate-200">
            </div>

            <div>
                <span class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Nama Amal Usaha</span>
                <p id="detailNamaAum" class="font-semibold text-slate-800 text-base"></p>
            </div>

            <div class="grid grid-cols-2 gap-4 pt-2 border-t border-slate-100">
                <div>
                    <span class="block text-xs font-semibold text-slate-400 uppercase mb-1">Jenis AUM</span>
                    <span id="detailJenis" class="inline-block bg-emerald-50 text-emerald-700 text-xs px-2.5 py-1 rounded-md font-medium border border-emerald-200"></span>
                </div>
                <div>
                    <span class="block text-xs font-semibold text-slate-400 uppercase mb-1">Pimpinan</span>
                    <p id="detailPimpinan" class="font-medium text-slate-800"></p>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-4 pt-2 border-t border-slate-100">
                <div>
                    <span class="block text-xs font-semibold text-slate-400 uppercase mb-1">Telepon</span>
                    <p id="detailTelepon" class="font-medium text-slate-700 text-xs"></p>
                </div>
                <div>
                    <span class="block text-xs font-semibold text-slate-400 uppercase mb-1">Email</span>
                    <p id="detailEmail" class="font-medium text-slate-700 text-xs break-all"></p>
                </div>
                <div>
                    <span class="block text-xs font-semibold text-slate-400 uppercase mb-1">Website</span>
                    <div id="detailWebsite"></div>
                </div>
            </div>

            <div class="pt-2 border-t border-slate-100">
                <span class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Alamat Lengkap</span>
                <p id="detailAlamat" class="text-slate-600 bg-slate-50 p-3 rounded-lg text-xs leading-relaxed"></p>
            </div>

            <div class="pt-2 border-t border-slate-100">
                <span class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Deskripsi Singkat</span>
                <p id="detailDeskripsi" class="text-slate-600 bg-slate-50 p-3 rounded-lg text-xs leading-relaxed whitespace-pre-line"></p>
            </div>
        </div>
        <div class="px-6 py-3.5 bg-slate-50 border-t border-slate-100 text-right">
            <button type="button" onclick="closeModal('modalDetail')" class="px-4 py-2 bg-slate-800 hover:bg-slate-900 text-white rounded-lg text-xs font-medium transition-colors">Tutup</button>
        </div>
    </div>
</div>

<!-- MODAL FORM TAMBAH / EDIT -->
<div id="modalAum" class="modal-backdrop fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm hidden" onclick="closeModalOnBackdrop(event, 'modalAum')">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-2xl overflow-hidden transform transition-all max-h-[90vh] flex flex-col">
        <!-- Modal Header -->
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
            <h3 id="modalTitle" class="font-bold text-slate-800 text-lg">Tambah Amal Usaha</h3>
            <button type="button" onclick="closeModal('modalAum')" class="text-slate-400 hover:text-slate-600 text-lg">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <!-- Modal Form Body -->
        <form id="formAum" action="<?= base_url('admin/profil/amal-usaha/simpan') ?>" method="POST" enctype="multipart/form-data" class="overflow-y-auto flex-1">
            <?= csrf_field() ?>
            <input type="hidden" name="id_aum" id="inputIdAum" value="">

            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Nama Amal Usaha <span class="text-rose-500">*</span></label>
                    <input type="text" id="inputNamaAum" name="nama_aum" required placeholder="Contoh: RS PKU Muhammadiyah / SMA Muhammadiyah 1" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                    <div class="md:col-span-6">
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Jenis AUM <span class="text-rose-500">*</span></label>
                        <select id="selectJenis" name="jenis" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none">
                            <option value="Kesehatan">Kesehatan</option>
                            <option value="Pendidikan">Pendidikan</option>
                            <option value="Sosial">Sosial</option>
                            <option value="Ekonomi">Ekonomi</option>
                            <option value="Keagamaan">Keagamaan</option>
                        </select>
                    </div>

                    <div class="md:col-span-6">
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Pimpinan</label>
                        <input type="text" id="inputPimpinan" name="pimpinan" placeholder="Nama Pimpinan / Direktur / Kepsek" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                    <div class="md:col-span-4">
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Telepon</label>
                        <input type="text" id="inputTelepon" name="telepon" placeholder="0274-123456" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none">
                    </div>

                    <div class="md:col-span-4">
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Email</label>
                        <input type="email" id="inputEmail" name="email" placeholder="info@aum.or.id" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none">
                    </div>

                    <div class="md:col-span-4">
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Website</label>
                        <input type="url" id="inputWebsite" name="website" placeholder="https://aum.or.id" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Foto AUM</label>
                    <input type="file" name="foto" id="inputFoto" accept="image/*" onchange="previewImage(event)" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 border border-slate-300 rounded-lg">
                    <p class="text-[11px] text-slate-400 mt-1">Format: JPG, PNG, JPEG. Maksimal 2MB. Kosongkan jika tidak ingin mengubah foto.</p>

                    <!-- Live Image Preview Container -->
                    <div id="formPreviewContainer" class="hidden mt-3">
                        <span class="block text-xs font-medium text-slate-500 mb-1">Pratinjau Foto:</span>
                        <img id="formPreviewImg" src="" alt="Preview Foto" class="w-32 h-32 object-cover rounded-lg border border-slate-200">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Alamat Lengkap</label>
                    <textarea id="inputAlamat" name="alamat" rows="2" placeholder="Jl. Ahmad Dahlan No. 45..." class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none"></textarea>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Deskripsi</label>
                    <textarea id="inputDeskripsi" name="deskripsi" rows="3" placeholder="Deskripsi singkat mengenai profil AUM..." class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none"></textarea>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-2">
                <button type="button" onclick="closeModal('modalAum')" class="px-4 py-2 bg-white border border-slate-300 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-50 transition-colors">Batal</button>
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
        <h3 class="text-lg font-bold text-slate-800 mb-1">Hapus Amal Usaha?</h3>
        <p class="text-sm text-slate-500 mb-6">Apakah Anda yakin ingin menghapus data Amal Usaha ini? Data yang dihapus tidak dapat dikembalikan.</p>

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
    const baseUrl = "<?= base_url('admin/profil/amal-usaha') ?>";
    const siteUrl = "<?= base_url() ?>".replace(/\/$/, '');

    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }

    // Close on backdrop click
    function closeModalOnBackdrop(e, modalId) {
        if (e.target.id === modalId) {
            closeModal(modalId);
        }
    }

    // Close on Escape key press
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            ['modalDetail', 'modalAum', 'modalHapus'].forEach(closeModal);
        }
    });

    // Extract row data safely from dataset
    function getRowData(btn) {
        const tr = btn.closest('tr');
        return JSON.parse(tr.getAttribute('data-aum'));
    }

    // Modal Detail Amal Usaha
    function openModalDetailFromRow(btn) {
        const data = getRowData(btn);

        document.getElementById('detailNamaAum').innerText = data.nama_aum || '-';
        document.getElementById('detailJenis').innerText = data.jenis || '-';
        document.getElementById('detailPimpinan').innerText = data.pimpinan || '-';
        document.getElementById('detailTelepon').innerText = data.telepon || '-';
        document.getElementById('detailEmail').innerText = data.email || '-';

        const webContainer = document.getElementById('detailWebsite');
        if (data.website) {
            webContainer.innerHTML = `<a href="${data.website}" target="_blank" class="text-emerald-600 hover:underline font-medium text-xs break-all">${data.website}</a>`;
        } else {
            webContainer.innerHTML = `<span class="font-medium text-slate-700 text-xs">-</span>`;
        }

        document.getElementById('detailAlamat').innerText = data.alamat || 'Tidak ada alamat.';
        document.getElementById('detailDeskripsi').innerText = data.deskripsi || 'Tidak ada deskripsi.';

        const fotoContainer = document.getElementById('detailFotoContainer');
        const fotoImg = document.getElementById('detailFoto');
        if (data.foto) {
            const cleanPath = data.foto.startsWith('/') ? data.foto : '/' + data.foto;
            fotoImg.src = siteUrl + cleanPath;
            fotoContainer.classList.remove('hidden');
        } else {
            fotoContainer.classList.add('hidden');
        }

        document.getElementById('modalDetail').classList.remove('hidden');
    }

    // Modal Tambah
    function openModalTambah() {
        document.getElementById('modalTitle').innerText = 'Tambah Amal Usaha';
        document.getElementById('formAum').action = `${baseUrl}/simpan`;

        document.getElementById('formAum').reset();
        document.getElementById('inputIdAum').value = '';
        document.getElementById('selectJenis').value = "Pendidikan";
        document.getElementById('formPreviewContainer').classList.add('hidden');

        document.getElementById('modalAum').classList.remove('hidden');
    }

    // Modal Edit
    function openModalEditFromRow(btn) {
        const data = getRowData(btn);

        document.getElementById('modalTitle').innerText = 'Edit Amal Usaha';
        document.getElementById('formAum').action = `${baseUrl}/update/${data.id_aum}`;
        document.getElementById('inputIdAum').value = data.id_aum || '';

        document.getElementById('inputNamaAum').value = data.nama_aum || '';
        document.getElementById('selectJenis').value = data.jenis || 'Pendidikan';
        document.getElementById('inputPimpinan').value = data.pimpinan || '';
        document.getElementById('inputTelepon').value = data.telepon || '';
        document.getElementById('inputEmail').value = data.email || '';
        document.getElementById('inputWebsite').value = data.website || '';
        document.getElementById('inputAlamat').value = data.alamat || '';
        document.getElementById('inputDeskripsi').value = data.deskripsi || '';

        // Show existing image preview if available
        const previewContainer = document.getElementById('formPreviewContainer');
        const previewImg = document.getElementById('formPreviewImg');
        if (data.foto) {
            const cleanPath = data.foto.startsWith('/') ? data.foto : '/' + data.foto;
            previewImg.src = siteUrl + cleanPath;
            previewContainer.classList.remove('hidden');
        } else {
            previewContainer.classList.add('hidden');
        }

        document.getElementById('modalAum').classList.remove('hidden');
    }

    // Modal Hapus
    function openModalHapus(id_aum) {
        document.getElementById('formHapus').action = `${baseUrl}/hapus/${id_aum}`;
        document.getElementById('modalHapus').classList.remove('hidden');
    }

    // Image file input preview handler
    function previewImage(e) {
        const file = e.target.files[0];
        const previewContainer = document.getElementById('formPreviewContainer');
        const previewImg = document.getElementById('formPreviewImg');

        if (file) {
            const reader = new FileReader();
            reader.onload = function(evt) {
                previewImg.src = evt.target.result;
                previewContainer.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        }
    }
</script>

<?= $this->endSection() ?>