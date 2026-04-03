<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - SIPPA</title>
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
        .register-card { 
            background: white; 
            padding: 40px; 
            border-radius: 20px; 
            box-shadow: 0 10px 25px rgba(0,0,0,0.1); 
            width: 100%; 
            max-width: 450px; 
        }
        .btn-register { 
            background-color: #2C3E50; 
            color: white; 
            width: 100%; 
            border-radius: 10px; 
            padding: 10px; 
            margin-top: 20px;
            font-weight: 600;
            border: none;
            transition: 0.3s;
        }
        .btn-register:hover { 
            background-color: #1a252f;
            color: white; 
            transform: translateY(-2px);
        }
        .form-control, .form-select { 
            border-radius: 10px; 
            background-color: #f8f9fa; 
        }
        .logo-img { width: 60px; margin-bottom: 15px; }
    </style>
</head>
<body>

<div class="register-card">
    <div class="text-center">
        <img src="<?= base_url('assets/img/logo.png') ?>" alt="Logo" class="logo-img">
        <h3 class="fw-bold">Daftar Akun</h3>
        <p class="text-muted small">Silakan lengkapi data untuk membuat akun baru</p>
    </div>

    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger small p-2" role="alert">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('register/save') ?>" method="post">
        <?= csrf_field() ?>

        <div class="mb-3">
            <label class="form-label small fw-bold">Email</label>
            <input type="email" name="email" class="form-control" placeholder="nama@email.com" value="<?= old('email') ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label small fw-bold">Username</label>
            <input type="text" name="username" class="form-control" placeholder="Pilih username" value="<?= old('username') ?>" required>
        </div>
        
        <div class="mb-3">
            <label class="form-label small fw-bold">Password (6 Digit Angka)</label>
            <input type="password" name="password" class="form-control" 
                   placeholder="******" 
                   minlength="6" maxlength="6" 
                   pattern="\d{6}" 
                   inputmode="numeric" 
                   required>
            <div class="form-text" style="font-size: 0.75rem;">Gunakan 6 digit angka saja.</div>
        </div>

        <div class="mb-3">
            <label class="form-label small fw-bold">Daftar Sebagai</label>
            <select name="role" class="form-select">
                <option value="petugas">Petugas</option>
                <option value="admin">Admin</option>
            </select>
        </div>

        <button type="submit" class="btn btn-register shadow-sm">Daftar Sekarang</button>
    </form>
    
    <div class="text-center mt-4">
        <p class="small text-muted">Sudah punya akun? <a href="<?= base_url('/') ?>" class="text-decoration-none fw-bold" style="color: #2C3E50;">Masuk di sini</a></p>
    </div>
</div>

</body>
</html>