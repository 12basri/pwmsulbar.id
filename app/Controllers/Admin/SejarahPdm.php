<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SejarahPdmModel;

class SejarahPdm extends BaseController
{
    protected $sejarahPdmModel;

    public function __construct()
    {
        $this->sejarahPdmModel = new SejarahPdmModel();
    }

    public function index()
    {
        $keyword     = $this->request->getGet('q');
        $filterTahun = $this->request->getGet('tahun');

        $builder = $this->sejarahPdmModel;

        if (!empty($keyword)) {
            $builder->groupStart()
                ->like('nama_pdm', $keyword)
                ->orLike('isi', $keyword)
                ->groupEnd();
        }

        if (!empty($filterTahun)) {
            $builder->where('tahun', $filterTahun);
        }

        $data = [
            'sejarahPdm'  => $builder->findAll(), // Mengirim variabel $sejarahPdm ke View
            'keyword'     => $keyword,
            'filterTahun' => $filterTahun
        ];

        return view('admin/sejarah_pdm/index', $data);
    }

    public function simpan()
    {
        $gambar     = $this->request->getFile('gambar');
        $namaGambar = null;

        if ($gambar && $gambar->isValid() && !$gambar->hasMoved()) {
            $namaGambar = $gambar->getRandomName();
            $gambar->move('uploads/sejarah', $namaGambar);
        }

        $this->sejarahPdmModel->save([
            'nama_pdm' => $this->request->getPost('nama_pdm'),
            'tahun'    => $this->request->getPost('tahun'),
            'isi'      => $this->request->getPost('isi'),
            'gambar'   => $namaGambar,
        ]);

        return redirect()->to(base_url('admin/sejarah-pdm'))->with('sukses', 'Data berhasil disimpan!');
    }

    public function update($id)
    {
        $sejarah = $this->sejarahPdmModel->find($id);
        if (!$sejarah) {
            return redirect()->to(base_url('admin/sejarah-pdm'))->with('gagal', 'Data tidak ditemukan!');
        }

        $gambar     = $this->request->getFile('gambar');
        $namaGambar = $sejarah['gambar'];

        if ($gambar && $gambar->isValid() && !$gambar->hasMoved()) {
            if ($namaGambar && file_exists('uploads/sejarah/' . $namaGambar)) {
                unlink('uploads/sejarah/' . $namaGambar);
            }
            $namaGambar = $gambar->getRandomName();
            $gambar->move('uploads/sejarah', $namaGambar);
        }

        $this->sejarahPdmModel->update($id, [
            'nama_pdm' => $this->request->getPost('nama_pdm'),
            'tahun'    => $this->request->getPost('tahun'),
            'isi'      => $this->request->getPost('isi'),
            'gambar'   => $namaGambar,
        ]);

        return redirect()->to(base_url('admin/sejarah-pdm'))->with('sukses', 'Data berhasil diperbarui!');
    }

    public function hapus($id)
    {
        $sejarah = $this->sejarahPdmModel->find($id);
        if ($sejarah) {
            if ($sejarah['gambar'] && file_exists('uploads/sejarah/' . $sejarah['gambar'])) {
                unlink('uploads/sejarah/' . $sejarah['gambar']);
            }
            $this->sejarahPdmModel->delete($id);
            return redirect()->to(base_url('admin/sejarah-pdm'))->with('sukses', 'Data berhasil dihapus!');
        }

        return redirect()->to(base_url('admin/sejarah-pdm'))->with('gagal', 'Data gagal dihapus!');
    }
}
