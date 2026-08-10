<?php

namespace App\Models;

use CodeIgniter\Model;

class VisiMisiModel extends Model
{
    protected $table            = 'visi_misi_tujuan';
    protected $primaryKey       = 'id_visi';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    // Field yang diizinkan untuk disimpan/diubah
    protected $allowedFields    = [
        'visi', 
        'misi', 
        'tujuan'
    ];

    // Konfigurasi Timestamps
    protected $useTimestamps    = false;

    /**
     * Helper Method: Mengambil data Visi Misi Tujuan baris pertama
     */
    public function getVisiMisi()
    {
        return $this->first();
    }
}