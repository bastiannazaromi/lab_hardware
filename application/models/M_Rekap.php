<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_Rekap extends CI_Model
{

    public function getAll()
    {
        $this->db->select('tb_pinjaman.id, tb_pinjaman.jumlah, tb_pinjaman.tanggal_pinjam, tb_pinjaman.tanggal_kembali, tb_barang.nama_barang, tb_mahasiswa.nim, tb_mahasiswa.nama');
        $this->db->from('tb_pinjaman');
        $this->db->join('tb_barang', 'tb_pinjaman.id_brg = tb_barang.id', 'left');
        $this->db->join('tb_mahasiswa', 'tb_pinjaman.nim = tb_mahasiswa.nim', 'left');
        $this->db->where('tb_pinjaman.status', 'Selesai');
        $this->db->order_by('tanggal_pinjam', 'desc');

        return $this->db->get()->result_array();
    }

    public function getOne($id)
    {
        $this->db->where('nim', $id);
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
}