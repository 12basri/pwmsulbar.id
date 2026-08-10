<?php

namespace App\Models;

use CodeIgniter\Model;

class KampusModel extends Model
{
    protected $table            = 'tb_kampus';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useTimestamps    = true;

    protected $allowedFields    = [
        'nama_kampus',
        'slug',
        'singkatan',
        'bentuk',
        'akreditasi',
        'kabupaten_kota',
        'kecamatan',
        'rektor_ketua',
        'alamat',
        'website',
        'link_pddikti',
        'deskripsi',
        'logo' // Ditambahkan agar data logo dapat disimpan/diperbarui
    ];
}
