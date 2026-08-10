<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PengurusPdmModel;

class PengurusPdm extends BaseController
{
    protected $pengurusModel;

    public function __construct()
    {
        $this->pengurusModel = new PengurusPdmModel();
    }

    public function index()
    {
        $data = [
            'title'    => 'Data Pengurus PDM',
            'pengurus' => $this->pengurusModel->orderBy('id_pengurus', 'DESC')->findAll()
        ];

        return view('admin/pengurus_pdm/index', $data);
    }

    public function simpan()
    {
        $rules = [
            'nama'    => 'required|min_length[3]',
            'jabatan' => 'required',
            'pdm'     => 'required',
            'periode' => 'required',
            'foto'    => 'permit_empty|max_size[foto,2048]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png,image/webp]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $fileFoto = $this->request->getFile('foto');
        $namaFoto = null;

        if ($fileFoto && $fileFoto->isValid() && !$fileFoto->hasMoved()) {
            $namaFoto = $fileFoto->getRandomName();
            $fileFoto->move(FCPATH . 'uploads/pengurus', $namaFoto);
        }

        $this->pengurusModel->insert([
            'nama'    => $this->request->getPost('nama'),
            'jabatan' => $this->request->getPost('jabatan'),
            'pdm'     => $this->request->getPost('pdm'),
            'periode' => $this->request->getPost('periode'),
            'foto'    => $namaFoto
        ]);

        return redirect()->to(site_url('admin/pengurus-pdm'))->with('success', 'Data pengurus berhasil ditambahkan.');
    }

    public function update($id)
    {
        $pengurus = $this->pengurusModel->find($id);
        if (!$pengurus) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }

        $rules = [
            'nama'    => 'required|min_length[3]',
            'jabatan' => 'required',
            'pdm'     => 'required',
            'periode' => 'required',
            'foto'    => 'permit_empty|max_size[foto,2048]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png,image/webp]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $fileFoto = $this->request->getFile('foto');
        $namaFoto = $pengurus['foto'];

        if ($fileFoto && $fileFoto->isValid() && !$fileFoto->hasMoved()) {
            // Hapus foto lama jika ada
            if ($namaFoto && file_exists(FCPATH . 'uploads/pengurus/' . $namaFoto)) {
                unlink(FCPATH . 'uploads/pengurus/' . $namaFoto);
            }
            $namaFoto = $fileFoto->getRandomName();
            $fileFoto->move(FCPATH . 'uploads/pengurus', $namaFoto);
        }

        $this->pengurusModel->update($id, [
            'nama'    => $this->request->getPost('nama'),
            'jabatan' => $this->request->getPost('jabatan'),
            'pdm'     => $this->request->getPost('pdm'),
            'periode' => $this->request->getPost('periode'),
            'foto'    => $namaFoto
        ]);

        return redirect()->to(site_url('admin/pengurus-pdm'))->with('success', 'Data pengurus berhasil diperbarui.');
    }

    public function hapus($id)
    {
        $pengurus = $this->pengurusModel->find($id);

        if ($pengurus) {
            // Hapus berkas foto jika ada
            if ($pengurus['foto'] && file_exists(FCPATH . 'uploads/pengurus/' . $pengurus['foto'])) {
                unlink(FCPATH . 'uploads/pengurus/' . $pengurus['foto']);
            }
            $this->pengurusModel->delete($id);
            return redirect()->to(site_url('admin/pengurus-pdm'))->with('success', 'Data pengurus berhasil dihapus.');
        }

        return redirect()->back()->with('error', 'Data tidak ditemukan.');
    }
}
