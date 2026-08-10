<?php

namespace App\Models;

use CodeIgniter\Model;

class RefleksiModel extends Model
{
    protected $table            = 'refleksi';
    protected $primaryKey       = 'id_refleksi'; // UNGKAP PENGUBAHAN: Disesuaikan dari 'id' ke 'id_refleksi'

    // Tambahkan 'tanggal' jika nanti kamu ingin menyimpan input tanggal
    protected $allowedFields    = ['judul', 'isi', 'penulis', 'tanggal'];

    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = ''; // Di-kosongkan karena tabel belum punya kolom updated_at
}
