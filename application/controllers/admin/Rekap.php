<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Rekap extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (empty($this->session->userdata('data_login'))) {
            $this->session->set_flashdata('flash-error', 'Anda Belum Login');
            redirect('belakang/login', 'refresh');
        }

        $this->load->model('M_Rekap', 'rekap');
        $this->load->model('M_Stok', 'stok');
    }

    public function barang($role = null)
    {
        $data['title'] = 'Rekap barang dipinjam ' . $role;
        $data['page'] = 'admin/backend/rekap';

        $data['rekap'] = $this->rekap->getAll($role);
        $data['role'] = $role;

        $this->session->set_userdata('previous_url', current_url());

        $this->load->view('admin/backend/index', $data);
    }

    public function update()
    {
        $id = dekrip($this->input->post('id'));
        $nama_barang = $this->input->post('nama_barang');
        $jumlah = $this->input->post('jumlah');
        $status = $this->input->post('status');

        $data = [
            'tanggal_kembali' => null,
            'status' => $status
        ];

        $this->db->where('id', $id);
        $this->db->update('tb_pinjaman', $data);

        $barang = $this->stok->getNama($nama_barang);
        $dipinjam = $barang[0]['dipinjam'];

        $data2 = [
            'dipinjam' => $dipinjam + $jumlah
        ];

        $this->db->where('nama_barang', $nama_barang);
        $this->db->update('tb_barang', $data2);
    }

    public function multiple_delete()
    {
        $id = $this->input->post('id');
        if ($id == NULL) {
            $this->session->set_flashdata('flash_error', flash_error('Pilih data yang akan dihapus !'));
            $previous_url = $this->session->userdata('previous_url');

            redirect($previous_url);
        } else {
            $this->rekap->multiple_delete($id);

            $this->session->set_flashdata('flash_sukses', flash_sukses('Barang berhasil dihapus'));
            $previous_url = $this->session->userdata('previous_url');

            redirect($previous_url);
        }
    }
}