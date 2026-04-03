<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background-color: #ebf3fc; font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; color: #333; }
        
        /* Navbar */
        .navbar-custom { background: white; padding: 15px 0; border-bottom: 1px solid #eee; }
        .navbar-brand img { width: 45px; height: auto; }
        .brand-text { line-height: 1.2; }
        .nav-link { color: #555 !important; font-weight: 500; }
        .nav-link:hover { color: #000 !important; }

        /* Typography & Header */
        h3.fw-bold { font-size: 28px; margin-bottom: 5px; }
        .text-danger.small { color: #d9534f !important; font-size: 13px; }

        /* Search Container */
        .search-container { position: relative; max-width: 400px; width: 100%; }
        .search-container i { position: absolute; left: 15px; top: 13px; color: #999; }
        .search-input { padding: 10px 20px 10px 40px; border-radius: 30px; border: 1px solid #ddd; background: white; font-size: 14px; }

        /* Card & Table */
        .card-rekap { border: none; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.03); margin-bottom: 40px; }
        .table thead th { background-color: #f8f9fa; border-bottom: none; color: #000; font-weight: 600; padding: 15px; font-size: 14px; }
        .table tbody td { padding: 15px; vertical-align: middle; border-color: #f1f1f1; font-size: 14px; }
        
        /* Status & Buttons */
        .badge-proses { background-color: #00ced1; color: white; border-radius: 5px; padding: 5px 12px; font-weight: normal; font-size: 12px; }
        .btn-detail { background-color: #0d6efd; color: white; border: none; border-radius: 4px; padding: 5px 12px; font-size: 13px; }
        .btn-detail:hover { background-color: #0b5ed7; color: white; }
        
        /* Button Kembali */
        .btn-back { background: white; color: #555; border: 1px solid #ddd; border-radius: 8px; padding: 8px 15px; font-size: 14px; transition: all 0.3s; }
        .btn-back:hover { background: #f8f9fa; color: #000; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }

        /* Footer */
        footer { background: #2c3e50; color: #adb5bd; padding: 20px 0; position: fixed; bottom: 0; width: 100%; font-size: 14px; }
        footer a { color: #fff; text-decoration: none; }

        @media print {
            .search-container, .navbar-custom, footer, .text-danger, .btn-detail, .btn-back { display: none !important; }
            body { background: white; }
            .card-rekap { box-shadow: none; padding: 0 !important; }
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-custom">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="#">
            <img src="<?= base_url('assets/img/logo.png') ?>" alt="Logo" class="me-2">
            <div class="brand-text">
                <span class="fw-bold d-block" style="font-size: 16px; letter-spacing: 0.5px;">DP3AP2KB KOTA PADANG</span>
                <small class="text-muted" style="font-size: 13px;">Perlindungan Perempuan dan Anak (PPA)</small>
            </div>
        </a>
        <div class="collapse navbar-collapse justify-content-end">
            <ul class="navbar-nav align-items-center">
                <li class="nav-item"><a class="nav-link mx-2" href="<?= base_url('petugas/dashboard') ?>">Beranda</a></li>
                <li class="nav-item"><a class="nav-link mx-2" href="#">Kontak</a></li>
                <li class="nav-item"><a class="nav-link mx-2" href="<?= base_url('logout') ?>">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5" style="padding-bottom: 100px;">
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div class="d-flex align-items-start gap-3">
            <a href="<?= base_url('petugas/dashboard') ?>" class="btn btn-back mt-1">
                <i class="fa fa-arrow-left me-1"></i> Kembali
            </a>
            <div>
                <h3 class="fw-bold">Dashboard Rekap Laporan Kasus</h3>
                <p class="text-danger small">Searching pada dashboard ini juga berguna untuk mencari nama korban, tanggal kejadian, dsb</p>
            </div>
        </div>
        <div class="search-container">
            <i class="fa fa-search"></i>
            <input type="text" id="searchInput" class="form-control search-input" placeholder="Cari data kasus...">
        </div>
    </div>

    <div class="card card-rekap p-4 bg-white">
        <div class="mb-4">
            <p class="text-muted mb-0" style="font-size: 14px;">Dashboard rekap laporan kasus per tahun dan per bulan</p>
        </div>

        <div class="table-responsive">
            <table class="table align-middle" id="tableRekap">
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th width="200">Tanggal Kejadian</th>
                        <th>Nama Korban</th>
                        <th>NIK</th>
                        <th>Status</th>
                        <th class="text-center" width="100">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($kasus)): $no=1; foreach($kasus as $k): ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td><?= date('d/m/Y', strtotime($k['tanggal_kejadian'])) ?></td>
                        <td class="fw-bold"><?= $k['nama_korban'] ?></td>
                        <td><?= $k['nik'] ?></td>
                        <td><span class="badge badge-proses"><?= $k['status'] ?></span></td>
                        <td class="text-center">
                            <a href="<?= base_url('petugas/detail_kasus/'.$k['id_kasus']) ?>" class="btn btn-detail">
                                <i class="fa fa-eye me-1"></i> Detail
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; else: ?>
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">Belum ada data laporan tersedia.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<footer>
    <div class="container d-flex justify-content-between align-items-center">
        <span>2026 DP3AP2KB Kota Padang</span>
        <div class="footer-links">
            <a href="#" class="me-3">Tentang</a>
            <span class="me-3">|</span>
            <a href="#">Bantuan</a>
        </div>
    </div>
</footer>

<script>
    document.getElementById('searchInput').addEventListener('keyup', function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll('#tableRekap tbody tr');
        rows.forEach(row => {
            let text = row.innerText.toLowerCase();
            row.style.display = text.includes(filter) ? '' : 'none';
        });
    });
</script>

</body>
</html>