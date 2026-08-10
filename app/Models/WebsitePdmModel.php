<?php

namespace App\Models;

use CodeIgniter\Model;

class WebsitePdmModel extends Model
{
    protected $table            = 'website_pdm';
    protected $primaryKey       = 'id_website';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['nama_pdm', 'url', 'keterangan'];

    // Timestamps
    protected $useTimestamps    = true;
    protected $dateFormat       = 'datetime';
    protected $createdField     = 'created_at';
    protected $updatedField     = ''; // Kosongkan karena tabel tidak memakai updated_at
}
