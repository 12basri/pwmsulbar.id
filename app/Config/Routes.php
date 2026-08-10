<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ==========================================
// 1. ROUTE PUBLIK (Visitor & Halaman Depan)
// ==========================================
$routes->get('/', 'Home::index');

// Berita & Refleksi Publik
$routes->get('berita', 'Home::berita');
$routes->get('berita/detail/(:segment)', 'Home::detailBerita/$1');
$routes->get('berita/(:segment)', 'Home::detailBerita/$1');
$routes->get('refleksi', 'Home::refleksi');

// Opini Publik
$routes->get('opini', 'Home::opini');
$routes->get('opini/detail/(:segment)', 'Home::detailOpini/$1');
$routes->get('opini/(:segment)', 'Home::detailOpini/$1');

// Majelis & Lembaga
$routes->get('majelis', 'Home::majelis');
$routes->get('majelis/detail/(:segment)', 'Home::detailMajelis/$1');
$routes->get('majelis/(:segment)', 'Home::detailMajelis/$1');

// Dokumen & Arsip Publik (TAMBAHAN UNTUK MEMPERBAIKI ERROR 404)
$routes->get('dokumen-arsip', 'Home::dokumenArsip');
$routes->get('dokumen-arsip/download/(:num)', 'Home::downloadDokumen/$1');

// Direct Link Publik (AUM, Ortom, Sekolah, Kampus)
$routes->group('aum', function ($routes) {
    $routes->get('/', 'Home::aum');
    $routes->get('sekolah', 'Home::sekolah');
    $routes->get('kampus', 'Home::kampus');
    $routes->get('kampus/detail/(:segment)', 'Home::detailKampus/$1');
    $routes->get('usaha-lain', 'Home::usahaLain');
    $routes->get('usaha-lain/detail/(:segment)', 'Home::detailUsaha/$1');
    $routes->get('detail/(:segment)', 'Home::detailUsaha/$1');
});

$routes->get('ortom', 'Home::ortom');
$routes->get('sekolah', 'Home::sekolah');
$routes->get('kampus', 'Home::kampus');
$routes->get('kampus/detail/(:segment)', 'Home::detailKampus/$1');
$routes->get('kampus/(:segment)', 'Home::detailKampus/$1');

// Profil Publik
$routes->group('profil', function ($routes) {
    $routes->get('tentang-kami', 'Home::tentangKami');
    $routes->get('visi-misi', 'Home::visiMisi');
    $routes->get('sejarah', 'Home::sejarah');
    $routes->get('struktur-organisasi', 'Home::strukturOrganisasi');
    $routes->get('program-kerja', 'Home::programKerja');
    $routes->get('majelis', 'Home::majelis');
    $routes->get('aum', 'Home::aum');
    $routes->get('aum/sekolah', 'Home::sekolah');
    $routes->get('aum/kampus', 'Home::kampus');
    $routes->get('aum/usaha-lain', 'Home::usahaLain');
    $routes->get('aum/usaha-lain/detail/(:segment)', 'Home::detailUsaha/$1');
    $routes->get('aum/detail/(:segment)', 'Home::detailUsaha/$1');
    $routes->get('ortom', 'Home::ortom');
    $routes->get('sekolah', 'Home::sekolah');
    $routes->get('kampus', 'Home::kampus');
});

// Route Direktori & Profil PDM
$routes->get('pdm', 'Home::pdm');
$routes->get('pdm/profil', 'Home::pdm'); // Alias jika diakses tanpa ID
$routes->get('pdm/profil/(:any)', 'Home::detailPdm/$1'); // Mendukung ID atau Slug (contoh: pdm/profil/1)
$routes->get('pdm/detail/(:any)', 'Home::detailPdm/$1'); // Opsional (backup URL)

// Route Otentikasi & Dashboard Admin Utama
$routes->get('login', 'Auth::index');
$routes->post('login/process', 'Auth::process');
$routes->get('logout', 'Auth::logout');
$routes->get('dashboard', 'Dashboard::index');

