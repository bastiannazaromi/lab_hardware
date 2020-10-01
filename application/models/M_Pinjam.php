<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_Pinjam extends CI_Model
{

    public function getAll()
    {
        $this->db->select('tb_pinjaman.id, tb_pinjaman.jumlah, tb_pinjaman.status, tb_pinjaman.tanggal_pinjam, tb_pinjaman.nama_barang, tb_mahasiswa.nim, tb_mahasiswa.nama');
        $this->db->from('tb_pinjaman');
        $this->db->join('tb_mahasiswa', 'tb_pinjaman.nim = tb_mahasiswa.nim', 'left');
        $this->db->where('tb_pinjaman.status !=', 'Selesai');

        $this->db->order_by('tanggal_pinjam', 'desc');

        return $this->db->get()->result_array();
    }

    public function getOne($id)
    {
        $this->db->where('id', $id);
        return $this->db->get('tb_pinjaman')->result_array();
    }

    public function edit($data)
    {
        $this->db->where('id', $this->input->post('id', TRUE));
        $this->db->update('tb_pinjaman', $data);
    }

    public function hapus($id)
    {
        // $this->db->where('id', $id);
        $this->db->delete('tb_pinjaman', ['id' => $id]);
    }
    public function multiple_delete($id)
    {
        $this->db->where_in('id', $id);
        $this->db->delete('tb_pinjaman');
    }

    public function getAllMahasiswa($nim)
    {
        $this->db->select('tb_pinjaman.id, tb_pinjaman.nama_barang, tb_pinjaman.jumlah, tb_pinjaman.status, tb_pinjaman.tanggal_pinjam, tb_pinjaman.tanggal_kembali, tb_mahasiswa.nim, tb_mahasiswa.nama');
        $this->db->from('tb_pinjaman');
        $this->db->join('tb_mahasiswa', 'tb_pinjaman.nim = tb_mahasiswa.nim', 'left');
        $this->db->where('tb_pinjaman.nim', $nim);

        $this->db->order_by('tanggal_pinjam', 'desc');

        return $this->db->get()->result_array();
    }
}