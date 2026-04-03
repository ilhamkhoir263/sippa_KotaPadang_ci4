<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Data Kasus - SIPPA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { 
            background: #D1E9F6;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            font-family: 'Poppins', sans-serif;
            margin: 0;
        }

        /* Navigasi */
        .navbar-custom { padding: 20px 50px; display: flex; justify-content: space-between; align-items: center; background: white; }
        .brand-section { display: flex; align-items: center; gap: 15px; }
        .logo-img { width: 60px; height: 60px; object-fit: contain; }
        .brand-text h1 { font-size: 1.1rem; font-weight: 700; margin: 0; color: #000; }
        .brand-text p { font-size: 0.85rem; margin: 0; color: #000; }
        .nav-links a { text-decoration: none; color: #000; font-weight: 500; font-size: 1rem; margin-left: 25px; }

        /* Container & Form */
        .form-container { flex: 1; padding: 20px 80px; position: relative; }
        .back-button { font-size: 2rem; color: #000; cursor: pointer; text-decoration: none; position: absolute; left: 30px; top: 20px; }
        
        .form-badge {
            background-color: #244769;
            color: white;
            padding: 8px 25px;
            border-radius: 8px;
            display: inline-block;
            font-weight: 600;
            margin-bottom: 30px;
            margin-left: 20px;
            font-size: 1.1rem;
            box-shadow: 0 4px 6px rgba(0,0,0,0.2);
        }

        /* Layout Horizontal */
        .form-group-custom { 
            display: flex; 
            flex-direction: column; /* Menyesuaikan dengan gambar referensi: label di atas input */
            margin-bottom: 15px;
        }
        .form-group-custom label { 
            font-weight: 700; 
            font-size: 1rem; 
            color: #000;
            margin-bottom: 5px;
        }

        .form-control-custom { 
            width: 100%;
            max-width: 800px;
            border-radius: 12px; 
            border: none; 
            padding: 12px 20px;
            background: white;
            box-shadow: inset 0 2px 4px rgba(0,0,0,0.05);
            outline: none;
            font-size: 1rem;
        }

        select.form-control-custom {
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            background-size: 16px 12px;
        }

        /* Pagination Indicator */
        .page-indicator {
            position: absolute;
            right: 80px;
            top: 20px;
            display: flex;
            gap: 10px;
        }
        .page-num {
            background: #A3C9E2;
            padding: 5px 12px;
            font-weight: bold;
            border-radius: 4px;
        }

        /* Tombol */
        .btn-footer {
            margin-top: 40px;
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            padding-right: 80px;
        }
        .btn-custom {
            padding: 10px 35px;
            border-radius: 10px;
            font-weight: 700;
            border: none;
            transition: 0.3s;
            font-size: 1rem;
        }
        .btn-next, .btn-save { background-color: #A3C9E2; color: #000; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .btn-prev { background-color: #A3C9E2; color: #000; opacity: 0.7; }

        .form-slide { display: none; }
        .form-slide.active { display: block; }

        footer { background-color: #244769; color: white; padding: 15px 50px; display: flex; justify-content: space-between; font-size: 0.9rem; }
        footer a { color: white; text-decoration: none; margin-left: 15px; }
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

    <div class="form-container">
        <a href="<?= base_url('petugas/dashboard') ?>" class="back-button"><i class="bi bi-arrow-left"></i></a>
        
        <form id="kasusForm" action="<?= base_url('petugas/simpan_kasus') ?>" method="POST">
            <?= csrf_field() ?>

            <!-- Slide 1: Form Kasus -->
            <div class="form-slide active" id="slide1">
                <div class="page-indicator"><span class="page-num">1 / 6</span></div>
                <div class="form-badge">Form Kasus</div>
                
                <div class="form-group-custom">
                    <label>Hari</label>
                    <input type="text" name="hari" class="form-control-custom" placeholder="Contoh: Senin" required>
                </div>

                <div class="form-group-custom">
                    <label>Tanggal Kejadian</label>
                    <input type="date" name="tgl_kejadian" class="form-control-custom" required>
                </div>

                <div class="form-group-custom">
                    <label>Waktu Kejadian</label>
                    <input type="text" name="waktu_kejadian" class="form-control-custom" placeholder="Pagi / Siang / Malam" required>
                </div>

                <div class="btn-footer">
                    <button type="button" class="btn btn-custom btn-next" onclick="validateAndNext(1, 2)">Next</button>
                </div>
            </div>

            <!-- Slide 2: Identitas Korban -->
            <div class="form-slide" id="slide2">
                <div class="page-indicator"><span class="page-num">2 / 6</span></div>
                <div class="form-badge">Identitas Korban</div>
                
                <div class="form-group-custom"><label>Nama Lengkap</label><input type="text" name="k_nama" class="form-control-custom" required></div>
                <div class="form-group-custom"><label>NIK</label><input type="number" name="k_nik" class="form-control-custom" required></div>
                <div class="form-group-custom"><label>TTL</label><input type="text" name="k_ttl" class="form-control-custom" placeholder="Padang, 01-01-2010" required></div>
                <div class="form-group-custom"><label>Alamat</label><input type="text" name="k_alamat" class="form-control-custom" required></div>

                <div class="form-group-custom">
                    <label>Kecamatan</label>
                    <select name="k_kecamatan" class="form-control-custom" required>
                        <option value="">--Kecamatan--</option>
                        <option value="Bungus Teluk Kabung">Bungus Teluk Kabung</option>
                        <option value="Koto Tangah">Koto Tangah</option>
                        <option value="Kuranji">Kuranji</option>
                        <option value="Lubuk Begalung">Lubuk Begalung</option>
                        <option value="Lubuk Kilangan">Lubuk Kilangan</option>
                        <option value="Nanggalo">Nanggalo</option>
                        <option value="Padang Barat">Padang Barat</option>
                        <option value="Padang Selatan">Padang Selatan</option>
                        <option value="Padang Timur">Padang Timur</option>
                        <option value="Padang Utara">Padang Utara</option>
                        <option value="Pauh">Pauh</option>
                    </select>
                </div>

                <div class="form-group-custom"><label>Kelurahan</label><input type="text" name="k_kelurahan" class="form-control-custom" required></div>

                <div class="form-group-custom">
                    <label>Jenis Kelamin</label>
                    <select name="k_jk" class="form-control-custom" required>
                        <option value="">-- Pilih --</option>
                        <option value="Perempuan">Perempuan</option>
                        <option value="Laki-laki">Laki-laki</option>
                    </select>
                </div>

                <div class="form-group-custom"><label>Agama</label><input type="text" name="k_agama" class="form-control-custom" required></div>
                <div class="form-group-custom"><label>Usia Saat Kejadian</label><input type="number" name="k_usia" class="form-control-custom" required></div>
                <div class="form-group-custom"><label>Pendidikan/ Pekerjaan</label><input type="text" name="k_kerja" class="form-control-custom" required></div>
                <div class="form-group-custom"><label>No HP</label><input type="text" name="k_nohp" class="form-control-custom" required></div>
                <div class="form-group-custom"><label>Suku</label><input type="text" name="k_suku" class="form-control-custom" required></div>

                <div class="btn-footer">
                    <button type="button" class="btn btn-custom btn-prev" onclick="goToSlide(1)">Kembali</button>
                    <button type="button" class="btn btn-custom btn-next" onclick="validateAndNext(2, 3)">Next</button>
                </div>
            </div>

            <!-- Slide 3: Data Pendukung Korban -->
            <div class="form-slide" id="slide3">
                <div class="page-indicator"><span class="page-num">3 / 6</span></div>
                <div class="form-badge">Data Pendukung Korban</div>
                
                <div class="form-group-custom"><label>Nama Ortu / Wali</label><input type="text" name="k_ortu" class="form-control-custom" required></div>
                <div class="form-group-custom"><label>Alamat Ortu / Wali</label><input type="text" name="k_alamat_ortu" class="form-control-custom" required></div>
                <div class="form-group-custom"><label>No HP Ortu / Wali</label><input type="text" name="k_hp_ortu" class="form-control-custom" required></div>
                
                <div class="btn-footer">
                    <button type="button" class="btn btn-custom btn-prev" onclick="goToSlide(2)">Kembali</button>
                    <button type="button" class="btn btn-custom btn-next" onclick="validateAndNext(3, 4)">Next</button>
                </div>
            </div>

            <!-- Slide 4: Informasi Kasus (NEW) -->
            <div class="form-slide" id="slide4">
                <div class="page-indicator"><span class="page-num">4 / 6</span></div>
                <div class="form-badge">Informasi Kasus</div>

                <div class="form-group-custom">
                    <label>Jenis Kasus</label>
                    <select name="jenis_kasus" class="form-control-custom" required>
                        <option value="">-- Pilih --</option>
                        <option value="Perempuan">Perempuan</option>
                        <option value="Anak">Anak</option>
                    </select>
                </div>

                <div class="form-group-custom">
                    <label>Bentuk Kekerasan</label>
                    <select name="bentuk_kekerasan" class="form-control-custom" required>
                        <option value="">-- Pilih --</option>
                        <option value="Fisik">Fisik</option>
                        <option value="Psikologis">Psikologis</option>
                        <option value="Seksual">Seksual</option>
                        <option value="Ekonomi">Ekonomi</option>
                        <option value="Penelantaran">Penelantaran</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>

                <div class="form-group-custom">
                    <label>Dampak Akibat Kekerasan</label>
                    <input type="text" name="dampak_kekerasan" class="form-control-custom" placeholder="Masukkan dampak yang dialami" required>
                </div>

                <div class="form-group-custom">
                    <label>Kronologi Kasus</label>
                    <textarea name="kronologi" class="form-control-custom" style="height: 150px;" placeholder="Ceritakan kronologi kejadian secara singkat..." required></textarea>
                </div>

                <div class="btn-footer">
                    <button type="button" class="btn btn-custom btn-prev" onclick="goToSlide(3)">Kembali</button>
                    <button type="button" class="btn btn-custom btn-next" onclick="validateAndNext(4, 5)">Next</button>
                </div>
            </div>

            <!-- Slide 5: Identitas Pelaku -->
            <div class="form-slide" id="slide5">
                <div class="page-indicator"><span class="page-num">5 / 6</span></div>
                <div class="form-badge">Identitas Pelaku</div>
                <div class="form-group-custom"><label>Nama Lengkap Pelaku</label><input type="text" name="p_nama" class="form-control-custom" required></div>
                <div class="form-group-custom"><label>Pekerjaan Pelaku</label><input type="text" name="p_kerja" class="form-control-custom" required></div>
                <div class="form-group-custom"><label>TTL / Umur Pelaku</label><input type="text" name="p_ttl" class="form-control-custom" required></div>
                <div class="form-group-custom"><label>Alamat Pelaku</label><input type="text" name="p_alamat" class="form-control-custom" required></div>
                <div class="form-group-custom"><label>Hubungan dengan Korban</label><input type="text" name="p_hubungan" class="form-control-custom" required></div>
                <div class="form-group-custom"><label>Status Perkawinan</label><input type="text" name="p_status" class="form-control-custom" required></div>

                <div class="btn-footer">
                    <button type="button" class="btn btn-custom btn-prev" onclick="goToSlide(4)">Kembali</button>
                    <button type="button" class="btn btn-custom btn-next" onclick="validateAndNext(5, 6)">Next</button>
                </div>
            </div>

            <!-- Slide 6: Identitas Pelapor -->
            <div class="form-slide" id="slide6">
                <div class="page-indicator"><span class="page-num">6 / 6</span></div>
                <div class="form-badge">Identitas Pelapor</div>
                <div class="form-group-custom"><label>Nama Lengkap Pelapor</label><input type="text" name="lp_nama" class="form-control-custom" required></div>
                <div class="form-group-custom"><label>NIK Pelapor</label><input type="number" name="lp_nik" class="form-control-custom" required></div>
                <div class="form-group-custom"><label>Tempat Tanggal Lahir</label><input type="text" name="lp_ttl" class="form-control-custom" required></div>
                <div class="form-group-custom"><label>Alamat Pelapor</label><input type="text" name="lp_alamat" class="form-control-custom" required></div>
                <div class="form-group-custom"><label>Kecamatan</label><input type="text" name="lp_kec" class="form-control-custom" required></div>
                <div class="form-group-custom"><label>Kota</label><input type="text" name="lp_kota" class="form-control-custom" required></div>
                <div class="form-group-custom"><label>Hubungan dengan Korban</label><input type="text" name="lp_hubungan" class="form-control-custom" required></div>
                
                <div class="btn-footer">
                    <button type="button" class="btn btn-custom btn-prev" onclick="goToSlide(5)">Kembali</button>
                    <button type="submit" class="btn btn-custom btn-save">Simpan Seluruh Data</button>
                </div>
            </div>

        </form>
    </div>

    <footer>
        <div>2026 DP3AP2KB Kota Padang</div>
        <div>
            <a href="#">Tentang</a> | <a href="#">Bantuan</a>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Logika Notifikasi
        <?php if (session()->getFlashdata('success')) : ?>
            Swal.fire({ icon: 'success', title: 'Berhasil!', text: '<?= session()->getFlashdata('success') ?>', confirmButtonColor: '#244769' });
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')) : ?>
            Swal.fire({ icon: 'error', title: 'Gagal!', text: '<?= session()->getFlashdata('error') ?>', confirmButtonColor: '#244769' });
        <?php endif; ?>

        function validateAndNext(current, next) {
            const currentSlide = document.getElementById('slide' + current);
            const inputs = currentSlide.querySelectorAll('input[required], select[required], textarea[required]');
            let allValid = true;

            inputs.forEach(input => {
                if (!input.value.trim()) {
                    allValid = false;
                    input.style.border = "2px solid #e74c3c";
                } else {
                    input.style.border = "none";
                }
            });

            if (allValid) {
                goToSlide(next);
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Data Belum Lengkap',
                    text: 'Mohon lengkapi semua isian pada form ini.',
                    confirmButtonColor: '#244769'
                });
            }
        }

        function goToSlide(slideIndex) {
            const slides = document.querySelectorAll('.form-slide');
            slides.forEach(slide => slide.classList.remove('active'));
            
            const targetSlide = document.getElementById('slide' + slideIndex);
            if (targetSlide) {
                targetSlide.classList.add('active');
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        }

        document.getElementById('kasusForm').onsubmit = function(e) {
            const inputs = this.querySelectorAll('input[required], select[required], textarea[required]');
            let allValid = true;
            
            inputs.forEach(input => {
                if (!input.value.trim()) { allValid = false; }
            });

            if (!allValid) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Simpan',
                    text: 'Pastikan seluruh data dari Slide 1 sampai Slide 6 telah terisi.',
                    confirmButtonColor: '#244769'
                });
            } else {
                Swal.fire({
                    title: 'Sedang Menyimpan...',
                    text: 'Mohon tunggu sebentar',
                    allowOutsideClick: false,
                    didOpen: () => { Swal.showLoading() }
                });
            }
        };
    </script>
</body>
</html>