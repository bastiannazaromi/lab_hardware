<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!empty($this->session->userdata('data_login'))) {
            if ($this->uri->segment(2) != 'logout') {
                $this->session->set_flashdata('flash-error', 'Anda Sudah Login');
                redirect('belakang/dashboard');
            }
        }
    }

    public function index()
    {
        $data['title'] = 'Halaman Login';
        $this->load->view('admin/auth/index', $data, FALSE);
    }

    public function login()
    {
        $this->form_validation->set_rules('username', 'Username', 'required|min_length[5]', [
            'required' => 'Username tidak boleh kosong !',
            'min_length' => 'Username kurang dari 5 digit !'
        ]);
        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[5]', [
            'required' => 'Password harap di isi !',
            'min_length' => 'Password kurang dari 5'
        ]);

        if ($this->form_validation->run() == false) {

            if (form_error('username', '-- ', ' --')) {
                $data['status'] = form_error('username', '-- ', ' --');
            } else {
                $data['status'] = form_error('password', '-- ', ' --');
            }

            $data['token'] = $this->security->get_csrf_hash();

            echo json_encode($data);
        } else {
            $username = $this->input->post("username");
            $password = $this->input->post("password");

            $this->load->model('M_Auth');
            $data['status'] = $this->M_Auth->cek_login($username, $password);
            $data['token'] = $this->security->get_csrf_hash();

            echo json_encode($data);
        }
    }

    public function logout()
    {
        $this->session->sess_destroy($this->session->userdata('data_login'));
        redirect('belakang/dashboard', 'refresh');
    }
}

/* End of file Auth.php */
/* Location: ./application/controllers/Auth.php */