<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pencarian extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if (empty($this->session->userdata('data_login'))) {
            $this->session->set_flashdata('flash-error', 'Anda Belum Login');
            redirect('belakang/login', 'refresh');
        }

        $this->u2		= $this->uri->segment(2);
        $this->u3		= $this->uri->segment(3);
        $this->u4		= $this->uri->segment(4);
        $this->u5		= $this->uri->segment(5);
        $this->u6		= $this->uri->segment(6);

        $this->load->model('M_Pinjam', 'pinjam');
    }

    public function index()
    {
        $data['title'] = 'Pencarian Barang';
        $data['page'] = 'admin/backend/pencarian';

        $this->load->view('admin/backend/index', $data);
    }

    public function cari()
    {
        $inputan = $this->input->post('inputan');

        if ($inputan)
        {
            $peminjam = $this->pinjam->cari($inputan);
            $data_peminjam = [];

            foreach ($peminjam as $hasil)
            {
                array_push($data_peminjam, [
                    'id'                => $hasil['id'],
                    'nama_peminjam'     => nama_user($hasil['id_user']),
                    'nama_barang'       => $hasil['nama_barang'],
                    'id_user'           => $hasil['id_user'],
                    'tanggal_pinjam'    => $hasil['tanggal_pinjam'],
                    'max_kembali'       => $hasil['max_kembali'],
                    'tanggal_kembali'   => $hasil['tanggal_kembali'],
                    'status'            => $hasil['status']
                ]);
            }

            $data = [
                "barang"   => $data_peminjam,
                "token"    => $this->security->get_csrf_hash() 
            ];
            
        }
        else{
            $data = [
                "barang"   => null,
                "token"    => $this->security->get_csrf_hash() 
            ];
        }

        echo json_encode($data);
    }

}

/* End of file Pencarian.php */