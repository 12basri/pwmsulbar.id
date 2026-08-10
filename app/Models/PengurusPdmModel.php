<?php

namespace App\Models;

use CodeIgniter\Model;

class PengurusPdmModel extends Model
{
    protected $table            = 'pengurus_pdm';
    protected $primaryKey       = 'id_pengurus';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nama', 'jabatan', 'pdm', 'foto', 'periode'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = ''; // Kosongkan jika tabel tidak memiliki updated_at
}
