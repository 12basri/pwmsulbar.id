<?= $this->extend('pages/layout/main') ?>

<?= $this->section('content') ?>

<div class="max-w-6xl mx-auto px-4 py-8 mb-16">

    <!-- ================= 1. HEADER SEJARAH ================= -->
    <div class="text-center max-w-3xl mx-auto space-y-4 mb-16">
        <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
            Sejarah PWM Sulawesi Barat
        </h1>

        <!-- Divider Aksen -->
        <div class="flex items-center justify-center gap-2">
            <span class="w-8 h-[2px] bg-emerald-500 rounded-full"></span>
            <span class="w-2.5 h-2.5 border-2 border-emerald-500 rounded-full"></span>
            <span class="w-8 h-[2px] bg-emerald-500 rounded-full"></span>
        </div>

        <p class="text-slate-600 text-sm sm:text-base leading-relaxed">
            Jejak langkah perjalanan dan perkembangan Pengurus Wilayah Muhammadiyah (PWM) Sulawesi Barat dari masa ke masa dalam melebarkan dakwah dan pelayanan kepada masyarakat.
        </p>
    </div>

    <!-- ================= 2. TIMELINE SEJARAH ================= -->
    <div class="relative border-l-2 border-slate-200 ml-4 sm:ml-32 md:ml-48 space-y-12 sm:space-y-16">

        <?php if (!empty($sejarah) && is_array($sejarah)): ?>
            <?php foreach ($sejarah as $item): ?>

                <div class="relative pl-6 sm:pl-10 group">

                    <!-- Node Tahun (Bulatan Putih di Garis Timeline) -->
                    <div class="absolute -left-[29px] top-0 flex items-center justify-center">
                        <div class="w-14 h-14 bg-white border-2 border-slate-200 rounded-full shadow-md flex items-center justify-center group-hover:border-emerald-500 transition duration-300">
                            <span class="text-xs font-extrabold text-slate-700 group-hover:text-emerald-600">
                                <?= esc($item['tahun'] ?? '-') ?>
                            </span>
                        </div>
                    </div>

                    <!-- Indicator Dot Atas Line -->
                    <div class="absolute -left-[7px] -top-8 w-3 h-3 bg-emerald-500 rounded-full border-2 border-white"></div>

                    <!-- Content Layout (Gambar & Deskripsi) -->
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-start bg-white p-6 sm:p-8 rounded-3xl border border-slate-200/80 shadow-sm hover:shadow-md transition">

                        <!-- Gambar Sejarah (Kolom Kiri) -->
                        <div class="md:col-span-5">
                            <?php
                            $imgPath = !empty($item['gambar'])
                                ? base_url('uploads/sejarah/' . $item['gambar'])
                                : 'https://placehold.co/600x400?text=Foto+Sejarah';
                            ?>
                            <div class="overflow-hidden rounded-2xl bg-slate-100 border border-slate-100 h-48 sm:h-56">
                                <img src="<?= $imgPath ?>"
                                    alt="<?= esc($item['judul']) ?>"
                                    onclick="openPreview('<?= $imgPath ?>', '<?= esc($item['judul']) ?>')"
                                    class="w-full h-full object-cover cursor-pointer hover:scale-105 transition duration-500"
                                    onerror="this.onerror=null; this.src='https://placehold.co/600x400?text=Foto+Sejarah';">
                            </div>
                        </div>

                        <!-- Teks & Detail Sejarah (Kolom Kanan) -->
                        <div class="md:col-span-7 space-y-3">
                            <h2 class="text-xl sm:text-2xl font-bold text-slate-900 leading-snug">
                                <?= esc($item['tahun']) ?> - <?= esc($item['judul']) ?>
                            </h2>
                            <div class="prose prose-slate text-sm sm:text-base text-slate-600 leading-relaxed">
                                <?= nl2br(esc($item['isi'])) ?>
                            </div>
                        </div>

                    </div>

                </div>

            <?php endforeach; ?>
        <?php else: ?>
            <div class="p-8 bg-slate-50 rounded-2xl text-center text-slate-500 text-sm">
                Belum ada data sejarah yang ditambahkan.
            </div>
        <?php endif; ?>

    </div>

</div>

<!-- ================= 3. LIGHTBOX MODAL PREVIEW ================= -->
<div id="imagePreviewModal" class="fixed inset-0 z-50 hidden bg-black/90 backdrop-blur-md flex items-center justify-center p-4">
    <button onclick="closePreview()" class="absolute top-5 right-5 p-2 bg-white/10 hover:bg-white/20 text-white rounded-full transition">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>
    <div class="max-w-4xl max-h-[90vh] flex flex-col items-center">
        <img id="previewImage" src="" alt="Preview" class="max-w-full max-h-[80vh] rounded-2xl object-contain shadow-2xl">
        <p id="previewTitle" class="mt-4 text-white font-semibold text-center"></p>
    </div>
</div>

<script>
    function openPreview(src, title) {
        document.getElementById('previewImage').src = src;
        document.getElementById('previewTitle').innerText = title;
        document.getElementById('imagePreviewModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closePreview() {
        document.getElementById('imagePreviewModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closePreview();
    });
</script>

<?= $this->endSection() ?>