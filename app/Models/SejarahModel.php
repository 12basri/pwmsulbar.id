<?php

namespace App\Models;

use CodeIgniter\Model;

class SejarahModel extends Model
{
    protected $table            = 'sejarah_pwm';
    protected $primaryKey       = 'id_sejarah';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['judul', 'isi', 'gambar', 'tahun'];
    protected $useTimestamps    = false; // created_at ditangani otomatis oleh MySQL
}
