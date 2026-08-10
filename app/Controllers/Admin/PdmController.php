<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PdmModel; // Sesuaikan jika nama Model Anda berbeda

class PdmController extends BaseController
{
    protected $pdmModel;

    public function __construct()
    {
        $this->pdmModel = new PdmModel();
    }

    // Menampilkan halaman utama tabel PDM (admin/pdm)
    public function index()
    {
        $keyword = $this->request->getGet('q');

        if ($keyword) {
            $this->pdmModel->like('nama_pdm', $keyword)
                           ->orLike('pimpinan', $keyword)
                           ->orLike('alamat', $keyword);
        }

        $data = [
            'title'   => 'Kelola Data PDM',
            'keyword' => $keyword,
            'pdmList' => $this->pdmModel->orderBy('id_pdm', 'DESC')->findAll(),
        ];

        return view('admin/pdm/index', $data);
    }

    // Mengambil data JSON untuk Modal Detail (admin/pdm/detail/1)
    public function detail($id = null)
    {
        if (!$id) {
            return $this->response->setJSON(['error' => 'ID tidak ditemukan'])->setStatusCode(400);
        }

        // Method kustom pada PdmModel jika ada relasi
        $dataComplete = method_exists($this->pdmModel, 'getPdmComplete') 
            ? $this->pdmModel->getPdmComplete($id) 
            : $this->pdmModel->find($id);

        if (!$dataComplete) {
            return $this->response->setJSON(['error' => 'Data tidak ditemukan'])->setStatusCode(404);
        }

        return $this->response->setJSON($dataComplete);
    }

    // Menyimpan data PDM terpadu (admin/pdm/store)
    public function store()
    {
        $pdmData = [
            'nama_pdm' => $this->request->getPost('nama_pdm'),
            'pimpinan' => $this->request->getPost('pimpinan'),
            'alamat'   => $this->request->getPost('alamat'),
            'telepon'  => $this->request->getPost('telepon'),
            'email'    => $this->request->getPost('email'),
        ];

        $pengurusData = $this->request->getPost('pengurus') ?? []; 
        $sejarahData  = $this->request->getPost('sejarah') ?? [];  
        $websiteData  = $this->request->getPost('website') ?? [];  

        // Filter array kosong dari input dinamis
        $pengurusData = array_filter($pengurusData, fn($item) => !empty($item['nama']));
        $sejarahData  = array_filter($sejarahData, fn($item) => !empty($item['isi']));
        $websiteData  = array_filter($websiteData, fn($item) => !empty($item['url']));

        if (method_exists($this->pdmModel, 'saveCompleteData')) {
            $simpan = $this->pdmModel->saveCompleteData($pdmData, $pengurusData, $sejarahData, $websiteData);
        } else {
            $simpan = $this->pdmModel->save($pdmData);
        }

        if ($simpan) {
            return redirect()->to('admin/pdm')->with('sukses', 'Data PDM berhasil disimpan.');
        } 

        return redirect()->back()->withInput()->with('gagal', 'Gagal menyimpan data PDM.');
    }

    // Menghapus data PDM (admin/pdm/delete/1)
    public function delete($id = null)
    {
        if ($id && $this->pdmModel->delete($id)) {
            return redirect()->to('admin/pdm')->with('sukses', 'Data PDM berhasil dihapus.');
        }

        return redirect()->to('admin/pdm')->with('gagal', 'Gagal menghapus data.');
    }
}