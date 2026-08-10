<?php

namespace App\Models;

use CodeIgniter\Model;

class MajelisModel extends Model
{
    protected $table            = 'majelis_lembaga';
    protected $primaryKey       = 'id_majelis';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $allowedFields    = [
        'jenis',
        'nama_majelis',
        'slug',
        'deskripsi_singkat',
        'nomor_sk',
        'tanggal_sk_masehi',
        'tanggal_sk_hijriah',
        'periode',
        'ditetapkan_oleh',
        'urutan',
        'status'
    ];

    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    protected $beforeInsert     = ['generateSlug'];
    protected $beforeUpdate     = ['generateSlug'];

    protected function generateSlug(array $data)
    {
        helper('url');

        // Hanya buat slug jika nama_majelis dikirim & tidak kosong
        if (!empty($data['data']['nama_majelis'])) {
            $data['data']['slug'] = url_title($data['data']['nama_majelis'], '-', true);
        } else {
            // Hapus key 'slug' dari antrean data update jika nama_majelis tidak diubah
            unset($data['data']['slug']);
        }

        return $data;
    }

    public function search(?string $keyword)
    {
        $builder = $this->select('majelis_lembaga.*, 
            (SELECT nama FROM majelis_pimpinan WHERE majelis_pimpinan.id_majelis = majelis_lembaga.id_majelis AND jabatan LIKE "%Ketua%" LIMIT 1) AS ketua,
            (SELECT nama FROM majelis_pimpinan WHERE majelis_pimpinan.id_majelis = majelis_lembaga.id_majelis AND jabatan LIKE "%Sekretaris%" LIMIT 1) AS sekretaris
        ');

        if (!empty($keyword)) {
            $builder->groupStart()
                ->like('nama_majelis', $keyword)
                ->orLike('deskripsi_singkat', $keyword)
                ->groupEnd();
        }

        return $builder;
    }
}
