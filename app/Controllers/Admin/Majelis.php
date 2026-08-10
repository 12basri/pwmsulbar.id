<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\MajelisModel;

class Majelis extends BaseController
{
    protected $majelisModel;
    protected $db;

    public function __construct()
    {
        // Load helper url (untuk slug) dan form secara otomatis
        helper(['url', 'form']);
        $this->majelisModel = new MajelisModel();
        $this->db           = \Config\Database::connect();
    }

    public function index()
    {
        $keyword = $this->request->getGet('q');

        $data = [
            'title'   => 'Data Majelis & Lembaga',
            'keyword' => $keyword,
            'majelis' => $this->majelisModel->search($keyword)->paginate(10, 'default'),
            'pager'   => $this->majelisModel->pager,
        ];

        return view('admin/majelis/index', $data);
    }

    public function detail($id)
    {
        $majelis = $this->majelisModel->find($id);
        if (!$majelis) {
            return redirect()->to(base_url('admin/majelis'))->with('gagal', 'Data majelis tidak ditemukan.');
        }

        // Ambil data bidang beserta anggotanya
        $bidang = $this->db->table('majelis_bidang')->where('id_majelis', $id)->orderBy('urutan', 'ASC')->get()->getResultArray();
        foreach ($bidang as &$b) {
            $b['anggota'] = $this->db->table('majelis_anggota_bidang')->where('id_bidang', $b['id_bidang'])->orderBy('urutan', 'ASC')->get()->getResultArray();
        }

        $data = [
            'title'    => 'Kelola Data - ' . $majelis['nama_majelis'],
            'majelis'  => $majelis,
            'pimpinan' => $this->db->table('majelis_pimpinan')->where('id_majelis', $id)->orderBy('urutan', 'ASC')->get()->getResultArray(),
            'pakar'    => $this->db->table('majelis_pakar')->where('id_majelis', $id)->orderBy('urutan', 'ASC')->get()->getResultArray(),
            'bidang'   => $bidang
        ];

        return view('admin/majelis/detail', $data);
    }

    public function anggota($idMajelis)
    {
        $majelis = $this->majelisModel->find($idMajelis);
        if (!$majelis) {
            return redirect()->to(base_url('admin/majelis'))->with('gagal', 'Data majelis tidak ditemukan.');
        }

        $bidang = $this->db->table('majelis_bidang')->where('id_majelis', $idMajelis)->orderBy('urutan', 'ASC')->get()->getResultArray();
        foreach ($bidang as &$b) {
            $b['anggota'] = $this->db->table('majelis_anggota_bidang')->where('id_bidang', $b['id_bidang'])->orderBy('urutan', 'ASC')->get()->getResultArray();
        }

        $data = [
            'title'   => 'Kelola Anggota - ' . $majelis['nama_majelis'],
            'majelis' => $majelis,
            'bidang'  => $bidang,
        ];

        return view('admin/majelis/anggota', $data);
    }

    // --- PROSES SIMPAN MAJELIS UTAMA ---
    public function simpan()
    {
        $data = [
            'jenis'              => $this->request->getPost('jenis') ?? 'Majelis',
            'nama_majelis'       => $this->request->getPost('nama_majelis'),
            'deskripsi_singkat'  => $this->request->getPost('deskripsi_singkat') ?? $this->request->getPost('deskripsi'),
            'nomor_sk'           => $this->request->getPost('nomor_sk'),
            'tanggal_sk_masehi'  => $this->request->getPost('tanggal_sk_masehi') ?: null,
            'tanggal_sk_hijriah' => $this->request->getPost('tanggal_sk_hijriah') ?: null,
            'periode'            => $this->request->getPost('periode') ?? '2022-2027',
            'ditetapkan_oleh'    => $this->request->getPost('ditetapkan_oleh') ?: null,
            'urutan'             => $this->request->getPost('urutan') ?? 0,
            'status'             => 'aktif'
        ];

        if (!$this->majelisModel->insert($data)) {
            $errors = $this->majelisModel->errors() ?: $this->db->error()['message'];
            return redirect()->back()->withInput()->with('gagal', 'Gagal menambah data: ' . (is_array($errors) ? implode(', ', $errors) : $errors));
        }

        return redirect()->to(base_url('admin/majelis'))->with('sukses', 'Majelis berhasil ditambahkan.');
    }

