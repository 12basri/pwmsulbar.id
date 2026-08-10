<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\OrtomModel;

class Ortom extends BaseController
{
    protected $ortomModel;

    public function __construct()
    {
        $this->ortomModel = new OrtomModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Manajemen Organisasi Otonom (Ortom)',
            'ortom' => $this->ortomModel->findAll(),
        ];

        return view('admin/ortom/index', $data);
    }

    public function simpan()
    {
        // Menggunakan aturan validasi dari OrtomModel
        if (!$this->validate($this->ortomModel->getValidationRules())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $fileLogo = $this->request->getFile('logo');
        $namaLogo = null;

        if ($fileLogo && $fileLogo->isValid() && !$fileLogo->hasMoved()) {
            $namaLogo = $fileLogo->getRandomName();
            $fileLogo->move(FCPATH . 'uploads/ortom/', $namaLogo);
        }

        $this->ortomModel->save([
            'nama_ortom' => $this->request->getPost('nama_ortom'),
            'ketua'      => $this->request->getPost('ketua'),
            'sekretaris' => $this->request->getPost('sekretaris'),
            'bendahara'  => $this->request->getPost('bendahara'),
            'deskripsi'  => $this->request->getPost('deskripsi'),
            'logo'       => $namaLogo,
        ]);

        return redirect()->to(site_url('admin/ortom'))->with('sukses', 'Data Ortom berhasil ditambahkan.');
    }

    public function update($id = null)
    {
        $ortom = $this->ortomModel->find($id);
        if (!$ortom) {
            return redirect()->to(site_url('admin/ortom'))->with('gagal', 'Data Ortom tidak ditemukan.');
        }

        // Menggunakan aturan validasi dari OrtomModel
        if (!$this->validate($this->ortomModel->getValidationRules())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $fileLogo = $this->request->getFile('logo');
        $namaLogo = $ortom['logo'];

        if ($fileLogo && $fileLogo->isValid() && !$fileLogo->hasMoved()) {
            if ($namaLogo && file_exists(FCPATH . 'uploads/ortom/' . $namaLogo)) {
                unlink(FCPATH . 'uploads/ortom/' . $namaLogo);
            }
            $namaLogo = $fileLogo->getRandomName();
            $fileLogo->move(FCPATH . 'uploads/ortom/', $namaLogo);
        }

        $this->ortomModel->update($id, [
            'nama_ortom' => $this->request->getPost('nama_ortom'),
            'ketua'      => $this->request->getPost('ketua'),
            'sekretaris' => $this->request->getPost('sekretaris'),
            'bendahara'  => $this->request->getPost('bendahara'),
            'deskripsi'  => $this->request->getPost('deskripsi'),
            'logo'       => $namaLogo,
        ]);

        return redirect()->to(site_url('admin/ortom'))->with('sukses', 'Data Ortom berhasil diperbarui.');
    }

    public function hapus($id = null)
    {
        $ortom = $this->ortomModel->find($id);

        if ($ortom) {
            if (!empty($ortom['logo']) && file_exists(FCPATH . 'uploads/ortom/' . $ortom['logo'])) {
                unlink(FCPATH . 'uploads/ortom/' . $ortom['logo']);
            }
            $this->ortomModel->delete($id);
            return redirect()->to(site_url('admin/ortom'))->with('sukses', 'Data Ortom berhasil dihapus.');
        }

        return redirect()->to(site_url('admin/ortom'))->with('gagal', 'Data tidak ditemukan.');
    }
}
