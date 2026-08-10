<?php

namespace App\Models;

use CodeIgniter\Model;

class OpiniModel extends Model
{
    protected $table            = 'opini';
    protected $primaryKey       = 'id_opini';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = [
        'judul',
        'slug',
        'isi',
        'gambar',
        'penulis',
        'profesi_penulis',
        'tanggal',
        'status',
        'views'
    ];

    // Otomatisasi Waktu
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}