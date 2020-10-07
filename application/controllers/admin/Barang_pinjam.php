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
        $this->load->model('M_Stok', 'stok');
    }

    public function index()
    {
        $data['title'] = 'List Barang Dipinjam';
        $data['page'] = 'admin/backend/barang_pinjam';

        $data['pinjam'] = $this->pinjam->getAll();

        $this->load->view('admin/backend/index', $data);
    }

    public function update()
    {
        $id = $this->input->post('id');
        $nama_barang = $this->input->post('nama_barang');
        $jumlah = $this->input->post('jumlah');
        $status = $this->input->post('status');

        if ($status == 'Selesai') {
            $data = [
                'tanggal_kembali' => date('Y-m-d H:i:s'),
                'status' => $status
            ];

            $this->db->where('id', $id);
            $this->db->update('tb_pinjaman', $data);

            $barang = $this->stok->getNama($nama_barang);
            $dipinjam = $barang[0]['dipinjam'];

            $data2 = [
                'dipinjam' => $dipinjam - $jumlah
            ];

            $this->db->where('nama_barang', $nama_barang);
            $this->db->update('tb_barang', $data2);
        } else {
            $data = [
                'status' => $status
            ];

            $this->db->where('id', $id);
            $this->db->update('tb_pinjaman', $data);
        }
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