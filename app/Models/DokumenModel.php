<?php

namespace App\Models;

use CodeIgniter\Model;

class DokumenModel extends Model
{
    protected $table            = 'dokumen_arsip'; // Mengarah ke tabel yang benar
    protected $primaryKey       = 'id_dokumen';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'judul', 
        'nomor_dokumen', 
        'kategori', 
        'nama_file', 
        'ukuran_file', 
        'tipe_file', 
        'tanggal_upload', 
        'akses', 
        'deskripsi'
    ];
}