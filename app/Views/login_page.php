<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login <?= ucfirst($role) ?> - SIPPA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body { 
            background: linear-gradient(180deg, #D1E9F6 0%, #FFFFFF 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            font-family: 'Poppins', sans-serif;
            margin: 0;
        }
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
        .login-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .login-box {
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        .login-box h2 {
            font-weight: 700;
            margin-bottom: 30px;
            font-size: 1.5rem;
        }
        .form-control-custom {
            border-radius: 50px;
            padding: 12px 25px;
            border: 1px solid #ced4da;
            background-color: white;
            margin-bottom: 20px;
            width: 100%;
            outline: none;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        .btn-masuk {
            background-color: white;
            color: black;
            border-radius: 50px;
            padding: 10px;
            width: 100%;
            font-weight: 600;
            border: none;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            margin-top: 10px;
            transition: 0.3s;
        }
        .btn-masuk:hover { background-color: #f8f9fa; transform: translateY(-2px); }
        .form-options {
            display: flex;
            justify-content: space-between;
            font-size: 0.75rem;
            padding: 0 10px;
            margin-top: -10px;
            margin-bottom: 20px;
        }
        .form-options a { text-decoration: none; color: #666; }
        footer {
            background-color: #2C3E50;
            color: white;
            padding: 15px 50px;
            display: flex;
            justify-content: space-between;
            font-size: 0.8rem;
        }
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
            <a href="<?= base_url('/') ?>">Beranda</a>
            <a href="#">Kontak</a>
            <?php if (session()->get('logged_in')) : ?>
                <a href="<?= base_url('logout') ?>">Logout</a>
            <?php endif; ?>
        </div>
    </nav>

    <div class="login-container">
        <div class="login-box">
            <!-- Judul dinamis sesuai role yang dipilih -->
            <h2>Masuk sebagai <?= ucfirst($role) ?></h2>

            <?php if (session()->getFlashdata('error')) : ?>
                <div class="alert alert-danger py-2 small" role="alert">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('login/auth') ?>" method="post">
                <?= csrf_field() ?>
                
                <!-- INPUT HIDDEN: Sangat penting untuk memvalidasi role di controller -->
                <input type="hidden" name="target_role" value="<?= $role ?>">
                
                <input type="email" name="email" class="form-control-custom" placeholder="Email" 
                       value="<?= isset($_COOKIE['user_email']) ? $_COOKIE['user_email'] : '' ?>" required>
                
                <input type="password" name="password" class="form-control-custom" placeholder="Password" maxlength="6" 
                       value="<?= isset($_COOKIE['user_pass']) ? $_COOKIE['user_pass'] : '' ?>" required>

                <div class="form-options">
                    <label>
                        <input type="checkbox" name="remember" <?= isset($_COOKIE['user_email']) ? 'checked' : '' ?>> Remember Me
                    </label>
                    <a href="#">Lupa Password?</a>
                </div>

                <button type="submit" class="btn-masuk">Masuk</button>
            </form>

            <p class="mt-4 small text-muted">
                Belum punya akun? <a href="<?= base_url('register') ?>" class="fw-bold text-dark text-decoration-none">Daftar di sini</a>
            </p>
        </div>
    </div>

    <footer>
        <div>2026 DP3AP2KB Kota Padang</div>
        <div>Tentang | Bantuan</div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        <?php if (session()->getFlashdata('success')) : ?>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '<?= session()->getFlashdata('success') ?>',
                confirmButtonColor: '#2C3E50',
                confirmButtonText: 'Oke'
            });
        <?php endif; ?>
    </script>
</body>
</html>