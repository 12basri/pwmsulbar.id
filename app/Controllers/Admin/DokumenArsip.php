<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\DokumenArsipModel;

class DokumenArsip extends BaseController
{
    protected $dokumenModel;

    public function __construct()
    {
        $this->dokumenModel = new DokumenArsipModel();
        helper(['form', 'url']);
    }

    public function index()
    {
        $keyword        = $this->request->getGet('q');
        $filterKategori = $this->request->getGet('kategori');
        $filterAkses    = $this->request->getGet('akses');

        $builder = $this->dokumenModel;

        if (!empty($keyword)) {
            $builder->groupStart()
                    ->like('judul', $keyword)
                    ->orLike('nomor_dokumen', $keyword)
                    ->orLike('deskripsi', $keyword)
                    ->groupEnd();
        }

        if (!empty($filterKategori)) {
            $builder->where('kategori', $filterKategori);
        }

        if (!empty($filterAkses)) {
            $builder->where('akses', $filterAkses);
        }

        $data = [
            'title'          => 'Manajemen Dokumen Arsip',
            'dokumen'        => $builder->orderBy('id_dokumen', 'DESC')->findAll(),
            'keyword'        => $keyword,
            'filterKategori' => $filterKategori,
            'filterAkses'    => $filterAkses,
        ];

        return view('admin/dokumen_arsip/index', $data);
    }

    public function simpan()
    {
        // 1. Validasi input teks
        $rules = [
            'judul_dokumen'   => 'required|min_length[3]|max_length[255]',
            'kategori'        => 'required',
            'tanggal_dokumen' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // 2. Ambil berkas file secara langsung
        $file = $this->request->getFile('file_dokumen');

        // Cek jika file belum dipilih
        if (!$file || $file->getError() === UPLOAD_ERR_NO_FILE) {
            return redirect()->back()->withInput()->with('gagal', 'Pilih file dokumen terlebih dahulu.');
        }

        // Cek jika terjadi kegagalan sistem saat upload
        if (!$file->isValid()) {
            return redirect()->back()->withInput()->with('gagal', 'Gagal mengunggah file: ' . $file->getErrorString());
        }

        // 3. Validasi Ekstensi & Ukuran File
        $allowedExts = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'zip', 'rar'];
        $ext         = strtolower($file->getClientExtension());
        $maxSize     = 10 * 1024 * 1024; // 10MB

        if (!in_array($ext, $allowedExts)) {
            return redirect()->back()->withInput()->with('gagal', 'Format file tidak didukung (Gunakan PDF, DOC, XLS, ZIP, RAR).');
        }

        if ($file->getSize() > $maxSize) {
            return redirect()->back()->withInput()->with('gagal', 'Ukuran file terlalu besar (Maksimal 10MB).');
        }

        // 4. Pindahkan File dan Simpan ke Database
        $uploadPath = FCPATH . 'uploads/dokumen/';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        $newName       = $file->getRandomName();
        $fileSize      = $this->formatBytes($file->getSize());
        $fileExtension = strtoupper($ext);

        $file->move($uploadPath, $newName);

        $data = [
            'judul'          => $this->request->getPost('judul_dokumen'),
            'nomor_dokumen'  => $this->request->getPost('nomor_dokumen'),
            'kategori'       => $this->request->getPost('kategori'),
            'nama_file'      => $newName,
            'ukuran_file'    => $fileSize,
            'tipe_file'      => $fileExtension,
            'tanggal_upload' => $this->request->getPost('tanggal_dokumen'),
            'akses'          => $this->request->getPost('akses') ?: 'Publik',
            'deskripsi'      => $this->request->getPost('keterangan'),
        ];

        $this->dokumenModel->insert($data);
        return redirect()->to(base_url('admin/dokumen-arsip'))->with('sukses', 'Dokumen berhasil disimpan!');
    }

    public function update($id)
    {
        $dokumenLama = $this->dokumenModel->find($id);
        if (!$dokumenLama) {
            return redirect()->to(base_url('admin/dokumen-arsip'))->with('gagal', 'Data dokumen tidak ditemukan.');
        }

        $rules = [
            'judul_dokumen'   => 'required|min_length[3]|max_length[255]',
            'kategori'        => 'required',
            'tanggal_dokumen' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $file          = $this->request->getFile('file_dokumen');
        $newName       = $dokumenLama['nama_file'];
        $fileSize      = $dokumenLama['ukuran_file'];
        $fileExtension = $dokumenLama['tipe_file'];

        // Cek jika pengguna memilih file baru
        if ($file && $file->getError() !== UPLOAD_ERR_NO_FILE) {
            if (!$file->isValid()) {
                return redirect()->back()->withInput()->with('gagal', 'Gagal mengunggah file baru: ' . $file->getErrorString());
            }

            $allowedExts = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'zip', 'rar'];
            $ext         = strtolower($file->getClientExtension());

            if (!in_array($ext, $allowedExts)) {
                return redirect()->back()->withInput()->with('gagal', 'Format file baru tidak didukung.');
            }

            if ($file->getSize() > 10 * 1024 * 1024) {
                return redirect()->back()->withInput()->with('gagal', 'Ukuran file baru terlalu besar (Maksimal 10MB).');
            }

            $uploadPath    = FCPATH . 'uploads/dokumen/';
            $newName       = $file->getRandomName();
            $fileSize      = $this->formatBytes($file->getSize());
            $fileExtension = strtoupper($ext);

            $file->move($uploadPath, $newName);

            // Hapus file lama jika ada
            if (!empty($dokumenLama['nama_file']) && file_exists($uploadPath . $dokumenLama['nama_file'])) {
                unlink($uploadPath . $dokumenLama['nama_file']);
            }
        }

        $data = [
            'judul'          => $this->request->getPost('judul_dokumen'),
            'nomor_dokumen'  => $this->request->getPost('nomor_dokumen'),
            'kategori'       => $this->request->getPost('kategori'),
            'nama_file'      => $newName,
            'ukuran_file'    => $fileSize,
            'tipe_file'      => $fileExtension,
            'tanggal_upload' => $this->request->getPost('tanggal_dokumen'),
            'akses'          => $this->request->getPost('akses') ?: 'Publik',
            'deskripsi'      => $this->request->getPost('keterangan'),
        ];

        $this->dokumenModel->update($id, $data);
        return redirect()->to(base_url('admin/dokumen-arsip'))->with('sukses', 'Dokumen berhasil diperbarui!');
    }

    public function download($id)
    {
        $dokumen = $this->dokumenModel->find($id);

        if ($dokumen && !empty($dokumen['nama_file'])) {
            $filePath = FCPATH . 'uploads/dokumen/' . $dokumen['nama_file'];
            if (file_exists($filePath)) {
                return $this->response->download($filePath, null);
            }
        }

        return redirect()->back()->with('gagal', 'File tidak ditemukan di server.');
    }

    public function hapus($id)
    {
        $dokumen = $this->dokumenModel->find($id);

        if ($dokumen) {
            if (!empty($dokumen['nama_file'])) {
                $filePath = FCPATH . 'uploads/dokumen/' . $dokumen['nama_file'];
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }

            $this->dokumenModel->delete($id);
            return redirect()->to(base_url('admin/dokumen-arsip'))->with('sukses', 'Dokumen berhasil dihapus!');
        }

        return redirect()->to(base_url('admin/dokumen-arsip'))->with('gagal', 'Dokumen tidak ditemukan.');
    }

    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow   = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow   = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}