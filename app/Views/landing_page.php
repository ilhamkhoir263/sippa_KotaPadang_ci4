<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPPA - Kota Padang</title>
    <!-- Bootstrap & Fonts -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Crimson+Text:wght@600;700&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --bg-blue: #D1E9F6; 
            --dark-blue: #2C3E50;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-blue);
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Header / Navbar */
        .custom-navbar {
            background-color: white;
            padding: 10px 0;
            border-bottom: 1px solid #ddd;
        }

        .brand-text {
            font-size: 0.85rem;
            line-height: 1.2;
            color: #000;
        }

        .nav-link {
            color: #000 !important;
            font-weight: 500;
            margin: 0 10px;
        }

        /* Hero Section */
        .content-wrapper {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding-bottom: 80px;
        }

        .welcome-text {
            font-family: 'Crimson Text', serif;
            font-size: 2rem;
            text-decoration: underline;
            margin-bottom: 20px;
        }

        .sippa-title {
            font-family: 'Crimson Text', serif;
            font-size: 4.5rem;
            font-weight: bold;
            margin: 0;
        }

        .sippa-subtitle {
            font-weight: 600;
            font-size: 1.2rem;
            margin-bottom: 30px;
        }

        /* Buttons */
        .btn-custom {
            border-radius: 8px;
            padding: 10px 25px;
            font-weight: 600;
            border: none;
            margin: 0 5px;
            transition: all 0.3s ease;
        }

        .btn-custom:hover {
            transform: scale(1.05);
            opacity: 0.9;
        }

        .btn-admin { background-color: #A9C9D9; color: #000; }
        .btn-petugas { background-color: #BDD7E7; color: #000; }
        
        /* Register Text Style */
        .register-text {
            margin-top: 20px;
            font-size: 0.95rem;
            color: #333;
        }
        
        .btn-daftar-link {
            color: var(--dark-blue);
            font-weight: 700;
            text-decoration: none;
        }
        
        .btn-daftar-link:hover {
            text-decoration: underline;
        }

        /* Footer */
        footer {
            background-color: var(--dark-blue);
            color: white;
            padding: 15px 0;
            font-size: 0.9rem;
            margin-top: auto;
        }
    </style>
</head>
<body>

<nav class="custom-navbar">
    <div class="container d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center">
            <img src="<?= base_url('assets/img/logo.png') ?>" alt="Logo" width="45" class="me-3">
            <div class="brand-text text-start">
                <strong>DP3AP2KB KOTA PADANG</strong><br>
                Perlindungan Perempuan dan Anak (PPA)
            </div>
        </div>
        <div class="nav-menu">
            <a href="<?= base_url('/') ?>" class="nav-link d-inline">Beranda</a>
            <a href="#" class="nav-link d-inline">Kontak</a>
            <?php if (session()->get('logged_in')) : ?>
                <a href="<?= base_url('logout') ?>" class="nav-link d-inline">Logout</a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<div class="container content-wrapper">
    <div class="welcome-text">Selamat Datang</div>
    
    <h1 class="sippa-title">SIPPA</h1>
    <p class="sippa-subtitle">
        Sistem Informasi Perlindungan Perempuan dan Anak<br>
        Kota Padang
    </p>

    <div class="mb-2">
        <!-- Mengarahkan ke form login dengan parameter role -->
        <a href="<?= base_url('login/admin') ?>" class="btn btn-custom btn-admin shadow-sm">Login Admin</a>
        <a href="<?= base_url('login/petugas') ?>" class="btn btn-custom btn-petugas shadow-sm">Login Petugas</a>
    </div>
    
    <div class="register-text">
        Belum memiliki akun? <a href="<?= base_url('register') ?>" class="btn-daftar-link">Daftar sekarang.</a>
    </div>
</div>

<footer>
    <div class="container d-flex justify-content-between align-items-center">
        <div>2026 DP3AP2KB Kota Padang</div>
        <div>
            <a href="#" class="text-white text-decoration-none me-3">Tentang</a>
            |
            <a href="#" class="text-white text-decoration-none ms-3">Bantuan</a>
        </div>
    </div>
</footer>

<!-- JS Scripts -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Popup jika ada pesan Sukses (Flashdata)
    <?php if (session()->getFlashdata('success')) : ?>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '<?= session()->getFlashdata('success') ?>',
            confirmButtonColor: '#2C3E50',
            timer: 3500
        });
    <?php endif; ?>

    // Popup jika ada pesan Error (Flashdata)
    <?php if (session()->getFlashdata('error')) : ?>
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '<?= session()->getFlashdata('error') ?>',
            confirmButtonColor: '#2C3E50'
        });
    <?php endif; ?>
</script>

</body>
</html>