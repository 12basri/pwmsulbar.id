<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\RefleksiModel;

class Refleksi extends BaseController
{
    protected $refleksiModel;

    public function __construct()
    {
        $this->refleksiModel = new RefleksiModel();
    }

    // 1. Menampilkan Halaman Utama / Daftar Refleksi
    public function index()
    {
        $data = [
            'title'        => 'Kelola Refleksi',
            'dataRefleksi' => $this->refleksiModel->orderBy('created_at', 'DESC')->findAll()
        ];

        return view('admin/refleksi', $data);
    }

    // 2. Memproses Simpan Data (Bisa untuk Tambah Baru maupun Update)
    public function simpan()
    {
        // Validasi Sederhana
        if (!$this->validate([
            'judul' => [
                'rules'  => 'required|min_length[3]',
                'errors' => [
                    'required'   => 'Judul refleksi wajib diisi.',
                    'min_length' => 'Judul minimal berisi 3 karakter.'
                ]
            ],
            'isi' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Isi refleksi tidak boleh kosong.'
                ]
            ]
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Tangkap ID jika berasal dari form edit
        $id = $this->request->getPost('id_refleksi');

        $dataSave = [
            'judul'   => $this->request->getPost('judul'),
            'isi'     => $this->request->getPost('isi'),
            'tanggal' => $this->request->getPost('tanggal') ?: date('Y-m-d'),
            'penulis' => session()->get('user_name') ?? 'Admin'
        ];

        // Jika $id tidak kosong, masukkan ke array agar method save() menjalankan UPDATE
        if (!empty($id)) {
            $dataSave['id_refleksi'] = $id;
            $pesan = 'Data refleksi berhasil diperbarui!';
        } else {
            $pesan = 'Data refleksi berhasil ditambahkan!';
        }

        $this->refleksiModel->save($dataSave);

        return redirect()->to(base_url('admin/refleksi'))->with('success', $pesan);
    }

    // 3. Memproses Hapus Data
    public function hapus($id = null)
    {
        if ($id) {
            // Cek apakah data dengan ID tersebut ada di DB
            $refleksi = $this->refleksiModel->find($id);

            if ($refleksi) {
                $this->refleksiModel->delete($id);
                return redirect()->to(base_url('admin/refleksi'))->with('success', 'Data berhasil dihapus!');
            }
        }

        return redirect()->to(base_url('admin/refleksi'))->with('error', 'Data tidak ditemukan!');
    }
}
