<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AumModel;

class Aum extends BaseController
{
    protected $aumModel;

    public function __construct()
    {
        $this->aumModel = new AumModel();
    }

    public function index()
    {
        // 1. Ambil Parameter Filter dari Query String (GET)
        $keyword   = $this->request->getGet('q');
        $jenis     = $this->request->getGet('jenis');
        $kabupaten = $this->request->getGet('kabupaten_kota');
        $kecamatan = $this->request->getGet('kecamatan');

        // 2. Query Data Tabel AUM dengan Filter
        $builder = $this->aumModel;

        if (!empty($keyword)) {
            $builder->groupStart()
                ->like('nama_aum', $keyword)
                ->orLike('pimpinan', $keyword)
                ->orLike('alamat', $keyword)
                ->orLike('kecamatan', $keyword)
                ->orLike('kabupaten_kota', $keyword)
                ->groupEnd();
        }

        if (!empty($jenis)) {
            $builder->where('jenis', $jenis);
        }

        if (!empty($kabupaten)) {
            $builder->where('kabupaten_kota', $kabupaten);
        }

        if (!empty($kecamatan)) {
            $builder->where('kecamatan', $kecamatan);
        }

        // 3. Ambil Nilai Unik Langsung dari Database untuk Opsi Filter Dinamis
        $jenisList     = $this->getDistinctValues('jenis');
        $kabupatenList = $this->getDistinctValues('kabupaten_kota');
        $kecamatanList = $this->getDistinctValues('kecamatan');

        // 4. Kirimkan Data ke View
        $data = [
            'title'           => 'Data Amal Usaha Muhammadiyah',
            'aumList'         => $builder->findAll(),
            'keyword'         => $keyword,
            'filterJenis'     => $jenis,
            'filterKabupaten' => $kabupaten,
            'filterKecamatan' => $kecamatan,
            'jenisList'       => $jenisList,
            'kabupatenList'   => $kabupatenList,
            'kecamatanList'   => $kecamatanList,
        ];

        return view('admin/aum/index', $data);
    }

    // Method Simpan Data Baru
    public function simpan()
    {
        $fileFoto = $this->request->getFile('foto');
        $namaFoto = null;

        if ($fileFoto && $fileFoto->isValid() && !$fileFoto->hasMoved()) {
            $namaFoto = $fileFoto->getRandomName();
            $fileFoto->move(FCPATH . 'uploads/aum', $namaFoto);
        }

        $this->aumModel->save([
            'nama_aum'       => $this->request->getPost('nama_aum'),
            'jenis'          => $this->request->getPost('jenis'),
            'pimpinan'       => $this->request->getPost('pimpinan'),
            'kabupaten_kota' => $this->request->getPost('kabupaten_kota'),
            'kecamatan'      => $this->request->getPost('kecamatan'),
            'telepon'        => $this->request->getPost('telepon'),
            'email'          => $this->request->getPost('email'),
            'maps'           => $this->request->getPost('maps'),
            'website'        => $this->request->getPost('website'),
            'alamat'         => $this->request->getPost('alamat'),
            'deskripsi'      => $this->request->getPost('deskripsi'),
            'foto'           => $namaFoto,
        ]);

        return redirect()->to(base_url('admin/aum'))->with('sukses', 'Data AUM berhasil ditambahkan!');
    }

    // Method Update Data
    public function update($id = null)
    {
        $aumLama = $this->aumModel->find($id);
        if (!$aumLama) {
            return redirect()->to(base_url('admin/aum'));
        }

        $fileFoto = $this->request->getFile('foto');
        $namaFoto = $aumLama['foto'];

        if ($fileFoto && $fileFoto->isValid() && !$fileFoto->hasMoved()) {
            // Hapus foto lama jika ada
            if (!empty($aumLama['foto']) && file_exists(FCPATH . 'uploads/aum/' . $aumLama['foto'])) {
                unlink(FCPATH . 'uploads/aum/' . $aumLama['foto']);
            }
            $namaFoto = $fileFoto->getRandomName();
            $fileFoto->move(FCPATH . 'uploads/aum', $namaFoto);
        }

        $this->aumModel->update($id, [
            'nama_aum'       => $this->request->getPost('nama_aum'),
            'jenis'          => $this->request->getPost('jenis'),
            'pimpinan'       => $this->request->getPost('pimpinan'),
            'kabupaten_kota' => $this->request->getPost('kabupaten_kota'),
            'kecamatan'      => $this->request->getPost('kecamatan'),
            'telepon'        => $this->request->getPost('telepon'),
            'email'          => $this->request->getPost('email'),
            'maps'           => $this->request->getPost('maps'),
            'website'        => $this->request->getPost('website'),
            'alamat'         => $this->request->getPost('alamat'),
            'deskripsi'      => $this->request->getPost('deskripsi'),
            'foto'           => $namaFoto,
        ]);

        return redirect()->to(base_url('admin/aum'))->with('sukses', 'Data AUM berhasil diperbarui!');
    }

    // Method Hapus Data
    public function hapus($id = null)
    {
        $aum = $this->aumModel->find($id);
        if ($aum) {
            if (!empty($aum['foto']) && file_exists(FCPATH . 'uploads/aum/' . $aum['foto'])) {
                unlink(FCPATH . 'uploads/aum/' . $aum['foto']);
            }
            $this->aumModel->delete($id);
        }

        return redirect()->to(base_url('admin/aum'))->with('sukses', 'Data AUM berhasil dihapus!');
    }

    // Helper Method Internal
    private function getDistinctValues(string $field): array
    {
        $results = $this->aumModel
            ->select($field)
            ->where("$field IS NOT NULL")
            ->where("$field !=", '')
            ->groupBy($field)
            ->orderBy($field, 'ASC')
            ->findAll();

        return array_column($results, $field);
    }
}
