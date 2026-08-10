<?= $this->extend('pages/layout/main') ?>

<?= $this->section('content') ?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<?php 
// 1. Perbaikan penangkapan data dari Controller ($tentang ditambahkan)
$dataProfil = $tentangKami ?? $tentang ?? $profil ?? [];

// Helper internal untuk memeriksa keberadaan file fisik di server
$getValidImageUrl = function(?string $fileName, string $folderPath, string $defaultPlaceholder) {
    if (empty($fileName)) {
        return $defaultPlaceholder;
    }
    
    // Hilangkan slash di awal/akhir jika ada
    $cleanFolder = trim($folderPath, '/');
    $physicalPath = FCPATH . $cleanFolder . '/' . $fileName;
    
    if (file_exists($physicalPath)) {
        return base_url($cleanFolder . '/' . $fileName);
    }
    
    // Jika nama file berisi path lengkap (misal: uploads/profil/foto.jpg)
    if (file_exists(FCPATH . $fileName)) {
        return base_url($fileName);
    }

    return $defaultPlaceholder;
};
?>

<div class="max-w-7xl mx-auto space-y-10 mb-12">

    <!-- HERO SLIDER BANNER -->
    <div class="relative overflow-hidden rounded-3xl shadow-xl bg-slate-900 border border-slate-200/80">
        <div class="swiper heroSwiper w-full h-[320px] sm:h-[420px] lg:h-[480px]">
            <div class="swiper-wrapper">

                <?php if (!empty($banners) && is_array($banners)): ?>
                    <?php foreach ($banners as $banner): ?>
                        <?php 
                            // Cek nama kolom gambar di DB (gambar / foto / file)
                            $namaGambar = $banner['gambar'] ?? $banner['foto'] ?? $banner['file'] ?? '';
                            $imgSrc = $getValidImageUrl($namaGambar, 'uploads/banner', 'https://placehold.co/1200x500?text=PWM+Sulawesi+Barat');
                            $judulBanner = esc($banner['judul'] ?? $banner['nama_banner'] ?? 'Pimpinan Wilayah Muhammadiyah Sulawesi Barat');
                        ?>
                        <div class="swiper-slide relative overflow-hidden group">
                            <img src="<?= $imgSrc ?>"
                                alt="<?= $judulBanner ?>"
                                onclick="openPreview('<?= $imgSrc ?>', '<?= $judulBanner ?>')"
                                class="w-full h-full object-cover cursor-pointer group-hover:scale-105 transition duration-700 opacity-90"
                                onerror="this.onerror=null; this.src='https://placehold.co/1200x500?text=PWM+Sulawesi+Barat';">

                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/40 to-transparent flex items-end p-6 md:p-12">
                                <div class="space-y-3 max-w-3xl">
                                    <span class="px-3.5 py-1 bg-emerald-600/90 backdrop-blur-md text-white text-xs font-semibold uppercase tracking-wider rounded-lg inline-block border border-emerald-400/30 shadow-sm">
                                        <?= esc($banner['kategori'] ?? 'Tentang Kami') ?>
                                    </span>
                                    <h1 class="text-2xl sm:text-4xl lg:text-5xl font-extrabold text-white leading-tight drop-shadow-md">
                                        <?= $judulBanner ?>
                                    </h1>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <?php
                        // Fallback ke foto profil jika banner tidak ada
                        $fotoProfil = $dataProfil['foto'] ?? $dataProfil['gambar'] ?? $dataProfil['file'] ?? '';
                        $heroImg = $getValidImageUrl($fotoProfil, 'uploads/profil', 'https://placehold.co/1200x500?text=PWM+Sulawesi+Barat');
                    ?>
                    <div class="swiper-slide relative overflow-hidden group">
                        <img src="<?= $heroImg ?>"
                            alt="Gambaran Umum"
                            onclick="openPreview('<?= $heroImg ?>', 'PWM Sulawesi Barat')"
                            class="w-full h-full object-cover cursor-pointer group-hover:scale-105 transition duration-700 opacity-90"
                            onerror="this.onerror=null; this.src='https://placehold.co/1200x500?text=PWM+Sulawesi+Barat';">

                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/50 to-transparent flex items-end p-6 md:p-12">
                            <div class="space-y-3 max-w-3xl">
                                <span class="px-3.5 py-1 bg-emerald-600/90 backdrop-blur-md text-white text-xs font-semibold uppercase tracking-wider rounded-lg inline-block border border-emerald-400/30 shadow-sm">
                                    Profil Persyarikatan
                                </span>
                                <h1 class="text-2xl sm:text-4xl lg:text-5xl font-extrabold text-white leading-tight drop-shadow-md">
                                    Pimpinan Wilayah Muhammadiyah Sulawesi Barat
                                </h1>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

            </div>

            <div class="swiper-pagination !bottom-5"></div>
            <div class="swiper-button-next !text-white/80 hover:!text-white after:!text-xl hidden sm:flex"></div>
            <div class="swiper-button-prev !text-white/80 hover:!text-white after:!text-xl hidden sm:flex"></div>
        </div>
    </div>

    <!-- KONTEN UTAMA -->
    <div class="bg-white p-6 sm:p-10 lg:p-12 rounded-3xl border border-slate-200/80 shadow-sm space-y-8">

        <div class="flex items-center gap-4 border-b border-slate-100 pb-6">
            <div class="p-3.5 bg-emerald-50 text-emerald-600 rounded-2xl shadow-sm">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h4m-4 0V11m0 0h4m-4 0H7" />
                </svg>
            </div>
            <div>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-800">Gambaran Umum</h2>
                <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Profil resmi persyarikatan dan peran dakwah di Sulawesi Barat</p>
            </div>
        </div>

        <div class="prose prose-slate max-w-none text-slate-600 text-base sm:text-lg leading-relaxed space-y-5">
            <?php 
                $deskripsi = $dataProfil['deskripsi'] ?? $dataProfil['isi'] ?? $dataProfil['profil'] ?? '';
            ?>
            <?php if (!empty($deskripsi)): ?>
                <?= nl2br(esc($deskripsi)) ?>
            <?php else: ?>
                <p class="italic text-slate-400">Informasi gambaran umum belum tersedia.</p>
            <?php endif; ?>
        </div>

    </div>

</div>

<!-- LIGHTBOX MODAL -->
<div id="imagePreviewModal" class="fixed inset-0 z-50 hidden bg-black/90 backdrop-blur-md flex items-center justify-center p-4 transition-opacity duration-300">
    <button onclick="closePreview()" class="absolute top-5 right-5 p-2.5 bg-white/10 hover:bg-white/20 text-white rounded-full transition z-10" title="Tutup (ESC)">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>
    <div class="max-w-4xl max-h-[90vh] flex flex-col items-center">
        <img id="previewImage" src="" alt="Preview Gambar" class="max-w-full max-h-[80vh] rounded-2xl object-contain shadow-2xl">
        <p id="previewTitle" class="mt-4 text-white font-semibold text-sm sm:text-base text-center"></p>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        new Swiper(".heroSwiper", {
            loop: true,
            autoplay: { delay: 4500, disableOnInteraction: false },
            pagination: { el: ".swiper-pagination", clickable: true },
            navigation: { nextEl: ".swiper-button-next", prevEl: ".swiper-button-prev" },
            effect: "fade",
            fadeEffect: { crossFade: true }
        });
    });

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