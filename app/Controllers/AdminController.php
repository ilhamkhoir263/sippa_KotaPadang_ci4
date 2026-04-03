<?php

namespace App\Controllers;

class AdminController extends BaseController
{
    /**
     * Halaman Utama Dashboard Admin
     * Pengecekan Login & Role sudah ditangani oleh Filters (roleAuth:admin)
     */
    public function index()
    {
        $session = session();
        $db      = \Config\Database::connect();

        // Ambil data role dari session (untuk dikirim ke view jika diperlukan)
        $userRole = trim($session->get('role'));

        // Tangkap input pencarian, filter tahun, dan filter kategori dari URL
        $keyword = $this->request->getGet('keyword');
        $tahun   = $this->request->getGet('tahun');
        $filter_kategori = $this->request->getGet('filter_kategori') ?: 'korban';

        // --- A. STATISTIK UNTUK CARD ---
        
        // 1. Total Kasus Keseluruhan
        $total_kasus = $db->table('kasus')->countAllResults();
        
        // 2. Kasus Hari Ini
        $kasus_hari_ini = $db->table('kasus')
            ->where('DATE(created_at)', date('Y-m-d'))
            ->countAllResults();

        // 3. Kasus Bulan Ini
        $kasus_bulan_ini = $db->table('kasus')
            ->where('MONTH(created_at)', date('m'))
            ->where('YEAR(created_at)', date('Y'))
            ->countAllResults();

        // 4. Kasus Perempuan
        $kasus_perempuan = $db->table('kasus')
            ->where('jenis_kasus', 'Perempuan')
            ->countAllResults();

        // 5. Kasus Anak
        $kasus_anak = $db->table('kasus')
            ->where('jenis_kasus', 'Anak')
            ->countAllResults();

        // --- B. DETAIL DATA KASUS (Join Tabel) ---
        $builder = $db->table('kasus');
        $builder->select('
            kasus.id_kasus, 
            kasus.tanggal_kejadian, 
            kasus.status, 
            kasus.jenis_kasus,
            kasus.bentuk_kekerasan,
            kasus.dampak_kekerasan,
            kasus.kronologi,
            kasus.waktu_kejadian,
            korban.nama_korban, 
            korban.nik as nik_korban,
            korban.jenis_kelamin, 
            korban.alamat as alamat_korban,
            pelaku.nama_lengkap as nama_pelaku, 
            pelaku.pekerjaan as kerja_pelaku,
            pelaku.alamat as alamat_pelaku,
            pelapor.nama_lengkap as nama_pelapor,
            pelapor.nik as nik_pelapor,
            pelapor.hubungan_dengan_korban as hub_pelapor
        ');
        $builder->join('korban', 'korban.id_kasus = kasus.id_kasus', 'left');
        $builder->join('pelaku', 'pelaku.id_kasus = kasus.id_kasus', 'left');
        $builder->join('pelapor', 'pelapor.id_kasus = kasus.id_kasus', 'left');

        if (!empty($tahun)) {
            $builder->where("YEAR(kasus.tanggal_kejadian)", $tahun);
        }

        if (!empty($keyword)) {
            $builder->groupStart()
                    ->like('korban.nama_korban', $keyword)
                    ->orLike('pelaku.nama_lengkap', $keyword)
                    ->orLike('pelapor.nama_lengkap', $keyword)
                    ->orLike('kasus.status', $keyword)
                    ->orLike('kasus.jenis_kasus', $keyword)
                    ->groupEnd();
        }

        $builder->orderBy('kasus.id_kasus', 'DESC');
        $daftar_kasus = $builder->get()->getResultArray();

        $data = [
            'username'         => $session->get('username'),
            'role'             => $userRole,
            'total_kasus'      => $total_kasus,
            'kasus_hari_ini'   => $kasus_hari_ini,
            'kasus_bulan_ini'  => $kasus_bulan_ini,
            'kasus_perempuan'  => $kasus_perempuan,
            'kasus_anak'       => $kasus_anak,
            'daftar_kasus'     => $daftar_kasus,
            'keyword'          => $keyword,
            'tahun_aktif'      => $tahun,
            'kategori_aktif'   => $filter_kategori
        ];

        return view('admin/dashboard', $data);
    }

    /**
     * Detail Kasus
     */
    public function detail($id)
    {
        $session = session();
        $db      = \Config\Database::connect();
        
        $builder = $db->table('kasus');
        $builder->select('
            kasus.*, 
            korban.*, 
            pelaku.nama_lengkap as p_nama, 
            pelaku.pekerjaan as p_kerja, 
            pelaku.ttl_umur as p_ttl, 
            pelaku.alamat as p_alamat, 
            pelaku.hubungan_dengan_korban as p_hubungan, 
            pelaku.status_perkawinan as p_status,
            pelapor.nama_lengkap as lp_nama,
            pelapor.nik as lp_nik,
            pelapor.ttl as lp_ttl,
            pelapor.hubungan_dengan_korban as lp_hubungan
        ');
        $builder->join('korban', 'korban.id_kasus = kasus.id_kasus', 'left');
        $builder->join('pelaku', 'pelaku.id_kasus = kasus.id_kasus', 'left');
        $builder->join('pelapor', 'pelapor.id_kasus = kasus.id_kasus', 'left');
        $builder->where('kasus.id_kasus', $id);
        
        $kasus = $builder->get()->getRowArray();

        if (!$kasus) {
            return redirect()->to('admin/dashboard')->with('error', 'Data tidak ditemukan.');
        }

        $data = [
            'username' => $session->get('username'),
            'role'     => $session->get('role'),
            'kasus'    => $kasus
        ];

        return view('admin/detail_kasus', $data);
    }
}