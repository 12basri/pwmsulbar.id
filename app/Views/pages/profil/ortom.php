<?= $this->extend('pages/layout/main') ?>

<?= $this->section('content') ?>

<!-- Hero Section -->
<section class="bg-gradient-to-br from-emerald-800 via-emerald-700 to-teal-900 text-white py-12 md:py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <span class="inline-block px-3 py-1 bg-emerald-600/50 backdrop-blur-md rounded-full text-xs font-semibold uppercase tracking-wider text-emerald-100 mb-3 border border-emerald-400/30">
            Profil Organisasi
        </span>
        <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight mb-3">
            Organisasi Otonom (Ortom)
        </h1>
        <p class="text-emerald-100 text-sm md:text-base max-w-2xl mx-auto leading-relaxed">
            Mengenal lebih dekat badan dan organisasi otonom yang membina, menggerakkan, serta membimbing berbagai elemen masyarakat.
        </p>

        <!-- Search Bar Frontend -->
        <div class="mt-8 max-w-md mx-auto">
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </span>
                <input type="text" id="searchInput" onkeyup="filterOrtom()" placeholder="Cari nama ortom atau pengurus..." class="w-full pl-11 pr-4 py-3 rounded-xl bg-white/95 text-slate-800 text-sm placeholder-slate-400 border-0 focus:ring-2 focus:ring-emerald-400 outline-none shadow-lg transition-all">
            </div>
        </div>
    </div>
</section>

<!-- Main Content Grid -->
<section class="py-12 bg-slate-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Grid Container -->
        <div id="ortomGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            <?php if (!empty($ortom) && is_array($ortom)) : ?>
                <?php foreach ($ortom as $row) : ?>
                    <?php $jsonData = htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8'); ?>

                    <!-- Card Item -->
                    <div class="ortom-card bg-white rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md transition-all duration-300 flex flex-col justify-between overflow-hidden"
                        data-search="<?= strtolower(esc(($row['nama_ortom'] ?? '') . ' ' . ($row['ketua'] ?? '') . ' ' . ($row['sekretaris'] ?? '') . ' ' . ($row['bendahara'] ?? ''))) ?>">

                        <div class="p-6">
                            <!-- Card Header & Logo -->
                            <div class="flex items-start gap-4 mb-5">
                                <div class="w-16 h-16 rounded-xl bg-slate-50 border border-slate-100 p-2 flex items-center justify-center shrink-0 shadow-inner">
                                    <?php if (!empty($row['logo']) && file_exists('uploads/ortom/' . $row['logo'])) : ?>
                                        <img src="<?= base_url('uploads/ortom/' . $row['logo']) ?>" alt="Logo <?= esc($row['nama_ortom']) ?>" class="w-full h-full object-contain">
                                    <?php else : ?>
                                        <i class="fa-solid fa-flag text-2xl text-emerald-600"></i>
                                    <?php endif; ?>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h2 class="text-lg font-bold text-slate-800 truncate mb-1">
                                        <?= esc($row['nama_ortom']) ?>
                                    </h2>
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-medium bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Aktif
                                    </span>
                                </div>
                            </div>

                            <!-- Structural Info -->
                            <div class="space-y-2 text-xs border-t border-slate-100 pt-4 mb-4">
                                <div class="flex items-center justify-between py-1">
                                    <span class="text-slate-400 font-medium">Ketua:</span>
                                    <span class="text-slate-700 font-semibold truncate max-w-[180px]"><?= esc($row['ketua'] ?? '-') ?></span>
                                </div>
                                <div class="flex items-center justify-between py-1">
                                    <span class="text-slate-400 font-medium">Sekretaris:</span>
                                    <span class="text-slate-600 truncate max-w-[180px]"><?= esc($row['sekretaris'] ?? '-') ?></span>
                                </div>
                                <div class="flex items-center justify-between py-1">
                                    <span class="text-slate-400 font-medium">Bendahara:</span>
                                    <span class="text-slate-600 truncate max-w-[180px]"><?= esc($row['bendahara'] ?? '-') ?></span>
                                </div>
                            </div>

                            <!-- Short Description -->
                            <p class="text-slate-500 text-xs line-clamp-2 leading-relaxed">
                                <?= esc($row['deskripsi'] ?? 'Tidak ada deskripsi singkat.') ?>
                            </p>
                        </div>

                        <!-- Card Footer Button -->
                        <div class="px-6 py-3.5 bg-slate-50/70 border-t border-slate-100 mt-auto">
                            <button type="button" onclick="openPublicModalDetail(<?= $jsonData ?>)" class="w-full py-2 px-3 bg-white hover:bg-emerald-600 text-emerald-700 hover:text-white border border-emerald-200 hover:border-emerald-600 rounded-lg text-xs font-semibold transition-all duration-200 flex items-center justify-center gap-2 shadow-xs">
                                <span>Lihat Profil Lengkap</span>
                                <i class="fa-solid fa-arrow-right text-[10px]"></i>
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <div class="col-span-full py-16 text-center bg-white rounded-2xl border border-slate-200/80">
                    <div class="w-16 h-16 bg-slate-100 text-slate-400 rounded-full flex items-center justify-center mx-auto mb-3 text-2xl">
                        <i class="fa-solid fa-folder-open"></i>
                    </div>
                    <h3 class="text-base font-bold text-slate-700">Belum Ada Data Ortom</h3>
                    <p class="text-slate-400 text-xs mt-1">Informasi profil organisasi otonom belum tersedia saat ini.</p>
                </div>
            <?php endif; ?>

        </div>

        <!-- No Search Result State -->
        <div id="noResult" class="hidden py-16 text-center bg-white rounded-2xl border border-slate-200/80">
            <p class="text-slate-500 text-sm font-medium">Organisasi yang Anda cari tidak ditemukan.</p>
        </div>

    </div>
