<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_Rekap extends CI_Model
{

    public function getAll($role)
    {
        if ($role == 'mahasiswa') {
            $this->db->select('tb_pinjaman.id, tb_pinjaman.jumlah, tb_pinjaman.nama_barang, tb_pinjaman.status, tb_pinjaman.tanggal_pinjam, tb_pinjaman.max_kembali, tb_pinjaman.tanggal_kembali, tb_mahasiswa.nim as id_user, tb_mahasiswa.nama, tb_mahasiswa.no_telepon, tb_mahasiswa.email');
            $this->db->from('tb_pinjaman');
            $this->db->join('tb_mahasiswa', 'tb_pinjaman.id_user = tb_mahasiswa.nim', 'left');
            $this->db->where('tb_pinjaman.status', 'Selesai');
            $this->db->where('tb_pinjaman.role', $role);

            $this->db->order_by('tanggal_pinjam', 'desc');

            return $this->db->get()->result_array();
        } else {
            $this->db->select('tb_pinjaman.id, tb_pinjaman.jumlah, tb_pinjaman.nama_barang, tb_pinjaman.status, tb_pinjaman.tanggal_pinjam, tb_pinjaman.max_kembali, tb_pinjaman.tanggal_kembali, tb_dosen.nidn_nipy as id_user, tb_dosen.nama, tb_dosen.no_telepon, tb_dosen.email');
            $this->db->from('tb_pinjaman');
            $this->db->join('tb_dosen', 'tb_pinjaman.id_user = tb_dosen.nidn_nipy', 'left');
            $this->db->where('tb_pinjaman.status', 'Selesai');
            $this->db->where('tb_pinjaman.role', $role);

            $this->db->order_by('tanggal_pinjam', 'desc');

            return $this->db->get()->result_array();
        }
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
        foreach ($id as $newId)
        {
            $this->db->where('id', dekrip($newId));
            $this->db->delete('tb_pinjaman');
        }
        
    }
}