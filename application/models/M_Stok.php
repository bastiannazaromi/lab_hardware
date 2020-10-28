<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_Stok extends CI_Model
{

    public function getAll()
    {
        $this->db->select('*');
        $this->db->from('tb_barang');
        $this->db->order_by('kategori');
        $this->db->order_by('nama_barang');

        return $this->db->get()->result_array();
    }

    public function getOne($id)
    {
        $this->db->where('id', $id);
        return $this->db->get('tb_barang')->result_array();
    }

    public function getNama($nama_barang)
    {
        $this->db->where('nama_barang', $nama_barang);
        return $this->db->get('tb_barang')->result_array();
    }

    public function getKategori()
    {
        $this->db->select('kategori');
        $this->db->from('tb_barang');
        $this->db->group_by('kategori');
        $this->db->order_by('kategori');

        return $this->db->get()->result_array();
    }

    public function tambah($data)
    {
        return $this->db->insert('tb_barang', $data);
    }

    public function edit($data)
    {
        $this->db->where('id', dekrip($this->input->post('id', TRUE)));
        return $this->db->update('tb_barang', $data);
    }

    public function hapus($id)
    {
        // $this->db->where('id', $id);
        return $this->db->delete('tb_barang', ['id' => $id]);
    }
    public function multiple_delete($id)
    {
        foreach ($id as $id_new) {
            $this->db->where('id', dekrip($id_new));
            return $this->db->delete('tb_barang');
        }
    }
}