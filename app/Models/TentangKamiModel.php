<?php

namespace App\Models;

use CodeIgniter\Model;

class TentangKamiModel extends Model
{
    protected $table            = 'tentang_kami';
    protected $primaryKey       = 'id_tentang'; // Pastikan primary key di database sesuai
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    // PERBAIKAN DI SINI: Samakan dengan nama di Controller
    protected $allowedFields    = ['deskripsi', 'foto'];

    // Tanggal/Timestamp
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
