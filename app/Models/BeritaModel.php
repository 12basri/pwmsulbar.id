<?php

namespace App\Models;

use CodeIgniter\Model;

class BeritaModel extends Model
{
    protected $table            = 'berita';
    protected $primaryKey       = 'id_berita';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = ''; // Set kosong jika tidak ada kolom updated_at

    protected $allowedFields    = [
        'judul',
        'slug',
        'isi',
        'gambar',
        'penulis',
        'tanggal',
        'status'
    ];
}
