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
        $this->load->model('M_Stok', 'stok');
    }

    public function index()
    {
        $data['title'] = 'Rekap Barang Dipinjam';
        $data['page'] = 'admin/backend/rekap';

        $data['rekap'] = $this->rekap->getAll();

        $this->load->view('admin/backend/index', $data);
    }

    public function update()
    {
        $id = $this->input->post('id');
        $id_brg = $this->input->post('id_brg');
        $jumlah = $this->input->post('jumlah');
        $status = $this->input->post('status');

        $data = [
            'tanggal_kembali' => null,
            'status' => $status
        ];

        $this->db->where('id', $id);
        $this->db->update('tb_pinjaman', $data);

        $barang = $this->stok->getOne($id_brg);
        $dipinjam = $barang[0]['dipinjam'];

        $data2 = [
            'dipinjam' => $dipinjam + $jumlah
        ];

        $this->db->where('id', $id_brg);
        $this->db->update('tb_barang', $data2);
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