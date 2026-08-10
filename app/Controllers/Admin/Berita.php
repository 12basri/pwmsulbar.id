<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BeritaModel;

class Berita extends BaseController
{
    protected $beritaModel;

    public function __construct()
    {
        $this->beritaModel = new BeritaModel();
    }

    // Tampil daftar berita
    public function index()
    {
        $data = [
            'title'      => 'Manajemen Berita',
            'beritaList' => $this->beritaModel->orderBy('id_berita', 'DESC')->findAll()
        ];

        return view('admin/berita', $data);
    }

    // Simpan berita baru
    public function simpan()
    {
        $gambar = $this->request->getFile('gambar');
        $namaGambar = 'default.jpg';

        if ($gambar && $gambar->isValid() && !$gambar->hasMoved()) {
            $namaGambar = $gambar->getRandomName();
            // PERBAIKAN: Ubah path simpan ke public/uploads/berita/
            $gambar->move(ROOTPATH . 'public/uploads/berita', $namaGambar);
        }

        $this->beritaModel->save([
            'judul'   => $this->request->getPost('judul'),
            'slug'    => url_title($this->request->getPost('judul'), '-', true),
            'isi'     => $this->request->getPost('isi'),
            'penulis' => $this->request->getPost('penulis'),
            'tanggal' => $this->request->getPost('tanggal'),
            'status'  => $this->request->getPost('status'),
            'gambar'  => $namaGambar,
        ]);

        return redirect()->to(base_url('admin/berita'))->with('sukses', 'Berita berhasil ditambahkan.');
    }

    // Update berita
    public function update($id)
    {
        $beritaLama = $this->beritaModel->find($id);

        if (!$beritaLama) {
            return redirect()->to(base_url('admin/berita'))->with('errors', ['Berita tidak ditemukan.']);
        }

        $gambar = $this->request->getFile('gambar');
        $namaGambar = $beritaLama['gambar']; // Default menggunakan gambar lama

        // Cek apakah user mengunggah gambar baru
        if ($gambar && $gambar->isValid() && !$gambar->hasMoved()) {
            $namaGambar = $gambar->getRandomName();
            // PERBAIKAN: Ubah path simpan ke public/uploads/berita/
            $gambar->move(ROOTPATH . 'public/uploads/berita', $namaGambar);

            // Hapus gambar lama dari server jika ada dan bukan default.jpg
            if (!empty($beritaLama['gambar']) && $beritaLama['gambar'] !== 'default.jpg') {
                // PERBAIKAN: Ubah path hapus ke public/uploads/berita/
                $path = ROOTPATH . 'public/uploads/berita/' . $beritaLama['gambar'];
                if (file_exists($path)) {
                    unlink($path);
                }
            }
        }

        // Update data ke database
        $this->beritaModel->update($id, [
            'judul'   => $this->request->getPost('judul'),
            'slug'    => url_title($this->request->getPost('judul'), '-', true),
            'isi'     => $this->request->getPost('isi'),
            'penulis' => $this->request->getPost('penulis'),
            'tanggal' => $this->request->getPost('tanggal'),
            'status'  => $this->request->getPost('status'),
            'gambar'  => $namaGambar,
        ]);

        return redirect()->to(base_url('admin/berita'))->with('sukses', 'Berita berhasil diperbarui.');
    }

    // Hapus berita
    public function hapus($id)
    {
        $berita = $this->beritaModel->find($id);

        if ($berita) {
            // Hapus gambar fisik jika bukan default.jpg
            if (!empty($berita['gambar']) && $berita['gambar'] !== 'default.jpg') {
                // PERBAIKAN: Ubah path hapus ke public/uploads/berita/
                $path = ROOTPATH . 'public/uploads/berita/' . $berita['gambar'];
                if (file_exists($path)) {
                    unlink($path);
                }
            }
            $this->beritaModel->delete($id);
        }

        return redirect()->to(base_url('admin/berita'))->with('sukses', 'Berita berhasil dihapus.');
    }
}
