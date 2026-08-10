<?php

namespace App\Models;

use CodeIgniter\Model;

class AumModel extends Model
{
    protected $table            = 'aum';
    protected $primaryKey       = 'id_aum';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;

    // Kolom yang dapat diisi melalui form/input
    protected $allowedFields    = [
        'nama_aum',
        'jenis',
        'alamat',
        'kabupaten_kota',
        'kecamatan',
        'maps', // <-- Menggunakan nama kolom dari database
        'pimpinan',
        'telepon',
        'email',
        'website',
        'deskripsi',
        'foto'
    ];

    protected $useTimestamps = false;
}
