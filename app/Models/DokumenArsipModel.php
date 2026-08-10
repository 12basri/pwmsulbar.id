<?php

namespace App\Models;

use CodeIgniter\Model;

class DokumenArsipModel extends Model
{
    protected $table            = 'dokumen_arsip';
    protected $primaryKey       = 'id_dokumen';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;

    // WAJIB mencantumkan semua kolom yang boleh diisi
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

    // Dates
    protected $useTimestamps = false; // Karena di MySQL sudah ada DEFAULT CURRENT_TIMESTAMP
}