    // --- PROSES UPDATE MAJELIS UTAMA ---
    public function update($id)
    {
        $majelis = $this->majelisModel->find($id);
        if (!$majelis) {
            return redirect()->to(base_url('admin/majelis'))->with('gagal', 'Data majelis tidak ditemukan.');
        }

        $namaBaru = $this->request->getPost('nama_majelis');

        $data = [
            'jenis'              => $this->request->getPost('jenis') ?? $majelis['jenis'],
            'nama_majelis'       => $namaBaru ?: $majelis['nama_majelis'],
            'deskripsi_singkat'  => $this->request->getPost('deskripsi_singkat') ?? $this->request->getPost('deskripsi') ?? $majelis['deskripsi_singkat'],
            'nomor_sk'           => $this->request->getPost('nomor_sk') ?? $majelis['nomor_sk'],
            'tanggal_sk_masehi'  => $this->request->getPost('tanggal_sk_masehi') ?: $majelis['tanggal_sk_masehi'],
            'tanggal_sk_hijriah' => $this->request->getPost('tanggal_sk_hijriah') ?: $majelis['tanggal_sk_hijriah'],
            'periode'            => $this->request->getPost('periode') ?? $majelis['periode'],
            'ditetapkan_oleh'    => $this->request->getPost('ditetapkan_oleh') ?: $majelis['ditetapkan_oleh'],
            'urutan'             => $this->request->getPost('urutan') ?? $majelis['urutan'],
            'status'             => $this->request->getPost('status') ?? $majelis['status']
        ];

        if ($this->majelisModel->update($id, $data) === false) {
            $errors = $this->majelisModel->errors() ?: $this->db->error()['message'];
            return redirect()->back()->withInput()->with('gagal', 'Gagal memperbarui data: ' . (is_array($errors) ? implode(', ', $errors) : $errors));
        }

        return redirect()->back()->with('sukses', 'Data majelis berhasil diperbarui.');
    }

    public function hapus($id)
    {
        $majelis = $this->majelisModel->find($id);
        if (!$majelis) {
            return redirect()->to(base_url('admin/majelis'))->with('gagal', 'Data majelis tidak ditemukan.');
        }

        $this->majelisModel->delete($id);
        return redirect()->to(base_url('admin/majelis'))->with('sukses', 'Majelis berhasil dihapus.');
    }

    // --- KELOLA RELASI: PIMPINAN ---
    public function simpanPimpinan($idMajelis)
    {
        $this->db->table('majelis_pimpinan')->insert([
            'id_majelis' => $idMajelis,
            'jabatan'    => $this->request->getPost('jabatan'),
            'nama'       => $this->request->getPost('nama'),
            'urutan'     => $this->request->getPost('urutan') ?? 1
        ]);
        return redirect()->back()->with('sukses', 'Pimpinan berhasil ditambahkan.');
    }

    public function hapusPimpinan($idPimpinan)
    {
        $this->db->table('majelis_pimpinan')->where('id_pimpinan', $idPimpinan)->delete();
        return redirect()->back()->with('sukses', 'Pimpinan berhasil dihapus.');
    }

    // --- KELOLA RELASI: PAKAR ---
    public function simpanPakar($idMajelis)
    {
        $this->db->table('majelis_pakar')->insert([
            'id_majelis' => $idMajelis,
            'nama'       => $this->request->getPost('nama'),
            'urutan'     => $this->request->getPost('urutan') ?? 1
        ]);
        return redirect()->back()->with('sukses', 'Dewan pakar berhasil ditambahkan.');
    }

    public function hapusPakar($idPakar)
    {
        $this->db->table('majelis_pakar')->where('id_pakar', $idPakar)->delete();
        return redirect()->back()->with('sukses', 'Dewan pakar berhasil dihapus.');
    }

    // --- KELOLA RELASI: BIDANG & ANGGOTA ---
    public function simpanBidang($idMajelis)
    {
        $this->db->table('majelis_bidang')->insert([
            'id_majelis'   => $idMajelis,
            'nama_bidang'  => $this->request->getPost('nama_bidang'),
            'ketua_bidang' => $this->request->getPost('ketua_bidang'),
            'urutan'       => $this->request->getPost('urutan') ?? 1
        ]);
        return redirect()->back()->with('sukses', 'Bidang berhasil dibuat.');
    }

    public function hapusBidang($idBidang)
    {
        $this->db->table('majelis_anggota_bidang')->where('id_bidang', $idBidang)->delete();
        $this->db->table('majelis_bidang')->where('id_bidang', $idBidang)->delete();
        return redirect()->back()->with('sukses', 'Bidang beserta anggotanya berhasil dihapus.');
    }

    public function simpanAnggota($idBidang)
    {
        $this->db->table('majelis_anggota_bidang')->insert([
            'id_bidang' => $idBidang,
            'nama'      => $this->request->getPost('nama'),
            'urutan'    => $this->request->getPost('urutan') ?? 1
        ]);
        return redirect()->back()->with('sukses', 'Anggota bidang berhasil ditambahkan.');
    }

    public function hapusAnggota($idAnggota)
    {
        $this->db->table('majelis_anggota_bidang')->where('id_anggota', $idAnggota)->delete();
        return redirect()->back()->with('sukses', 'Anggota bidang berhasil dihapus.');
    }
}
