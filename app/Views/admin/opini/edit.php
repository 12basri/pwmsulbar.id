<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="p-6">
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 pb-4 border-b border-slate-200">
            <div>
                <h1 class="text-xl font-bold text-slate-800">Edit Opini</h1>
                <p class="text-xs text-slate-500 mt-0.5">Perbarui data dan konten artikel opini.</p>
            </div>
            <a href="<?= base_url('admin/opini'); ?>" class="inline-flex items-center space-x-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium px-4 py-2 rounded-lg transition shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span>Kembali</span>
            </a>
        </div>

        <!-- Form -->
        <form action="<?= base_url('admin/opini/update/' . $opini['id_opini']); ?>" method="post" enctype="multipart/form-data" class="space-y-5">
            <?= csrf_field(); ?>

            <!-- Judul Opini -->
            <div>
                <label for="judul" class="block text-sm font-medium text-slate-700 mb-1.5">Judul Opini <span class="text-rose-500">*</span></label>
                <input type="text" 
                       class="w-full rounded-lg border <?= ($validation->hasError('judul')) ? 'border-rose-500 focus:border-rose-500 focus:ring-rose-500/20' : 'border-slate-300 focus:border-blue-500 focus:ring-blue-500/20'; ?> px-3.5 py-2.5 text-sm text-slate-800 placeholder-slate-400 focus:ring-2 outline-none transition" 
                       id="judul" 
                       name="judul" 
                       value="<?= old('judul', $opini['judul']); ?>" 
                       required>
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
                           value="<?= old('penulis', $opini['penulis']); ?>">
                </div>
                <div>
                    <label for="profesi_penulis" class="block text-sm font-medium text-slate-700 mb-1.5">Profesi / Jabatan Penulis</label>
                    <input type="text" 
                           class="w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm text-slate-800 placeholder-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none transition" 
                           id="profesi_penulis" 
                           name="profesi_penulis" 
                           value="<?= old('profesi_penulis', $opini['profesi_penulis']); ?>">
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
                           value="<?= old('tanggal', $opini['tanggal']); ?>">
                </div>
                <div>
                    <label for="status" class="block text-sm font-medium text-slate-700 mb-1.5">Status Publikasi</label>
                    <select id="status" 
                            name="status" 
                            class="w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm text-slate-800 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none transition bg-white">
                        <option value="Draft" <?= old('status', $opini['status']) == 'Draft' ? 'selected' : ''; ?>>Draft</option>
                        <option value="Publish" <?= old('status', $opini['status']) == 'Publish' ? 'selected' : ''; ?>>Publish</option>
                    </select>
                </div>
            </div>

            <!-- Gambar / Header Preview & Input -->
            <div>
                <label for="gambar" class="block text-sm font-medium text-slate-700 mb-1.5">Ganti Foto Penulis / Header (Opsional)</label>
                
                <?php if ($opini['gambar']) : ?>
                    <div class="mb-3 flex items-center space-x-3 p-2 border border-slate-200 rounded-lg bg-slate-50 w-max">
                        <img src="<?= base_url('uploads/opini/' . $opini['gambar']); ?>" alt="Gambar Lama" class="w-16 h-16 object-cover rounded-md border border-slate-200">
                        <div class="text-xs text-slate-500">
                            <p class="font-medium text-slate-700">Gambar Saat Ini</p>
                            <p><?= esc($opini['gambar']); ?></p>
                        </div>
                    </div>
                <?php endif; ?>

                <input type="file" 
                       id="gambar" 
                       name="gambar"
                       class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 border border-slate-300 rounded-lg cursor-pointer focus:outline-none">
                <p class="text-xs text-slate-400 mt-1">Biarkan kosong jika tidak ingin mengganti gambar.</p>
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
                          rows="10"><?= old('isi', $opini['isi']); ?></textarea>
                <?php if ($validation->hasError('isi')) : ?>
                    <p class="text-xs text-rose-500 mt-1"><?= $validation->getError('isi'); ?></p>
                <?php endif; ?>
            </div>

            <!-- Submit Button -->
            <div class="pt-3 border-t border-slate-100 flex justify-end">
                <button type="submit" class="inline-flex items-center space-x-2 bg-emerald-600 hover:bg-emerald-700 text-white font-medium text-sm px-5 py-2.5 rounded-lg transition shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>Perbarui Opini</span>
                </button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection(); ?>