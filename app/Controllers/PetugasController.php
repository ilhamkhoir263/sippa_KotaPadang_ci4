<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class PetugasController extends BaseController
{
    /**
     * Menampilkan Dashboard Petugas
     * Proteksi sudah ditangani oleh Filter roleAuth:petugas
     */
    public function index()
    {
        $session = session();
        $userRole = trim($session->get('role'));

        $data = [
            'username' => $session->get('username'),
            'role'     => $userRole
        ];

        return view('petugas/dashboard', $data);
    }

    /**
     * Menampilkan Halaman Input Kasus
     */
    public function input_Kasus()
    {
        $session = session();
        
        return view('petugas/input_kasus', [
            'username' => $session->get('username'),
            'role'     => $session->get('role')
        ]);
    }

    /**
     * Menampilkan Halaman Rekap Laporan Kasus
     */
    public function rekap_laporan()
    {
        $session = session();
        $db = \Config\Database::connect();
        
        // Query Gabungan tabel kasus dan korban
        $builder = $db->table('kasus');
        $builder->select('kasus.*, korban.nama_korban, korban.nik');
        $builder->join('korban', 'korban.id_kasus = kasus.id_kasus', 'left');
        $builder->orderBy('kasus.created_at', 'DESC');
        
        $query = $builder->get();

        $data = [
            'username' => $session->get('username'),
            'role'     => $session->get('role'),
            'kasus'    => $query->getResultArray(),
            'title'    => 'Dashboard Rekap Laporan Kasus'
        ];

        return view('petugas/rekap_laporan', $data);
    }

    /**
     * Menampilkan Detail Lengkap Kasus (Output dari 4 Tabel)
     */
    public function detail_kasus($id_kasus)
    {
        $session = session();
        $db = \Config\Database::connect();

        // Mengambil data dengan join 4 tabel
        $builder = $db->table('kasus');
        $builder->select('
            kasus.*, 
            korban.*, 
            pelaku.nama_lengkap as p_nama, pelaku.pekerjaan as p_kerja, pelaku.ttl_umur as p_ttl, pelaku.alamat as p_alamat, pelaku.hubungan_dengan_korban as p_hubungan, pelaku.status_perkawinan as p_status,
            pelapor.nama_lengkap as lp_nama, pelapor.nik as lp_nik, pelapor.ttl as lp_ttl, pelapor.alamat as lp_alamat, pelapor.kecamatan as lp_kec, pelapor.kota as lp_kota, pelapor.hubungan_dengan_korban as lp_hubungan
        ');
        $builder->join('korban', 'korban.id_kasus = kasus.id_kasus', 'left');
        $builder->join('pelaku', 'pelaku.id_kasus = kasus.id_kasus', 'left');
        $builder->join('pelapor', 'pelapor.id_kasus = kasus.id_kasus', 'left');
        $builder->where('kasus.id_kasus', $id_kasus);
        
        $dataKasus = $builder->get()->getRowArray();

        if (!$dataKasus) {
            return redirect()->to('/petugas/rekap_laporan')->with('error', 'Data tidak ditemukan.');
        }

        $data = [
            'username' => $session->get('username'),
            'role'     => $session->get('role'),
            'title'    => 'Detail Laporan Kasus',
            'kasus'    => $dataKasus
        ];

        return view('petugas/detail_kasus', $data);
    }

    /**
     * Memproses Penyimpanan Data ke 4 Tabel (kasus, korban, pelaku, pelapor)
     */
    public function simpan_Kasus()
    {
        $session = session();
        
        // Validasi Input Dasar
        if (!$this->request->getPost('tgl_kejadian') || !$this->request->getPost('k_nama')) {
            return redirect()->back()->withInput()->with('error', 'Data wajib (Tanggal & Nama Korban) tidak boleh kosong.');
        }

        $db = \Config\Database::connect();
        
        // Mulai Transaksi untuk menjamin data tersimpan di semua tabel atau tidak sama sekali
        $db->transBegin();

        try {
            // A. Insert ke Tabel 'kasus'
            $dataKasus = [
                'hari'             => $this->request->getPost('hari'),
                'tanggal_kejadian' => $this->request->getPost('tgl_kejadian'),
                'waktu_kejadian'   => $this->request->getPost('waktu_kejadian'),
                'jenis_kasus'      => $this->request->getPost('jenis_kasus'),
                'bentuk_kekerasan' => $this->request->getPost('bentuk_kekerasan'),
                'dampak_kekerasan' => $this->request->getPost('dampak_kekerasan'),
                'kronologi'        => $this->request->getPost('kronologi'),
                'status'           => 'Proses',
                'created_at'       => date('Y-m-d H:i:s')
            ];
            
            $db->table('kasus')->insert($dataKasus);
            $idKasus = $db->insertID();

            if (!$idKasus || $idKasus == 0) {
                throw new \Exception("ID Kasus tidak berhasil dihasilkan.");
            }

            // B. Insert ke Tabel 'korban'
            $dataKorban = [
                'id_kasus'             => $idKasus,
                'nama_korban'          => $this->request->getPost('k_nama'),
                'nik'                  => $this->request->getPost('k_nik'),
                'ttl'                  => $this->request->getPost('k_ttl'),
                'alamat'               => $this->request->getPost('k_alamat'),
                'kecamatan'            => $this->request->getPost('k_kecamatan'),
                'kelurahan'            => $this->request->getPost('k_kelurahan'),
                'jenis_kelamin'        => $this->request->getPost('k_jk'),
                'agama'                => $this->request->getPost('k_agama'),
                'usia_saat_kejadian'   => $this->request->getPost('k_usia'),
                'pendidikan_pekerjaan' => $this->request->getPost('k_kerja'),
                'no_hp'                => $this->request->getPost('k_nohp'),
                'suku'                 => $this->request->getPost('k_suku'),
                'nama_ortu_wali'       => $this->request->getPost('k_ortu'),
                'alamat_ortu_wali'     => $this->request->getPost('k_alamat_ortu'),
                'no_hp_ortu_wali'      => $this->request->getPost('k_hp_ortu')
            ];
            $db->table('korban')->insert($dataKorban);

            // C. Insert ke Tabel 'pelaku'
            $dataPelaku = [
                'id_kasus'               => $idKasus,
                'nama_lengkap'           => $this->request->getPost('p_nama'),
                'pekerjaan'              => $this->request->getPost('p_kerja'),
                'ttl_umur'               => $this->request->getPost('p_ttl'),
                'alamat'                 => $this->request->getPost('p_alamat'),
                'hubungan_dengan_korban' => $this->request->getPost('p_hubungan'),
                'status_perkawinan'      => $this->request->getPost('p_status')
            ];
            $db->table('pelaku')->insert($dataPelaku);

            // D. Insert ke Tabel 'pelapor'
            $dataPelapor = [
                'id_kasus'               => $idKasus,
                'nama_lengkap'           => $this->request->getPost('lp_nama'),
                'nik'                    => $this->request->getPost('lp_nik'),
                'ttl'                    => $this->request->getPost('lp_ttl'),
                'alamat'                 => $this->request->getPost('lp_alamat'),
                'kecamatan'              => $this->request->getPost('lp_kec'),
                'kota'                   => $this->request->getPost('lp_kota'),
                'hubungan_dengan_korban' => $this->request->getPost('lp_hubungan')
            ];
            $db->table('pelapor')->insert($dataPelapor);

            // Cek Status Transaksi
            if ($db->transStatus() === FALSE) {
                $db->transRollback();
                return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data ke database.');
            } else {
                $db->transCommit();
                return redirect()->to('/petugas/rekap_laporan')->with('success', 'Data kasus berhasil disimpan!');
            }

        } catch (\Exception $e) {
            $db->transRollback();
            return redirect()->back()->withInput()->with('error', 'Kesalahan: ' . $e->getMessage());
        }
    }
}