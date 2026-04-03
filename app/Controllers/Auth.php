<?php

namespace App\Controllers;

class Auth extends BaseController
{
    /**
     * Fungsi untuk memproses pendaftaran
     * Tetap mempertahankan validasi email, username, dan password 6 digit.
     */
    public function registerSave()
    {
        $db = \Config\Database::connect();
        
        $email    = $this->request->getPost('email');
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $role     = $this->request->getPost('role');

        // Validasi Password 6 Digit
        if (strlen((string)$password) !== 6) {
            return redirect()->back()->with('error', 'Password harus tepat 6 digit!')->withInput();
        }

        // Cek Username unik
        $existingUser = $db->table('users')->where('username', $username)->get()->getRow();
        if ($existingUser) {
            return redirect()->back()->with('error', 'Username sudah digunakan!')->withInput();
        }

        // Cek Email unik
        $existingEmail = $db->table('users')->where('email', $email)->get()->getRow();
        if ($existingEmail) {
            return redirect()->back()->with('error', 'Email sudah terdaftar!')->withInput();
        }

        $data = [
            'username' => $username,
            'email'    => $email,
            'password' => $password, 
            'role'     => trim($role) // Bersihkan spasi saat simpan
        ];

        if ($db->table('users')->insert($data)) {
            return redirect()->to('/')->with('success', 'Pendaftaran Berhasil! Silakan login.');
        } else {
            return redirect()->back()->with('error', 'Terjadi kesalahan sistem saat menyimpan data.')->withInput();
        }
    }

    /**
     * Fungsi Login dengan Proteksi Role-Cross (Mencegah salah pintu masuk)
     */
    public function login()
    {
        $session  = session();
        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $remember = $this->request->getPost('remember'); 
        
        // 1. TANGKAP TARGET ROLE (Dari input hidden di login_page)
        $targetRole = strtolower(trim((string)$this->request->getPost('target_role')));

        $db = \Config\Database::connect();
        $user = $db->table('users')->where('email', $email)->get()->getRowArray();

        // Verifikasi User dan Password
        if ($user && $password == $user['password']) {
            
            // Ambil role asli dari database
            $userRole = strtolower(trim($user['role']));

            // 2. LOGIKA VALIDASI PINTU MASUK
            // Jika target_role ada (admin/petugas) tapi tidak cocok dengan role di DB, TOLAK.
            if (!empty($targetRole) && $userRole !== $targetRole) {
                return redirect()->back()->with('error', 'Maaf, akun Anda tidak terdaftar sebagai ' . ucfirst($targetRole) . '.');
            }

            // Jika cocok, buat session
            $session->set([
                'username'  => $user['username'],
                'email'     => $user['email'],
                'role'      => $userRole,
                'logged_in' => true,
            ]);

            // Logika Remember Me (30 Hari)
            if ($remember) {
                setcookie("user_email", $email, time() + (86400 * 30), "/");
                setcookie("user_pass", $password, time() + (86400 * 30), "/");
            } else {
                setcookie("user_email", "", time() - 3600, "/");
                setcookie("user_pass", "", time() - 3600, "/");
            }
            
            // 3. PENGALIHAN BERDASARKAN ROLE
            if ($userRole === 'admin') {
                return redirect()->to('/admin/dashboard');
            } else if ($userRole === 'petugas') {
                return redirect()->to('/petugas/dashboard');
            } else {
                return redirect()->to('/')->with('error', 'Role akun tidak valid.');
            }
        }
        
        return redirect()->back()->with('error', 'Email atau Password salah!');
    }

    /**
     * Fungsi Logout
     */
    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/')->with('success', 'Anda telah logout.');
    }
}