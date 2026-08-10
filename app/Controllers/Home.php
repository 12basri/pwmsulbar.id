<?php

namespace App\Controllers;

use App\Models\AumModel;
use App\Models\BannerModel;
use App\Models\BeritaModel;
use App\Models\DokumenModel;
use App\Models\KampusModel;
use App\Models\MajelisModel;
use App\Models\OpiniModel;
use App\Models\OrtomModel;
use App\Models\PdmModel;
use App\Models\ProgramKerjaModel;
use App\Models\RefleksiModel;
use App\Models\SekolahModel;
use App\Models\SejarahModel;
use App\Models\SliderModel;
use App\Models\StrukturOrganisasiModel;
use App\Models\TentangKamiModel;
use App\Models\VisiMisiModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Home extends BaseController
{
    protected BannerModel $bannerModel;
    protected BeritaModel $beritaModel;
    protected DokumenModel $dokumenModel;
    protected RefleksiModel $refleksiModel;
    protected SliderModel $sliderModel;
    protected TentangKamiModel $tentangKamiModel;
    protected VisiMisiModel $visiMisiModel;
    protected SejarahModel $sejarahModel;
    protected StrukturOrganisasiModel $strukturModel;
    protected ProgramKerjaModel $programModel;
    protected AumModel $aumModel;
    protected OrtomModel $ortomModel;
    protected SekolahModel $sekolahModel;
    protected KampusModel $kampusModel;
    protected MajelisModel $majelisModel;
    protected PdmModel $pdmModel;
    protected OpiniModel $opiniModel;

    public function __construct()
    {
        helper(['text', 'url', 'number', 'form']);

        $this->bannerModel      = new BannerModel();
        $this->beritaModel      = new BeritaModel();
        $this->dokumenModel     = new DokumenModel();
        $this->refleksiModel    = new RefleksiModel();
        $this->sliderModel      = new SliderModel();
        $this->tentangKamiModel = new TentangKamiModel();
        $this->visiMisiModel    = new VisiMisiModel();
        $this->sejarahModel     = new SejarahModel();
        $this->strukturModel    = new StrukturOrganisasiModel();
        $this->programModel     = new ProgramKerjaModel();
        $this->aumModel         = new AumModel();
        $this->ortomModel       = new OrtomModel();
        $this->sekolahModel     = new SekolahModel();
        $this->kampusModel      = new KampusModel();
        $this->majelisModel     = new MajelisModel();
        $this->pdmModel         = new PdmModel();
        $this->opiniModel       = new OpiniModel();
    }

    private function getNavData(): array
    {
        return [
            'navAum'    => $this->aumModel->orderBy('jenis', 'ASC')->orderBy('nama_aum', 'ASC')->findAll(),
            'navKampus' => $this->kampusModel->orderBy('nama_kampus', 'ASC')->findAll(),
        ];
    }

    public function index(): string
    {
        $data = array_merge($this->getNavData(), [
            'title'          => 'Muhammadiyah Sulawesi Barat - PWM Sulawesi Barat',
            'sliders'        => $this->sliderModel->where('status', 'aktif')->orderBy('id', 'DESC')->findAll(),
            'banners'        => $this->bannerModel->where('status', 'aktif')->orderBy('id', 'DESC')->findAll(),
            'berita'         => $this->beritaModel->where('status', 'Publish')->orderBy('tanggal', 'DESC')->findAll(6),
            'opini'          => $this->opiniModel->where('status', 'Publish')->orderBy('tanggal', 'DESC')->findAll(4),
            'refleksi'       => $this->refleksiModel->orderBy('created_at', 'DESC')->findAll(4),
            
            // Perhitungan Statistik Realtime
            'total_pdm'      => $this->pdmModel->countAllResults(),
            'total_sekolah'  => $this->sekolahModel->countAllResults(),
            'total_majelis'  => $this->majelisModel->where('status', 'aktif')->countAllResults(),
            'total_aum'      => $this->aumModel->countAllResults(),
            'pdm_list'       => $this->pdmModel->orderBy('nama_pdm', 'ASC')->findAll(),
        ]);

        return view('pages/beranda', $data);
    }

    // ==========================================
    // METHOD HALAMAN BERITA PUBLIK
    // ==========================================

    public function berita(): string
    {
        $keyword = $this->request->getGet('q');

        $this->beritaModel->where('status', 'Publish');

        if (!empty($keyword)) {
            $this->beritaModel->groupStart()
                ->like('judul', $keyword)
                ->orLike('isi', $keyword)
                ->orLike('penulis', $keyword)
                ->groupEnd();
        }

        $beritaList = $this->beritaModel->orderBy('tanggal', 'DESC')->findAll();

        $data = array_merge($this->getNavData(), [
            'title'   => 'Berita & Informasi - PWM Sulawesi Barat',
            'berita'  => $beritaList,
            'keyword' => $keyword,
        ]);

        return view('pages/berita', $data);
    }

    public function detailBerita($param = null): string
    {
        if (!$param) {
            throw PageNotFoundException::forPageNotFound('Berita tidak ditemukan.');
        }

        $field  = is_numeric($param) ? 'id_berita' : 'slug';
        $berita = $this->beritaModel
            ->where('status', 'Publish')
            ->where($field, $param)
            ->first();

        if (!$berita) {
            throw PageNotFoundException::forPageNotFound('Berita tidak ditemukan.');
        }

        $beritaTerkini = $this->beritaModel
            ->where('status', 'Publish')
            ->where('id_berita !=', $berita['id_berita'])
            ->orderBy('tanggal', 'DESC')
            ->findAll(5);

        $data = array_merge($this->getNavData(), [
            'title'         => $berita['judul'] . ' - PWM Sulawesi Barat',
            'berita'        => $berita,
            'beritaTerkini' => $beritaTerkini,
        ]);

        return view('pages/detail_berita', $data);
    }

    // ==========================================
    // METHOD HALAMAN OPINI PUBLIK
    // ==========================================

    public function opini(): string
    {
        $keyword = $this->request->getGet('q');

        $this->opiniModel->where('status', 'Publish');

        if (!empty($keyword)) {
            $this->opiniModel->groupStart()
                ->like('judul', $keyword)
                ->orLike('isi', $keyword)
                ->orLike('penulis', $keyword)
                ->groupEnd();
        }

        $opiniList = $this->opiniModel->orderBy('tanggal', 'DESC')->paginate(9, 'opini');

        $data = array_merge($this->getNavData(), [
            'title'   => 'Artikel & Opini - PWM Sulawesi Barat',
            'opini'   => $opiniList,
            'pager'   => $this->opiniModel->pager,
            'keyword' => $keyword,
        ]);

        return view('pages/opini', $data);
    }

    public function detailOpini($param = null): string
    {
        if (!$param) {
            throw PageNotFoundException::forPageNotFound('Artikel opini tidak ditemukan.');
        }

        $pk    = $this->opiniModel->primaryKey;
        $field = is_numeric($param) ? $pk : 'slug';

        $opini = $this->opiniModel
            ->where('status', 'Publish')
            ->where($field, $param)
            ->first();

        if (!$opini) {
            throw PageNotFoundException::forPageNotFound('Artikel opini tidak ditemukan.');
        }

        if (array_key_exists('views', $opini)) {
            $this->opiniModel->update($opini[$pk], [
                'views' => ($opini['views'] ?? 0) + 1
            ]);
        }

        $opiniTerkini = $this->opiniModel
            ->where('status', 'Publish')
            ->where("{$pk} !=", $opini[$pk])
            ->orderBy('tanggal', 'DESC')
            ->findAll(5);

        $data = array_merge($this->getNavData(), [
            'title'        => $opini['judul'] . ' - PWM Sulawesi Barat',
            'opini'        => $opini,
            'opiniTerkini' => $opiniTerkini,
        ]);

        return view('pages/detail_opini', $data);
    }

    // ==========================================
    // METHOD HALAMAN PROFIL PUBLIK
    // ==========================================

    public function tentangKami(): string
    {
        $data = array_merge($this->getNavData(), [
            'title'   => 'Tentang Kami - PWM Sulawesi Barat',
            'tentang' => $this->tentangKamiModel->first(),
        ]);

        return view('pages/profil/tentang_kami', $data);
    }

    public function visiMisi(): string
    {
        $data = array_merge($this->getNavData(), [
            'title'     => 'Visi & Misi - PWM Sulawesi Barat',
            'visi_misi' => $this->visiMisiModel->orderBy('id_visi', 'DESC')->first(),
        ]);

        return view('pages/profil/visi_misi', $data);
    }

    public function sejarah(): string
    {
        $data = array_merge($this->getNavData(), [
            'title'   => 'Sejarah - PWM Sulawesi Barat',
            'sejarah' => $this->sejarahModel->findAll(),
        ]);

        return view('pages/profil/sejarah', $data);
    }

    public function strukturOrganisasi(): string
    {
        $data = array_merge($this->getNavData(), [
            'title'    => 'Struktur Organisasi - PWM Sulawesi Barat',
            'struktur' => $this->strukturModel->orderBy('urutan', 'ASC')->orderBy('id_struktur', 'ASC')->findAll(),
        ]);

        return view('pages/profil/struktur_organisasi', $data);
    }

    public function programKerja(): string
    {
        $data = array_merge($this->getNavData(), [
            'title'         => 'Program Kerja - PWM Sulawesi Barat',
            'program_kerja' => $this->programModel->orderBy('tahun', 'DESC')->orderBy('id_program', 'DESC')->findAll(),
        ]);

        return view('pages/profil/program_kerja', $data);
    }

    public function aum(): string
    {
        $jenisFilter = $this->request->getGet('jenis');

        if (!empty($jenisFilter)) {
            $this->aumModel->where('jenis', $jenisFilter);
        }

        $amalUsaha = $this->aumModel->orderBy('id_aum', 'DESC')->findAll();

        $data = array_merge($this->getNavData(), [
            'title'       => 'Amal Usaha Muhammadiyah (AUM) - PWM Sulawesi Barat',
            'amalUsaha'   => $amalUsaha,
            'filterJenis' => $jenisFilter,
        ]);

        return view('pages/profil/aum', $data);
    }

    // ==========================================
    // METHOD HALAMAN DIREKTORI MAJELIS & LEMBAGA
    // ==========================================

    public function majelis(): string
    {
        $keyword = $this->request->getGet('q');
        $jenis   = $this->request->getGet('jenis');

        $this->majelisModel->where('status', 'aktif');

        if (!empty($jenis)) {
            $this->majelisModel->where('jenis', $jenis);
        }

        if (!empty($keyword)) {
            $this->majelisModel->groupStart()
                ->like('nama_majelis', $keyword)
                ->orLike('deskripsi_singkat', $keyword)
                ->orLike('nomor_sk', $keyword)
                ->groupEnd();
        }

        $dataMajelis = $this->majelisModel->orderBy('nama_majelis', 'ASC')->findAll();

        $data = array_merge($this->getNavData(), [
            'title'       => 'Direktori Majelis & Lembaga - PWM Sulawesi Barat',
            'majelis'     => $dataMajelis,
            'keyword'     => $keyword,
            'filterJenis' => $jenis,
        ]);

        return view('pages/majelis', $data);
    }

    public function detailMajelis($id = null): string
    {
        if (!$id) {
            throw PageNotFoundException::forPageNotFound('Data Majelis/Lembaga tidak ditemukan.');
        }

        $majelis = $this->majelisModel->find($id);

        if (!$majelis) {
            throw PageNotFoundException::forPageNotFound('Data Majelis/Lembaga tidak ditemukan.');
        }

        $db = \Config\Database::connect();

        $pimpinan = $db->table('majelis_pimpinan')
            ->where('id_majelis', $id)
            ->orderBy('urutan', 'ASC')
            ->get()->getResultArray();

        $pakar = $db->table('majelis_pakar')
            ->where('id_majelis', $id)
            ->orderBy('urutan', 'ASC')
            ->get()->getResultArray();

        $bidang = $db->table('majelis_bidang')
            ->where('id_majelis', $id)
            ->orderBy('urutan', 'ASC')
            ->get()->getResultArray();

        foreach ($bidang as &$b) {
            $b['anggota'] = $db->table('majelis_anggota_bidang')
                ->where('id_bidang', $b['id_bidang'])
                ->orderBy('urutan', 'ASC')
                ->get()->getResultArray();
        }

        $programKerja = $db->table('program_kerja')
            ->where('id_majelis', $id)
            ->get()->getResultArray();

        $data = array_merge($this->getNavData(), [
            'title'         => $majelis['nama_majelis'] . ' - PWM Sulawesi Barat',
            'majelis'       => $majelis,
            'pimpinan'      => $pimpinan,
            'bidang'        => $bidang,
            'program_kerja' => $programKerja,
            'pakar'         => $pakar,
        ]);

        return view('pages/detail_majelis', $data);
    }

    // ==========================================
    // METHOD HALAMAN USAHA & FASILITAS LAINNYA
    // ==========================================

    public function usahaLain(): string
    {
        $jenisFilter = $this->request->getGet('jenis');
        $keyword     = $this->request->getGet('q');

        if (!empty($jenisFilter)) {
            $this->aumModel->where('jenis', $jenisFilter);
        }

        if (!empty($keyword)) {
            $this->aumModel->groupStart()
                ->like('nama_aum', $keyword)
                ->orLike('pimpinan', $keyword)
                ->orLike('alamat', $keyword)
                ->groupEnd();
        }

        $listUsaha = $this->aumModel->orderBy('id_aum', 'DESC')->findAll();

        $data = array_merge($this->getNavData(), [
            'title'       => 'Direktori Usaha Lainnya & Fasilitas - PWM Sulawesi Barat',
            'listUsaha'   => $listUsaha,
            'filterJenis' => $jenisFilter,
            'keyword'     => $keyword,
        ]);

        return view('pages/usaha_lain', $data);
    }

    public function detailUsaha($id = null): string
    {
        if (!$id) {
            throw PageNotFoundException::forPageNotFound('Data Usaha / Fasilitas tidak ditemukan.');
        }

        $aum = $this->aumModel->find($id);

        if (!$aum) {
            throw PageNotFoundException::forPageNotFound('Data Usaha / Fasilitas tidak ditemukan.');
        }

        $usahaLainnya = $this->aumModel
            ->where('id_aum !=', $aum['id_aum'])
            ->orderBy('id_aum', 'DESC')
            ->findAll(6);

        $data = array_merge($this->getNavData(), [
            'title'        => $aum['nama_aum'] . ' - PWM Sulawesi Barat',
            'aum'          => $aum,
            'usahaLainnya' => $usahaLainnya,
        ]);

        return view('pages/usaha_detail', $data);
    }

    public function ortom(): string
    {
        $data = array_merge($this->getNavData(), [
            'title' => 'Organisasi Otonom (Ortom) - PWM Sulawesi Barat',
            'ortom' => $this->ortomModel->findAll(),
        ]);

        return view('pages/profil/ortom', $data);
    }

    // ==========================================
    // METHOD HALAMAN DIREKTORI SEKOLAH
    // ==========================================

    public function sekolah(): string
    {
        $keyword    = $this->request->getGet('q');
        $jenjang    = $this->request->getGet('tingkat');
        $kabupaten  = $this->request->getGet('kabupaten');
        $akreditasi = $this->request->getGet('akreditasi');
        $urutan     = $this->request->getGet('urutan') ?? 'nama';

        $applyFilter = function ($model) use ($keyword, $jenjang, $kabupaten, $akreditasi) {
            if (!empty($keyword)) {
                $model->groupStart()
                    ->like('nama_sekolah', $keyword)
                    ->orLike('npsn', $keyword)
                    ->orLike('alamat', $keyword)
                    ->orLike('kepala_sekolah', $keyword)
                    ->groupEnd();
            }
            if (!empty($jenjang)) {
                $model->where('jenjang', $jenjang);
            }
            if (!empty($kabupaten)) {
                $model->where('kabupaten_kota', $kabupaten);
            }
            if (!empty($akreditasi)) {
                $model->where('akreditasi', $akreditasi);
            }
        };

        $this->sekolahModel->resetQuery();
        $applyFilter($this->sekolahModel);

        if ($urutan === 'kabupaten') {
            $this->sekolahModel->orderBy('kabupaten_kota', 'ASC')->orderBy('nama_sekolah', 'ASC');
        } else {
            $this->sekolahModel->orderBy('nama_sekolah', 'ASC');
        }

        $sekolahList   = $this->sekolahModel->paginate(12, 'sekolah');
        $pager         = $this->sekolahModel->pager;
        $totalFiltered = $pager->getTotal('sekolah');

        $db = \Config\Database::connect();
        $stats = $db->table($this->sekolahModel->getTable())
            ->select('
                COUNT(*) as total_sekolah,
                SUM(CASE WHEN akreditasi = "A" THEN 1 ELSE 0 END) as total_akre_a,
                SUM(CASE WHEN akreditasi = "B" THEN 1 ELSE 0 END) as total_akre_b,
                COUNT(DISTINCT CASE WHEN kabupaten_kota IS NOT NULL AND kabupaten_kota != "" AND kabupaten_kota != "-" THEN kabupaten_kota END) as total_kabupaten
            ')
            ->get()->getRowArray();

        $listJenjangMaster = ['MA', 'MI', 'MTS', 'SD', 'SLB', 'SMA', 'SMK', 'SMP'];
        $statJenjang       = array_fill_keys($listJenjangMaster, 0);

        $rawJenjang = $db->table($this->sekolahModel->getTable())
            ->select('jenjang, COUNT(*) as total')
            ->where('jenjang IS NOT NULL')
            ->where('jenjang !=', '')
            ->groupBy('jenjang')
            ->get()->getResultArray();

        foreach ($rawJenjang as $row) {
            $jKey = strtoupper(trim($row['jenjang'] ?? ''));
            if (array_key_exists($jKey, $statJenjang)) {
                $statJenjang[$jKey] = (int)$row['total'];
            }
        }

        $listKabupaten = $db->table($this->sekolahModel->getTable())
            ->select('kabupaten_kota, COUNT(*) as total')
            ->where('kabupaten_kota !=', '')
            ->where('kabupaten_kota IS NOT NULL')
            ->where('kabupaten_kota !=', '-')
            ->groupBy('kabupaten_kota')
            ->orderBy('kabupaten_kota', 'ASC')
            ->get()->getResultArray();

        $statKabupaten = $listKabupaten;
        usort($statKabupaten, fn($a, $b) => $b['total'] <=> $a['total']);
        $statKabupaten = array_slice($statKabupaten, 0, 6);

        $data = array_merge($this->getNavData(), [
            'title'          => 'Direktori Sekolah & Madrasah - PWM Sulawesi Barat',
            'sekolahList'    => $sekolahList,
            'pager'          => $pager,
            'totalSekolah'   => (int)($stats['total_sekolah'] ?? 0),
            'totalFiltered'  => $totalFiltered,
            'totalKabupaten' => (int)($stats['total_kabupaten'] ?? 0),
            'totalAkreA'     => (int)($stats['total_akre_a'] ?? 0),
            'totalAkreB'     => (int)($stats['total_akre_b'] ?? 0),
            'statJenjang'    => $statJenjang,
            'statKabupaten'  => $statKabupaten,
            'listKabupaten'  => $listKabupaten,
            'keyword'        => $keyword,
            'filterTingkat'  => $jenjang,
            'filterKab'      => $kabupaten,
            'filterAkre'     => $akreditasi,
            'filterUrutan'   => $urutan,
        ]);

        return view('pages/sekolah', $data);
    }

    // ==========================================
    // METHOD HALAMAN DIREKTORI KAMPUS
    // ==========================================

    public function kampus(): string
    {
        $bentuk  = $this->request->getGet('bentuk') ?? $this->request->getGet('jenis');
        $keyword = $this->request->getGet('q');

        if (!empty($bentuk)) {
            $this->kampusModel->where('bentuk', $bentuk);
        }

        if (!empty($keyword)) {
            $this->kampusModel->groupStart()
                ->like('nama_kampus', $keyword)
                ->orLike('singkatan', $keyword)
                ->orLike('kabupaten_kota', $keyword)
                ->orLike('rektor_ketua', $keyword)
                ->orLike('alamat', $keyword)
                ->groupEnd();
        }

        $kampusList = $this->kampusModel->orderBy('nama_kampus', 'ASC')->findAll();

        $data = array_merge($this->getNavData(), [
            'title'        => 'Direktori Perguruan Tinggi / Kampus - PWM Sulawesi Barat',
            'kampusList'   => $kampusList,
            'filterBentuk' => $bentuk,
            'filterJenis'  => $bentuk,
            'keyword'      => $keyword,
        ]);

        return view('pages/kampus', $data);
    }

    public function detailKampus($param = null): string
    {
        if (!$param) {
            throw PageNotFoundException::forPageNotFound('Data Kampus tidak ditemukan.');
        }

        $field  = is_numeric($param) ? $this->kampusModel->primaryKey : 'slug';
        $kampus = $this->kampusModel->where($field, $param)->first();

        if (!$kampus) {
            throw PageNotFoundException::forPageNotFound('Data Kampus tidak ditemukan.');
        }

        $pk = $this->kampusModel->primaryKey;

        $kampusLainnya = $this->kampusModel
            ->where("{$pk} !=", $kampus[$pk])
            ->orderBy($pk, 'DESC')
            ->findAll(6);

        $data = array_merge($this->getNavData(), [
            'title'         => $kampus['nama_kampus'] . ' - PWM Sulawesi Barat',
            'kampus'        => $kampus,
            'kampusLainnya' => $kampusLainnya,
            'ptma_lainnya'  => $kampusLainnya,
        ]);

        return view('pages/detail_kampus', $data);
    }

    // ==========================================
    // METHOD HALAMAN DIREKTORI PDM
    // ==========================================

    public function pdm(): string
    {
        $keyword = $this->request->getGet('q');

        if (!empty($keyword)) {
            $this->pdmModel->groupStart()
                ->like('nama_pdm', $keyword)
                ->orLike('pimpinan', $keyword)
                ->orLike('alamat', $keyword)
                ->groupEnd();
        }

        $pdmList = $this->pdmModel->orderBy('nama_pdm', 'ASC')->findAll();

        $data = array_merge($this->getNavData(), [
            'title'   => 'Direktori PDM (Pimpinan Daerah Muhammadiyah) - PWM Sulawesi Barat',
            'pdmList' => $pdmList,
            'keyword' => $keyword,
        ]);

        return view('pages/pdm', $data);
    }

    public function detailPdm($param = null): string
    {
        if (!$param) {
            throw PageNotFoundException::forPageNotFound('Data PDM tidak ditemukan.');
        }

        $pk    = $this->pdmModel->primaryKey;
        $field = is_numeric($param) ? (in_array('id_pdm', $this->pdmModel->allowedFields) || $pk === 'id_pdm' ? 'id_pdm' : $pk) : 'slug';
        $pdm   = $this->pdmModel->where($field, $param)->first();

        if (!$pdm) {
            throw PageNotFoundException::forPageNotFound('Data PDM tidak ditemukan.');
        }

        $pdm['ketua_umum']    = $pdm['ketua_umum'] ?? $pdm['pimpinan'] ?? $pdm['ketua'] ?? $pdm['nama_pimpinan'] ?? '-';
        $pdm['alamat_kantor'] = $pdm['alamat_kantor'] ?? $pdm['alamat'] ?? $pdm['lokasi'] ?? '-';
        $pdm['telepon']       = $pdm['telepon'] ?? $pdm['no_telp'] ?? $pdm['hp'] ?? $pdm['kontak'] ?? '-';
        $pdm['email']         = $pdm['email'] ?? $pdm['email_pdm'] ?? '-';

        $idPdm = $pdm['id_pdm'] ?? $pdm['id'] ?? null;
        $db    = \Config\Database::connect();

        $pengurusQuery = $db->table('pengurus_pdm')->where('id_pdm', $idPdm);
        if ($db->fieldExists('nama_pengurus', 'pengurus_pdm')) {
            $pengurusQuery->select('*, nama_pengurus AS nama');
        }
        $pengurus = $pengurusQuery->get()->getResultArray();

        $sejarahQuery = $db->table('sejarah_pdm')->where('id_pdm', $idPdm);
        if ($db->fieldExists('tahun_kejadian', 'sejarah_pdm')) {
            $sejarahQuery->select('*, tahun_kejadian AS tahun, deskripsi AS isi');
            $sejarahQuery->orderBy('tahun_kejadian', 'ASC');
        } elseif ($db->fieldExists('tahun', 'sejarah_pdm')) {
            $sejarahQuery->orderBy('tahun', 'ASC');
        }
        $sejarah = $sejarahQuery->get()->getResultArray();

        $websiteQuery = $db->table('website_pdm')->where('id_pdm', $idPdm);
        if ($db->fieldExists('url_website', 'website_pdm')) {
            $websiteQuery->select('*, url_website AS url');
        }
        $website = $websiteQuery->get()->getResultArray();

        $data = array_merge($this->getNavData(), [
            'title'    => $pdm['nama_pdm'] . ' - PWM Sulawesi Barat',
            'pdm'      => $pdm,
            'pengurus' => $pengurus,
            'sejarah'  => $sejarah,
            'website'  => $website,
        ]);

        return view('pages/detail_pdm', $data);
    }

    // ==========================================
    // METHOD HALAMAN DOKUMEN & ARSIP
    // ==========================================

    public function dokumenArsip(): string
    {
        $keyword  = $this->request->getGet('q');
        $kategori = $this->request->getGet('kategori');

        if (!empty($kategori)) {
            $this->dokumenModel->where('kategori', $kategori);
        }

        if (!empty($keyword)) {
            $this->dokumenModel->groupStart()
                ->like('nama_dokumen', $keyword)
                ->orLike('kategori', $keyword)
                ->groupEnd();
        }

        $dokumenList = $this->dokumenModel->orderBy('id_dokumen', 'DESC')->paginate(10, 'dokumen');

        $data = array_merge($this->getNavData(), [
            'title'          => 'Dokumen & Arsip - PWM Sulawesi Barat',
            'dokumen'        => $dokumenList,
            'pager'          => $this->dokumenModel->pager,
            'keyword'        => $keyword,
            'filterKategori' => $kategori,
        ]);

        return view('pages/dokumen_arsip', $data);
    }
}