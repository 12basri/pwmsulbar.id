<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\Exceptions\PageNotFoundException;

use App\Models\TentangKamiModel;
use App\Models\VisiMisiModel;
use App\Models\SejarahModel;
use App\Models\StrukturOrganisasiModel;
use App\Models\ProgramKerjaModel;
use App\Models\MajelisModel;

class Profil extends BaseController
{
    protected $tentangKamiModel;
    protected $visiMisiModel;
    protected $sejarahModel;
    protected $strukturModel;
    protected $programKerjaModel;
    protected $majelisModel;

    public function __construct()
    {
        $this->tentangKamiModel  = new TentangKamiModel();
        $this->visiMisiModel     = new VisiMisiModel();
        $this->sejarahModel      = new SejarahModel();
        $this->strukturModel     = new StrukturOrganisasiModel();
        $this->programKerjaModel = new ProgramKerjaModel();
        $this->majelisModel      = new MajelisModel();
    }

    // =========================================================================
    // 1. TENTANG KAMI
    // =========================================================================

    public function tentangKami()
    {
        $data = [
            'title'       => 'Profil - Tentang Kami',
            'tentangKami' => $this->tentangKamiModel->first()
        ];

        return view('admin/profil/tentang_kami', $data);
    }

    public function editTentangKami()
    {
        $data = [
            'title'       => 'Edit Tentang Kami',
            'tentangKami' => $this->tentangKamiModel->first(),
            'validation'  => \Config\Services::validation()
        ];

        return view('admin/profil/edit_tentang_kami', $data);
    }

