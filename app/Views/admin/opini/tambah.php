<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="p-6">
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 pb-4 border-b border-slate-200">
            <div>
                <h1 class="text-xl font-bold text-slate-800">Tambah Opini Baru</h1>
                <p class="text-xs text-slate-500 mt-0.5">Isi formulir di bawah ini untuk menambahkan artikel opini baru.</p>
            </div>
            <a href="<?= base_url('admin/opini'); ?>" class="inline-flex items-center space-x-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium px-4 py-2 rounded-lg transition shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span>Kembali</span>
            </a>
        </div>

        <!-- Form -->
        <form action="<?= base_url('admin/opini/simpan'); ?>" method="post" enctype="multipart/form-data" class="space-y-5">
            <?= csrf_field(); ?>

            <!-- Judul Opini -->
            <div>
                <label for="judul" class="block text-sm font-medium text-slate-700 mb-1.5">Judul Opini <span class="text-rose-500">*</span></label>
                <input type="text" 
                       class="w-full rounded-lg border <?= ($validation->hasError('judul')) ? 'border-rose-500 focus:border-rose-500 focus:ring-rose-500/20' : 'border-slate-300 focus:border-blue-500 focus:ring-blue-500/20'; ?> px-3.5 py-2.5 text-sm text-slate-800 placeholder-slate-400 focus:ring-2 outline-none transition" 
                       id="judul" 
                       name="judul" 
                       value="<?= old('judul'); ?>" 
                       placeholder="Masukkan judul opini..."
                       required 
                       autofocus>
                <?php if ($validation->hasError('judul')) : ?>
                    <p class="text-xs text-rose-500 mt-1"><?= $validation->getError('judul'); ?></p>
                <?php endif; ?>
            </div>

            <!-- Penulis & Profesi -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label for="penulis" class="block text-sm font-medium text-slate-700 mb-1.5">Nama Penulis</label>
                    <input type="text" 
                           class="w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm text-slate-800 placeholder-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none transition" 
                           id="penulis" 
                           name="penulis" 
                           value="<?= old('penulis'); ?>" 
                           placeholder="Contoh: Dr. Ahmad">
                </div>
                <div>
                    <label for="profesi_penulis" class="block text-sm font-medium text-slate-700 mb-1.5">Profesi / Jabatan Penulis</label>
                    <input type="text" 
                           class="w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm text-slate-800 placeholder-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none transition" 
                           id="profesi_penulis" 
                           name="profesi_penulis" 
                           value="<?= old('profesi_penulis'); ?>" 
                           placeholder="Contoh: Dosen ITBM Polman / Kader IPM">
                </div>
            </div>

            <!-- Tanggal & Status -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label for="tanggal" class="block text-sm font-medium text-slate-700 mb-1.5">Tanggal Publikasi</label>
                    <input type="date" 
                           class="w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm text-slate-800 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none transition" 
                           id="tanggal" 
                           name="tanggal" 
                           value="<?= old('tanggal') ?: date('Y-m-d'); ?>">
                </div>
                <div>
                    <label for="status" class="block text-sm font-medium text-slate-700 mb-1.5">Status Publikasi</label>
                    <select id="status" 
                            name="status" 
                            class="w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm text-slate-800 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none transition bg-white">
                        <option value="Draft" <?= old('status') == 'Draft' ? 'selected' : ''; ?>>Draft</option>
                        <option value="Publish" <?= old('status') == 'Publish' ? 'selected' : ''; ?>>Publish</option>
                    </select>
                </div>
            </div>

            <!-- Foto Penulis / Header -->
            <div>
                <label for="gambar" class="block text-sm font-medium text-slate-700 mb-1.5">Foto Penulis / Header (Opsional)</label>
                <input type="file" 
                       id="gambar" 
                       name="gambar"
                       class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 border border-slate-300 rounded-lg cursor-pointer focus:outline-none">
                <p class="text-xs text-slate-400 mt-1">Format: JPG, JPEG, PNG, WEBP. Maksimal 2MB.</p>
                <?php if ($validation->hasError('gambar')) : ?>
                    <p class="text-xs text-rose-500 mt-1"><?= $validation->getError('gambar'); ?></p>
                <?php endif; ?>
            </div>

            <!-- Isi Opini -->
            <div>
                <label for="isi" class="block text-sm font-medium text-slate-700 mb-1.5">Isi Opini <span class="text-rose-500">*</span></label>
                <textarea class="editor w-full rounded-lg border <?= ($validation->hasError('isi')) ? 'border-rose-500 focus:border-rose-500 focus:ring-rose-500/20' : 'border-slate-300 focus:border-blue-500 focus:ring-blue-500/20'; ?> px-3.5 py-2.5 text-sm text-slate-800 focus:ring-2 outline-none transition" 
                          id="isi" 
                          name="isi" 
                          rows="10"><?= old('isi'); ?></textarea>
                <?php if ($validation->hasError('isi')) : ?>
                    <p class="text-xs text-rose-500 mt-1"><?= $validation->getError('isi'); ?></p>
                <?php endif; ?>
            </div>

            <!-- Submit Button -->
            <div class="pt-3 border-t border-slate-100 flex justify-end">
                <button type="submit" class="inline-flex items-center space-x-2 bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm px-5 py-2.5 rounded-lg transition shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002 2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                    </svg>
                    <span>Simpan Opini</span>
                </button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection(); ?>