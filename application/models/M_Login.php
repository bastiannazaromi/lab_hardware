<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_Login extends CI_Model
{

    function cek_login($u, $p)
    {

        $this->db->where('nim', $u);
        $query = $this->db->get('tb_mahasiswa');
        $data = $query->result();

        if (count($data) === 1) {
            if (password_verify($p, $data[0]->password)) {
                $login        =    array(
                    'is_logged_in'    =>     true,
                    'username'            =>    $u,
                    'id'            =>    $data[0]->id,
                    'nim'           =>    $data[0]->nim,
                    'nama'            =>    $data[0]->nama,
                    'semester'         => $data[0]->semester
                );
                if ($login) {
                    $this->session->set_userdata('user_login', $login);
                    $this->session->set_userdata($login);
                    return 'Valid';
                }
            } else {
                return 'Password Salah';
            }
        } else {
            return 'NIM tidak terdaftar';
        }
    }
}