    public function updateTentangKami()
    {
        if (!$this->request->is('post')) {
            return redirect()->to('/admin/profil/tentang-kami');
        }

        $id          = $this->request->getPost('id');
        $tentangLama = $id ? $this->tentangKamiModel->find($id) : null;

        $rules = [
            'deskripsi' => 'required',
            'foto'      => 'is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png,image/webp]|max_size[foto,2048]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $fileFoto = $this->request->getFile('foto');
        if ($fileFoto && $fileFoto->isValid() && !$fileFoto->hasMoved()) {
            if ($tentangLama && !empty($tentangLama['foto'])) {
                $this->deleteFile($tentangLama['foto'], 'uploads/profil');
            }
            $namaFoto = $this->uploadFile($fileFoto, 'uploads/profil');
        } else {
            $namaFoto = $tentangLama['foto'] ?? null;
        }

        $dataSave = [
            'deskripsi' => $this->request->getPost('deskripsi'),
            'foto'      => $namaFoto
        ];

        if ($id) {
            $dataSave['id'] = $id;
        }

        $this->tentangKamiModel->save($dataSave);

        return redirect()->to('/admin/profil/tentang-kami')->with('sukses', 'Data Tentang Kami berhasil diperbarui.');
    }

    // =========================================================================
    // 2. VISI MISI & TUJUAN
    // =========================================================================

    public function visiMisi()
    {
        $data = [
            'title'    => 'Profil - Visi & Misi',
            'visiMisi' => $this->visiMisiModel->first()
        ];

        return view('admin/profil/visi_misi', $data);
    }

    public function editVisiMisi()
    {
        $data = [
            'title'      => 'Edit Visi & Misi',
            'visiMisi'   => $this->visiMisiModel->first(),
            'validation' => \Config\Services::validation()
        ];

        return view('admin/profil/edit_visi_misi', $data);
    }

    public function updateVisiMisi($id = null)
    {
        if (!$this->request->is('post')) {
            return redirect()->to('/admin/profil/visi-misi');
        }

        // Ambil data lama jika ada di DB
        $existingData = $this->visiMisiModel->first();

        // Tangkap ID dari URL, Form POST, atau fallback ke ID di Database
        $idForm = $this->request->getPost('id_visi') ?: $this->request->getPost('id');
        $targetId = !empty($id) ? $id : (!empty($idForm) ? $idForm : ($existingData['id_visi'] ?? null));

        $rules = [
            'visi'   => 'required',
            'misi'   => 'required',
            'tujuan' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $dataSave = [
            'visi'   => $this->request->getPost('visi'),
            'misi'   => $this->request->getPost('misi'),
            'tujuan' => $this->request->getPost('tujuan')
        ];

        if ($targetId) {
            // Jika ID ditemukan, lakukan UPDATE
            $simpan = $this->visiMisiModel->update($targetId, $dataSave);
        } else {
            // Jika belum ada data sama sekali di DB, lakukan INSERT baru
            $simpan = $this->visiMisiModel->insert($dataSave);
        }

        if ($simpan === false) {
            return redirect()->back()->withInput()->with('errors', ['Gagal memperbarui data Visi Misi ke database.']);
        }

        return redirect()->to('/admin/profil/visi-misi')->with('sukses', 'Visi, Misi, dan Tujuan berhasil diperbarui.');
    }

    // =========================================================================
    // 3. SEJARAH
    // =========================================================================

    public function sejarah()
    {
        $data = [
            'title'   => 'Profil - Sejarah',
            'sejarah' => $this->sejarahModel->orderBy('id_sejarah', 'DESC')->findAll()
        ];

        return view('admin/profil/sejarah', $data);
    }

    public function simpanSejarah()
    {
        if (!$this->request->is('post')) {
            return redirect()->to('/admin/profil/sejarah');
        }

        $rules = [
            'judul'  => 'required',
            'isi'    => 'required',
            'gambar' => 'is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png,image/webp]|max_size[gambar,2048]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $fileGambar = $this->request->getFile('gambar');
        $namaGambar = ($fileGambar && $fileGambar->isValid() && !$fileGambar->hasMoved())
            ? $this->uploadFile($fileGambar, 'uploads/sejarah')
            : null;

        $this->sejarahModel->save([
            'judul'  => $this->request->getPost('judul'),
            'tahun'  => $this->request->getPost('tahun'),
            'isi'    => $this->request->getPost('isi'),
            'gambar' => $namaGambar
        ]);

        return redirect()->to('/admin/profil/sejarah')->with('sukses', 'Data Sejarah berhasil ditambahkan.');
    }

    public function updateSejarah($id = null)
    {
        if (!$this->request->is('post')) {
            return redirect()->to('/admin/profil/sejarah');
        }

        $id = $id ?? $this->request->getPost('id_sejarah');
        $sejarahLama = $this->sejarahModel->find($id);

        if (!$sejarahLama) {
            throw PageNotFoundException::forPageNotFound('Data Sejarah tidak ditemukan.');
        }

        $rules = [
            'judul'  => 'required',
            'isi'    => 'required',
            'gambar' => 'is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png,image/webp]|max_size[gambar,2048]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $fileGambar = $this->request->getFile('gambar');
        if ($fileGambar && $fileGambar->isValid() && !$fileGambar->hasMoved()) {
            if (!empty($sejarahLama['gambar'])) {
                $this->deleteFile($sejarahLama['gambar'], 'uploads/sejarah');
            }
            $namaGambar = $this->uploadFile($fileGambar, 'uploads/sejarah');
        } else {
            $namaGambar = $sejarahLama['gambar'] ?? null;
        }

        $this->sejarahModel->update($id, [
            'judul'  => $this->request->getPost('judul'),
            'tahun'  => $this->request->getPost('tahun'),
            'isi'    => $this->request->getPost('isi'),
            'gambar' => $namaGambar
        ]);

        return redirect()->to('/admin/profil/sejarah')->with('sukses', 'Data Sejarah berhasil diperbarui.');
    }

    public function hapusSejarah($id = null)
    {
        $sejarah = $this->sejarahModel->find($id);

        if ($sejarah) {
            if (!empty($sejarah['gambar'])) {
                $this->deleteFile($sejarah['gambar'], 'uploads/sejarah');
            }
            $this->sejarahModel->delete($id);
            return redirect()->to('/admin/profil/sejarah')->with('sukses', 'Data Sejarah berhasil dihapus.');
        }

        return redirect()->to('/admin/profil/sejarah')->with('gagal', 'Data Sejarah tidak ditemukan.');
    }

    // =========================================================================
    // 4. STRUKTUR ORGANISASI
    // =========================================================================

    public function strukturOrganisasi()
    {
        $data = [
            'title'    => 'Profil - Struktur Organisasi',
            'struktur' => $this->strukturModel->orderBy('urutan', 'ASC')->findAll()
        ];

        return view('admin/profil/struktur_organisasi', $data);
    }

    public function simpanStruktur()
    {
        if (!$this->request->is('post')) {
            return redirect()->to('/admin/profil/struktur-organisasi');
        }

        $rules = [
            'nama'    => 'required',
            'jabatan' => 'required',
            'foto'    => 'is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png,image/webp]|max_size[foto,2048]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $fileFoto = $this->request->getFile('foto');
        $namaFoto = ($fileFoto && $fileFoto->isValid() && !$fileFoto->hasMoved())
            ? $this->uploadFile($fileFoto, 'uploads/struktur')
            : null;

        $this->strukturModel->save([
            'nama'    => $this->request->getPost('nama'),
            'jabatan' => $this->request->getPost('jabatan'),
            'urutan'  => $this->request->getPost('urutan') ?? 0,
            'foto'    => $namaFoto
        ]);

        return redirect()->to('/admin/profil/struktur-organisasi')->with('sukses', 'Pengurus berhasil ditambahkan.');
    }

    public function updateStruktur($id = null)
    {
        if (!$this->request->is('post')) {
            return redirect()->to('/admin/profil/struktur-organisasi');
        }

        $id = $id ?? $this->request->getPost('id');
        $strukturLama = $this->strukturModel->find($id);

        if (!$strukturLama) {
            throw PageNotFoundException::forPageNotFound('Data pengurus tidak ditemukan.');
        }

        $rules = [
            'nama'    => 'required',
            'jabatan' => 'required',
            'foto'    => 'is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png,image/webp]|max_size[foto,2048]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $fileFoto = $this->request->getFile('foto');
        if ($fileFoto && $fileFoto->isValid() && !$fileFoto->hasMoved()) {
            if (!empty($strukturLama['foto'])) {
                $this->deleteFile($strukturLama['foto'], 'uploads/struktur');
            }
            $namaFoto = $this->uploadFile($fileFoto, 'uploads/struktur');
        } else {
            $namaFoto = $strukturLama['foto'] ?? null;
        }

        $this->strukturModel->update($id, [
            'nama'    => $this->request->getPost('nama'),
            'jabatan' => $this->request->getPost('jabatan'),
            'urutan'  => $this->request->getPost('urutan') ?? 0,
            'foto'    => $namaFoto
        ]);

        return redirect()->to('/admin/profil/struktur-organisasi')->with('sukses', 'Data pengurus berhasil diperbarui.');
    }

    public function hapusStruktur($id = null)
    {
        $struktur = $this->strukturModel->find($id);

        if ($struktur) {
            if (!empty($struktur['foto'])) {
                $this->deleteFile($struktur['foto'], 'uploads/struktur');
            }
            $this->strukturModel->delete($id);
            return redirect()->to('/admin/profil/struktur-organisasi')->with('sukses', 'Data pengurus berhasil dihapus.');
        }

        return redirect()->to('/admin/profil/struktur-organisasi')->with('gagal', 'Data pengurus tidak ditemukan.');
    }

    // =========================================================================
    // 5. PROGRAM KERJA
    // =========================================================================

    public function programKerja()
    {
        $keyword       = $this->request->getGet('q');
        $filterTahun   = $this->request->getGet('tahun');
        $filterStatus  = $this->request->getGet('status');
        $filterMajelis = $this->request->getGet('id_majelis');

        $model = $this->programKerjaModel
            ->select('program_kerja.*, majelis_lembaga.nama_majelis')
            ->join('majelis_lembaga', 'majelis_lembaga.id_majelis = program_kerja.id_majelis', 'left');

        if (!empty($keyword)) {
            $model->groupStart()
                ->like('program_kerja.nama_program', $keyword)
                ->orLike('program_kerja.deskripsi', $keyword)
                ->orLike('program_kerja.kategori', $keyword)
                ->groupEnd();
        }

        if (!empty($filterTahun)) {
            $model->where('program_kerja.tahun', $filterTahun);
        }

        if (!empty($filterStatus)) {
            $model->where('program_kerja.status', $filterStatus);
        }

        if (!empty($filterMajelis)) {
            $model->where('program_kerja.id_majelis', $filterMajelis);
        }

        $resultData = $model->orderBy('program_kerja.id_program', 'DESC')->findAll();

        $data = [
            'title'         => 'Profil - Program Kerja',
            'programKerja'  => $resultData,
            'program_kerja' => $resultData,
            'listMajelis'   => $this->majelisModel->orderBy('nama_majelis', 'ASC')->findAll(),
            'keyword'       => $keyword,
            'filterTahun'   => $filterTahun,
            'filterStatus'  => $filterStatus,
            'filterMajelis' => $filterMajelis,
        ];

        return view('admin/profil/program_kerja', $data);
    }

    public function simpanProgramKerja()
    {
        if (!$this->request->is('post')) {
            return redirect()->to('/admin/profil/program-kerja');
        }

        $rules = [
            'id_majelis'   => 'required',
            'nama_program' => 'required',
            'kategori'     => 'required',
            'tahun'        => 'required|numeric',
            'deskripsi'    => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->programKerjaModel->save([
            'id_majelis'   => $this->request->getPost('id_majelis'),
            'nama_program' => $this->request->getPost('nama_program'),
            'kategori'     => $this->request->getPost('kategori'),
            'tahun'        => $this->request->getPost('tahun'),
            'status'       => $this->request->getPost('status') ?? 'Aktif',
            'deskripsi'    => $this->request->getPost('deskripsi')
        ]);

        return redirect()->to('/admin/profil/program-kerja')->with('sukses', 'Program Kerja berhasil ditambahkan.');
    }

    public function updateProgramKerja($id = null)
    {
        if (!$this->request->is('post')) {
            return redirect()->to('/admin/profil/program-kerja');
        }

        $id = $id ?? $this->request->getPost('id_program') ?? $this->request->getPost('id');
        $progLama = $this->programKerjaModel->find($id);

        if (!$progLama) {
            throw PageNotFoundException::forPageNotFound('Program kerja tidak ditemukan.');
        }

        $rules = [
            'id_majelis'   => 'required',
            'nama_program' => 'required',
            'kategori'     => 'required',
            'tahun'        => 'required|numeric',
            'deskripsi'    => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->programKerjaModel->update($id, [
            'id_majelis'   => $this->request->getPost('id_majelis'),
            'nama_program' => $this->request->getPost('nama_program'),
            'kategori'     => $this->request->getPost('kategori'),
            'tahun'        => $this->request->getPost('tahun'),
            'status'       => $this->request->getPost('status'),
            'deskripsi'    => $this->request->getPost('deskripsi')
        ]);

        return redirect()->to('/admin/profil/program-kerja')->with('sukses', 'Program Kerja berhasil diperbarui.');
    }

    public function hapusProgramKerja($id = null)
    {
        $program = $this->programKerjaModel->find($id);

        if ($program) {
            $this->programKerjaModel->delete($id);
            return redirect()->to('/admin/profil/program-kerja')->with('sukses', 'Program Kerja berhasil dihapus.');
        }

        return redirect()->to('/admin/profil/program-kerja')->with('gagal', 'Program Kerja tidak ditemukan.');
    }

    // =========================================================================
    // PRIVATE HELPER METHODS
    // =========================================================================

    private function uploadFile($file, string $folder): ?string
    {
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(FCPATH . $folder, $newName);
            return $newName;
        }
        return null;
    }

    private function deleteFile(?string $fileName, string $folder): void
    {
        if ($fileName && file_exists(FCPATH . $folder . '/' . $fileName) && is_file(FCPATH . $folder . '/' . $fileName)) {
            unlink(FCPATH . $folder . '/' . $fileName);
        }
    }
}