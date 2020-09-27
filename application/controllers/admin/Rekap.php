<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Rekap extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (empty($this->session->userdata('data_login'))) {
            $this->session->set_flashdata('flash-error', 'Anda Belum Login');
            redirect('admin/auth', 'refresh');
        }

        $this->load->model('M_Rekap', 'rekap');
    }

    public function index()
    {
        $data['title'] = 'Rekap Barang Dipinjam';
        $data['page'] = 'admin/backend/rekap';

        $data['rekap'] = $this->rekap->getAll();

        $this->load->view('admin/backend/index', $data);
    }

    public function multiple_delete()
    {
        $id = $this->input->post('id');
        if ($id == NULL) {
            $this->session->set_flashdata('flash_error', flash_error('Pilih data yang akan dihapus !'));
            redirect('admin/rekap');
        } else {
            $this->rekap->multiple_delete($id);

            $this->session->set_flashdata('flash_sukses', flash_sukses('Barang berhasil dihapus'));
            redirect('admin/rekap');
        }
    }
}