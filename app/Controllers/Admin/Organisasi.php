<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\OrganisasiModel;

class Organisasi extends BaseController
{
    protected $organisasiModel;

    public function __construct()
    {
        $this->organisasiModel = new OrganisasiModel();
    }

    // Menampilkan Halaman Utama & Filter Data
    public function index()
    {
        $keyword        = $this->request->getGet('q');
        $filterKategori = $this->request->getGet('kategori');
        $filterStatus   = $this->request->getGet('status');

        $builder = $this->organisasiModel;

        if (!empty($keyword)) {
            $builder->groupStart()
                ->like('nama', $keyword)
                ->orLike('jabatan', $keyword)
                ->groupEnd();
        }

        if (!empty($filterKategori)) {
            $builder->where('kategori', $filterKategori);
        }

        if (!empty($filterStatus)) {
            $builder->where('status', $filterStatus);
        }

        // Urutkan berdasarkan 'urutan' ASC
        $dataOrganisasi = $builder->orderBy('urutan', 'ASC')->findAll();

        $data = [
            'title'          => 'Struktur Organisasi',
            'organisasi'     => $dataOrganisasi,
            'keyword'        => $keyword,
            'filterKategori' => $filterKategori,
            'filterStatus'   => $filterStatus,
        ];

        return view('admin/organisasi/index', $data);
    }

    // Simpan Data Pengurus Baru
    public function simpan()
    {
        if (!$this->validate([
            'nama'     => 'required',
            'jabatan'  => 'required',
            'kategori' => 'required',
            'periode'  => 'required',
            'urutan'   => 'required|numeric',
            'status'   => 'required',
            'logo'     => 'max_size[logo,2048]|is_image[logo]|mime_in[logo,image/png,image/jpg,image/jpeg]'
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Handle File Upload Logo
        $fileLogo = $this->request->getFile('logo');
        $namaLogo = null;

        if ($fileLogo && $fileLogo->isValid() && !$fileLogo->hasMoved()) {
            $namaLogo = $fileLogo->getRandomName();
            $fileLogo->move('uploads/organisasi', $namaLogo);
        }

        $this->organisasiModel->save([
            'nama'      => $this->request->getPost('nama'),
            'jabatan'   => $this->request->getPost('jabatan'),
            'kategori'  => $this->request->getPost('kategori'),
            'periode'   => $this->request->getPost('periode'),
            'urutan'    => $this->request->getPost('urutan'),
            'status'    => $this->request->getPost('status'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'logo'      => $namaLogo,
        ]);

        return redirect()->to(base_url('admin/profil/organisasi'))->with('sukses', 'Data pengurus berhasil ditambahkan.');
    }

    // Update Data Pengurus
    public function update($id = null)
    {
        if (!$id) {
            return redirect()->back()->with('gagal', 'ID tidak valid.');
        }

        if (!$this->validate([
            'nama'     => 'required',
            'jabatan'  => 'required',
            'kategori' => 'required',
            'periode'  => 'required',
            'urutan'   => 'required|numeric',
            'status'   => 'required',
            'logo'     => 'max_size[logo,2048]|is_image[logo]|mime_in[logo,image/png,image/jpg,image/jpeg]'
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $dataLama = $this->organisasiModel->find($id);
        $fileLogo = $this->request->getFile('logo');

        if ($fileLogo && $fileLogo->isValid() && !$fileLogo->hasMoved()) {
            $namaLogo = $fileLogo->getRandomName();
            $fileLogo->move('uploads/organisasi', $namaLogo);

            // Hapus logo lama jika ada
            if (!empty($dataLama['logo']) && file_exists('uploads/organisasi/' . $dataLama['logo'])) {
                unlink('uploads/organisasi/' . $dataLama['logo']);
            }
        } else {
            $namaLogo = $dataLama['logo'];
        }

        $this->organisasiModel->update($id, [
            'nama'      => $this->request->getPost('nama'),
            'jabatan'   => $this->request->getPost('jabatan'),
            'kategori'  => $this->request->getPost('kategori'),
            'periode'   => $this->request->getPost('periode'),
            'urutan'    => $this->request->getPost('urutan'),
            'status'    => $this->request->getPost('status'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'logo'      => $namaLogo,
        ]);

        return redirect()->to(base_url('admin/profil/organisasi'))->with('sukses', 'Data pengurus berhasil diperbarui.');
    }

    // Hapus Data Pengurus
    public function hapus($id = null)
    {
        if ($id) {
            $data = $this->organisasiModel->find($id);
            if ($data) {
                if (!empty($data['logo']) && file_exists('uploads/organisasi/' . $data['logo'])) {
                    unlink('uploads/organisasi/' . $data['logo']);
                }
                $this->organisasiModel->delete($id);
                return redirect()->to(base_url('admin/profil/organisasi'))->with('sukses', 'Data pengurus berhasil dihapus.');
            }
        }

        return redirect()->to(base_url('admin/profil/organisasi'))->with('gagal', 'Gagal menghapus data.');
    }
}
