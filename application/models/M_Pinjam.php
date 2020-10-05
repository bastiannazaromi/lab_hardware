<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_Pinjam extends CI_Model
{

    public function getAll()
    {
        $this->db->select('tb_pinjaman.id, tb_pinjaman.jumlah, tb_pinjaman.status, tb_pinjaman.tanggal_pinjam, tb_pinjaman.max_kembali, tb_pinjaman.nama_barang, tb_mahasiswa.nim, tb_mahasiswa.nama');
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

    public function hapus($nama_barang)
    {
        $this->db->where('nama_barang', $nama_barang);
        $data = $this->db->get('tb_barang')->result_array();
        $dipinjam = $data[0]['dipinjam'];

        $this->db->where('nama_barang', $nama_barang);
        $data2 = $this->db->get('tb_pinjaman')->result_array();
        $jumlah = $data2[0]['jumlah'];

        $dt_update = [
            'dipinjam' => $dipinjam - $jumlah
        ];

        $this->db->where('nama_barang', $nama_barang);
        $this->db->update('tb_barang', $dt_update);

        // $this->db->where('id', $id);
        $this->db->delete('tb_pinjaman', ['nama_barang' => $nama_barang]);
    }
    public function multiple_delete($nm_brg)
    {
        foreach ($nm_brg as $nama_barang) {
            $this->db->where('nama_barang', $nama_barang);
            $data = $this->db->get('tb_barang')->result_array();
            $dipinjam = $data[0]['dipinjam'];

            $this->db->where('nama_barang', $nama_barang);
            $data2 = $this->db->get('tb_pinjaman')->result_array();
            $jumlah = $data2[0]['jumlah'];

            $dt_update = [
                'dipinjam' => $dipinjam - $jumlah
            ];

            $this->db->where('nama_barang', $nama_barang);
            $this->db->update('tb_barang', $dt_update);
        }
        $this->db->where_in('nama_barang', $nm_brg);
        $this->db->delete('tb_pinjaman');
    }

    public function getAllMahasiswa($nim)
    {
        $this->db->select('tb_pinjaman.id, tb_pinjaman.nama_barang, tb_pinjaman.jumlah, tb_pinjaman.status, tb_pinjaman.tanggal_pinjam, tb_pinjaman.max_kembali, tb_pinjaman.tanggal_kembali, tb_mahasiswa.nim, tb_mahasiswa.nama');
        $this->db->from('tb_pinjaman');
        $this->db->join('tb_mahasiswa', 'tb_pinjaman.nim = tb_mahasiswa.nim', 'left');
        $this->db->where('tb_pinjaman.nim', $nim);

        $this->db->order_by('tanggal_pinjam', 'desc');

        return $this->db->get()->result_array();
    }

    public function tambah($data)
    {
        return $this->db->insert('tb_pinjaman', $data);
    }
}