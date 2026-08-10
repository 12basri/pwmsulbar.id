<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\OpiniModel;

class Opini extends BaseController
{
    protected $opiniModel;

    public function __construct()
    {
        $this->opiniModel = new OpiniModel();
    }

    // Tampil seluruh data opini
    public function index()
    {
        $data = [
            'title' => 'Kelola Data Opini',
            'opini' => $this->opiniModel->orderBy('id_opini', 'DESC')->findAll()
        ];
        return view('admin/opini/index', $data);
    }

    // Form Tambah Opini
    public function tambah()
    {
        $data = [
            'title'      => 'Tambah Opini Baru',
            'validation' => \Config\Services::validation()
        ];
        return view('admin/opini/tambah', $data);
    }

    // Proses Simpan Data
    public function simpan()
    {
        if (!$this->validate([
            'judul' => [
                'rules'  => 'required|is_unique[opini.judul]',
                'errors' => [
                    'required'  => 'Judul opini wajib diisi.',
                    'is_unique' => 'Judul opini sudah pernah ada.'
                ]
            ],
            'isi' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Isi opini tidak boleh kosong.']
            ],
            'gambar' => [
                'rules'  => 'max_size[gambar,2048]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png,image/webp]',
                'errors' => [
                    'max_size' => 'Ukuran gambar maksimal 2MB.',
                    'is_image' => 'File wajib berformat gambar.',
                    'mime_in'  => 'Format harus JPG, JPEG, PNG, atau WEBP.'
                ]
            ]
        ])) {
            return redirect()->to('/admin/opini/tambah')->withInput();
        }

        // Handle upload file gambar
        $fileGambar = $this->request->getFile('gambar');
        $namaGambar = null;

        if ($fileGambar && $fileGambar->isValid() && !$fileGambar->hasMoved()) {
            $namaGambar = $fileGambar->getRandomName();
            $fileGambar->move('uploads/opini', $namaGambar);
        }

        // Generate Slug URL otomatis
        $slug = url_title($this->request->getVar('judul'), '-', true);

        $this->opiniModel->save([
            'judul'           => $this->request->getVar('judul'),
            'slug'            => $slug,
            'isi'             => $this->request->getVar('isi'),
            'gambar'          => $namaGambar,
            'penulis'         => $this->request->getVar('penulis'),
            'profesi_penulis' => $this->request->getVar('profesi_penulis'),
            'tanggal'         => $this->request->getVar('tanggal') ?: date('Y-m-d'),
            'status'          => $this->request->getVar('status') ?: 'Draft',
            'views'           => 0
        ]);

        session()->setFlashdata('pesan', 'Data opini berhasil ditambahkan.');
        return redirect()->to('/admin/opini');
    }

    // Form Edit Data
    public function edit($id)
    {
        $opini = $this->opiniModel->find($id);

        if (!$opini) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Data opini tidak ditemukan.');
        }

        $data = [
            'title'      => 'Edit Opini',
            'opini'      => $opini,
            'validation' => \Config\Services::validation()
        ];
        return view('admin/opini/edit', $data);
    }

    // Proses Update Data
    public function update($id)
    {
        $opiniLama = $this->opiniModel->find($id);
        $ruleJudul = ($opiniLama['judul'] == $this->request->getVar('judul')) ? 'required' : 'required|is_unique[opini.judul]';

        if (!$this->validate([
            'judul' => [
                'rules'  => $ruleJudul,
                'errors' => [
                    'required'  => 'Judul opini wajib diisi.',
                    'is_unique' => 'Judul opini sudah ada.'
                ]
            ],
            'isi' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Isi opini tidak boleh kosong.']
            ],
            'gambar' => [
                'rules'  => 'max_size[gambar,2048]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png,image/webp]',
                'errors' => [
                    'max_size' => 'Ukuran gambar maksimal 2MB.',
                    'is_image' => 'File wajib berformat gambar.',
                    'mime_in'  => 'Format harus JPG, JPEG, PNG, atau WEBP.'
                ]
            ]
        ])) {
            return redirect()->to('/admin/opini/edit/' . $id)->withInput();
        }

        $fileGambar = $this->request->getFile('gambar');

        if ($fileGambar && $fileGambar->isValid() && !$fileGambar->hasMoved()) {
            $namaGambar = $fileGambar->getRandomName();
            $fileGambar->move('uploads/opini', $namaGambar);

            // Hapus gambar lama jika ada
            if ($opiniLama['gambar'] && file_exists('uploads/opini/' . $opiniLama['gambar'])) {
                unlink('uploads/opini/' . $opiniLama['gambar']);
            }
        } else {
            $namaGambar = $opiniLama['gambar'];
        }

        $slug = url_title($this->request->getVar('judul'), '-', true);

        $this->opiniModel->update($id, [
            'judul'           => $this->request->getVar('judul'),
            'slug'            => $slug,
            'isi'             => $this->request->getVar('isi'),
            'gambar'          => $namaGambar,
            'penulis'         => $this->request->getVar('penulis'),
            'profesi_penulis' => $this->request->getVar('profesi_penulis'),
            'tanggal'         => $this->request->getVar('tanggal'),
            'status'          => $this->request->getVar('status')
        ]);

        session()->setFlashdata('pesan', 'Data opini berhasil diperbarui.');
        return redirect()->to('/admin/opini');
    }

    // Hapus Data
    public function hapus($id)
    {
        $opini = $this->opiniModel->find($id);

        if ($opini) {
            if ($opini['gambar'] && file_exists('uploads/opini/' . $opini['gambar'])) {
                unlink('uploads/opini/' . $opini['gambar']);
            }
            $this->opiniModel->delete($id);
            session()->setFlashdata('pesan', 'Data opini berhasil dihapus.');
        }

        return redirect()->to('/admin/opini');
    }
}