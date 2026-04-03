<?php

namespace App\Controllers;

class Home extends BaseController
{
    /**
     * Menampilkan Halaman Landing Page Utama
     */
    public function index(): string
    {
        return view('landing_page');
    }

    /**
     * Menampilkan Halaman Registrasi Akun
     */
    public function register()
    {
        return view('register_page');
    }

    /**
     * Menampilkan Halaman Login Berdasarkan Role
     * $role diambil dari URL (admin atau petugas)
     */
    public function login($role)
    {
        // ucfirst() mengubah 'admin' menjadi 'Admin' untuk tampilan judul di view
        $data = [
            'role'        => $role, 
            'display_role' => ucfirst($role) 
        ];

        return view('login_page', $data);
    }

    /**
     * Menampilkan Halaman Verifikasi (Jika diperlukan)
     */
    public function verify()
    {
        return view('verify_page'); 
    }

    /**
     * Fungsi opsional untuk mengarahkan user yang sudah login 
     * ke dashboard masing-masing jika mereka mengakses route /dashboard
     */
    public function dashboard()
    {
        $session = session();
        
        if (!$session->get('logged_in')) {
            return redirect()->to('/')->with('error', 'Silakan login terlebih dahulu.');
        }

        $role = strtolower(trim($session->get('role')));

        if ($role === 'admin') {
            return redirect()->to('/admin/dashboard');
        } elseif ($role === 'petugas') {
            return redirect()->to('/petugas/dashboard');
        }

        return redirect()->to('/')->with('error', 'Role tidak dikenali.');
    }
}