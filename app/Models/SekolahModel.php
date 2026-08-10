<?php

namespace App\Models;

use CodeIgniter\Model;

class SekolahModel extends Model
{
    protected $table            = 'sekolah';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;

    protected $allowedFields    = [
        'npsn',
        'nama_sekolah',
        'jenjang',
        'akreditasi',
        'kabupaten_kota',
        'kecamatan',
        'alamat',
        'kepala_sekolah',
        'telepon',
        'email',
        'website',
        'foto'
    ];

    // Diaktifkan agar CI4 mengelola timestamp secara otomatis sesuai bawaan DB Anda
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
