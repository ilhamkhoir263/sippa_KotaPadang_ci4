<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Akun - SIPPA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body { 
            background-color: #D1E9F6; 
            height: 100vh; 
            display: flex; 
            align-items: center; 
            justify-content: center;
            font-family: 'Poppins', sans-serif;
        }
        .verify-card { 
            background: white; 
            padding: 40px; 
            border-radius: 20px; 
            box-shadow: 0 10px 25px rgba(0,0,0,0.1); 
            width: 100%; 
            max-width: 400px; 
            text-align: center;
        }
        .otp-input {
            letter-spacing: 10px;
            font-size: 2rem;
            font-weight: bold;
            text-align: center;
            border-radius: 10px;
            background-color: #f8f9fa;
            border: 2px solid #dee2e6;
        }
        .otp-input:focus {
            border-color: #2C3E50;
            box-shadow: none;
        }
        .btn-verify { 
            background-color: #2C3E50; 
            color: white; 
            width: 100%; 
            border-radius: 10px; 
            padding: 12px; 
            margin-top: 25px;
            font-weight: 600;
            border: none;
        }
        .btn-verify:hover { color: white; opacity: 0.9; }
        .logo-img { width: 60px; margin-bottom: 20px; }
    </style>
</head>
<body>

<div class="verify-card">
    <img src="<?= base_url('assets/img/logo.png') ?>" alt="Logo" class="logo-img">
    <h3 class="fw-bold">Verifikasi Kode</h3>
    <p class="text-muted small">Masukkan 6 digit kode verifikasi yang telah dikirimkan ke email Anda.</p>

    <?php if(session()->getFlashdata('info')): ?>
        <div class="alert alert-info small py-2">
            <?= session()->getFlashdata('info') ?>
        </div>
    <?php endif; ?>

    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger small py-2">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('register/verify_process') ?>" method="post">
        <?= csrf_field() ?>
        <div class="mb-3">
            <input type="text" name="otp" class="form-control otp-input" placeholder="000000" maxlength="6" pattern="\d{6}" required autocomplete="off">
        </div>
        <button type="submit" class="btn btn-verify shadow-sm">Verifikasi Sekarang</button>
    </form>
    
    <div class="mt-4">
        <p class="small text-muted">Tidak menerima kode? <a href="#" class="text-decoration-none fw-bold" style="color: #2C3E50;">Kirim ulang</a></p>
        <a href="<?= base_url('register') ?>" class="small text-decoration-none text-muted">← Kembali ke Pendaftaran</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>