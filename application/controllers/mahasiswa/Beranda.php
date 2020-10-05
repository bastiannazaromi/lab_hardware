<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Beranda extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (empty($this->session->userdata('user_login'))) {
            $this->session->set_flashdata('flash-error', 'Anda Belum Login');
            redirect('login', 'refresh');
        }

        $this->load->model('M_Mahasiswa', 'mahasiswa');
        $this->load->model('M_Stok', 'stok');
        $this->load->model('M_Pinjam', 'pinjam');

        if ($this->session->userdata('status') == "Dosen") {
            redirect('dosen/beranda');
        }
    }

    public function index()
    {
        $nim = $this->session->userdata('nim');
        cek_biodata($nim);

        $data['title'] = 'LAB HARDWARE';

        $data['mahasiswa'] = $this->mahasiswa->getOne($nim);
        $data['kategori'] = $this->stok->getKategori();
        $data['pinjaman'] = $this->pinjam->getAllMahasiswa($nim);

        $data['page'] = 'frontend/mahasiswa/beranda';

        $this->load->view('frontend/mahasiswa/index', $data);
    }

    public function profile()
    {
        $this->form_validation->set_rules('no_telepon', 'No Telepon', 'required|min_length[10]|numeric', [
            'required' => 'No telepon tidak boleh kosong !',
            'min_length' => 'No telepon kurang dari 10 digit !',
            'numeric' => 'Harus menggunakan angka !'
        ]);
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email', [
            'required' => 'Email tidak boleh kosong !',
            'valid_email' => 'Gunakan email yang valid !'
        ]);

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Profil Mahasiswa';

            $nim = $this->session->userdata('nim');
            $data['mahasiswa'] = $this->mahasiswa->getOne($nim);

            $data['page'] = 'frontend/mahasiswa/profile';

            $this->load->view('frontend/mahasiswa/index', $data);
        } else {
            $this->_update();
        }
    }

    private function _update()
    {
        $nim = $this->input->post('nim');
        $mahasiswa = $this->mahasiswa->getOne($nim);

        $config['upload_path']          = './assets/uploads/profile';
        $config['allowed_types']        = 'png|jpg|jpeg';
        $config['max_size']             = 2048; // 2 mb
        $config['remove_spaces']        = TRUE;
        $config['file_name']            = $nim . "_" . $_FILES["foto_profil"]['name'];;
        // $config['max_width']            = 390; //354
        // $config['max_height']           = 500; // 472

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('foto_profil')) {
            $data = [
                "no_telepon" => $this->input->post('no_telepon'),
                "email" => $this->input->post('email')
            ];

            $this->db->where('nim', $nim);
            $this->db->update('tb_mahasiswa', $data);

            $this->session->set_flashdata('foto', $this->upload->display_errors());

            redirect('mahasiswa/beranda/profile', 'refresh');
        } else {
            $upload_data = $this->upload->data();

            $data = [
                "no_telepon" => $this->input->post('no_telepon'),
                "email" => $this->input->post('email'),
                "foto" => $upload_data['file_name']
            ];

            if ($mahasiswa[0]['foto'] != "default.jpg") {
                unlink(FCPATH . 'assets/uploads/profile/' . $mahasiswa[0]['foto']);
            }

            $this->db->where('nim', $nim);
            $this->db->update('tb_mahasiswa', $data);

            $this->session->set_flashdata('flash-sukses', 'Profile berhasil diupdate');

            redirect('mahasiswa/beranda/profile', 'refresh');
        }
    }

    public function updatePass()
    {
        $this->form_validation->set_rules('pas_lama', 'Password Baru', 'required', [
            'required' => 'Password lama harap di isi !'
        ]);
        $this->form_validation->set_rules('pas_baru', 'Password Baru', 'required|trim|min_length[8]', [
            'required' => 'Password baru harap di isi !',
            'min_length' => 'Password kurang dari 8'
        ]);
        $this->form_validation->set_rules('pas_konfir', 'Password Konfirmasi', 'required|trim|min_length[8]|matches[pas_baru]', [
            'required' => 'Password konfirmasi harap di isi !',
            'matches' => 'Password konfirmasi salah !',
            'min_length' => 'Password kurang dari 8'
        ]);

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Profil Mahasiswa';

            $nim = $this->session->userdata('nim');
            $data['mahasiswa'] = $this->mahasiswa->getOne($nim);

            $data['page'] = 'frontend/mahasiswa/profile';

            $this->load->view('frontend/mahasiswa/index', $data);
        } else {
            $nim = $this->session->userdata('nim');
            $mahasiswa = $this->mahasiswa->getOne($nim);

            $pas_lama = $this->input->post('pas_lama', TRUE);
            $pas_baru = $this->input->post('pas_baru', TRUE);

            if (password_verify($pas_lama, $mahasiswa[0]['password'])) {
                $data = [
                    "password" =>  password_hash($pas_baru, PASSWORD_DEFAULT)
                ];

                $this->mahasiswa->resetPassword($data, $mahasiswa[0]['id']);

                $this->session->set_flashdata('flash-sukses', 'Password berhasil diupdate');

                redirect('mahasiswa/beranda/profile', 'refresh');
            } else {
                $this->session->set_flashdata('flash-error', 'Password lama salah');

                redirect('mahasiswa/beranda/profile', 'refresh');
            }
        }
    }

    public function cari_barang()
    {
        $kategori = $this->input->post('kategori');

        $this->db->where('kategori', $kategori);
        $this->db->order_by('nama_barang');
        $a = $this->db->get('tb_barang')->result_array();

        $data['hasil'] = $a;
        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data);
    }

    public function tambah()
    {
        $nim = $this->session->userdata('nim');

        $this->form_validation->set_rules('nama_barang', 'Nama Barang', 'required');
        $this->form_validation->set_rules('jumlah', 'Jumlah Pinjam', 'required|numeric');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'LAB HARDWARE';

            $data['mahasiswa'] = $this->mahasiswa->getOne($nim);
            $data['kategori'] = $this->stok->getKategori();
            $data['pinjaman'] = $this->pinjam->getAllMahasiswa($nim);

            $data['page'] = 'frontend/mahasiswa/beranda';

            $this->load->view('frontend/mahasiswa/index', $data);
        } else {
            $nama_barang = htmlspecialchars($this->input->post('nama_barang', TRUE));
            $jumlah = htmlspecialchars($this->input->post('jumlah', TRUE));

            $barang = $this->stok->getNama($nama_barang);
            $dipinjam = $barang[0]['dipinjam'] + $jumlah;

            $data_barang = [
                "dipinjam" => $dipinjam
            ];

            $this->db->where('nama_barang', $nama_barang);
            $this->db->update('tb_barang', $data_barang);

            $dates = date('Y-m-d H:i:s');
            $date = strtotime($dates);
            $date_kembali = strtotime("+7 day", $date);

            $data_pinjam = [
                "nama_barang" => $nama_barang,
                "nim" => $nim,
                "jumlah" => $jumlah,
                "tanggal_pinjam" => $dates,
                "max_kembali" => date('Y-m-d', $date_kembali),
                "status" => "Menunggu"
            ];

            $query = $this->pinjam->tambah($data_pinjam);
            if ($query) {
                $this->session->set_flashdata('flash_sukses', flash_sukses('Barang berhasil ditambahkan'));
                redirect('mahasiswa/beranda');
            } else {
                $this->session->set_flashdata('flash_error', flash_error('Barang gagal ditambahkan !'));
                redirect('mahasiswa/beranda');
            }
        }
    }

    public function cek()
    {
        $date = date('Y-m-d H:i:s');
        echo "tanggal pinjam : " . $date;
        $date = strtotime($date);
        $date_kembali = strtotime("+7 day", $date);
        echo date('Y-m-d H:i:s', $date_kembali);
    }

    public function hapus($nm_brg)
    {
        $this->pinjam->hapus($nm_brg);
        $this->session->set_flashdata('flash_sukses', flash_sukses('Barang berhasil ditambahkan'));
        redirect('mahasiswa/beranda');
    }
}
        
    /* End of file  Beranda.php */