<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AdminFilter implements FilterInterface
{
    /**
     * Filter sebelum request masuk ke Controller
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        // 1. Cek apakah user sudah login
        // Jika session 'logged_in' tidak ada atau false, lempar ke halaman login
        if (!$session->has('logged_in') || $session->get('logged_in') !== true) {
            return redirect()->to('/')->with('error', 'Silakan login terlebih dahulu.');
        }

        // 2. Ambil role user dari session
        // Menggunakan trim dan strtolower agar pengecekan tidak sensitif terhadap spasi/kapital
        $rawRole = $session->get('role') ?? '';
        $userRole = strtolower(trim((string)$rawRole));

        // 3. Validasi Akses Berdasarkan Role (Arguments dari Routes)
        if (!empty($arguments)) {
            // Pastikan semua isi arguments juga dalam huruf kecil untuk perbandingan yang adil
            $allowedRoles = array_map('strtolower', $arguments);

            if (!in_array($userRole, $allowedRoles)) {
                // Memberikan pesan error yang informatif jika terjadi ketidakcocokan
                return redirect()->to('/')
                    ->with('error', 'Akses ditolak! Akun Anda (' . ($userRole ?: 'Tanpa Role') . ') tidak diizinkan mengakses halaman ini.');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Kosongkan jika tidak ada logika setelah request
    }
}