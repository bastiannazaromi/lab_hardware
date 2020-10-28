<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Stok_barang extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (empty($this->session->userdata('data_login'))) {
            $this->session->set_flashdata('flash-error', 'Anda Belum Login');
            redirect('belakang/login', 'refresh');
        }

        $this->load->model('M_Stok', 'stok');
        $this->load->model('M_Kategori', 'kategori');
    }

    public function index()
    {
        $data['title'] = 'Stok Barang';
        $data['page'] = 'admin/backend/stok_barang';
        $data['stok'] = $this->stok->getAll();
        $data['kategori'] = $this->kategori->getAll();

        $this->load->view('admin/backend/index', $data);
    }

    public function tambah()
    {
        $this->form_validation->set_rules('kategori', 'Kategori', 'required');
        $this->form_validation->set_rules('nama', 'Nama barang', 'required');
        $this->form_validation->set_rules('stok', 'Stok Barang', 'required|numeric');
        $this->form_validation->set_rules('normal', 'Barang Normal', 'required|numeric');
        $this->form_validation->set_rules('rusak', 'Barang Rusak', 'required|numeric');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Stok Barang';

            $data['page'] = 'admin/backend/stok_barang';

            $data['stok'] = $this->stok->getAll();

            $this->load->view('admin/backend/index', $data);
        } else {

            $stok = htmlspecialchars($this->input->post('stok', TRUE));
            $normal = htmlspecialchars($this->input->post('normal', TRUE));

            $data = [
                "kategori" => $this->input->post('kategori', TRUE),
                "nama_barang" => htmlspecialchars($this->input->post('nama', TRUE)),
                "stok" => $stok,
                "normal" => $normal,
                "rusak" => $stok - $normal
            ];

            $query = $this->stok->tambah($data);
            if ($query) {
                $this->session->set_flashdata('flash_sukses', flash_sukses('Barang berhasil ditambahkan'));
                redirect('belakang/stok');
            } else {
                $this->session->set_flashdata('flash_error', flash_error('Barang gagal ditambahkan !'));
                redirect('belakang/stok');
            }
        }
    }

    public function edit()
    {
        $this->form_validation->set_rules('kategori', 'Kategori', 'required');
        $this->form_validation->set_rules('nama', 'Nama barang', 'required');
        $this->form_validation->set_rules('stok', 'Stok Barang', 'required|numeric');
        $this->form_validation->set_rules('normal', 'Barang Normal', 'required|numeric');
        $this->form_validation->set_rules('rusak', 'Barang Rusak', 'required|numeric');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Stok Barang';

            $data['page'] = 'admin/backend/stok_barang';

            $data['stok'] = $this->stok->getAll();

            $this->load->view('admin/backend/index', $data);
        } else {
            $stok = htmlspecialchars($this->input->post('stok', TRUE));
            $normal = htmlspecialchars($this->input->post('normal', TRUE));

            $data = [
                "kategori" => $this->input->post('kategori', TRUE),
                "nama_barang" => htmlspecialchars($this->input->post('nama', TRUE)),
                "stok" => $stok,
                "normal" => $normal,
                "rusak" => $stok - $normal
            ];

            $query = $this->stok->edit($data);

            if ($query) {
                $this->session->set_flashdata('flash_sukses', flash_sukses('Barang berhasil diupdate'));
                redirect('belakang/stok');
            } else {
                $this->session->set_flashdata('flash_error', flash_error('Barang gagal diupdate'));
                redirect('belakang/stok');
            }
        }
    }

    public function hapus($id)
    {
        $query = $this->stok->hapus(dekrip($id));
        if ($query) {
            $this->session->set_flashdata('flash_sukses', flash_sukses('Barang berhasil dihapus'));
            redirect('belakang/stok');
        } else {
            $this->session->set_flashdata('flash_error', flash_error('Barang gagal dihapus'));
            redirect('belakang/stok');
        }
    }

    public function import()
    {
        // Load plugin PHPExcel nya
        include APPPATH . 'third_party/PHPExcel/PHPExcel.php';

        $config['upload_path'] = realpath('excel');
        $config['allowed_types'] = 'xlsx|xls|csv';
        $config['max_size'] = '10000';

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('fileExcel')) {

            //upload gagal
            $this->session->set_flashdata('flash_error', flash_error($this->upload->display_errors()));
            //redirect halaman
            redirect('belakang/stok');
        } else {

            $data_upload = $this->upload->data();

            $excelreader     = new PHPExcel_Reader_Excel2007();
            $loadexcel         = $excelreader->load('excel/' . $data_upload['file_name']); // Load file yang telah diupload ke folder excel
            $sheet             = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

            $data = array();

            $numrow = 1;
            $status = 0;
            foreach ($sheet as $row) {
                if ($numrow > 1) {
                    $cek = $this->db->get_where('tb_barang', ['nama_barang' => str_replace('\'', '', $row['C'])])->result_array();

                    if ($row['A'] != null) {
                        if (!$cek) {
                            array_push($data, array(
                                'kategori' => str_replace('\'', '', $row['B']),
                                'nama_barang' => str_replace('\'', '',  $row['C']),
                                'stok' => str_replace('\'', '',  $row['D']),
                                'normal' => str_replace('\'', '',  $row['E']),
                                'rusak' => str_replace('\'', '',  $row['F'])
                            ));
                        } else {
                            $stok = $cek[0]['stok'];
                            $normal = $cek[0]['normal'];
                            $rusak = $cek[0]['rusak'];

                            if ($stok != str_replace('\'', '',  $row['D']) || $normal != str_replace('\'', '',  $row['E']) || $rusak != str_replace('\'', '',  $row['F'])) {
                                $update = [
                                    "stok" => str_replace('\'', '',  $row['D']),
                                    "normal" => str_replace('\'', '',  $row['E']),
                                    "rusak" => str_replace('\'', '',  $row['F'])
                                ];

                                $this->db->where('nama_barang', str_replace('\'', '',  $row['C']));
                                $this->db->update('tb_barang', $update);

                                $status += $status + 1;
                            }
                        }
                    }
                }
                $numrow++;
            }
            if (count($data) != 0) {
                $this->db->insert_batch('tb_barang', $data);

                $this->session->set_flashdata('flash_sukses', flash_sukses('Data berhasil diimport'));
            } else {
                if ($status == 0) {
                    $this->session->set_flashdata('flash_error', flash_error('Gagal import ! Data kosong / sudah ada dalam database'));
                } else {
                    $this->session->set_flashdata('flash_sukses', flash_sukses('Data berhasil diupdate'));
                }
            }
            //delete file from server
            unlink(realpath('excel/' . $data_upload['file_name']));

            //redirect halaman
            redirect('belakang/stok');
        }
    }

    public function multiple_delete()
    {
        $id = $this->input->post('id');
        if ($id == NULL) {
            $this->session->set_flashdata('flash_error', flash_error('Pilih data yang akan dihapus !'));
            redirect('belakang/stok');
        } else {
            $query = $this->stok->multiple_delete($id);

            if ($query) {
                $this->session->set_flashdata('flash_sukses', flash_sukses('Barang berhasil dihapus'));
                redirect('belakang/stok');
            } else {
                $this->session->set_flashdata('flash_error', flash_error('Barang gagal dihapus'));
                redirect('belakang/stok');
            }
        }
    }
}