</section>

<!-- PUBLIC DETAIL MODAL -->
<div id="publicModalDetail" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm hidden">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden transform transition-all">

        <!-- Header Modal -->
        <div class="relative bg-gradient-to-r from-emerald-700 to-teal-800 p-6 text-white">
            <button type="button" onclick="closePublicModal()" class="absolute top-4 right-4 w-8 h-8 rounded-full bg-black/20 hover:bg-black/40 text-white flex items-center justify-center text-sm transition-colors">
                <i class="fa-solid fa-xmark"></i>
            </button>

            <div class="flex items-center gap-4">
                <div id="modalLogoBox" class="w-16 h-16 rounded-xl bg-white p-2 shrink-0 flex items-center justify-center shadow-md">
                    <!-- Logo JS -->
                </div>
                <div>
                    <span class="text-[11px] font-semibold text-emerald-200 uppercase tracking-wider block">Profil Ortom</span>
                    <h3 id="modalNamaOrtom" class="text-xl font-bold"></h3>
                </div>
            </div>
        </div>

        <!-- Body Modal -->
        <div class="p-6 space-y-5 text-sm text-slate-700">
            <div>
                <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Struktur Kepengurusan</h4>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 bg-slate-50 p-3.5 rounded-xl border border-slate-100 text-xs">
                    <div>
                        <span class="text-slate-400 block mb-0.5">Ketua</span>
                        <strong id="modalKetua" class="text-slate-800 block truncate"></strong>
                    </div>
                    <div>
                        <span class="text-slate-400 block mb-0.5">Sekretaris</span>
                        <strong id="modalSekretaris" class="text-slate-800 block truncate"></strong>
                    </div>
                    <div>
                        <span class="text-slate-400 block mb-0.5">Bendahara</span>
                        <strong id="modalBendahara" class="text-slate-800 block truncate"></strong>
                    </div>
                </div>
            </div>

            <div>
                <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Deskripsi & Program</h4>
                <div id="modalDeskripsi" class="text-xs leading-relaxed text-slate-600 bg-slate-50/50 p-4 rounded-xl border border-slate-100 max-h-48 overflow-y-auto whitespace-pre-line">
                </div>
            </div>
        </div>

        <!-- Footer Modal -->
        <div class="px-6 py-3.5 bg-slate-50 border-t border-slate-100 text-right">
            <button type="button" onclick="closePublicModal()" class="px-5 py-2 bg-slate-800 hover:bg-slate-900 text-white rounded-lg text-xs font-semibold transition-colors">
                Tutup
            </button>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script>
    const uploadUrl = "<?= base_url('uploads/ortom/') ?>";

    function openPublicModalDetail(data) {
        document.getElementById('modalNamaOrtom').innerText = data.nama_ortom || '-';
        document.getElementById('modalKetua').innerText = data.ketua || '-';
        document.getElementById('modalSekretaris').innerText = data.sekretaris || '-';
        document.getElementById('modalBendahara').innerText = data.bendahara || '-';
        document.getElementById('modalDeskripsi').innerText = data.deskripsi || 'Belum ada deskripsi profil untuk organisasi ini.';

        const logoBox = document.getElementById('modalLogoBox');
        if (data.logo) {
            logoBox.innerHTML = `<img src="${uploadUrl + data.logo}" alt="Logo ${data.nama_ortom}" class="w-full h-full object-contain">`;
        } else {
            logoBox.innerHTML = `<i class="fa-solid fa-flag text-2xl text-emerald-600"></i>`;
        }

        document.getElementById('publicModalDetail').classList.remove('hidden');
    }

    function closePublicModal() {
        document.getElementById('publicModalDetail').classList.add('hidden');
    }

    // Live search client-side
    function filterOrtom() {
        const query = document.getElementById('searchInput').value.toLowerCase().trim();
        const cards = document.querySelectorAll('.ortom-card');
        let visibleCount = 0;

        cards.forEach(card => {
            const searchData = card.getAttribute('data-search');
            if (searchData.includes(query)) {
                card.classList.remove('hidden');
                visibleCount++;
            } else {
                card.classList.add('hidden');
            }
        });

        const noResult = document.getElementById('noResult');
        if (visibleCount === 0 && cards.length > 0) {
            noResult.classList.remove('hidden');
        } else {
            noResult.classList.add('hidden');
        }
    }

    // Modal Keyboard & Backdrop Click
    window.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closePublicModal();
    });

    document.getElementById('publicModalDetail')?.addEventListener('click', function(e) {
        if (e.target === this) closePublicModal();
    });
</script>

<?= $this->endSection() ?>