<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    // Nama tabel di database Anda
    protected $table            = 'users';

    // Primary key dari tabel
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;

    // Tipe data kembalian ('array' atau 'object')
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    // =========================================================================
    // SANGAT PENTING! 
    // Sesuaikan nama-nama di bawah ini dengan nama kolom di tabel database Anda.
    // Jika nama kolom tidak ada di sini, data tersebut akan DIBUANG oleh CodeIgniter
    // dan menyebabkan error "There is no data to insert".
    // =========================================================================
    protected $allowedFields    = [
        'nama',
        'email',
        'password',
        'telepon',
        'alamat'
    ];

    // Otomatis mengisi kolom created_at dan updated_at jika tabel Anda memilikinya
    protected $useTimestamps   = true;
    protected $createdField    = 'created_at';
    protected $updatedField    = 'updated_at';
    protected $deletedField    = 'deleted_at';

    // Aturan Validasi opsional (bisa diisi jika ingin validasi otomatis dari model)
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
}
