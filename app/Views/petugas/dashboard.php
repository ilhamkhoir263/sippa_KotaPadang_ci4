<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Petugas - SIPPA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        body { 
            background: linear-gradient(180deg, #D1E9F6 0%, #FFFFFF 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            font-family: 'Poppins', sans-serif;
            margin: 0;
        }

        /* Navigasi Atas */
        .navbar-custom {
            padding: 20px 50px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .brand-section { display: flex; align-items: center; gap: 15px; }
        .logo-img { width: 50px; height: 50px; object-fit: contain; }
        .brand-text h1 { font-size: 1rem; font-weight: 700; margin: 0; color: #000; }
        .brand-text p { font-size: 0.75rem; margin: 0; color: #000; }
        .nav-links { display: flex; gap: 30px; }
        .nav-links a { text-decoration: none; color: #000; font-weight: 500; font-size: 0.9rem; }

        /* Area Dashboard */
        .dashboard-container {
            flex: 1;
            padding: 20px 50px;
        }

        .header-dashboard {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .header-dashboard h2 { 
            font-weight: 700; 
            font-size: 1.5rem; 
            margin: 0; 
        }

        /* Menu Buttons */
        .menu-row {
            display: flex;
            gap: 15px;
            margin-bottom: 40px;
        }
        .btn-menu {
            background-color: white;
            color: black;
            border-radius: 10px;
            padding: 10px 25px;
            font-weight: 600;
            border: 1px solid #000;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            transition: 0.3s;
            text-decoration: none;
            display: inline-block;
        }
        .btn-menu:hover { 
            background-color: #f0f0f0; 
            color: black;
        }

        /* Footer */
        footer {
            background-color: #2C3E50;
            color: white;
            padding: 15px 50px;
            display: flex;
            justify-content: space-between;
            font-size: 0.8rem;
            margin-top: auto;
        }
        footer a { color: white; text-decoration: none; }
    </style>
</head>
<body>

    <nav class="navbar-custom">
        <div class="brand-section">
            <img src="<?= base_url('assets/img/logo.png') ?>" alt="Logo" class="logo-img">
            <div class="brand-text">
                <h1>DP3AP2KB KOTA PADANG</h1>
                <p>Perlindungan Perempuan dan Anak (PPA)</p>
            </div>
        </div>
        <div class="nav-links">
            <a href="#">Beranda</a>
            <a href="#">Kontak</a>
            <a href="<?= base_url('logout') ?>">Logout</a>
        </div>
    </nav>

    <div class="dashboard-container">
        
        <div class="header-dashboard">
            <h2>Dashboard Petugas</h2>
        </div>

        <div class="menu-row">
            <a href="<?= base_url('petugas/rekap_laporan') ?>" class="btn btn-primary d-flex align-items-center gap-2" style="border-radius: 10px; padding: 10px 25px; font-weight: 600;">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
            <a href="<?= base_url('petugas/input_kasus') ?>" class="btn-menu">Input Data Kasus</a>
        </div>
        
        <div class="welcome-text mt-4">
    <p class="mb-1">Selamat Datang, <strong><?= esc($username) ?></strong>. Silakan pilih menu Dashboard untuk melihat rekapan data,</p>
    <p>dan menu Input Data Kasus untuk mulai mengelola data kasus.</p>
</div>

    </div>

    <footer>
        <div>2026 DP3AP2KB Kota Padang</div>
        <div>Tentang | Bantuan</div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Cek apakah ada flashdata 'success'
        <?php if (session()->getFlashdata('success')) : ?>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '<?= session()->getFlashdata('success') ?>',
                timer: 3000,
                showConfirmButton: false
            });
        <?php endif; ?>

        // Cek apakah ada flashdata 'error'
        <?php if (session()->getFlashdata('error')) : ?>
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '<?= session()->getFlashdata('error') ?>',
            });
        <?php endif; ?>
    });
    </script>
</body>
</html>