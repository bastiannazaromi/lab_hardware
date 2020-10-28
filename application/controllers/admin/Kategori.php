<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if (empty($this->session->userdata('data_login'))) {
            $this->session->set_flashdata('flash-error', 'Anda Belum Login');
            redirect('belakang/login', 'refresh');
        }

        $this->load->model('M_Kategori', 'kategori');
    }
    
    public function index()
    {
        $data['title'] = 'Kategori Barang';
        $data['page'] = 'admin/backend/kategori';
        $data['kategori'] = $this->kategori->getAll();

        $this->load->view('admin/backend/index', $data);
    }

    public function tambah()
    {
        $this->form_validation->set_rules('kategori', 'Kategori', 'required');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Kategori Barang';
            $data['page'] = 'admin/backend/kategori';
            $data['kategori'] = $this->kategori->getAll();

            $this->load->view('admin/backend/index', $data);
        } else {
            $data = [
                "nama_kategori" => $this->input->post('kategori', TRUE)
            ];

            $query = $this->kategori->tambah($data);
            if ($query) {
                $this->session->set_flashdata('flash_sukses', flash_sukses('Kategori berhasil ditambahkan'));
                redirect('belakang/kategori');
            } else {
                $this->session->set_flashdata('flash_error', flash_error('Kategori gagal ditambahkan !'));
                redirect('belakang/kategori');
            }
        }
    }

    public function edit()
    {
        $this->form_validation->set_rules('kategori', 'Kategori', 'required');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Kategori Barang';
            $data['page'] = 'admin/backend/kategori';
            $data['kategori'] = $this->kategori->getAll();

            $this->load->view('admin/backend/index', $data);
        } else {
            $data = [
                "nama_kategori" => $this->input->post('kategori', TRUE)
            ];

            $query = $this->kategori->edit($data);

            if ($query) {
                $this->session->set_flashdata('flash_sukses', flash_sukses('Kategori berhasil diupdate'));
                redirect('belakang/kategori');
            } else {
                $this->session->set_flashdata('flash_error', flash_error('Kategori gagal diupdate'));
                redirect('belakang/kategori');
            }
        }
    }

    public function multiple_delete()
    {
        $id = $this->input->post('id');
        if ($id == NULL) {
            $this->session->set_flashdata('flash_error', flash_error('Pilih data yang akan dihapus !'));
            redirect('belakang/kategori');
        } else {
            $query = $this->kategori->multiple_delete($id);

            if ($query) {
                $this->session->set_flashdata('flash_sukses', flash_sukses('Barang berhasil dihapus'));
                redirect('belakang/kategori');
            } else {
                $this->session->set_flashdata('flash_error', flash_error('Barang gagal dihapus'));
                redirect('belakang/kategori');
            }
        }
    }

}

/* End of file Kategori.php */