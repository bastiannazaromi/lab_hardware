<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_Dosen extends CI_Model
{

    public function getAll()
    {
        $this->db->select('*');
        $this->db->from('tb_dosen');
        $this->db->order_by('nama');

        return $this->db->get()->result_array();
    }

    public function getOne($no_unik)
    {
        $this->db->where('nidn_nipy', $no_unik);
        return $this->db->get('tb_dosen')->result_array();
    }

    public function tambah($data)
    {
        $this->db->insert('tb_dosen', $data);
    }

    public function edit($data)
    {
        $this->db->where('id', dekrip($this->input->post('id', TRUE)));
        $this->db->update('tb_dosen', $data);
    }

    public function resetPassword($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('tb_dosen', $data);
    }

    public function hapus($id)
    {
        // $this->db->where('id', $id);
        $this->db->delete('tb_dosen', ['id' => dekrip($id)]);
    }
    public function multiple_delete($id)
    {
        foreach ($id as $id_new) {
            $this->db->where('id', dekrip($id_new));
            $data = $this->db->get('tb_dosen')->result_array();

            if ($data[0]['foto'] != "default.jpg") {
                unlink(FCPATH . 'assets/uploads/profile/' . $data[0]['foto']);
            }
            $this->db->where_in('id', dekrip($id_new));
            $this->db->delete('tb_dosen');
        }
        
    }
}