<?php

namespace App\Models;

use CodeIgniter\Model;

class StrukturOrganisasiModel extends Model
{
    protected $table            = 'struktur_organisasi';
    protected $primaryKey       = 'id_struktur';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    // Field yang diizinkan untuk diinput/diubah (Mass Assignment)
    protected $allowedFields    = [
        'nama',
        'jabatan',
        'foto',
        'urutan',
        'periode'
    ];

    // Konfigurasi otomatis Timestamp
    protected $useTimestamps    = true;
    protected $dateFormat       = 'datetime';
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    // Validation Rules (Batas max_length pada jabatan dan nama sudah dihapus)
    protected $validationRules      = [
        'nama'    => 'required|min_length[3]',
        'jabatan' => 'required', 
        'urutan'  => 'permit_empty|numeric'
    ];

    protected $validationMessages   = [
        'nama' => [
            'required'   => 'Nama pengurus/pimpinan wajib diisi.',
            'min_length' => 'Nama minimal terdiri dari 3 karakter.'
        ],
        'jabatan' => [
            'required'   => 'Jabatan wajib diisi.'
        ]
    ];

    /**
     * Helper Method: Mengambil data struktur organisasi yang diurutkan
     */
    public function getStruktur()
    {
        return $this->orderBy('urutan', 'ASC')
            ->orderBy('id_struktur', 'ASC')
            ->findAll();
    }
}