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

        $this->u2		= $this->uri->segment(2);
        $this->u3		= $this->uri->segment(3);
        $this->u4		= $this->uri->segment(4);
        $this->u5		= $this->uri->segment(5);
        $this->u6		= $this->uri->segment(6);
        $this->u7		= $this->uri->segment(7);

        $this->load->model('M_Dosen', 'dosen');
        $this->load->model('M_Stok', 'stok');
        $this->load->model('M_Pinjam', 'pinjam');

        if ($this->session->userdata('status') == "Mahasiswa") {
            redirect('dashboard/mahasiswa');
        }
    }

    public function index()
    {
        $nidn = $this->session->userdata('nidn');
        cek_biodata($nidn);

        $data['title'] = 'LAB HARDWARE';

        $data['dosen'] = $this->dosen->getOne($nidn);
        $data['kategori'] = $this->stok->getKategori();
        $data['pinjaman'] = $this->pinjam->getAllDosen($nidn);
        $data['page'] = 'frontend/dosen/beranda';

        $this->load->view('frontend/dosen/index', $data);
    }

    public function profile()
    {
        $this->form_validation->set_rules('username', 'Username', 'required|trim|min_length[5]', [
            'required' => 'Email tidak boleh kosong !',
            'min_length' => 'Username kurang dari 5 !'
        ]);
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email', [
            'required' => 'Email tidak boleh kosong !',
            'valid_email' => 'Gunakan email yang valid !'
        ]);
        $this->form_validation->set_rules('no_telepon', 'No Telepon', 'required|min_length[10]|numeric', [
            'required' => 'No telepon tidak boleh kosong !',
            'min_length' => 'No telepon kurang dari 10 digit !',
            'numeric' => 'Harus menggunakan angka !'
        ]);

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Profil Dosen';

            $nidn = $this->session->userdata('nidn');
            $data['dosen'] = $this->dosen->getOne($nidn);

            $data['page'] = 'frontend/dosen/profile';

            $this->load->view('frontend/dosen/index', $data);
        } else {
            $this->_update();
        }
    }

    private function _update()
    {
        $id = dekrip($this->input->post('id', TRUE));
        $nidn = $this->session->userdata('nidn');
        $dosen = $this->dosen->getOne($nidn);

        $config['upload_path']          = './upload/profile';
        $config['allowed_types']        = 'png|jpg|jpeg';
        $config['max_size']             = 2048; // 2 mb
        $config['remove_spaces']        = TRUE;
        $config['file_name']            = $nidn . "_" . $_FILES["foto_profil"]['name'];;
        // $config['max_width']            = 390; //354
        // $config['max_height']           = 500; // 472

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('foto_profil')) {
            $data = [
                "no_telepon" => $this->input->post('no_telepon'),
                "username" => $this->input->post('username'),
                "email" => $this->input->post('email')
            ];

            $this->db->where('nidn_nipy', $nidn);
            $this->db->update('tb_dosen', $data);

            $this->session->set_flashdata('foto', $this->upload->display_errors());

            redirect('dashboard/dosen/profile', 'refresh');
        } else {
            $upload_data = $this->upload->data();

            $data = [
                "no_telepon" => $this->input->post('no_telepon'),
                "email" => $this->input->post('email'),
                "username" => $this->input->post('username'),
                "foto" => $upload_data['file_name']
            ];

            if ($dosen[0]['foto'] != "default.jpg") {
                unlink(FCPATH . 'upload/profile/' . $dosen[0]['foto']);
            }

            $this->db->where('id', $id);
            $this->db->update('tb_dosen', $data);

            $this->session->set_flashdata('flash-sukses', 'Profile berhasil diupdate');

            redirect('dashboard/dosen/profile', 'refresh');
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
            $data['title'] = 'Profil Dosen';

            $nidn = $this->session->userdata('nidn');
            $data['dosen'] = $this->dosen->getOne($nidn);

            $data['page'] = 'frontend/dosen/profile';

            $this->load->view('frontend/dosen/index', $data);
        } else {
            $id = dekrip($this->input->post('id', TRUE));
            $nidn = $this->session->userdata('nidn');
            $dosen = $this->dosen->getOne($nidn);

            $pas_lama = $this->input->post('pas_lama', TRUE);
            $pas_baru = $this->input->post('pas_baru', TRUE);

            if (password_verify($pas_lama, $dosen[0]['password'])) {
                $data = [
                    "password" =>  password_hash($pas_baru, PASSWORD_DEFAULT)
                ];

                $this->dosen->resetPassword($data, $id);

                $this->session->set_flashdata('flash-sukses', 'Password berhasil diupdate');

                redirect('dashboard/dosen/profile', 'refresh');
            } else {
                $this->session->set_flashdata('flash-error', 'Password lama salah');

                redirect('dashboard/dosen/profile', 'refresh');
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

    public function pinjaman()
    {
        $nidn = $this->session->userdata('nidn');
        cek_biodata($nidn);

        $tgl = dekrip($this->u4);

        $data['title'] = 'LAB HARDWARE';

        $data['dosen'] = $this->dosen->getOne($nidn);
        $data['kategori'] = $this->stok->getKategori();
        $data['pinjaman'] = $this->pinjam->getSpesifikUser('dosen', $nidn, $tgl);

        $data['page'] = 'frontend/dosen/pinjaman';

        $this->load->view('frontend/dosen/index', $data);
    }

    public function pinjam()
    {
        $nidn = $this->session->userdata('nidn');
        cek_biodata($nidn);

        $tgl = dekrip($this->u4);

        $data['title'] = 'LAB HARDWARE';

        $data['dosen'] = $this->dosen->getOne($nidn);
        $data['kategori'] = $this->stok->getKategori();
        $data['barang'] = $this->pinjam->getKeranjang('dosen');

        $data['page'] = 'frontend/dosen/pinjam';

        $this->load->view('frontend/dosen/index', $data);
    }

    public function tambah()
    {
        $nidn = $this->session->userdata('nidn');

        $this->form_validation->set_rules('nama_barang', 'Nama Barang', 'required');
        $this->form_validation->set_rules('jumlah', 'Jumlah Pinjam', 'required|numeric');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'LAB HARDWARE';

            $data['dosen'] = $this->dosen->getOne($nidn);
            $data['kategori'] = $this->stok->getKategori();
            $data['pinjaman'] = $this->pinjam->getAllDosen($nidn);

            $data['page'] = 'frontend/dosen/beranda';

            $this->load->view('frontend/dosen/index', $data);
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
                "id_user" => $nidn,
                "jumlah" => $jumlah,
                "status" => "Menunggu",
                "role" => "Dosen"
            ];

            $query = $this->pinjam->tambah($data_pinjam);
            if ($query) {
                $this->session->set_flashdata('flash_sukses', flash_sukses('Barang berhasil ditambahkan'));
                redirect('dashboard/dosen/pinjam');
            } else {
                $this->session->set_flashdata('flash_error', flash_error('Barang gagal ditambahkan !'));
                redirect('dashboard/dosen/pinjam');
            }
        }
    }

    public function edit()
    {
        $nidn = $this->session->userdata('nidn');

        $this->form_validation->set_rules('nama_barang', 'Nama Barang', 'required');
        $this->form_validation->set_rules('jumlah', 'Jumlah Pinjam', 'required|numeric');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'LAB HARDWARE';

            $data['mahasiswa'] = $this->mahasiswa->getOne($nidn);
            $data['kategori'] = $this->stok->getKategori();
            $data['pinjaman'] = $this->pinjam->getAllDosen($nidn);

            $data['page'] = 'frontend/dosen/beranda';

            $this->load->view('frontend/dosen/index', $data);
        } else {
            $nama_barang = htmlspecialchars($this->input->post('nama_barang', TRUE));
            $jumlah = htmlspecialchars($this->input->post('jumlah', TRUE));

            $barang_pinjam = $this->pinjam->getOne(dekrip($this->input->post('id', TRUE)));
            $jumlahOld = $barang_pinjam[0]['jumlah'];
            $nama_barang_old = $barang_pinjam[0]['nama_barang'];

            $barang = $this->stok->getNama($nama_barang_old);
            $dipinjamOld = $barang[0]['dipinjam'];

            $data_barangOld = [
                "dipinjam" => $dipinjamOld - $jumlahOld
            ];

            $this->db->where('nama_barang', $nama_barang_old);
            $this->db->update('tb_barang', $data_barangOld);

            $barangNew = $this->stok->getNama($nama_barang);
            $dipinjamNew = $barangNew[0]['dipinjam'] + $jumlah;

            $data_barangNew = [
                "dipinjam" => $dipinjamNew
            ];

            $this->db->where('nama_barang', $nama_barang);
            $this->db->update('tb_barang', $data_barangNew);

            $dates = date('Y-m-d H:i:s');
            $date = strtotime($dates);
            $date_kembali = strtotime("+7 day", $date);

            $data_pinjam = [
                "nama_barang" => $nama_barang,
                "jumlah" => $jumlah,
                "status" => "Menunggu"
            ];

            $query = $this->pinjam->edit($data_pinjam);
            if ($query) {
                $this->session->set_flashdata('flash_sukses', flash_sukses('Barang berhasil diedit'));
                redirect('dashboard/dosen/pinjam');
            } else {
                $this->session->set_flashdata('flash_error', flash_error('Barang gagal diedit !'));
                redirect('dashboard/dosen/pinjam');
            }
        }
    }

    public function checkout()
    {
        $id = $this->input->post('id');
        
        if ($id)
        {
            $dates = date('Y-m-d H:i:s');
            $date = strtotime($dates);
            $date_kembali = strtotime("+7 day", $date);

            $data = [
                "tanggal_pinjam"    => $dates,
                "max_kembali"       => date('Y-m-d', $date_kembali),
                "status"            => "Dipinjam"
            ];

            foreach ($id as $hasil)
            {
                $this->db->where('id', dekrip($hasil));
                $this->db->update('tb_pinjaman', $data);
            }

            $this->session->set_flashdata('flash_sukses', flash_sukses('Barang berhasil di checkout'));
            redirect('dashboard/dosen/pinjam');
        }
        else
        {
            $this->session->set_flashdata('flash_error', flash_error('Pilih barang yang akan di checkout !'));
            redirect('dashboard/dosen/pinjam');
        }
    }

    public function hapus($id)
    {
        $this->pinjam->hapus(dekrip($id));
        $this->session->set_flashdata('flash_sukses', flash_sukses('Barang pinjam berhasil dihapus'));
        redirect('dashboard/dosen/pinjam', 'refresh');
    }
}
        
    /* End of file  Beranda.php */