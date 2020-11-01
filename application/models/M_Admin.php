<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_Admin extends CI_Model
{

    public function getAll()
    {
        $this->db->order_by('id', 'desc');
        return $this->db->get('tb_admin')->result_array();
    }

    public function getOne($id)
    {
        $this->db->where('id', $id);
        return $this->db->get('tb_admin')->result_array();
    }

    public function tambah($data)
    {
        $this->db->insert('tb_admin', $data);
    }

    public function edit($data)
    {
        $this->db->where('id', dekrip($this->input->post('id', TRUE)));
        $this->db->update('tb_admin', $data);
    }

    public function resetPassword($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('tb_admin', $data);
    }

    public function multiple_delete($id)
    {
        foreach ($id as $id_new) {
            $this->db->where('id', dekrip($id_new));
            $data = $this->db->get('tb_admin')->result_array();

            if ($data[0]['foto'] != "default.jpg") {
                unlink(FCPATH . 'upload/profile/' . $data[0]['foto']);
            }
            $this->db->where('id', dekrip($id_new));
            $this->db->delete('tb_admin');
        }
    }
}