// ==========================================
// 2. ROUTE ADMIN (Panel Kontrol Admin)
// ==========================================
$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function ($routes) {

    // --- SLIDER HERO UTAMA ---
    $routes->group('slider', function ($routes) {
        $routes->get('/', 'Slider::index');
        $routes->get('tambah', 'Slider::tambah');
        $routes->post('simpan', 'Slider::simpan');
        $routes->get('edit/(:num)', 'Slider::edit/$1');
        $routes->post('update/(:num)', 'Slider::update/$1');
        $routes->add('hapus/(:num)', 'Slider::hapus/$1'); // Mendukung GET, POST, DELETE
    });

    // --- BANNER IKLAN / SPONSOR ---
    $routes->group('banner', function ($routes) {
        $routes->get('/', 'Banner::index');
        $routes->get('tambah', 'Banner::tambah');
        $routes->post('simpan', 'Banner::simpan');
        $routes->get('edit/(:num)', 'Banner::edit/$1');
        $routes->post('update/(:num)', 'Banner::update/$1');
        $routes->add('hapus/(:num)', 'Banner::hapus/$1');
    });

    // --- BERITA ---
    $routes->group('berita', function ($routes) {
        $routes->get('/', 'Berita::index');
        $routes->get('tambah', 'Berita::tambah');
        $routes->post('simpan', 'Berita::simpan');
        $routes->get('edit/(:num)', 'Berita::edit/$1');
        $routes->post('update/(:num)', 'Berita::update/$1');
        $routes->add('hapus/(:num)', 'Berita::hapus/$1');
    });

    // --- REFLEKSI & KAJIAN ---
    $routes->group('refleksi', function ($routes) {
        $routes->get('/', 'Refleksi::index');
        $routes->get('tambah', 'Refleksi::tambah');
        $routes->post('simpan', 'Refleksi::simpan');
        $routes->get('edit/(:num)', 'Refleksi::edit/$1');
        $routes->post('update/(:num)', 'Refleksi::update/$1');
        $routes->add('hapus/(:num)', 'Refleksi::hapus/$1');
    });

    // --- OPINI ---
    $routes->group('opini', function ($routes) {
        $routes->get('/', 'Opini::index');
        $routes->get('tambah', 'Opini::tambah');
        $routes->post('simpan', 'Opini::simpan');
        $routes->get('edit/(:num)', 'Opini::edit/$1');
        $routes->post('update/(:num)', 'Opini::update/$1');
        $routes->add('hapus/(:num)', 'Opini::hapus/$1');
    });

    // --- AMAL USAHA MUHAMMADIYAH (AUM) ---
    $routes->group('aum', function ($routes) {
        $routes->get('/', 'Aum::index');
        $routes->get('tambah', 'Aum::create');
        $routes->get('create', 'Aum::create');
        $routes->post('simpan', 'Aum::save');
        $routes->post('save', 'Aum::save');
        $routes->get('edit/(:num)', 'Aum::edit/$1');
        $routes->post('update/(:num)', 'Aum::update/$1');
        $routes->add('hapus/(:num)', 'Aum::delete/$1');
        $routes->add('delete/(:num)', 'Aum::delete/$1');
    });

    // --- MAJELIS & LEMBAGA ---
    $routes->group('majelis', function ($routes) {
        $routes->get('/', 'Majelis::index');
        $routes->get('tambah', 'Majelis::tambah');
        $routes->post('simpan', 'Majelis::simpan');
        $routes->get('edit/(:num)', 'Majelis::edit/$1');
        $routes->post('update/(:num)', 'Majelis::update/$1');
        $routes->add('hapus/(:num)', 'Majelis::hapus/$1');

        $routes->get('detail/(:num)', 'Majelis::detail/$1');
        $routes->get('(:num)/anggota', 'Majelis::anggota/$1');

        $routes->post('pimpinan/simpan/(:num)', 'Majelis::simpanPimpinan/$1');
        $routes->get('pimpinan/hapus/(:num)', 'Majelis::hapusPimpinan/$1');

        $routes->post('pakar/simpan/(:num)', 'Majelis::simpanPakar/$1');
        $routes->get('pakar/hapus/(:num)', 'Majelis::hapusPakar/$1');

        $routes->post('bidang/simpan/(:num)', 'Majelis::simpanBidang/$1');
        $routes->get('bidang/hapus/(:num)', 'Majelis::hapusBidang/$1');

        $routes->post('anggota/simpan/(:num)', 'Majelis::simpanAnggota/$1');
        $routes->get('anggota/hapus/(:num)', 'Majelis::hapusAnggota/$1');
    });

    // --- SEKOLAH & PESANTREN ---
    $routes->group('sekolah', function ($routes) {
        $routes->get('/', 'Sekolah::index');
        $routes->get('tambah', 'Sekolah::tambah');
        $routes->post('simpan', 'Sekolah::simpan');
        $routes->get('edit/(:num)', 'Sekolah::edit/$1');
        $routes->post('update/(:num)', 'Sekolah::update/$1');
        $routes->add('hapus/(:num)', 'Sekolah::hapus/$1');
    });

    // --- PERGURUAN TINGGI / KAMPUS ---
    $routes->group('kampus', function ($routes) {
        $routes->get('/', 'Kampus::index');
        $routes->post('simpan', 'Kampus::simpan');
        $routes->post('update/(:num)', 'Kampus::update/$1');
        $routes->add('hapus/(:num)', 'Kampus::hapus/$1');
    });

    // --- ORGANISASI OTONOM (ORTOM) ---
    $routes->group('ortom', function ($routes) {
        $routes->get('/', 'Ortom::index');
        $routes->post('simpan', 'Ortom::simpan');
        $routes->post('update/(:num)', 'Ortom::update/$1');
        $routes->add('hapus/(:num)', 'Ortom::hapus/$1');
    });

    // --- DOKUMEN & ARSIP ---
    $routes->group('dokumen-arsip', function ($routes) {
        $routes->get('/', 'DokumenArsip::index');
        $routes->post('simpan', 'DokumenArsip::simpan');
        $routes->post('update/(:num)', 'DokumenArsip::update/$1');
        $routes->add('hapus/(:num)', 'DokumenArsip::hapus/$1');
        $routes->get('download/(:num)', 'DokumenArsip::download/$1');
    });

    // --- PIMPINAN DAERAH MUHAMMADIYAH (PDM) ---
    $routes->group('pdm', function ($routes) {
        // Rute utama admin/pdm & aksi relasi
        $routes->get('/', 'PdmController::index');
        $routes->get('detail/(:num)', 'PdmController::detail/$1');
        $routes->post('store', 'PdmController::store');
        $routes->add('delete/(:num)', 'PdmController::delete/$1');

        $routes->group('sejarah', function ($routes) {
            $routes->get('/', 'SejarahPdm::index');
            $routes->post('simpan', 'SejarahPdm::simpan');
            $routes->post('update/(:num)', 'SejarahPdm::update/$1');
            $routes->add('hapus/(:num)', 'SejarahPdm::hapus/$1');
        });

        $routes->group('pengurus', function ($routes) {
            $routes->get('/', 'PengurusPdm::index');
            $routes->post('simpan', 'PengurusPdm::simpan');
            $routes->post('update/(:num)', 'PengurusPdm::update/$1');
            $routes->add('hapus/(:num)', 'PengurusPdm::hapus/$1');
        });

        $routes->group('website', function ($routes) {
            $routes->get('/', 'WebsitePdm::index');
            $routes->post('simpan', 'WebsitePdm::simpan');
            $routes->post('update/(:num)', 'WebsitePdm::update/$1');
            $routes->add('hapus/(:num)', 'WebsitePdm::hapus/$1');
        });
    });

    // Direct link PDM
    $routes->get('sejarah-pdm', 'SejarahPdm::index');
    $routes->post('sejarah-pdm/simpan', 'SejarahPdm::simpan');
    $routes->post('sejarah-pdm/update/(:num)', 'SejarahPdm::update/$1');
    $routes->add('sejarah-pdm/hapus/(:num)', 'SejarahPdm::hapus/$1');

    $routes->get('pengurus-pdm', 'PengurusPdm::index');
    $routes->post('pengurus-pdm/simpan', 'PengurusPdm::simpan');
    $routes->post('pengurus-pdm/update/(:num)', 'PengurusPdm::update/$1');
    $routes->add('pengurus-pdm/hapus/(:num)', 'PengurusPdm::hapus/$1');

    $routes->get('website-pdm', 'WebsitePdm::index');
    $routes->post('website-pdm/simpan', 'WebsitePdm::simpan');
    $routes->post('website-pdm/update/(:num)', 'WebsitePdm::update/$1');
    $routes->add('website-pdm/hapus/(:num)', 'WebsitePdm::hapus/$1');

    // --- PROFIL PWM (ADMIN) ---
    $routes->group('profil', function ($routes) {
        $routes->get('tentang-kami', 'Profil::tentangKami');
        $routes->get('tentang-kami/edit', 'Profil::editTentangKami');
        $routes->post('tentang-kami/update', 'Profil::updateTentangKami');

        $routes->get('visi-misi', 'Profil::visiMisi');
        $routes->get('visi-misi/edit', 'Profil::editVisiMisi');
        $routes->post('update-visi-misi', 'Profil::updateVisiMisi');
        $routes->post('update-visi-misi/(:segment)', 'Profil::updateVisiMisi/$1');

        $routes->get('sejarah', 'Profil::sejarah');
        $routes->post('sejarah/simpan', 'Profil::simpanSejarah');
        $routes->post('sejarah/update/(:num)', 'Profil::updateSejarah/$1');
        $routes->add('sejarah/hapus/(:num)', 'Profil::hapusSejarah/$1');

        $routes->get('struktur-organisasi', 'Profil::strukturOrganisasi');
        $routes->post('struktur-organisasi/simpan', 'Profil::simpanStruktur');
        $routes->post('struktur-organisasi/update/(:num)', 'Profil::updateStruktur/$1');
        $routes->add('struktur-organisasi/hapus/(:num)', 'Profil::hapusStruktur/$1');

        $routes->get('program-kerja', 'Profil::programKerja');
        $routes->post('program-kerja/simpan', 'Profil::simpanProgramKerja');
        $routes->post('program-kerja/update/(:num)', 'Profil::updateProgramKerja/$1');
        $routes->add('program-kerja/hapus/(:num)', 'Profil::hapusProgramKerja/$1');

        // Alias penanganan admin/profil/aum & ortom & sekolah & kampus & majelis
        $routes->get('majelis', 'Majelis::index');
        $routes->get('aum', 'Aum::index');
        $routes->get('amal-usaha', 'Aum::index');
        $routes->get('ortom', 'Ortom::index');
        $routes->get('sekolah', 'Sekolah::index');
        $routes->get('kampus', 'Kampus::index');
    });
});