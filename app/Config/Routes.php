<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// --- Halaman Umum (Tanpa Filter) ---
$routes->get('/', 'Home::index'); // Halaman Beranda (Tempat tombol Login Admin/Petugas)

/**
 * Rute Login dengan Parameter Role
 * Menangkap 'admin' atau 'petugas' dari URL (login/admin atau login/petugas)
 */
$routes->get('login/(:any)', 'Home::login/$1'); 

$routes->post('login/auth', 'Auth::login'); // Proses verifikasi login di Auth Controller
$routes->get('logout', 'Auth::logout');      // Rute logout

// --- Registrasi ---
$routes->get('register', 'Home::register');
$routes->post('register/save', 'Auth::registerSave');

// --- Grup Rute ADMIN (Hanya bisa diakses oleh user dengan role: admin) ---
// Menggunakan filter 'roleAuth' dengan argumen 'admin'
$routes->group('admin', ['filter' => 'roleAuth:admin'], function($routes) {
    $routes->get('dashboard', 'AdminController::index');
    $routes->get('detail/(:num)', 'AdminController::detail/$1');
});

// --- Grup Rute PETUGAS (Hanya bisa diakses oleh user dengan role: petugas) ---
// Menggunakan filter 'roleAuth' dengan argumen 'petugas'
$routes->group('petugas', ['filter' => 'roleAuth:petugas'], function($routes) {
    $routes->get('dashboard', 'PetugasController::index');
    
    /**
     * Menyesuaikan nama method dengan PetugasController.php 
     * Memastikan case-sensitivity sesuai dengan script Controller Anda
     */
    $routes->get('input_kasus', 'PetugasController::input_Kasus'); 
    $routes->post('simpan_kasus', 'PetugasController::simpan_Kasus');
    $routes->get('rekap_laporan', 'PetugasController::rekap_laporan');
    $routes->get('detail_kasus/(:num)', 'PetugasController::detail_kasus/$1');
});

/**
 * Rute Tambahan
 * Mengarahkan '/dashboard' ke fungsi pengecekan role di Home Controller
 */
$routes->get('dashboard', 'Home::dashboard');