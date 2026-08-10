<?php

namespace App\Models;

use CodeIgniter\Model;

class PdmModel extends Model
{
    protected $table            = 'pdm';
    protected $primaryKey       = 'id_pdm';
    protected $allowedFields    = ['nama_pdm', 'pimpinan', 'alamat', 'telepon', 'email'];
    protected $useTimestamps    = true;

    // Mengambil 1 PDM beserta seluruh data relasinya untuk 1 View
    public function getPdmComplete($id)
    {
        $pdm = $this->find($id);
        if (!$pdm) {
            return null;
        }

        $db = \Config\Database::connect();

        return [
            'pdm'      => $pdm,
            'pengurus' => $db->table('pengurus_pdm')->where('id_pdm', $id)->get()->getResultArray(),
            'sejarah'  => $db->table('sejarah_pdm')->where('id_pdm', $id)->get()->getResultArray(),
            'website'  => $db->table('website_pdm')->where('id_pdm', $id)->get()->getResultArray(),
        ];
    }

    // Menyimpan input gabungan dari form tunggal ke 4 tabel sekaligus
    public function saveCompleteData($pdmData, $pengurusData = [], $sejarahData = [], $websiteData = [])
    {
        $db = \Config\Database::connect();
        $db->transStart(); // Mulai Database Transaction

        // 1. Insert ke tabel induk (pdm)
        $db->table('pdm')->insert($pdmData);
        $idPdm = $db->insertID();

        // 2. Insert ke tabel pengurus_pdm (jika ada input pengurus)
        if (!empty($pengurusData)) {
            foreach ($pengurusData as $pengurus) {
                $pengurus['id_pdm'] = $idPdm;
                $db->table('pengurus_pdm')->insert($pengurus);
            }
        }

        // 3. Insert ke tabel sejarah_pdm (jika ada input sejarah)
        if (!empty($sejarahData)) {
            foreach ($sejarahData as $sejarah) {
                $sejarah['id_pdm'] = $idPdm;
                $db->table('sejarah_pdm')->insert($sejarah);
            }
        }

        // 4. Insert ke tabel website_pdm (jika ada input website)
        if (!empty($websiteData)) {
            foreach ($websiteData as $website) {
                $website['id_pdm'] = $idPdm;
                $db->table('website_pdm')->insert($website);
            }
        }

        $db->transComplete(); // Eksekusi / Commit Transaksi

        return $db->transStatus(); // Return true jika sukses, false jika gagal
    }
}