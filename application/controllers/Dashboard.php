<?php
defined('BASEPATH') or exit('No direct script access allowed');
error_reporting(0);

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$_SESSION['username']) {
            echo "<script>alert('Anda harus login terlebih dahulu untuk dapat mengakses halaman ini'); location.href = '" . base_url() . "login'</script>";
        }
        if ($_SESSION['role'] == 'pasien') {
            echo "<script>alert('Anda tidak memiliki izin untuk mengakses halaman ini'); location.href = '" . base_url() . "feedback'</script>";
        }
    }

    public function index()
    {
        $data = [];
        $data['active'] = 'dashboard';
           
        $this->load->view('v_header', $data);
        $this->load->view('v_dashboard', $data);
        $this->load->view('v_footer');
    }

    #region fakultas
    public function daftar_fakultas()
    {
        $data['datasets'] = $this->db->get('fakultas')->result_array();
        $data['active'] = 'datafakultas';
        $this->load->view('v_header', $data);
        $this->load->view('v_daftar_fakultas');
        $this->load->view('v_footer');
    }

    public function tambah_fakultas()
    {
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $params = $this->input->post();

            if ((int) $params['id'] > 0) {
                $this->db->where('id', $params['id']);
                $this->db->update('fakultas', [
                    'kode' => $params['kode'],
                    'nama' => $params['nama'],
                ]);
            } else {
                $this->db->insert('fakultas', [
                    'kode' => $params['kode'],
                    'nama' => $params['nama'],
                ]);
            }

            echo "<script>alert('Data Fakultas berhasil disimpan'); location.href = '" . base_url() . "dashboard/daftar_fakultas';</script>";
        } else {
            $params = $_REQUEST;
            $data['fetch'] = [];
            $id = $params['id'];
            if ((int) $id > 0) {
                $this->db->where('id', $id);
                $data['fetch'] = $this->db->get('fakultas')->row_array();
            }

            $data['id'] = $id;
            $data['active'] = 'datafakultas';
            $this->load->view('v_header', $data);
            $this->load->view('v_tambah_fakultas');
            $this->load->view('v_footer');
        }
    }

    public function delete_fakultas()
    {
        $params = $_REQUEST;
        $this->db->where('id', $params['id']);
        $this->db->delete('fakultas');

        echo "<script>alert('Data Fakultas berhasil dihapus'); location.href = '" . base_url() . "dashboard/daftar_fakultas';</script>";
    }
    #endregion

    #region pencegahan
    public function daftar_pencegahan()
    {
        $params = $_REQUEST;

        $id_fakultas = (int) $params['id_fakultas'];
        if ($_SESSION['id_fakultas']) {
            $id_fakultas = $_SESSION['id_fakultas'];
            $params['id_fakultas'] = $id_fakultas;
        }

        if ($id_fakultas > 0) {
            $this->db->where('id_fakultas', $params['id_fakultas']);
            $data['datasets'] = $this->db->get('pencegahan')->result_array();
        } else {
            $data['datasets'] = [];
        }
        
        $data['active'] = 'datapencegahan';
        $data['fakultas'] = $this->db->get('fakultas')->result_array();
        $data['id_fakultas'] = $id_fakultas;
        $this->load->view('v_header', $data);
        $this->load->view('v_daftar_pencegahan');
        $this->load->view('v_footer');
    }

    public function tambah_pencegahan()
    {
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $params = $this->input->post();

            $this->db->where('id', $params['id_fakultas']);
            $fakultas = $this->db->get('fakultas')->row_array();

            if ((int) $params['id'] > 0) {
                $this->db->where('id', $params['id']);
                $this->db->update('pencegahan', [
                    'id_fakultas' => $params['id_fakultas'],
                    'nama_fakultas' => $fakultas['nama'],
                    'tanggal_kegiatan' => $params['tanggal_kegiatan'],
                    'nama' => $params['nama'],
                    'jenis' => $params['jenis'],
                    'jumlah_peserta' => $params['jumlah_peserta'],
                    'deskripsi' => $params['deskripsi'],
                ]);

                $dokumentasi = '';
                if ($_FILES['dokumentasi']['name']) {
                    $upload_dir = './assets/upload/';
                    if (!is_dir($upload_dir)) {
                        mkdir($upload_dir, 0755, true);
                    }
                    $temp_file = $_FILES['dokumentasi']['tmp_name'];
                    $original_file = $_FILES['dokumentasi']['name'];

                    $unique_filename = uniqid() . '_' . $original_file;
                    move_uploaded_file($temp_file, $upload_dir . $unique_filename);
                    
                    $dokumentasi = base_url().'assets/upload/'.$unique_filename;

                    $this->db->where('id', $params['id']);
                    $this->db->update('pencegahan', [
                        'dokumentasi' => $dokumentasi,
                    ]);
                }
            } else {
                $dokumentasi = '';
                if ($_FILES['dokumentasi']['name']) {
                    $upload_dir = './assets/upload/';
                    if (!is_dir($upload_dir)) {
                        mkdir($upload_dir, 0755, true);
                    }
                    $temp_file = $_FILES['dokumentasi']['tmp_name'];
                    $original_file = $_FILES['dokumentasi']['name'];

                    $unique_filename = uniqid() . '_' . $original_file;
                    move_uploaded_file($temp_file, $upload_dir . $unique_filename);
                    
                    $dokumentasi = base_url().'assets/upload/'.$unique_filename;
                }

                $this->db->insert('pencegahan', [
                    'id_fakultas' => $params['id_fakultas'],
                    'nama_fakultas' => $fakultas['nama'],
                    'tanggal_kegiatan' => $params['tanggal_kegiatan'],
                    'nama' => $params['nama'],
                    'jenis' => $params['jenis'],
                    'jumlah_peserta' => $params['jumlah_peserta'],
                    'dokumentasi' => $dokumentasi,
                    'deskripsi' => $params['deskripsi'],
                    'timestamp' => date('Y-m-d')
                ]);
            }

            echo "<script>alert('Data Pencegahan berhasil disimpan'); location.href = '" . base_url() . "dashboard/daftar_pencegahan?id_fakultas=".$params['id_fakultas']."';</script>";
        } else {
            $params = $_REQUEST;
            $data['fetch'] = [];
            $id = $params['id'];
            if ((int) $id > 0) {
                $this->db->where('id', $id);
                $data['fetch'] = $this->db->get('pencegahan')->row_array();
            }
            $data['fakultas'] = $this->db->get('fakultas')->result_array();

            if ($params['id_fakultas'] <= 0) {
                echo "<script>alert('Mohon pilih fakultas terlebih dahulu sebelum menambahkan'); location.href = '" . base_url() . "dashboard/daftar_pencegahan';</script>";
            }

            $this->db->where('id', $params['id_fakultas']);
            $fakultas = $this->db->get('fakultas')->row_array();
            if (empty($fakultas)) {
                echo "<script>alert('Data fakultas tidak ditemukan'); location.href = '" . base_url() . "dashboard/daftar_pencegahan';</script>";
            }

            $data['id'] = $id;
            $data['active'] = 'datapencegahan';
            $this->load->view('v_header', $data);
            $this->load->view('v_tambah_pencegahan');
            $this->load->view('v_footer');
        }
    }

    public function delete_pencegahan()
    {
        $params = $_REQUEST;
        $this->db->where('id', $params['id']);
        $this->db->delete('pencegahan');

        echo "<script>alert('Data Pencegahan berhasil dihapus'); location.href = '" . base_url() . "dashboard/daftar_pencegahan?id_fakultas=".$params['id_fakultas']."';</script>";
    }
    #endregion

    #region laporan
    public function daftar_laporan()
    {
        $params = $_REQUEST;
        $id_fakultas = (int) $params['id_fakultas'];
        if ($id_fakultas > 0) {
            $this->db->where('id_fakultas', $params['id_fakultas']);
            $data['datasets'] = $this->db->get('laporan')->result_array();
        } else {
            $data['datasets'] = [];
        }
        
        $data['active'] = 'datapenanganan';
        $data['fakultas'] = $this->db->get('fakultas')->result_array();
        $data['id_fakultas'] = $id_fakultas;
        $this->load->view('v_header', $data);
        $this->load->view('v_daftar_laporan');
        $this->load->view('v_footer');
    }

    public function tambah_laporan()
    {
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $params = $this->input->post();

            $this->db->where('id', $params['id_fakultas']);
            $fakultas = $this->db->get('fakultas')->row_array();

            if ((int) $params['id'] > 0) {
                $this->db->where('id', $params['id']);
                $this->db->update('laporan', [
                    // 'id_fakultas' => $params['id_fakultas'],
                    // 'nama_fakultas' => $fakultas['nama'],
                    'tanggal_kejadian' => $params['tanggal_kejadian'],
                    'pelapor' => $params['pelapor_id'],
                    'pelapor_nama' => $params['pelapor_id'] == 'Orang Lain' ? $params['pelapor_nama'] : $params['korban_nama'],
                    'pelapor_nik' => $params['pelapor_id'] == 'Orang Lain' ? $params['pelapor_nik'] : $params['korban_nik'],
                    'korban_nama' => $params['korban_nama'],
                    'korban_nik' => $params['korban_nik'],
                    'pelaku' => $params['pelaku'],
                    'tingkat_kasus' => $params['tingkat_kasus'],
                    'klasifikasi' => $params['klasifikasi'] ? $params['klasifikasi'] : "",
                    'deskripsi' => $params['deskripsi'],
                ]);

                $lampiran = '';
                if ($_FILES['lampiran']['name']) {
                    $upload_dir = './assets/upload/';
                    if (!is_dir($upload_dir)) {
                        mkdir($upload_dir, 0755, true);
                    }
                    $temp_file = $_FILES['lampiran']['tmp_name'];
                    $original_file = $_FILES['lampiran']['name'];

                    $unique_filename = uniqid() . '_' . $original_file;
                    move_uploaded_file($temp_file, $upload_dir . $unique_filename);
                    
                    $lampiran = base_url().'assets/upload/'.$unique_filename;

                    $this->db->where('id', $params['id']);
                    $this->db->update('laporan', [
                        'lampiran' => $lampiran,
                    ]);
                }
            } else {
                $lampiran = '';
                if ($_FILES['lampiran']['name']) {
                    $upload_dir = './assets/upload/';
                    if (!is_dir($upload_dir)) {
                        mkdir($upload_dir, 0755, true);
                    }
                    $temp_file = $_FILES['lampiran']['tmp_name'];
                    $original_file = $_FILES['lampiran']['name'];

                    $unique_filename = uniqid() . '_' . $original_file;
                    move_uploaded_file($temp_file, $upload_dir . $unique_filename);
                    
                    $lampiran = base_url().'assets/upload/'.$unique_filename;
                }

                $this->db->insert('laporan', [
                    'id_fakultas' => $params['id_fakultas'],
                    'nama_fakultas' => $fakultas['nama'],
                    'tanggal_kejadian' => $params['tanggal_kejadian'],
                    'pelapor' => $params['pelapor_id'],
                    'pelapor_nama' => $params['pelapor_id'] == 'Orang Lain' ? $params['pelapor_nama'] : $params['korban_nama'],
                    'pelapor_nik' => $params['pelapor_id'] == 'Orang Lain' ? $params['pelapor_nik'] : $params['korban_nik'],
                    'korban_nama' => $params['korban_nama'],
                    'korban_nik' => $params['korban_nik'],
                    'pelaku' => $params['pelaku'],
                    'tingkat_kasus' => $params['tingkat_kasus'],
                    'klasifikasi' => $params['klasifikasi'] ? $params['klasifikasi'] : "",
                    'deskripsi' => $params['deskripsi'],
                    'timestamp' => date('Y-m-d'),
                    // 'lampiran' => $lampiran,
                ]);
            }

            echo "<script>alert('Data Laporan berhasil disimpan'); location.href = '" . base_url() . "dashboard/daftar_laporan?id_fakultas=".$params['id_fakultas']."';</script>";
        } else {
            $params = $_REQUEST;
            $data['fetch'] = [];
            $id = $params['id'];
            if ((int) $id > 0) {
                $this->db->where('id', $id);
                $data['fetch'] = $this->db->get('laporan')->row_array();
            }
            $data['fakultas'] = $this->db->get('fakultas')->result_array();

            if ($params['id_fakultas'] <= 0) {
                echo "<script>alert('Mohon pilih fakultas terlebih dahulu sebelum menambahkan'); location.href = '" . base_url() . "dashboard/daftar_laporan';</script>";
            }

            $this->db->where('id', $params['id_fakultas']);
            $fakultas = $this->db->get('fakultas')->row_array();
            if (empty($fakultas)) {
                echo "<script>alert('Data fakultas tidak ditemukan'); location.href = '" . base_url() . "dashboard/daftar_laporan';</script>";
            }

            $data['id'] = $id;
            $data['active'] = 'datapenanganan';
            $this->load->view('v_header', $data);
            $this->load->view('v_tambah_laporan');
            $this->load->view('v_footer');
        }
    }

    public function delete_laporan()
    {
        $params = $_REQUEST;
        $this->db->where('id', $params['id']);
        $this->db->delete('laporan');

        echo "<script>alert('Data Laporan berhasil dihapus'); location.href = '" . base_url() . "dashboard/daftar_laporan?id_fakultas=".$params['id_fakultas']."';</script>";
    }
    #endregion
    
    #region sanksi
    public function daftar_sanksi()
    {
        $params = $_REQUEST;
        $id_fakultas = (int) $params['id_fakultas'];
        if ($id_fakultas > 0) {
            $this->db->where('id_fakultas', $params['id_fakultas']);
            $data['datasets'] = $this->db->get('sanksi')->result_array();
        } else {
            $data['datasets'] = [];
        }
        
        $data['active'] = 'datapenanganan';
        $data['fakultas'] = $this->db->get('fakultas')->result_array();
        $data['id_fakultas'] = $id_fakultas;
        $this->load->view('v_header', $data);
        $this->load->view('v_daftar_sanksi');
        $this->load->view('v_footer');
    }

    public function tambah_sanksi()
    {
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $params = $this->input->post();

            $this->db->where('id', $params['id_fakultas']);
            $fakultas = $this->db->get('fakultas')->row_array();

            if ((int) $params['id'] > 0) {
                $this->db->where('id', $params['id']);
                $this->db->update('sanksi', [
                    // 'id_fakultas' => $params['id_fakultas'],
                    // 'nama_fakultas' => $fakultas['nama'],
                    'kasus' => $params['kasus'],
                    'korban' => $params['korban'],
                    'pelaku' => $params['pelaku'],
                    'sk' => $params['sk'],
                    'sanksi' => $params['sanksi'],
                    'jenis_sanksi' => $params['jenis_sanksi'],
                ]);
            } else {
                $this->db->insert('sanksi', [
                    'id_fakultas' => $params['id_fakultas'],
                    'nama_fakultas' => $fakultas['nama'],
                    'kasus' => $params['kasus'],
                    'korban' => $params['korban'],
                    'pelaku' => $params['pelaku'],
                    'sk' => $params['sk'],
                    'sanksi' => $params['sanksi'],
                    'jenis_sanksi' => $params['jenis_sanksi'],
                    'timestamp' => date('Y-m-d'),
                ]);
            }

            echo "<script>alert('Data Sanksi berhasil disimpan'); location.href = '" . base_url() . "dashboard/daftar_sanksi?id_fakultas=".$params['id_fakultas']."';</script>";
        } else {
            $params = $_REQUEST;
            $data['fetch'] = [];
            $id = $params['id'];
            if ((int) $id > 0) {
                $this->db->where('id', $id);
                $data['fetch'] = $this->db->get('sanksi')->row_array();
            }
            $data['fakultas'] = $this->db->get('fakultas')->result_array();

            if ($params['id_fakultas'] <= 0) {
                echo "<script>alert('Mohon pilih fakultas terlebih dahulu sebelum menambahkan'); location.href = '" . base_url() . "dashboard/daftar_sanksi';</script>";
            }

            $this->db->where('id', $params['id_fakultas']);
            $fakultas = $this->db->get('fakultas')->row_array();
            if (empty($fakultas)) {
                echo "<script>alert('Data fakultas tidak ditemukan'); location.href = '" . base_url() . "dashboard/daftar_sanksi';</script>";
            }

            $data['id'] = $id;
            $data['active'] = 'datapenanganan';
            $this->load->view('v_header', $data);
            $this->load->view('v_tambah_sanksi');
            $this->load->view('v_footer');
        }
    }

    public function delete_sanksi()
    {
        $params = $_REQUEST;
        $this->db->where('id', $params['id']);
        $this->db->delete('sanksi');

        echo "<script>alert('Data Sanksi berhasil dihapus'); location.href = '" . base_url() . "dashboard/daftar_sanksi?id_fakultas=".$params['id_fakultas']."';</script>";
    }
    #endregion

    #region lain_lain
    public function daftar_lain_lain()
    {
        $params = $_REQUEST;
        $id_fakultas = (int) $params['id_fakultas'];
        if ($id_fakultas > 0) {
            $this->db->where('id_fakultas', $params['id_fakultas']);
            $data['datasets'] = $this->db->get('lain_lain')->result_array();
        } else {
            $data['datasets'] = [];
        }
        
        $data['active'] = 'datapenanganan';
        $data['fakultas'] = $this->db->get('fakultas')->result_array();
        $data['id_fakultas'] = $id_fakultas;
        $this->load->view('v_header', $data);
        $this->load->view('v_daftar_lain_lain');
        $this->load->view('v_footer');
    }

    public function tambah_lain_lain()
    {
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $params = $this->input->post();

            $this->db->where('id', $params['id_fakultas']);
            $fakultas = $this->db->get('fakultas')->row_array();

            if ((int) $params['id'] > 0) {
                $this->db->where('id', $params['id']);
                $this->db->update('lain_lain', [
                    // 'id_fakultas' => $params['id_fakultas'],
                    // 'nama_fakultas' => $fakultas['nama'],
                    'tanggal_kejadian' => $params['tanggal_kejadian'],
                    'nama_korban' => $params['nama_korban'],
                    'deskripsi_kasus' => $params['deskripsi_kasus'],
                    'catatan_tambahan' => $params['catatan_tambahan'],
                ]);

                $berita_acara = '';
                if ($_FILES['berita_acara']['name']) {
                    $upload_dir = './assets/upload/';
                    if (!is_dir($upload_dir)) {
                        mkdir($upload_dir, 0755, true);
                    }
                    $temp_file = $_FILES['berita_acara']['tmp_name'];
                    $original_file = $_FILES['berita_acara']['name'];

                    $unique_filename = uniqid() . '_' . $original_file;
                    move_uploaded_file($temp_file, $upload_dir . $unique_filename);
                    
                    $berita_acara = base_url().'assets/upload/'.$unique_filename;

                    $this->db->where('id', $params['id']);
                    $this->db->update('lain_lain', [
                        'berita_acara' => $berita_acara,
                    ]);
                }
            } else {
                $berita_acara = '';
                if ($_FILES['berita_acara']['name']) {
                    $upload_dir = './assets/upload/';
                    if (!is_dir($upload_dir)) {
                        mkdir($upload_dir, 0755, true);
                    }
                    $temp_file = $_FILES['berita_acara']['tmp_name'];
                    $original_file = $_FILES['berita_acara']['name'];

                    $unique_filename = uniqid() . '_' . $original_file;
                    move_uploaded_file($temp_file, $upload_dir . $unique_filename);
                    
                    $berita_acara = base_url().'assets/upload/'.$unique_filename;
                }

                $this->db->insert('lain_lain', [
                    'id_fakultas' => $params['id_fakultas'],
                    'nama_fakultas' => $fakultas['nama'],
                    'tanggal_kejadian' => $params['tanggal_kejadian'],
                    'nama_korban' => $params['nama_korban'],
                    'deskripsi_kasus' => $params['deskripsi_kasus'],
                    'catatan_tambahan' => $params['catatan_tambahan'],
                    'timestamp' => date('Y-m-d'),
                    'berita_acara' => $berita_acara,
                ]);
            }

            echo "<script>alert('Data Laporan berhasil disimpan'); location.href = '" . base_url() . "dashboard/daftar_lain_lain?id_fakultas=".$params['id_fakultas']."';</script>";
        } else {
            $params = $_REQUEST;
            $data['fetch'] = [];
            $id = $params['id'];
            if ((int) $id > 0) {
                $this->db->where('id', $id);
                $data['fetch'] = $this->db->get('lain_lain')->row_array();
            }
            $data['fakultas'] = $this->db->get('fakultas')->result_array();

            if ($params['id_fakultas'] <= 0) {
                echo "<script>alert('Mohon pilih fakultas terlebih dahulu sebelum menambahkan'); location.href = '" . base_url() . "dashboard/daftar_lain_lain';</script>";
            }

            $this->db->where('id', $params['id_fakultas']);
            $fakultas = $this->db->get('fakultas')->row_array();
            if (empty($fakultas)) {
                echo "<script>alert('Data fakultas tidak ditemukan'); location.href = '" . base_url() . "dashboard/daftar_lain_lain';</script>";
            }

            $data['id'] = $id;
            $data['active'] = 'datapenanganan';
            $this->load->view('v_header', $data);
            $this->load->view('v_tambah_lain_lain');
            $this->load->view('v_footer');
        }
    }

    public function delete_lain_lain()
    {
        $params = $_REQUEST;
        $this->db->where('id', $params['id']);
        $this->db->delete('lain_lain');

        echo "<script>alert('Data Laporan berhasil dihapus'); location.href = '" . base_url() . "dashboard/daftar_lain_lain?id_fakultas=".$params['id_fakultas']."';</script>";
    }
    #endregion

    #region pemulihan
    public function daftar_pemulihan()
    {
        $params = $_REQUEST;

        $id_fakultas = (int) $params['id_fakultas'];
        if ($_SESSION['id_fakultas']) {
            $id_fakultas = $_SESSION['id_fakultas'];
            $params['id_fakultas'] = $id_fakultas;
        }

        $id_fakultas = (int) $params['id_fakultas'];
        if ($id_fakultas > 0) {
            $this->db->where('id_fakultas', $params['id_fakultas']);
            $data['datasets'] = $this->db->get('pemulihan')->result_array();
        } else {
            $data['datasets'] = [];
        }
        
        $data['active'] = 'datapemulihan';
        $data['fakultas'] = $this->db->get('fakultas')->result_array();
        $data['id_fakultas'] = $id_fakultas;
        $this->load->view('v_header', $data);
        $this->load->view('v_daftar_pemulihan');
        $this->load->view('v_footer');
    }

    public function tambah_pemulihan()
    {
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $params = $this->input->post();

            $this->db->where('id', $params['id_fakultas']);
            $fakultas = $this->db->get('fakultas')->row_array();

            if ((int) $params['id'] > 0) {
                if ($_SESSION['role'] == 'wali') {
                    $this->db->where('id', $params['id']);
                    $this->db->update('pemulihan', [
                        'laporan_hasil' => $params['laporan_hasil'],
                    ]);
                } else {
                    $this->db->where('id', $params['id']);
                    $this->db->update('pemulihan', [
                        // 'id_fakultas' => $params['id_fakultas'],
                        // 'nama_fakultas' => $fakultas['nama'],
                        'korban' => $params['korban'],
                        'laporan_hasil' => $params['laporan_hasil'],
                        'sk' => $params['sk'],
                        'deskripsi_kasus' => $params['deskripsi_kasus'],
                    ]);
                }

                $berita_acara = '';
                if ($_FILES['berita_acara']['name']) {
                    $upload_dir = './assets/upload/';
                    if (!is_dir($upload_dir)) {
                        mkdir($upload_dir, 0755, true);
                    }
                    $temp_file = $_FILES['berita_acara']['tmp_name'];
                    $original_file = $_FILES['berita_acara']['name'];

                    $unique_filename = uniqid() . '_' . $original_file;
                    move_uploaded_file($temp_file, $upload_dir . $unique_filename);
                    
                    $berita_acara = base_url().'assets/upload/'.$unique_filename;

                    $this->db->where('id', $params['id']);
                    $this->db->update('pemulihan', [
                        'berita_acara' => $berita_acara,
                    ]);
                }

                $lampiran = '';
                if ($_FILES['lampiran']['name']) {
                    $upload_dir = './assets/upload/';
                    if (!is_dir($upload_dir)) {
                        mkdir($upload_dir, 0755, true);
                    }
                    $temp_file = $_FILES['lampiran']['tmp_name'];
                    $original_file = $_FILES['lampiran']['name'];

                    $unique_filename = uniqid() . '_' . $original_file;
                    move_uploaded_file($temp_file, $upload_dir . $unique_filename);
                    
                    $lampiran = base_url().'assets/upload/'.$unique_filename;

                    $this->db->where('id', $params['id']);
                    $this->db->update('pemulihan', [
                        'lampiran' => $lampiran,
                    ]);
                }
            } else {
                $berita_acara = '';
                if ($_FILES['berita_acara']['name']) {
                    $upload_dir = './assets/upload/';
                    if (!is_dir($upload_dir)) {
                        mkdir($upload_dir, 0755, true);
                    }
                    $temp_file = $_FILES['berita_acara']['tmp_name'];
                    $original_file = $_FILES['berita_acara']['name'];

                    $unique_filename = uniqid() . '_' . $original_file;
                    move_uploaded_file($temp_file, $upload_dir . $unique_filename);
                    
                    $berita_acara = base_url().'assets/upload/'.$unique_filename;
                }

                $lampiran = '';
                if ($_FILES['lampiran']['name']) {
                    $upload_dir = './assets/upload/';
                    if (!is_dir($upload_dir)) {
                        mkdir($upload_dir, 0755, true);
                    }
                    $temp_file = $_FILES['lampiran']['tmp_name'];
                    $original_file = $_FILES['lampiran']['name'];

                    $unique_filename = uniqid() . '_' . $original_file;
                    move_uploaded_file($temp_file, $upload_dir . $unique_filename);
                    
                    $lampiran = base_url().'assets/upload/'.$unique_filename;
                }

                $this->db->insert('pemulihan', [
                    'id_fakultas' => $params['id_fakultas'],
                    'nama_fakultas' => $fakultas['nama'],
                    'korban' => $params['korban'],
                    'laporan_hasil' => $params['laporan_hasil'],
                    'sk' => $params['sk'],
                    'deskripsi_kasus' => $params['deskripsi_kasus'],
                    'timestamp' => date('Y-m-d'),
                    'berita_acara' => $berita_acara,
                    'lampiran' => $lampiran,
                ]);
            }

            echo "<script>alert('Data Laporan berhasil disimpan'); location.href = '" . base_url() . "dashboard/daftar_pemulihan?id_fakultas=".$params['id_fakultas']."';</script>";
        } else {
            $params = $_REQUEST;
            $data['fetch'] = [];
            $id = $params['id'];
            if ((int) $id > 0) {
                $this->db->where('id', $id);
                $data['fetch'] = $this->db->get('pemulihan')->row_array();
            }
            $data['fakultas'] = $this->db->get('fakultas')->result_array();

            if ($params['id_fakultas'] <= 0) {
                echo "<script>alert('Mohon pilih fakultas terlebih dahulu sebelum menambahkan'); location.href = '" . base_url() . "dashboard/daftar_pemulihan';</script>";
            }

            $this->db->where('id', $params['id_fakultas']);
            $fakultas = $this->db->get('fakultas')->row_array();
            if (empty($fakultas)) {
                echo "<script>alert('Data fakultas tidak ditemukan'); location.href = '" . base_url() . "dashboard/daftar_pemulihan';</script>";
            }

            $data['id'] = $id;
            $data['active'] = 'datapemulihan';
            $this->load->view('v_header', $data);
            $this->load->view('v_tambah_pemulihan');
            $this->load->view('v_footer');
        }
    }

    public function delete_pemulihan()
    {
        $params = $_REQUEST;
        $this->db->where('id', $params['id']);
        $this->db->delete('pemulihan');

        echo "<script>alert('Data Laporan berhasil dihapus'); location.href = '" . base_url() . "dashboard/daftar_pemulihan?id_fakultas=".$params['id_fakultas']."';</script>";
    }
    #endregion

    #region user
    public function daftar_user()
    {
        $data['datasets'] = $this->db->query(
            'SELECT users.*, pegawai.nama_pegawai as nama, pegawai.nip_pegawai as nip, pegawai.jabatan_detil as jabatan_detil, divisi.nama_divisi as divisi, jabatan.nama_jabatan as jabatan
            FROM users 
            JOIN pegawai ON pegawai.id = users.id_pegawai
            JOIN divisi ON divisi.id = pegawai.divisi_id
            JOIN jabatan ON jabatan.id = pegawai.jabatan_id
            WHERE users.role != "admin" '
        )->result_array();
        $data['active'] = 'datauser';
        $this->load->view('v_header', $data);
        $this->load->view('v_daftar_user');
        $this->load->view('v_footer');
    }

    public function tambah_user()
    {
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $params = $this->input->post();

            if ($_FILES['foto']['name']) {
                $upload_dir = './assets/upload/avatar/';

                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0755, true);
                }

                $temp_file = $_FILES['foto']['tmp_name'];
                $original_file = $_FILES['foto']['name'];

                $unique_filename = uniqid() . '_' . $original_file;
                if (move_uploaded_file($temp_file, $upload_dir . $unique_filename)) {
                    // echo "File uploaded successfully!";
                } else {
                    // echo "Error uploading file.";
                }
            } else {
                // echo "No file uploaded or an error occurred.";
            }

            if ($unique_filename) {
                if ((int) $params['id'] > 0) {
                    $input = [
                        'email' => $params['email'],
                        'username' => $params['username'],
                        'password' => md5($params['password']),
                        'foto' => $unique_filename,
                        'role' => $params['role'],
                        'id_pegawai' => $params['id_pegawai'],
                    ];
                    if (empty($params['password'])) {
                        unset($input['password']);
                    }

                    $this->db->where('id', $params['id']);
                    $this->db->update('users', $input);
                } else {
                    $this->db->insert('users', [
                        'email' => $params['email'],
                        'username' => $params['username'],
                        'password' => md5($params['password']),
                        'foto' => $unique_filename,
                        'role' => $params['role'],
                        'id_pegawai' => $params['id_pegawai'],
                    ]);
                }
            } else {
                if ((int) $params['id'] > 0) {
                    $input = [
                        'email' => $params['email'],
                        'username' => $params['username'],
                        'password' => md5($params['password']),
                        'role' => $params['role'],
                        'id_pegawai' => $params['id_pegawai'],
                    ];
                    if (empty($params['password'])) {
                        unset($input['password']);
                    }

                    $this->db->where('id', $params['id']);
                    $this->db->update('users', $input);
                } else {
                    $this->db->insert('users', [
                        'email' => $params['email'],
                        'username' => $params['username'],
                        'password' => md5($params['password']),
                        'foto' => 'default.jpg',
                        'role' => $params['role'],
                        'id_pegawai' => $params['id_pegawai'],
                    ]);
                }
            }

            echo "<script>alert('Data berhasil disimpan'); location.href = '" . base_url() . "dashboard/daftar_user';</script>";
        } else {
            $params = $_REQUEST;
            $data['fetch'] = [];
            $id = $params['id'];
            if ((int) $id > 0) {
                $this->db->where('id', $id);
                $data['fetch'] = $this->db->get('users')->row_array();
            }

            $data['id'] = $id;
            $data['active'] = 'datauser';
            $data['pegawai'] = $this->db->query(
                'SELECT pegawai.* FROM pegawai
                LEFT JOIN users ON users.id_pegawai = pegawai.id
                WHERE users.id IS NULL'
            )->result_array();
            $data['pegawai2'] = $this->db->get('pegawai')->result_array();
            $this->load->view('v_header', $data);
            $this->load->view('v_tambah_user');
            $this->load->view('v_footer');
        }
    }

    public function delete_user()
    {
        $params = $_REQUEST;
        $this->db->where('id', $params['id']);
        $this->db->delete('users');

        echo "<script>alert('Dataset berhasil dihapus'); location.href = '" . base_url() . "dashboard/daftar_user';</script>";
    }
    #endregion

    public function import()
    {
        $upload_success = false;
        $file_ext = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
        if ($file_ext == "csv") {
            $upload_success = true;
        }
        if ($upload_success) {
            $file = fopen($_FILES['file']['tmp_name'], "r");
            $excel_data = explode("\r", reset(fgetcsv($file)));
            // var_dump($excel_data);
            // exit;
            while (($arr = fgetcsv($file)) !== false) {
                if ($arr[2] == 'positif') {
                    $label = '1';
                } elseif ($arr[2] == 'negatif') {
                    $label = '0';
                } else {
                    $label = '2';
                }
                $this->db->insert('datasets', [
                    'text' => $arr[1],
                    'label' => $label,
                    'pre_processing_text' => '',
                    'predicted_label' => 0
                ]);
            }
            echo "<script>alert('Dataset berhasil disimpan'); location.href = '" . base_url() . "dashboard/daftar_dataset';</script>";
        } else {
            echo "<script>alert('Dataset gagal disimpan, pastikan format import .csv dan data sudah terisi semua'); location.href = '" . base_url() . "dashboard/daftar_dataset';</script>";
        }
    }

    public function import2()
    {
        $upload_success = false;
        $file_ext = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
        if ($file_ext == "csv") {
            $upload_success = true;
        }
        if ($upload_success) {
            $file = fopen($_FILES['file']['tmp_name'], "r");
            $excel_data = explode("\r", reset(fgetcsv($file)));
            // var_dump($excel_data);
            // exit;
            while (($arr = fgetcsv($file)) !== false) {
                if ($arr[2] == 'positif') {
                    $label = '1';
                } elseif ($arr[2] == 'negatif') {
                    $label = '0';
                } else {
                    $label = '2';
                }
                $this->db->insert('datalatih', [
                    'text' => $arr[1],
                    'label' => $label,
                    'pre_processing_text' => '',
                    'predicted_label' => 0
                ]);
            }
            echo "<script>alert('Data Latih berhasil disimpan'); location.href = '" . base_url() . "dashboard/daftar_datalatih';</script>";
        } else {
            echo "<script>alert('Data Latih gagal disimpan, pastikan format import .csv dan data sudah terisi semua'); location.href = '" . base_url() . "dashboard/daftar_datalatih';</script>";
        }
    }

    public function data_admin()
    {
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $foto = '';
            if ($_FILES['foto']['name']) {
                $upload_dir = './assets/upload/avatar/';

                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0755, true);
                }

                $temp_file = $_FILES['foto']['tmp_name'];
                $original_file = $_FILES['foto']['name'];

                $unique_filename = uniqid() . '_' . $original_file;
                if (move_uploaded_file($temp_file, $upload_dir . $unique_filename)) {
                    // echo "File uploaded successfully!";
                } else {
                    // echo "Error uploading file.";
                }
            } else {
                // echo "No file uploaded or an error occurred.";
            }

            $params = $this->input->post();
            if ($unique_filename) {
                $this->db->where('id', $_SESSION['id']);
                $this->db->update('users', [
                    'email' => $params['email'],
                    'username' => $params['username'],
                    'password' => md5($params['password']),
                    'foto' => $unique_filename
                ]);
                $_SESSION['email'] = $params['email'];
                $_SESSION['username'] = $params['username'];
                $_SESSION['password'] = $params['password'];
                $_SESSION['foto'] = $unique_filename;
            } else {
                $this->db->where('id', $_SESSION['id']);
                $this->db->update('users', [
                    'email' => $params['email'],
                    'username' => $params['username'],
                    'password' => md5($params['password']),
                ]);
                $_SESSION['email'] = $params['email'];
                $_SESSION['username'] = $params['username'];
                $_SESSION['password'] = $params['password'];
            }

            echo "<script>alert('Data berhasil disimpan'); location.href = '" . base_url() . "dashboard/data_admin';</script>";
        } else {
            $data['active'] = 'data_admin';
            $this->load->view('v_header', $data);
            $this->load->view('v_data_admin');
            $this->load->view('v_footer');
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('/login', 'refresh');
    }
}
