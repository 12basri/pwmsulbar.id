<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\WebsitePdmModel;

class WebsitePdm extends BaseController
{
    protected $websitePdmModel;

    public function __construct()
    {
        $this->websitePdmModel = new WebsitePdmModel();
    }

    public function index()
    {
        $data = [
            'title'       => 'Daftar Website PDM',
            'website_pdm' => $this->websitePdmModel->orderBy('id_website', 'DESC')->findAll()
        ];

        return view('website_pdm/index', $data);
    }

    public function simpan()
    {
        $rules = [
            'nama_pdm' => [
                'rules'  => 'required|min_length[3]',
                'errors' => [
                    'required'   => 'Nama PDM wajib diisi.',
                    'min_length' => 'Nama PDM minimal 3 karakter.'
                ]
            ],
            'url' => [
                'rules'  => 'required|valid_url',
                'errors' => [
                    'required'  => 'URL Website wajib diisi.',
                    'valid_url' => 'Format URL tidak valid (gunakan http:// atau https://).'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->websitePdmModel->save([
            'nama_pdm'   => $this->request->getPost('nama_pdm'),
            'url'        => $this->request->getPost('url'),
            'keterangan' => $this->request->getPost('keterangan')
        ]);

        return redirect()->to(base_url('admin/website-pdm'))->with('success', 'Data Website PDM berhasil ditambahkan.');
    }

    public function update($id = null)
    {
        $rules = [
            'nama_pdm' => [
                'rules'  => 'required|min_length[3]',
                'errors' => [
                    'required'   => 'Nama PDM wajib diisi.',
                    'min_length' => 'Nama PDM minimal 3 karakter.'
                ]
            ],
            'url' => [
                'rules'  => 'required|valid_url',
                'errors' => [
                    'required'  => 'URL Website wajib diisi.',
                    'valid_url' => 'Format URL tidak valid (gunakan http:// atau https://).'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->websitePdmModel->update($id, [
            'nama_pdm'   => $this->request->getPost('nama_pdm'),
            'url'        => $this->request->getPost('url'),
            'keterangan' => $this->request->getPost('keterangan')
        ]);

        return redirect()->to(base_url('admin/website-pdm'))->with('success', 'Data Website PDM berhasil diperbarui.');
    }

    public function hapus($id = null)
    {
        $data = $this->websitePdmModel->find($id);
        if ($data) {
            $this->websitePdmModel->delete($id);
            return redirect()->to(base_url('admin/website-pdm'))->with('success', 'Data Website PDM berhasil dihapus.');
        }

        return redirect()->to(base_url('admin/website-pdm'))->with('error', 'Data tidak ditemukan.');
    }
}
