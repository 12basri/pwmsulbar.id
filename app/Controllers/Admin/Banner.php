<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BannerModel;

class Banner extends BaseController
{
    protected $bannerModel;

    public function __construct()
    {
        $this->bannerModel = new BannerModel();
    }

    public function index()
    {
        $data = [
            'banners' => $this->bannerModel->findAll(),
        ];

        return view('admin/banner/index', $data);
    }

    public function simpan()
    {
        $fileGambar = $this->request->getFile('gambar');

        if ($fileGambar && $fileGambar->isValid() && !$fileGambar->hasMoved()) {
            $namaGambar = $fileGambar->getRandomName();
            $fileGambar->move('uploads/banner', $namaGambar);
        } else {
            $namaGambar = 'default.jpg';
        }

        $this->bannerModel->save([
            'judul'  => $this->request->getPost('judul'),
            'link'   => $this->request->getPost('link'),
            'posisi' => $this->request->getPost('posisi'),
            'status' => $this->request->getPost('status'),
            'gambar' => $namaGambar,
        ]);

        return redirect()->to('/admin/banner')->with('success', 'Banner berhasil ditambahkan.');
    }

    public function update($id = null)
    {
        $bannerLama = $this->bannerModel->find($id);

        $fileGambar = $this->request->getFile('gambar');

        if ($fileGambar && $fileGambar->isValid() && !$fileGambar->hasMoved()) {
            $namaGambar = $fileGambar->getRandomName();
            $fileGambar->move('uploads/banner', $namaGambar);

            if ($bannerLama['gambar'] && file_exists('uploads/banner/' . $bannerLama['gambar'])) {
                unlink('uploads/banner/' . $bannerLama['gambar']);
            }
        } else {
            $namaGambar = $bannerLama['gambar'];
        }

        $this->bannerModel->update($id, [
            'judul'  => $this->request->getPost('judul'),
            'link'   => $this->request->getPost('link'),
            'posisi' => $this->request->getPost('posisi'),
            'status' => $this->request->getPost('status'),
            'gambar' => $namaGambar,
        ]);

        return redirect()->to('/admin/banner')->with('success', 'Banner berhasil diperbarui.');
    }

    public function hapus($id = null)
    {
        $banner = $this->bannerModel->find($id);

        if ($banner) {
            if ($banner['gambar'] && file_exists('uploads/banner/' . $banner['gambar'])) {
                unlink('uploads/banner/' . $banner['gambar']);
            }
            $this->bannerModel->delete($id);
        }

        return redirect()->to('/admin/banner')->with('success', 'Banner berhasil dihapus.');
    }
}
