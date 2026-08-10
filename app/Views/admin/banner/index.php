<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="container mx-auto p-6">
    <!-- Header Page -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Manajemen Banner</h1>
            <p class="text-sm text-gray-600">Kelola daftar banner PWMuhammadiyah</p>
        </div>
        <button onclick="openModal('add')" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg shadow flex items-center transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Tambah Banner
        </button>
    </div>

    <!-- Alert Flash Data -->
    <?php if (session()->getFlashdata('success')) : ?>
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm" role="alert">
            <p><?= session()->getFlashdata('success') ?></p>
        </div>
    <?php endif; ?>

    <!-- Table Banner -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-100 border-b border-gray-200 text-gray-700 uppercase text-xs">
                    <th class="py-3 px-4 font-semibold">No</th>
                    <th class="py-3 px-4 font-semibold">Gambar</th>
                    <th class="py-3 px-4 font-semibold">Judul</th>
                    <th class="py-3 px-4 font-semibold">Link Target</th>
                    <th class="py-3 px-4 font-semibold">Posisi</th>
                    <th class="py-3 px-4 font-semibold">Status</th>
                    <th class="py-3 px-4 font-semibold text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 text-sm">
                <?php if (!empty($banners)) : ?>
                    <?php foreach ($banners as $index => $banner) : ?>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="py-3 px-4"><?= $index + 1 ?></td>
                            <td class="py-3 px-4">
                                <img src="<?= base_url('uploads/banner/' . $banner['gambar']) ?>" alt="<?= esc($banner['judul']) ?>" class="w-24 h-14 object-cover rounded shadow-sm">
                            </td>
                            <td class="py-3 px-4 font-medium text-gray-800"><?= esc($banner['judul']) ?></td>
                            <td class="py-3 px-4 text-blue-600">
                                <?php if ($banner['link']) : ?>
                                    <a href="<?= esc($banner['link']) ?>" target="_blank" class="hover:underline flex items-center">
                                        <?= esc($banner['link']) ?>
                                    </a>
                                <?php else : ?>
                                    <span class="text-gray-400 font-normal">-</span>
                                <?php endif; ?>
                            </td>
                            <td class="py-3 px-4 capitalize">
                                <span class="bg-blue-50 text-blue-700 text-xs px-2.5 py-0.5 rounded font-medium border border-blue-200">
                                    <?= esc($banner['posisi']) ?>
                                </span>
                            </td>
                            <td class="py-3 px-4">
                                <?php if ($banner['status'] === 'aktif') : ?>
                                    <span class="bg-green-100 text-green-800 text-xs px-2.5 py-0.5 rounded-full font-medium">Aktif</span>
                                <?php else : ?>
                                    <span class="bg-red-100 text-red-800 text-xs px-2.5 py-0.5 rounded-full font-medium">Nonaktif</span>
                                <?php endif; ?>
                            </td>
                            <td class="py-3 px-4 text-center">
                                <div class="flex justify-center space-x-2">
                                    <button onclick="openModal('edit', <?= htmlspecialchars(json_encode($banner)) ?>)" class="bg-yellow-500 hover:bg-yellow-600 text-white p-2 rounded shadow transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </button>
                                    <a href="<?= base_url('admin/banner/hapus/' . $banner['id']) ?>" onclick="return confirm('Yakin ingin menghapus banner ini?')" class="bg-red-500 hover:bg-red-600 text-white p-2 rounded shadow transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="7" class="py-6 text-center text-gray-500">Belum ada data banner.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Form (Tambah & Edit) -->
<div id="bannerModal" class="fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg w-full max-w-md p-6 shadow-xl relative">
        <h2 id="modalTitle" class="text-xl font-bold mb-4 text-gray-800">Tambah Banner</h2>

        <form id="bannerForm" action="<?= base_url('admin/banner/simpan') ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <input type="hidden" id="bannerId" name="id">

            <div class="mb-4">
                <label for="judul" class="block text-sm font-medium text-gray-700 mb-1">Judul Banner</label>
                <input type="text" id="judul" name="judul" required class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div class="mb-4">
                <label for="link" class="block text-sm font-medium text-gray-700 mb-1">Link Target (Opsional)</label>
                <input type="url" id="link" name="link" placeholder="https://..." class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div class="mb-4">
                <label for="posisi" class="block text-sm font-medium text-gray-700 mb-1">Posisi Banner</label>
                <select id="posisi" name="posisi" class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-blue-500 focus:border-blue-500">
                    <option value="utama">Utama</option>
                    <option value="samping">Samping</option>
                    <option value="bawah">Bawah</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select id="status" name="status" class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-blue-500 focus:border-blue-500">
                    <option value="aktif">Aktif</option>
                    <option value="nonaktif">Nonaktif</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="gambar" class="block text-sm font-medium text-gray-700 mb-1">File Gambar</label>
                <input type="file" id="gambar" name="gambar" accept="image/*" onchange="previewImage(event)" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
            </div>

            <div id="previewContainer" class="hidden mb-4">
                <p class="text-xs text-gray-500 mb-1">Pratinjau Gambar:</p>
                <img id="formPreviewImg" src="#" alt="Pratinjau" class="w-full h-32 object-cover rounded border">
            </div>

            <div class="flex justify-end space-x-3 mt-6">
                <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">Batal</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal(mode, data = null) {
        const modal = document.getElementById('bannerModal');
        const modalTitle = document.getElementById('modalTitle');
        const form = document.getElementById('bannerForm');
        const previewContainer = document.getElementById('previewContainer');
        const previewImg = document.getElementById('formPreviewImg');

        modal.classList.remove('hidden');

        if (mode === 'edit' && data) {
            modalTitle.innerText = 'Edit Banner';
            // Mengarahkan action form ke admin/banner/update/{id}
            form.action = '<?= base_url('admin/banner/update/') ?>' + data.id;
            document.getElementById('bannerId').value = data.id;
            document.getElementById('judul').value = data.judul;
            document.getElementById('link').value = data.link || '';
            document.getElementById('posisi').value = data.posisi;
            document.getElementById('status').value = data.status;

            if (data.gambar) {
                previewImg.src = '<?= base_url('uploads/banner/') ?>/' + data.gambar;
                previewContainer.classList.remove('hidden');
            }
        } else {
            modalTitle.innerText = 'Tambah Banner';
            // Mengarahkan action form ke admin/banner/simpan
            form.action = '<?= base_url('admin/banner/simpan') ?>';
            form.reset();
            document.getElementById('bannerId').value = '';
            previewContainer.classList.add('hidden');
        }
    }

    function closeModal() {
        document.getElementById('bannerModal').classList.add('hidden');
    }

    function previewImage(event) {
        const input = event.target;
        const previewContainer = document.getElementById('previewContainer');
        const previewImg = document.getElementById('formPreviewImg');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(evt) {
                previewImg.src = evt.target.result;
                previewContainer.classList.remove('hidden');
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            previewContainer.classList.add('hidden');
        }
    }
</script>

<?= $this->endSection() ?>