<?php

namespace App\Models;

use CodeIgniter\Model;

class ProgramKerjaModel extends Model
{
    protected $table            = 'program_kerja';
    protected $primaryKey       = 'id_program';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;

    // Field yang diizinkan untuk diisi / diperbarui (Wajib tambahkan id_majelis)
    protected $allowedFields    = [
        'id_majelis', // <-- DIPERBAIKI: Wajib ada agar id_majelis bisa disimpan/diupdate
        'nama_program',
        'kategori',
        'deskripsi',
        'tahun',
        'status'
    ];

    // Konfigurasi Timestamp Otomatis
    protected $useTimestamps    = true;
    protected $dateFormat       = 'datetime';
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    // Rules Validasi
    protected $validationRules  = [
        'id_majelis'   => 'required|numeric', // <-- DIPERBAIKI: Tambahkan rule untuk id_majelis
        'nama_program' => 'required|min_length[3]|max_length[200]',
        'kategori'     => 'permit_empty|max_length[150]',
        'tahun'        => 'permit_empty|exact_length[4]|numeric',
        'status'       => 'permit_empty|in_list[Aktif,Selesai,Perencanaan]'
    ];

    protected $validationMessages = [
        'id_majelis' => [
            'required' => 'Majelis / Lembaga Induk wajib dipilih.'
        ],
        'nama_program' => [
            'required'   => 'Nama program kerja wajib diisi.',
            'min_length' => 'Nama program minimal terdiri dari 3 karakter.'
        ],
        'status' => [
            'in_list'    => 'Status harus berupa Aktif, Selesai, atau Perencanaan.'
        ]
    ];

    /**
     * Helper Method: Mengambil semua data program kerja terurut dari yang terbaru
     */
    public function getProgramKerja()
    {
        return $this->orderBy('tahun', 'DESC')
            ->orderBy('id_program', 'DESC')
            ->findAll();
    }
}
