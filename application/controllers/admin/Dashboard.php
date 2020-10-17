<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (empty($this->session->userdata('data_login'))) {
            $this->session->set_flashdata('flash-error', 'Anda Belum Login');
            redirect('admin/auth', 'refresh');
        }

        $this->load->model('M_Mahasiswa', 'mahasiswa');
        $this->load->model('M_Dosen', 'dosen');
        $this->load->model('M_Pinjam', 'pinjam');

        $this->load->model('M_Admin', 'admin');
    }

    public function index()
    {
        $data['title'] = 'Dashboard Admin';
        $data['page'] = 'admin/backend/dashboard';

        $data['mahasiswa'] = count($this->mahasiswa->getAll());
        $data['dosen'] = count($this->dosen->getAll());
        $data['admin'] = count($this->admin->getAll());
        $data['pinjamMhs'] = count($this->pinjam->getAll('mahasiswa'));
        $data['pinjamDsn'] = count($this->pinjam->getAll('dosen'));
        $data['lbMhs'] = count($this->pinjam->getLewatBatas('mahasiswa'));
        $data['lbDsn'] = count($this->pinjam->getLewatBatas('dosen'));

        $this->load->view('admin/backend/index', $data);
    }
}
        
    /* End of file  Dashboard.php */