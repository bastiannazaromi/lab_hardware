<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Kategori extends CI_Model {

    public function getAll()
    {
        $this->db->order_by('nama_kategori');
        return $this->db->get('tb_kategori')->result_array();
    }

    public function tambah($data)
    {
        return $this->db->insert('tb_kategori', $data);
    }

    public function edit($data)
    {
        $this->db->where('id', dekrip($this->input->post('id', TRUE)));
        return $this->db->update('tb_kategori', $data);
    }

    public function multiple_delete($id)
    {
        foreach ($id as $id_new) {
            $this->db->where('id', dekrip($id_new));
            return $this->db->delete('tb_kategori');
        }
    }

}

/* End of file M_Kategori.php */