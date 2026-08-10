<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SekolahModel;

class Sekolah extends BaseController
{
    protected $sekolahModel;

    public function __construct()
    {
        $this->sekolahModel = new SekolahModel();
    }

    /**
     * Menampilkan daftar sekolah beserta filter, pencarian, & paginasi
     */
    public function index()
    {
        $keyword   = $this->request->getGet('q');
        $jenjang   = $this->request->getGet('jenjang');
        $kabupaten = $this->request->getGet('kabupaten');

        if (!empty($keyword)) {
            $this->sekolahModel->groupStart()
                ->like('nama_sekolah', $keyword)
                ->orLike('npsn', $keyword)
                ->orLike('kepala_sekolah', $keyword)
                ->orLike('kecamatan', $keyword)
                ->orLike('alamat', $keyword)
                ->groupEnd();
        }

        if (!empty($jenjang)) {
            $this->sekolahModel->where('jenjang', strtoupper($jenjang));
        }

        if (!empty($kabupaten)) {
            $this->sekolahModel->where('kabupaten_kota', $kabupaten);
        }

        $primaryKey = $this->sekolahModel->primaryKey;

        $data = [
            'title'           => 'Kelola Data Sekolah',
            'sekolahList'     => $this->sekolahModel->orderBy($primaryKey, 'DESC')->paginate(10, 'sekolah'),
            'pager'           => $this->sekolahModel->pager,
            'keyword'         => $keyword,
            'filterJenjang'   => $jenjang,
            'filterKabupaten' => $kabupaten,
        ];

        return view('admin/sekolah/index', $data);
    }

    /**
     * Menyimpan data sekolah baru
     */
    public function simpan()
    {
        $validationRules = [
            'nama_sekolah' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Nama sekolah harus diisi.']
            ],
            'jenjang' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Jenjang pendidikan harus dipilih.']
            ],
            'kabupaten_kota' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Kabupaten/Kota harus dipilih.']
            ],
            'kecamatan' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Kecamatan harus diisi.']
            ],
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->sekolahModel->save([
            'nama_sekolah'   => $this->request->getPost('nama_sekolah'),
            'npsn'           => $this->request->getPost('npsn') ?: null,
            'jenjang'        => strtoupper($this->request->getPost('jenjang')),
            'akreditasi'     => $this->request->getPost('akreditasi') ?: 'Belum Akreditasi',
            'kabupaten_kota' => $this->request->getPost('kabupaten_kota'),
            'kecamatan'      => $this->request->getPost('kecamatan'),
            'alamat'         => $this->request->getPost('alamat'),
            'kepala_sekolah' => $this->request->getPost('kepala_sekolah'),
        ]);

        return redirect()->to(base_url('admin/sekolah'))->with('sukses', 'Data sekolah berhasil ditambahkan.');
    }

    /**
     * Memperbarui data sekolah
     */
    public function update($id)
    {
        $sekolahLama = $this->sekolahModel->find($id);
        if (!$sekolahLama) {
            return redirect()->to(base_url('admin/sekolah'))->with('errors', ['Data sekolah tidak ditemukan.']);
        }

        $validationRules = [
            'nama_sekolah' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Nama sekolah harus diisi.']
            ],
            'jenjang' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Jenjang pendidikan harus dipilih.']
            ],
            'kabupaten_kota' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Kabupaten/Kota harus dipilih.']
            ],
            'kecamatan' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Kecamatan harus diisi.']
            ],
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->sekolahModel->update($id, [
            'nama_sekolah'   => $this->request->getPost('nama_sekolah'),
            'npsn'           => $this->request->getPost('npsn') ?: null,
            'jenjang'        => strtoupper($this->request->getPost('jenjang')),
            'akreditasi'     => $this->request->getPost('akreditasi') ?: 'Belum Akreditasi',
            'kabupaten_kota' => $this->request->getPost('kabupaten_kota'),
            'kecamatan'      => $this->request->getPost('kecamatan'),
            'alamat'         => $this->request->getPost('alamat'),
            'kepala_sekolah' => $this->request->getPost('kepala_sekolah'),
        ]);

        return redirect()->to(base_url('admin/sekolah'))->with('sukses', 'Data sekolah berhasil diperbarui.');
    }

    /**
     * Menghapus data sekolah
     */
    public function hapus($id)
    {
        $sekolah = $this->sekolahModel->find($id);

        if ($sekolah) {
            $this->sekolahModel->delete($id);
            return redirect()->to(base_url('admin/sekolah'))->with('sukses', 'Data sekolah berhasil dihapus.');
        }

        return redirect()->to(base_url('admin/sekolah'))->with('errors', ['Data sekolah gagal dihapus atau tidak ditemukan.']);
    }
}
