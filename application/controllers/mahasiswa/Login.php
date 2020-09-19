<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!empty($this->session->userdata('user_login'))) {
            if ($this->uri->segment(3) != 'logout') {
                $this->session->set_flashdata('flash-error', 'Anda Sudah Login');
                redirect('user/beranda');
            }
        }
    }

    public function index()
    {
        $data['title'] = 'Halaman Login';
        $this->load->view('user/login/index', $data, FALSE);
    }

    public function login()
    {
        $this->form_validation->set_rules('nim', 'NIM', 'required|min_length[8]', [
            'required' => 'NIM tidak boleh kosong !',
            'min_length' => 'NIM kurang dari 8 digit !'
        ]);
        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[8]', [
            'required' => 'Password harap di isi !',
            'min_length' => 'Password kurang dari 8'
        ]);

        if ($this->form_validation->run() == false) {

            if (form_error('nim', '-- ', ' --')) {
                $data['status'] = form_error('nim', '-- ', ' --');
            } else {
                $data['status'] = form_error('password', '-- ', ' --');
            }

            $data['token'] = $this->security->get_csrf_hash();

            echo json_encode($data);
        } else {
            $nim = $this->input->post("nim");
            $password = $this->input->post("password");

            $this->load->model('M_Login');
            $data['status'] = $this->M_Login->cek_login($nim, $password);
            $data['token'] = $this->security->get_csrf_hash();

            echo json_encode($data);
        }
    }

    public function logout()
    {
        $this->session->sess_destroy($this->session->userdata('user_login'));
        redirect('mahasiswa/login', 'refresh');
    }
}