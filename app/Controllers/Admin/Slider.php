<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SliderModel;

class Slider extends BaseController
{
    protected $sliderModel;

    public function __construct()
    {
        $this->sliderModel = new SliderModel();
    }

    public function index()
    {
        $data = [
            'title'   => 'Kelola Slider',
            'sliders' => $this->sliderModel->orderBy('urutan', 'ASC')->findAll()
        ];

        return view('admin/slider/index', $data);
    }

    public function simpan()
    {
        // 1. Ambil File Upload
        $fileGambar = $this->request->getFile('gambar');

        // 2. Cek apakah file benar-benar terunggah dari form/PHP
        if (!$fileGambar || !$fileGambar->isValid()) {
            $errorMessage = $fileGambar ? $fileGambar->getErrorString() : 'File gambar tidak ditemukan.';
            return redirect()->back()->withInput()->with('gagal', 'Gagal unggah: ' . $errorMessage);
        }

        // 3. Validasi Aturan File
        $rules = [
            'judul'  => 'permit_empty|string',
            'gambar' => [
                'rules'  => 'max_size[gambar,2048]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png,image/webp]',
                'errors' => [
                    'max_size' => 'Ukuran gambar maksimal 2MB.',
                    'is_image' => 'File harus berupa gambar.',
                    'mime_in'  => 'Format gambar harus JPG, JPEG, PNG, atau WEBP.'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // 4. Pindahkan File ke Folder Tujuan
        $namaGambar = $fileGambar->getRandomName();
        $targetPath = FCPATH . 'uploads/slider';

        if (!is_dir($targetPath)) {
            mkdir($targetPath, 0777, true);
        }

        $fileGambar->move($targetPath, $namaGambar);

        // 5. Simpan Data ke Database
        $data = [
            'judul'     => $this->request->getPost('judul'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'gambar'    => $namaGambar,
            'link'      => $this->request->getPost('link'),
            'urutan'    => $this->request->getPost('urutan') ?: 0,
            'status'    => $this->request->getPost('status') ?: 'aktif'
        ];

        if ($this->sliderModel->insert($data)) {
            return redirect()->to(base_url('admin/slider'))->with('sukses', 'Data slider berhasil ditambahkan.');
        }

        return redirect()->back()->withInput()->with('gagal', 'Gagal menyimpan data ke database.');
    }

    public function update($id = null)
    {
        // 1. Cek keberadaan data
        $sliderLama = $this->sliderModel->find($id);
        if (!$sliderLama) {
            return redirect()->to(base_url('admin/slider'))->with('gagal', 'Data slider tidak ditemukan.');
        }

        // 2. Ambil File Upload (Opsional saat update)
        $fileGambar = $this->request->getFile('gambar');
        $namaGambar = $sliderLama['gambar'];

        if ($fileGambar && $fileGambar->isValid() && !$fileGambar->hasMoved()) {
            // Validasi file baru jika diunggah
            $rules = [
                'gambar' => [
                    'rules'  => 'max_size[gambar,2048]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png,image/webp]',
                    'errors' => [
                        'max_size' => 'Ukuran gambar maksimal 2MB.',
                        'is_image' => 'File harus berupa gambar.',
                        'mime_in'  => 'Format gambar harus JPG, JPEG, PNG, atau WEBP.'
                    ]
                ]
            ];

            if (!$this->validate($rules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            // Hapus gambar lama jika ada
            $pathLama = FCPATH . 'uploads/slider/' . $sliderLama['gambar'];
            if (file_exists($pathLama) && is_file($pathLama)) {
                unlink($pathLama);
            }

            // Pindahkan file baru
            $namaGambar = $fileGambar->getRandomName();
            $fileGambar->move(FCPATH . 'uploads/slider', $namaGambar);
        }

        // 3. Update Data
        $data = [
            'judul'     => $this->request->getPost('judul'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'gambar'    => $namaGambar,
            'link'      => $this->request->getPost('link'),
            'urutan'    => $this->request->getPost('urutan') ?: 0,
            'status'    => $this->request->getPost('status') ?: 'aktif'
        ];

        if ($this->sliderModel->update($id, $data)) {
            return redirect()->to(base_url('admin/slider'))->with('sukses', 'Data slider berhasil diperbarui.');
        }

        return redirect()->back()->withInput()->with('gagal', 'Gagal memperbarui data.');
    }

    public function delete($id = null)
    {
        $slider = $this->sliderModel->find($id);
        if ($slider) {
            // Hapus berkas gambar di server
            $pathGambar = FCPATH . 'uploads/slider/' . $slider['gambar'];
            if (file_exists($pathGambar) && is_file($pathGambar)) {
                unlink($pathGambar);
            }

            $this->sliderModel->delete($id);
            return redirect()->to(base_url('admin/slider'))->with('sukses', 'Data slider berhasil dihapus.');
        }

        return redirect()->to(base_url('admin/slider'))->with('gagal', 'Data tidak ditemukan.');
    }
}
