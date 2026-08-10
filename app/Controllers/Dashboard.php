<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Dashboard extends BaseController
{
    public function index()
    {
        // Proteksi halaman dashboard (wajib login)
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $db = \Config\Database::connect();

        // Mengambil data ringkas statistik dari database
        $data = [
            'title'          => 'Dashboard Administrator',
            'total_berita'   => $db->table('berita')->countAllResults(),
            'total_aum'      => $db->table('aum')->countAllResults(),
            'total_sekolah'  => $db->table('sekolah')->countAllResults(),
            'total_pdm'      => $db->table('pdm')->countAllResults(),
            'total_dokumen'  => $db->table('dokumen_arsip')->countAllResults(),
            'total_users'    => $db->table('users')->countAllResults(),
            'berita_terbaru' => $db->table('berita')->orderBy('id_berita', 'DESC')->limit(5)->get()->getResultArray(),
        ];

        return view('admin/dashboard', $data);
    }
}
