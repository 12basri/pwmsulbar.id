<?= $this->extend('pages/layout/main') ?>

<?= $this->section('content') ?>

<div class="max-w-7xl mx-auto px-4 py-8 mb-16 space-y-10">

    <!-- ================= 1. HEADER HALAMAN ================= -->
    <div class="text-center max-w-3xl mx-auto space-y-3">
        <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
            Struktur Organisasi
        </h1>

        <!-- Aksen Garis & Titik -->
        <div class="flex items-center justify-center gap-2">
            <span class="w-8 h-[2px] bg-emerald-500 rounded-full"></span>
            <span class="w-2.5 h-2.5 border-2 border-emerald-500 rounded-full"></span>
            <span class="w-8 h-[2px] bg-emerald-500 rounded-full"></span>
        </div>

        <p class="text-slate-600 text-sm sm:text-base leading-relaxed">
            Susunan Personel Pengurus Wilayah Muhammadiyah Sulawesi Barat
        </p>
    </div>

    <!-- ================= 2. LOGIKA PEMBAGIAN LEVEL STRUKTUR ================= -->
    <?php if (!empty($struktur) && is_array($struktur)): ?>
        <?php
        $level1 = []; // Nomor Urut 1
        $level2 = []; // Nomor Urut 2 & 3
        $level3 = []; // Nomor Urut 4, 5, 6, 7, 8, 9, dst. (Sejajar Horizontal)

        foreach ($struktur as $item) {
            $noUrut = (int)($item['urutan'] ?? $item['sort_order'] ?? 99);

            if ($noUrut === 1) {
                $level1[] = $item;
            } elseif ($noUrut === 2 || $noUrut === 3) {
                $level2[] = $item;
            } else {
                $level3[] = $item;
            }
        }
        ?>

        <!-- Helper Reusable Card (Warna Biru Kombinasi Hijau) -->
        <?php
        function renderCardBagan($item)
        {
            if (!$item) return;
            $fotoPath = !empty($item['foto'])
                ? base_url('uploads/struktur/' . $item['foto'])
                : 'https://placehold.co/150x200/2563eb/ffffff?text=Foto';
        ?>
            <!-- Menggunakan Background Gradient/Kombinasi Biru & Hijau (bg-gradient-to-r from-emerald-50 to-blue-50) -->
            <div class="relative flex items-center bg-gradient-to-r from-emerald-50 via-teal-50 to-blue-50 rounded-r-2xl rounded-l-xl border-l-4 border-l-emerald-500 border border-teal-200/80 shadow-sm hover:shadow-md transition duration-300 w-full max-w-sm sm:w-88 h-full overflow-hidden group">
                <!-- Foto Sisi Kiri -->
                <div class="w-24 sm:w-28 shrink-0 bg-slate-200 overflow-hidden self-stretch flex items-center justify-center">
                    <img src="<?= $fotoPath ?>"
                        alt="<?= esc($item['nama'] ?? '') ?>"
                        onclick="openPreview('<?= $fotoPath ?>', '<?= esc($item['nama'] ?? '') ?> - <?= esc($item['jabatan'] ?? '') ?>')"
                        class="w-full h-full object-cover object-top cursor-pointer group-hover:scale-105 transition duration-500"
                        onerror="this.onerror=null; this.src='https://placehold.co/150x200/2563eb/ffffff?text=Foto';">
                </div>
                <!-- Detail Nama & Jabatan Sisi Kanan -->
                <div class="p-3 sm:p-4 flex-1 flex flex-col justify-center space-y-1">
                    <h3 class="font-bold text-slate-800 text-sm sm:text-base leading-snug group-hover:text-emerald-700 transition">
                        <?= esc($item['nama'] ?? '-') ?>
                    </h3>
                    <p class="text-xs font-semibold text-teal-800 leading-tight">
                        <?= esc($item['jabatan'] ?? '-') ?>
                    </p>
                </div>
            </div>
        <?php
        }
        ?>

        <!-- CONTAINER BAGAN DAN GARIS KONEKTOR -->
        <div class="flex flex-col items-center">

            <!-- LEVEL 1: URUTAN 1 (PALING ATAS) -->
            <?php if (!empty($level1)): ?>
                <div class="flex flex-col items-center">
                    <?php foreach ($level1 as $item): ?>
                        <?php renderCardBagan($item); ?>
                    <?php endforeach; ?>
                    <div class="w-[2px] h-8 bg-slate-700"></div>
                </div>
            <?php endif; ?>

            <!-- LEVEL 2: URUTAN 2 & 3 (SUSUN VERTIKAL KE BAWAH) -->
            <?php if (!empty($level2)): ?>
                <div class="flex flex-col items-center space-y-0">
                    <?php foreach ($level2 as $item): ?>
                        <?php renderCardBagan($item); ?>
                        <div class="w-[2px] h-8 bg-slate-700"></div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <!-- LEVEL 3: URUTAN 4, 5, 6, 7, 8, 9 DST (SEJAJAR HORIZONTAL & RATA TINGGI) -->
            <?php if (!empty($level3)): ?>
                <div class="w-full flex flex-col items-center">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 pt-4 w-full max-w-7xl justify-items-center border-t-2 border-slate-700">
                        <?php foreach ($level3 as $item): ?>
                            <div class="relative flex flex-col items-center w-full h-full">
                                <!-- Garis Vertikal Cabang Ke Card -->
                                <div class="w-[2px] h-4 bg-slate-700 hidden lg:block -mt-4 mb-2 shrink-0"></div>
                                <?php renderCardBagan($item); ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

        </div>

    <?php else: ?>
        <div class="p-12 bg-white rounded-3xl border border-slate-200/80 text-center space-y-3">
            <div class="p-4 bg-slate-100 text-slate-400 rounded-full w-16 h-16 mx-auto flex items-center justify-center">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <h3 class="text-base font-bold text-slate-700">Data Struktur Belum Tersedia</h3>
            <p class="text-xs text-slate-500">Belum ada data pengurus yang dimasukkan ke dalam database.</p>
        </div>
    <?php endif; ?>

</div>

<!-- ================= 3. MODAL PREVIEW GAMBAR (LIGHTBOX) ================= -->
<div id="imagePreviewModal" class="fixed inset-0 z-50 hidden bg-black/90 backdrop-blur-md flex items-center justify-center p-4">
    <button onclick="closePreview()" class="absolute top-5 right-5 p-2.5 bg-white/10 hover:bg-white/20 text-white rounded-full transition z-10">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>
    <div class="max-w-2xl max-h-[90vh] flex flex-col items-center">
        <img id="previewImage" src="" alt="Preview Foto" class="max-w-full max-h-[75vh] rounded-2xl object-contain shadow-2xl">
        <p id="previewTitle" class="mt-4 text-white font-semibold text-center text-sm sm:text-base"></p>
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