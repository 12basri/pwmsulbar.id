<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Auth extends BaseController
{
    public function index()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/dashboard');
        }
        return view('auth/login');
    }

    public function process()
    {
        $session = session();
        $db      = \Config\Database::connect();

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // Pengecekan password secara langsung (tanpa hash)
        $user = $db->table('users')
            ->where('username', $username)
            ->where('password', $password)
            ->where('status', 'Aktif')
            ->get()
            ->getRowArray();

        if ($user) {
            $sessionData = [
                'id_user'      => $user['id'],
                'nama_lengkap' => $user['nama_lengkap'],
                'username'     => $user['username'],
                'email'        => $user['email'],
                'level'        => $user['level'],
                'foto'         => $user['foto'],
                'isLoggedIn'   => true,
            ];
            $session->set($sessionData);
            return redirect()->to('/dashboard');
        } else {
            $session->setFlashdata('error', 'Username atau Password salah, atau akun Anda nonaktif.');
            return redirect()->to('/login');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
