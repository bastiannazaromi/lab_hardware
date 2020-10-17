<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_Pinjam extends CI_Model
{

    public function getAll($role)
    {
        $today = date('Y-m-d');
        if ($role == 'mahasiswa') {
            $this->db->select('tb_pinjaman.id, tb_pinjaman.jumlah, tb_pinjaman.status, tb_pinjaman.tanggal_pinjam, tb_pinjaman.max_kembali, tb_pinjaman.nama_barang, tb_mahasiswa.nim as id_user, tb_mahasiswa.nama');
            $this->db->from('tb_pinjaman');
            $this->db->join('tb_mahasiswa', 'tb_pinjaman.id_user = tb_mahasiswa.nim', 'left');
            $this->db->where('tb_pinjaman.status !=', 'Selesai');
            $this->db->where('tb_pinjaman.role', $role);
            $this->db->where('tb_pinjaman.max_kembali >= ', $today);

            $this->db->order_by('tanggal_pinjam', 'desc');

            return $this->db->get()->result_array();
        } else {
            $this->db->select('tb_pinjaman.id, tb_pinjaman.jumlah, tb_pinjaman.status, tb_pinjaman.tanggal_pinjam, tb_pinjaman.max_kembali, tb_pinjaman.nama_barang, tb_dosen.nidn_nipy as id_user, tb_dosen.nama');
            $this->db->from('tb_pinjaman');
            $this->db->join('tb_dosen', 'tb_pinjaman.id_user = tb_dosen.nidn_nipy', 'left');
            $this->db->where('tb_pinjaman.status !=', 'Selesai');
            $this->db->where('tb_pinjaman.role', $role);
            $this->db->where('tb_pinjaman.max_kembali >= ', $today);

            $this->db->order_by('tanggal_pinjam', 'desc');

            return $this->db->get()->result_array();
        }
    }

    public function getLewatBatas($role)
    {
        $today = date('Y-m-d');
        if ($role == 'mahasiswa') {
            $this->db->select('tb_pinjaman.id, tb_pinjaman.jumlah, tb_pinjaman.status, tb_pinjaman.tanggal_pinjam, tb_pinjaman.max_kembali, tb_pinjaman.tanggal_kembali, tb_pinjaman.nama_barang, tb_mahasiswa.nim as id_user, tb_mahasiswa.nama');
            $this->db->from('tb_pinjaman');
            $this->db->join('tb_mahasiswa', 'tb_pinjaman.id_user = tb_mahasiswa.nim', 'left');
            $this->db->where('tb_pinjaman.status !=', 'Selesai');
            $this->db->where('tb_pinjaman.role', $role);
            $this->db->where('tb_pinjaman.max_kembali < ', $today);

            $this->db->order_by('tanggal_pinjam', 'desc');

            return $this->db->get()->result_array();
        } else {
            $this->db->select('tb_pinjaman.id, tb_pinjaman.jumlah, tb_pinjaman.status, tb_pinjaman.tanggal_pinjam, tb_pinjaman.max_kembali, tb_pinjaman.tanggal_kembali, tb_pinjaman.nama_barang, tb_dosen.nidn_nipy as id_user, tb_dosen.nama');
            $this->db->from('tb_pinjaman');
            $this->db->join('tb_dosen', 'tb_pinjaman.id_user = tb_dosen.nidn_nipy', 'left');
            $this->db->where('tb_pinjaman.status !=', 'Selesai');
            $this->db->where('tb_pinjaman.role', $role);
            $this->db->where('tb_pinjaman.max_kembali < ', $today);

            $this->db->order_by('tanggal_pinjam', 'desc');

            return $this->db->get()->result_array();
        }
    }

    public function getOne($id)
    {
        $this->db->where('id', $id);
        return $this->db->get('tb_pinjaman')->result_array();
    }

    public function edit($data)
    {
        $this->db->where('id', $this->input->post('id', TRUE));
        return $this->db->update('tb_pinjaman', $data);
    }

    public function hapus($id)
    {
        $this->db->where('id', $id);
        $data = $this->db->get('tb_pinjaman')->result_array();
        $jumlah = $data[0]['jumlah'];

        $this->db->where('nama_barang', $data[0]['nama_barang']);
        $data2 = $this->db->get('tb_barang')->result_array();
        $dipinjam = $data2[0]['dipinjam'];

        $dt_update = [
            'dipinjam' => $dipinjam - $jumlah
        ];

        $this->db->where('nama_barang', $data2[0]['nama_barang']);
        $this->db->update('tb_barang', $dt_update);

        // $this->db->where('id', $id);
        $this->db->delete('tb_pinjaman', ['id' => $id]);
    }
    public function multiple_delete($id)
    {
        foreach ($id as $newId) {

            $this->db->where('id', $newId);
            $data = $this->db->get('tb_pinjaman')->result_array();
            $jumlah = $data[0]['jumlah'];

            $this->db->where('nama_barang', $data[0]['nama_barang']);
            $data2 = $this->db->get('tb_barang')->result_array();
            $dipinjam = $data2[0]['dipinjam'];

            $dt_update = [
                'dipinjam' => $dipinjam - $jumlah
            ];

            $this->db->where('nama_barang', $data2[0]['nama_barang']);
            $this->db->update('tb_barang', $dt_update);
        }
        $this->db->where_in('id', $id);
        $this->db->delete('tb_pinjaman');
    }

    public function getAllMahasiswa($id_user)
    {
        $this->db->select('tb_pinjaman.id, tb_pinjaman.nama_barang, tb_pinjaman.jumlah, tb_pinjaman.status, tb_pinjaman.tanggal_pinjam, tb_pinjaman.max_kembali, tb_pinjaman.tanggal_kembali, tb_barang.stok, tb_barang.kategori, tb_barang.normal, tb_barang.dipinjam, tb_mahasiswa.nim, tb_mahasiswa.nama');
        $this->db->from('tb_pinjaman');
        $this->db->join('tb_barang', 'tb_barang.nama_barang = tb_pinjaman.nama_barang', 'left');
        $this->db->join('tb_mahasiswa', 'tb_pinjaman.id_user = tb_mahasiswa.nim', 'left');
        $this->db->where('tb_pinjaman.id_user', $id_user);

        $this->db->order_by('tanggal_pinjam', 'desc');

        return $this->db->get()->result_array();
    }

    public function getAllDosen($id_user)
    {
        $this->db->select('tb_pinjaman.id, tb_pinjaman.nama_barang, tb_pinjaman.jumlah, tb_pinjaman.status, tb_pinjaman.tanggal_pinjam, tb_pinjaman.max_kembali, tb_pinjaman.tanggal_kembali, tb_barang.stok, tb_barang.kategori, tb_barang.normal, tb_barang.dipinjam, tb_dosen.nidn_nipy, tb_dosen.nama');
        $this->db->from('tb_pinjaman');
        $this->db->join('tb_barang', 'tb_barang.nama_barang = tb_pinjaman.nama_barang', 'left');
        $this->db->join('tb_dosen', 'tb_pinjaman.id_user = tb_dosen.nidn_nipy', 'left');
        $this->db->where('tb_pinjaman.id_user', $id_user);

        $this->db->order_by('tanggal_pinjam', 'desc');

        return $this->db->get()->result_array();
    }

    public function tambah($data)
    {
        return $this->db->insert('tb_pinjaman', $data);
    }
}