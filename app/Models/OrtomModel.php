<?php

namespace App\Models;

use CodeIgniter\Model;

class OrtomModel extends Model
{
    protected $table            = 'organisasi_otonom';
    protected $primaryKey       = 'id_ortom';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nama_ortom',
        'ketua',
        'sekretaris',
        'bendahara',
        'deskripsi',
        'logo',
        'created_at',
        'updated_at'
    ];

    // Dates Configuration
    // Diset 'false' untuk mencegah DatabaseException #1054 jika kolom belum ada di database.
    // Ubah menjadi 'true' jika Anda sudah menambahkan kolom created_at dan updated_at.
    protected $useTimestamps   = false;
    protected $dateFormat      = 'datetime';
    protected $createdField    = 'created_at';
    protected $updatedField    = 'updated_at';

    // Centralized Validation Rules
    protected $validationRules = [
        'nama_ortom' => [
            'rules'  => 'required',
            'errors' => [
                'required' => 'Nama Ortom wajib diisi.'
            ]
        ],
        'logo' => [
            'rules'  => 'permit_empty|max_size[logo,5120]|is_image[logo]|mime_in[logo,image/jpg,image/jpeg,image/png,image/webp]',
            'errors' => [
                'max_size' => 'Ukuran file logo terlalu besar (maksimal 5 MB).',
                'is_image' => 'File yang diunggah harus berupa gambar.',
                'mime_in'  => 'Format logo harus berupa JPG, JPEG, PNG, atau WEBP.'
            ]
        ]
    ];
}
