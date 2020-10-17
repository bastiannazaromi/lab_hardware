<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (empty($this->session->userdata('data_login'))) {
            $this->session->set_flashdata('flash-error', 'Anda Belum Login');
            redirect('admin/auth', 'refresh');
        }

        $this->load->model('M_Admin', 'admin');
    }

    
    public function cek()
    {
        echo dekrip('MytQdGhSYUlCQSsvekpwSGs4eWpKZw');
    }

    public function index()
    {
        $this->cek_level();

        $data['title'] = 'Management Admin';
        $data['page'] = 'admin/backend/admin';

        $data['admin'] = $this->admin->getAll();

        $this->load->view('admin/backend/index', $data);
    }

    public function profile()
    {
        $data['admin'] = $this->admin->getOne($this->session->userdata('id'));

        $data['title'] = 'Profile Admin';
        $data['page'] = 'admin/backend/profile';
        $this->load->view('admin/backend/index', $data);
    }

    public function updateFoto()
    {
        $id = $this->input->post('id');

        $config['upload_path']          = './assets/uploads/profile';
        $config['allowed_types']        = 'png|jpg|jpeg';
        $config['max_size']             = 2048; // 2 mb
        $config['remove_spaces']        = TRUE;
        $config['file_name']            = date('d-m-Y') . '_' . $_FILES["foto_profil"]['name'];;
        // $config['max_width']            = 1024;
        // $config['max_height']           = 768;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('foto_profil')) {

            $data = [
                "nama" => htmlspecialchars($this->input->post('nama', TRUE))
            ];

            $this->admin->edit($data);

            $this->session->set_flashdata('flash-sukses', 'Profil berhasil diupdate');

            redirect('admin/admin/profile', 'refresh');
        } else {
            $upload_data = $this->upload->data();

            $admin = $this->admin->getOne($id);

            $data = [
                "nama" => htmlspecialchars($this->input->post('nama', TRUE)),
                "foto" => $upload_data['file_name']
            ];

            if ($admin[0]['foto'] != "default.jpg") {
                unlink(FCPATH . 'assets/uploads/profile/' . $admin[0]['foto']);
            }

            $this->admin->edit($data);

            $this->session->set_flashdata('flash-sukses', 'Profil berhasil diupdate');

            redirect('admin/admin/profile', 'refresh');
        }
    }

    public function updatePass()
    {
        $this->form_validation->set_rules('pas_lama', 'Password Baru', 'required', [
            'required' => 'Password lama harap di isi !'
        ]);
        $this->form_validation->set_rules('pas_baru', 'Password Baru', 'required|trim|min_length[5]', [
            'required' => 'Password baru harap di isi !',
            'min_length' => 'Password kurang dari 5'
        ]);
        $this->form_validation->set_rules('pas_konfir', 'Password Konfirmasi', 'required|trim|min_length[5]|matches[pas_baru]', [
            'required' => 'Password konfirmasi harap di isi !',
            'matches' => 'Password konfirmasi salah !',
            'min_length' => 'Password kurang dari 5'
        ]);

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Profil Admin';

            $id = $this->input->post('id');
            $data['admin'] = $this->admin->getOne($id);

            $data['page'] = 'admin/backend/profile';

            $this->load->view('admin/backend/index', $data);
        } else {
            $id = $this->input->post('id');
            $admin = $this->admin->getOne($id);

            $pas_lama = $this->input->post('pas_lama', TRUE);
            $pas_baru = $this->input->post('pas_baru', TRUE);

            if (password_verify($pas_lama, $admin[0]['password'])) {
                $data = [
                    "password" =>  password_hash($pas_baru, PASSWORD_DEFAULT)
                ];

                $this->admin->resetPassword($data, $admin[0]['id']);

                $this->session->set_flashdata('flash-sukses', 'Password berhasil diupdate');

                redirect('admin/admin/profile', 'refresh');
            } else {
                $this->session->set_flashdata('flash-error', 'Password lama salah');

                redirect('admin/admin/profile', 'refresh');
            }
        }
    }

    public function tambah()
    {
        $this->cek_level();

        $data = [
            "username" => htmlspecialchars($this->input->post('username', TRUE)),
            "password" => password_hash('admin', PASSWORD_DEFAULT),
            "nama" => htmlspecialchars($this->input->post('nama', TRUE)),
            "level" => htmlspecialchars($this->input->post('level', TRUE)),
            "foto" => 'default.jpg'
        ];

        $this->admin->tambah($data);

        $this->session->set_flashdata('flash-sukses', 'Data berhasil ditambahkan');
        redirect('admin/admin');
    }

    public function edit()
    {
        $this->cek_level();

        $data = [
            "username" => htmlspecialchars($this->input->post('username', TRUE)),
            "nama" => htmlspecialchars($this->input->post('nama', TRUE)),
            "level" => htmlspecialchars($this->input->post('level', TRUE)),
            "foto" => 'default.jpg'
        ];

        $this->admin->edit($data);

        $this->session->set_flashdata('flash-sukses', 'Data berhasil diupdate');
        redirect('admin/admin');
    }

    public function resetPassword($id)
    {
        $this->cek_level();

        $this->db->where('id', $id);
        $data = $this->db->get('tb_admin')->result_array();

        $data = [
            "password" => password_hash('admin', PASSWORD_DEFAULT)
        ];

        $this->admin->resetPassword($data, $id);

        $this->session->set_flashdata('flash-sukses', 'Password berhasil direset');
        redirect('admin/admin');
    }

    public function multiple_delete()
    {
        $this->cek_level();

        $id = $this->input->post('id');
        if ($id == NULL) {
            $this->session->set_flashdata('flash-error', 'Pilih data yang akan dihapus !');
            redirect('admin/admin');
        } else {
            $this->admin->multiple_delete($id);

            $this->session->set_flashdata('flash-sukses', 'Data berhasil di hapus');
            redirect('admin/admin');
        }
    }

    public function cek_level()
    {
        if (level($this->session->userdata('id')) != 'Super Admin') {
            redirect('admin/dashboard');
        }
    }
}
        
    /* End of file  Admin.php */