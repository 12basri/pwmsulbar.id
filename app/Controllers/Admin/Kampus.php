<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KampusModel;

class Kampus extends BaseController
{
    protected $kampusModel;

    public function __construct()
    {
        $this->kampusModel = new KampusModel();
        helper(['form', 'url']);
    }

    // 1. Tampil Daftar Kampus (dengan Search & Filter)
    public function index()
    {
        $keyword = $this->request->getGet('q');
        $bentuk  = $this->request->getGet('bentuk');
        $kab     = $this->request->getGet('kabupaten');

        $builder = $this->kampusModel;

        if (!empty($keyword)) {
            $builder->groupStart()
                ->like('nama_kampus', $keyword)
                ->orLike('singkatan', $keyword)
                ->orLike('rektor_ketua', $keyword)
                ->groupEnd();
        }

        if (!empty($bentuk)) {
            $builder->where('bentuk', $bentuk);
        }

        if (!empty($kab)) {
            $builder->where('kabupaten_kota', $kab);
        }

        $data = [
            'title'           => 'Kelola Data Kampus',
            'kampusList'      => $builder->paginate(10, 'kampus'),
            'pager'           => $this->kampusModel->pager,
            'keyword'         => $keyword,
            'filterBentuk'    => $bentuk,
            'filterKabupaten' => $kab
        ];

        return view('admin/kampus/index', $data);
    }

    // 2. Simpan Data Baru
    public function simpan()
    {
        $rules = [
            'nama_kampus'    => 'required|min_length[3]',
            'bentuk'         => 'required',
            'kabupaten_kota' => 'required',
            'logo'           => 'is_image[logo]|mime_in[logo,image/jpg,image/jpeg,image/png,image/webp]|max_size[logo,2048]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $namaKampus = $this->request->getPost('nama_kampus');
        $fileLogo   = $this->request->getFile('logo');

        $namaLogo = null;
        if ($fileLogo && $fileLogo->isValid() && !$fileLogo->hasMoved()) {
            $namaLogo = $fileLogo->getRandomName();
            $fileLogo->move(FCPATH . 'uploads/kampus', $namaLogo);
        }

        $this->kampusModel->save([
            'nama_kampus'    => $namaKampus,
            'slug'           => url_title($namaKampus, '-', true),
            'singkatan'      => $this->request->getPost('singkatan'),
            'bentuk'         => $this->request->getPost('bentuk'),
            'akreditasi'     => $this->request->getPost('akreditasi'),
            'kabupaten_kota' => $this->request->getPost('kabupaten_kota'),
            'kecamatan'      => $this->request->getPost('kecamatan'),
            'rektor_ketua'   => $this->request->getPost('rektor_ketua'),
            'alamat'         => $this->request->getPost('alamat'),
            'website'        => $this->request->getPost('website'),
            'link_pddikti'   => $this->request->getPost('link_pddikti'),
            'deskripsi'      => $this->request->getPost('deskripsi'),
            'logo'           => $namaLogo
        ]);

        return redirect()->to(base_url('admin/kampus'))->with('sukses', 'Data kampus berhasil ditambahkan.');
    }

    // 3. Update Data Kampus
    public function update($id)
    {
        $kampus = $this->kampusModel->find($id);
        if (!$kampus) {
            return redirect()->to(base_url('admin/kampus'))->with('errors', ['Data tidak ditemukan']);
        }

        $rules = [
            'nama_kampus'    => 'required|min_length[3]',
            'bentuk'         => 'required',
            'kabupaten_kota' => 'required',
            'logo'           => 'is_image[logo]|mime_in[logo,image/jpg,image/jpeg,image/png,image/webp]|max_size[logo,2048]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $namaKampus = $this->request->getPost('nama_kampus');
        $fileLogo   = $this->request->getFile('logo');
        $logoLama   = $this->request->getPost('logo_lama');

        $namaLogo = $logoLama;

        // Jika user mengunggah file logo baru
        if ($fileLogo && $fileLogo->isValid() && !$fileLogo->hasMoved()) {
            $namaLogo = $fileLogo->getRandomName();
            $fileLogo->move(FCPATH . 'uploads/kampus', $namaLogo);

            // Hapus logo lama dari server jika ada
            if (!empty($logoLama) && file_exists(FCPATH . 'uploads/kampus/' . $logoLama)) {
                unlink(FCPATH . 'uploads/kampus/' . $logoLama);
            }
        }

        $this->kampusModel->update($id, [
            'nama_kampus'    => $namaKampus,
            'slug'           => url_title($namaKampus, '-', true),
            'singkatan'      => $this->request->getPost('singkatan'),
            'bentuk'         => $this->request->getPost('bentuk'),
            'akreditasi'     => $this->request->getPost('akreditasi'),
            'kabupaten_kota' => $this->request->getPost('kabupaten_kota'),
            'kecamatan'      => $this->request->getPost('kecamatan'),
            'rektor_ketua'   => $this->request->getPost('rektor_ketua'),
            'alamat'         => $this->request->getPost('alamat'),
            'website'        => $this->request->getPost('website'),
            'link_pddikti'   => $this->request->getPost('link_pddikti'),
            'deskripsi'      => $this->request->getPost('deskripsi'),
            'logo'           => $namaLogo
        ]);

        return redirect()->to(base_url('admin/kampus'))->with('sukses', 'Data kampus berhasil diperbarui.');
    }

    // 4. Hapus Data Kampus
    public function hapus($id)
    {
        $kampus = $this->kampusModel->find($id);

        if ($kampus) {
            // Hapus berkas gambar dari server jika ada
            if (!empty($kampus['logo']) && file_exists(FCPATH . 'uploads/kampus/' . $kampus['logo'])) {
                unlink(FCPATH . 'uploads/kampus/' . $kampus['logo']);
            }

            $this->kampusModel->delete($id);
            return redirect()->to(base_url('admin/kampus'))->with('sukses', 'Data kampus berhasil dihapus.');
        }

        return redirect()->to(base_url('admin/kampus'))->with('errors', ['Data tidak ditemukan']);
    }
}
