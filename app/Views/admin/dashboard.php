<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - SIPPA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { 
            background: linear-gradient(180deg, #E3F2FD 0%, #FFFFFF 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            font-family: 'Poppins', sans-serif;
            margin: 0;
        }

        /* Navigasi Atas */
        .navbar-custom {
            padding: 30px 80px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .brand-section { display: flex; align-items: center; gap: 15px; }
        .logo-img { 
            width: 60px; height: 60px; object-fit: contain; 
            background: white; padding: 5px; border-radius: 50%;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .brand-text h1 { font-size: 1.1rem; font-weight: 700; margin: 0; color: #000; }
        .brand-text p { font-size: 0.85rem; margin: 0; color: #000; }
        .nav-links { display: flex; gap: 40px; }
        .nav-links a { text-decoration: none; color: #000; font-weight: 500; font-size: 1.1rem; }

        /* Area Dashboard */
        .dashboard-container {
            flex: 1;
            padding: 20px 80px;
        }

        .header-dashboard {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
        }

        .header-dashboard h2 { font-weight: 700; font-size: 2rem; margin: 0; }

        /* Search Bar */
        .search-container {
            position: relative;
            width: 400px;
        }
        .search-input {
            width: 100%;
            border-radius: 12px;
            padding: 10px 20px 10px 50px;
            border: 1px solid #000;
            outline: none;
            background: white;
        }
        .search-icon {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #000;
            font-size: 1.2rem;
        }

        /* Menu Buttons & Dropdowns */
        .menu-row {
            display: flex;
            gap: 20px;
            margin-bottom: 50px;
        }
        .btn-menu {
            background-color: white;
            color: black;
            border-radius: 12px;
            padding: 10px 30px;
            font-weight: 400;
            border: 1px solid #000;
            transition: 0.3s;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: space-between;
            min-width: 160px;
        }
        
        .dropdown-custom-menu {
            background: white;
            border: 1px solid #000;
            border-radius: 12px;
            margin-top: 10px;
            padding: 15px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .dropdown-custom-menu a {
            display: block;
            color: black;
            text-decoration: none;
            padding: 5px 0;
            font-size: 0.95rem;
        }
        .dropdown-custom-menu a:hover {
            color: #0d6efd;
        }

        /* Stats Cards */
        .stats-row {
            display: flex;
            gap: 20px; /* Dipersempit sedikit agar 5 kotak muat dengan baik */
            justify-content: center;
            margin-bottom: 60px;
            flex-wrap: wrap;
        }
        .card-stat {
            background: white;
            border-radius: 15px;
            padding: 30px 15px; /* Padding disesuaikan */
            width: 220px; /* Lebar disesuaikan agar muat 5 dalam satu baris */
            text-align: center;
            box-shadow: 0 8px 15px rgba(0,0,0,0.1);
            border: 1px solid #dee2e6;
        }
        .card-stat h3 { font-size: 1.1rem; color: #000; margin-bottom: 15px; font-weight: 400; }
        .card-stat .value { font-size: 2rem; font-weight: 700; color: #000; }

        /* Table Section */
        .table-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.05);
            border: none;
            margin-bottom: 50px;
        }
        .table-card h4 { font-weight: 700; font-size: 1.2rem; margin-bottom: 20px; color: #2C3E50; }

        /* Footer */
        footer {
            background-color: #2C4E6A;
            color: white;
            padding: 20px 80px;
            display: flex;
            justify-content: space-between;
            font-size: 1rem;
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
            <a href="<?= base_url('admin/dashboard') ?>">Beranda</a>
            <a href="#">Kontak</a>
            <a href="<?= base_url('logout') ?>">Logout</a>
        </div>
    </nav>

    <div class="dashboard-container">
        
        <div class="header-dashboard">
            <h2>Dashboard Admin</h2>
            <div class="search-container">
                <form action="<?= base_url('admin/dashboard') ?>" method="get">
                    <?php if(!empty($tahun_aktif)): ?>
                        <input type="hidden" name="tahun" value="<?= $tahun_aktif ?>">
                    <?php endif; ?>
                    <?php if(!empty($kategori_aktif)): ?>
                        <input type="hidden" name="filter_kategori" value="<?= $kategori_aktif ?>">
                    <?php endif; ?>
                    
                    <i class="bi bi-search search-icon"></i>
                    <input type="text" name="keyword" class="search-input" placeholder="Search" value="<?= htmlspecialchars($keyword ?? '') ?>">
                </form>
            </div>
        </div>

        <div class="menu-row">
            <div>
                <a href="<?= base_url('admin/dashboard') ?>" class="btn-menu">Dashboard</a>
            </div>

            <div class="dropdown">
                <button class="btn-menu dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Data Pelapor
                </button>
                <div class="dropdown-menu dropdown-custom-menu">
                    <a href="<?= base_url('admin/dashboard') ?>" style="color: #6c757d; font-style: italic;">-- Pilih Kategori --</a>
                    <a href="<?= base_url('admin/dashboard?filter_kategori=korban') ?>">Identitas Korban</a>
                    <a href="<?= base_url('admin/dashboard?filter_kategori=pelapor') ?>">Identitas Pelapor</a>
                    <a href="<?= base_url('admin/dashboard?filter_kategori=pelaku') ?>">Identitas Pelaku</a>
                    <a href="<?= base_url('admin/dashboard?filter_kategori=kasus') ?>">Informasi Kasus</a>
                </div>
            </div>

            <div class="dropdown">
                <button class="btn-menu dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Laporan Kasus
                </button>
                <div class="dropdown-menu dropdown-custom-menu">
                    <?php for($t=2026; $t<=2030; $t++): ?>
                        <a href="<?= base_url("admin/dashboard?tahun=$t") ?>">Tahun <?= $t ?></a>
                    <?php endfor; ?>
                </div>
            </div>
        </div>

        <div class="stats-row">
            <div class="card card-stat">
                <h3>Kasus Hari Ini</h3>
                <div class="value"><?= $kasus_hari_ini ?></div>
            </div>
            <div class="card card-stat">
                <h3>Kasus Bulan Ini</h3>
                <div class="value"><?= $kasus_bulan_ini ?></div>
            </div>
            <div class="card card-stat">
                <h3>Kasus Perempuan</h3>
                <div class="value"><?= $kasus_perempuan ?></div>
            </div>
            <div class="card card-stat">
                <h3>Kasus Anak</h3>
                <div class="value"><?= $kasus_anak ?></div>
            </div>
            <div class="card card-stat">
                <h3>Total Kasus</h3>
                <div class="value"><?= $total_kasus ?></div>
            </div>
        </div>

        <div class="table-card">
            <h4>Daftar Laporan Kasus</h4>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Tgl Kejadian</th>
                            <?php if ($kategori_aktif == 'pelapor'): ?>
                                <th>Nama Pelapor</th>
                                <th>NIK Pelapor</th>
                                <th>Hubungan</th>
                            <?php elseif ($kategori_aktif == 'pelaku'): ?>
                                <th>Nama Pelaku</th>
                                <th>Pekerjaan</th>
                                <th>Alamat</th>
                            <?php elseif ($kategori_aktif == 'kasus'): ?>
                                <th>Jenis Kasus</th>
                                <th>Bentuk Kekerasan</th>
                                <th>Dampak Kekerasan</th>
                                <th>Waktu Kejadian</th>
                                <th>Kronologi</th>
                            <?php else: ?>
                                <th>Nama Korban</th>
                                <th>NIK Korban</th>
                                <th>Jenis Kelamin</th>
                                <th>Alamat</th>
                            <?php endif; ?>
                            <th class="text-center">Status</th>
                            <th class="text-center">Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($daftar_kasus)) : foreach ($daftar_kasus as $k) : ?>
                            <tr>
                                <td><?= date('d/m/Y', strtotime($k['tanggal_kejadian'])) ?></td>
                                <?php if ($kategori_aktif == 'pelapor'): ?>
                                    <td><?= $k['nama_pelapor'] ?></td>
                                    <td><?= $k['nik_pelapor'] ?></td>
                                    <td><?= $k['hub_pelapor'] ?></td>
                                <?php elseif ($kategori_aktif == 'pelaku'): ?>
                                    <td><?= $k['nama_pelaku'] ?></td>
                                    <td><?= $k['kerja_pelaku'] ?></td>
                                    <td><?= $k['alamat_pelaku'] ?></td>
                                <?php elseif ($kategori_aktif == 'kasus'): ?>
                                    <td><?= $k['jenis_kasus'] ?></td>
                                    <td><?= $k['bentuk_kekerasan'] ?></td>
                                    <td><?= $k['dampak_kekerasan'] ?></td>
                                    <td><?= $k['waktu_kejadian'] ?></td>
                                    <td><?= $k['kronologi'] ?></td>
                                <?php else: ?>
                                    <td><?= $k['nama_korban'] ?></td>
                                    <td><?= $k['nik_korban'] ?></td>
                                    <td><?= $k['jenis_kelamin'] ?></td>
                                    <td><?= $k['alamat_korban'] ?></td>
                                <?php endif; ?>
                                <td class="text-center">
                                    <span class="badge <?= ($k['status'] == 'Selesai') ? 'bg-success' : 'bg-warning text-dark' ?>">
                                        <?= $k['status'] ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="<?= base_url('admin/detail/' . $k['id_kasus']) ?>" class="text-dark">
                                        <i class="bi bi-eye-fill fs-5"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; else: ?>
                            <tr><td colspan="7" class="text-center">Tidak ada data.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <footer>
        <div>2026 DP3AP2KB Kota Padang</div>
        <div><a href="#">Tentang</a> | <a href="#">Bantuan</a></div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>