<?php

namespace App\Models;

use CodeIgniter\Model;

class SejarahPdmModel extends Model
{
    protected $table            = 'sejarah_pdm';
    protected $primaryKey       = 'id_pdm'; // Sesuai Primary Key di DB
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['nama_pdm', 'isi', 'gambar', 'tahun'];
    protected $useTimestamps    = false;
}
