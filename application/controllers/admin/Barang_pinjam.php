<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Barang_pinjam extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (empty($this->session->userdata('data_login'))) {
            $this->session->set_flashdata('flash-error', 'Anda Belum Login');
            redirect('admin/auth', 'refresh');
        }

        $this->load->model('M_Pinjam', 'pinjam');
    }

    public function index()
    {
        $data['title'] = 'List Barang Dipinjam';
        $data['page'] = 'admin/backend/barang_pinjam';

        $data['pinjam'] = $this->pinjam->getAll();

        $this->load->view('admin/backend/index', $data);
    }

    public function multiple_delete()
    {
        $id = $this->input->post('id');
        if ($id == NULL) {
            $this->session->set_flashdata('flash_error', flash_error('Pilih data yang akan dihapus !'));
            redirect('admin/barang_pinjam');
        } else {
            $this->pinjam->multiple_delete($id);

            $this->session->set_flashdata('flash_sukses', flash_sukses('Data berhasil dihapus'));
            redirect('admin/barang_pinjam');
        }
    }
}