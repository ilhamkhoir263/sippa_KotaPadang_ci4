<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Detail Kasus Admin') ?></title>
    
    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        body { 
            background-color: #ebf3fc; 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            padding-bottom: 50px; 
        }
        .navbar-custom { 
            background: white; 
            box-shadow: 0 2px 4px rgba(0,0,0,0.05); 
        }
        .card-detail { 
            border: none; 
            border-radius: 12px; 
            box-shadow: 0 4px 12px rgba(0,0,0,0.05); 
            margin-bottom: 25px; 
            background: white;
        }
        .section-title { 
            border-left: 4px solid #0d6efd; 
            padding-left: 15px; 
            margin-bottom: 20px; 
            font-weight: bold; 
            color: #333; 
        }
        /* Style Tabel Custom */
        .table-detail {
            margin-bottom: 0;
        }
        .table-detail td {
            padding: 12px 8px;
            border-bottom: 1px solid #f1f1f1;
            font-size: 14px;
        }
        .label-cell { 
            color: #777; 
            width: 35%;
            font-weight: 500;
        }
        .value-cell { 
            font-weight: 600; 
            color: #333; 
        }
        .badge-status { 
            background: #00ced1; 
            color: white; 
            padding: 6px 18px; 
            border-radius: 5px; 
            font-weight: 500;
        }
        .bg-light-custom {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            border: 1px solid #eee;
        }

        /* Print Settings */
        @media print {
            .no-print, .navbar-custom, .btn-outline-secondary, .btn-action-export {
                display: none !important;
            }
            body { background-color: white !important; padding: 0; }
            .container { max-width: 100% !important; width: 100% !important; }
            .card-detail { box-shadow: none !important; border: 1px solid #eee !important; }
        }
    </style>
</head>
<body>

<!-- Header Navigation -->
<nav class="navbar navbar-expand-lg navbar-custom py-3 mb-4">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="#">
            <img src="<?= base_url('assets/img/logo.png') ?>" alt="Logo" width="40" class="me-2">
            <span class="fw-bold" style="font-size: 14px;">DP3AP2KB KOTA PADANG (ADMIN)</span>
        </a>
        <div class="d-flex gap-2">
            <button onclick="exportToExcel()" class="btn btn-success btn-sm btn-action-export">
                <i class="fa fa-file-excel me-1"></i>Unduh Excel
            </button>
            <button onclick="window.print()" class="btn btn-danger btn-sm btn-action-export">
                <i class="fa fa-file-pdf me-1"></i> Cetak PDF
            </button>
            <!-- Tombol kembali diarahkan ke dashboard admin -->
            <a href="<?= base_url('admin/dashboard') ?>" class="btn btn-outline-secondary btn-sm">
                <i class="fa fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>
</nav>

<div class="container" id="printableArea">
    <!-- Title Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold m-0">Detail Informasi Kasus</h4>
        <span class="badge-status">Status: <?= esc($kasus['status']) ?></span>
    </div>

    <div class="row">
        <!-- 1. INFORMASI KEJADIAN (TABEL) -->
        <div class="col-md-6">
            <div class="card card-detail p-4 h-100">
                <h5 class="section-title">I. Informasi Kejadian</h5>
                <table class="table table-detail">
                    <tr>
                        <td class="label-cell">Hari / Tanggal</td>
                        <td class="value-cell"><?= esc($kasus['hari'] ?? '-') ?>, <?= date('d/m/Y', strtotime($kasus['tanggal_kejadian'])) ?></td>
                    </tr>
                    <tr>
                        <td class="label-cell">Waktu Kejadian</td>
                        <td class="value-cell"><?= esc($kasus['waktu_kejadian']) ?></td>
                    </tr>
                    <tr>
                        <td class="label-cell">Dibuat Pada</td>
                        <td class="value-cell"><?= date('d/m/Y H:i', strtotime($kasus['created_at'])) ?></td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- 2. IDENTITAS KORBAN (TABEL) -->
        <div class="col-md-6">
            <div class="card card-detail p-4 h-100">
                <h5 class="section-title">II. Identitas Korban</h5>
                <table class="table table-detail">
                    <tr>
                        <td class="label-cell">Nama Korban</td>
                        <td class="value-cell"><?= esc($kasus['nama_korban']) ?></td>
                    </tr>
                    <tr>
                        <td class="label-cell">NIK</td>
                        <td class="value-cell"><?= esc($kasus['nik']) ?></td>
                    </tr>
                    <tr>
                        <td class="label-cell">Tempat/Tanggal Lahir</td>
                        <td class="value-cell"><?= esc($kasus['ttl']) ?></td>
                    </tr>
                    <tr>
                        <td class="label-cell">Alamat</td>
                        <td class="value-cell"><?= esc($kasus['alamat']) ?>, Kec. <?= esc($kasus['kecamatan']) ?></td>
                    </tr>
                    <tr>
                        <td class="label-cell">Jenis Kelamin</td>
                        <td class="value-cell"><?= esc($kasus['jenis_kelamin']) ?></td>
                    </tr>
                    <tr>
                        <td class="label-cell">Agama</td>
                        <td class="value-cell"><?= esc($kasus['agama']) ?></td>
                    </tr>
                    <tr>
                        <td class="label-cell">Usia Saat Kejadian</td>
                        <td class="value-cell"><?= esc($kasus['usia_saat_kejadian']) ?></td>
                    </tr>
                    <tr>
                        <td class="label-cell">Pendidikan/Pekerjaan</td>
                        <td class="value-cell"><?= esc($kasus['pendidikan_pekerjaan']) ?></td>
                    </tr>
                    <tr>
                        <td class="label-cell">No Hp</td>
                        <td class="value-cell"><?= esc($kasus['no_hp']) ?></td>
                    </tr>
                    <tr>
                        <td class="label-cell">Suku</td>
                        <td class="value-cell"><?= esc($kasus['suku']) ?></td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- 3. INFORMASI KASUS -->
        <div class="col-12">
            <div class="card card-detail p-4">
                <h5 class="section-title">III. Detail Kasus & Kronologi</h5>
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-detail">
                            <tr>
                                <td class="label-cell">Jenis Kasus</td>
                                <td class="value-cell"><span class="text-primary"><?= esc($kasus['jenis_kasus']) ?></span></td>
                            </tr>
                            <tr>
                                <td class="label-cell">Bentuk Kekerasan</td>
                                <td class="value-cell"><?= esc($kasus['bentuk_kekerasan']) ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-detail">
                            <tr>
                                <td class="label-cell">Dampak Kekerasan</td>
                                <td class="value-cell"><?= esc($kasus['dampak_kekerasan']) ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-12 mt-3">
                        <p class="label-info fw-bold">Kronologi Kejadian:</p>
                        <div class="bg-light-custom">
                            <p class="mb-0" style="text-align: justify; line-height: 1.6; color: #444;">
                                <?= nl2br(esc($kasus['kronologi'])) ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 4. IDENTITAS PELAKU -->
        <div class="col-md-12">
            <div class="card card-detail p-4">
                <h5 class="section-title">IV. Data Pelaku</h5>
                <div class="table-responsive">
                    <table class="table table-bordered text-center" style="font-size: 14px;" id="tablePelakuExport">
                        <thead class="table-light">
                            <tr>
                                <th>Nama Pelaku</th>
                                <th>Pekerjaan</th>
                                <th>Tempat Tanggal Lahir</th>
                                <th>Alamat</th>
                                <th>Hubungan dengan Korban</th>
                                <th>Status Perkawinan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="value-cell"><?= esc($kasus['p_nama'] ?? '-') ?></td>
                                <td><?= esc($kasus['p_kerja'] ?? '-') ?></td>
                                <td><?= esc($kasus['p_ttl'] ?? '-') ?></td>
                                <td><?= esc($kasus['p_alamat'] ?? '-') ?></td>
                                <td><?= esc($kasus['p_hubungan'] ?? '-') ?></td>
                                <td><?= esc($kasus['p_status'] ?? '-') ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- 5. DATA PELAPOR -->
        <div class="col-md-12">
            <div class="card card-detail p-4">
                <h5 class="section-title">V. Data Pelapor</h5>
                <div class="table-responsive">
                    <table class="table table-bordered text-center" style="font-size: 14px;" id="tablePelaporExport">
                        <thead class="table-light">
                            <tr>
                                <th>Nama Lengkap Pelapor</th>
                                <th>NIK Pelapor</th>
                                <th>Tempat Tanggal Lahir</th>
                                <th>Alamat</th>
                                <th>Hubungan dengan Korban</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="value-cell"><?= esc($kasus['lp_nama'] ?? '-') ?></td>
                                <td><?= esc($kasus['lp_nik'] ?? '-') ?></td>
                                <td><?= esc($kasus['lp_ttl'] ?? '-') ?></td>
                                <td class="value-cell"><?= esc($kasus['alamat']) ?>, Kec. <?= esc($kasus['kecamatan']) ?></td>
                                <td><?= esc($kasus['lp_hubungan'] ?? '-') ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Bootstrap Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
function exportToExcel() {
    const table = document.getElementById("printableArea");
    const html = table.outerHTML;
    
    // Menambahkan Header Meta agar Excel mengenali UTF-8 (mencegah karakter aneh)
    const header = "<html xmlns:o='urn:schemas-microsoft-com:office:office' xmlns:x='urn:schemas-microsoft-com:office:excel' xmlns='http://www.w3.org/TR/REC-html40'><head><meta charset='utf-8'></head><body>";
    const footer = "</body></html>";
    
    const finalHtml = header + html + footer;

    const url = 'data:application/vnd.ms-excel;base64,' + window.btoa(unescape(encodeURIComponent(finalHtml)));
    const link = document.createElement("a");
    link.download = "Detail_Kasus_<?= esc($kasus['nama_korban']) ?>.xls";
    link.href = url;
    link.click();
}
</script>

</body>
</html>