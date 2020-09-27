<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Stok_barang extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (empty($this->session->userdata('data_login'))) {
            $this->session->set_flashdata('flash-error', 'Anda Belum Login');
            redirect('admin/auth', 'refresh');
        }

        $this->load->model('M_Stok', 'stok');
    }

    public function index()
    {
        $data['title'] = 'Stok Barang';
        $data['page'] = 'admin/backend/stok_barang';

        $data['stok'] = $this->stok->getAll();

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

            $data = [
                "kategori" => htmlspecialchars($this->input->post('kategori', TRUE)),
                "nama_barang" => htmlspecialchars($this->input->post('nama', TRUE)),
                "stok" => htmlspecialchars($this->input->post('stok', TRUE)),
                "normal" => htmlspecialchars($this->input->post('normal', TRUE)),
                "rusak" => htmlspecialchars($this->input->post('rusak', TRUE))
            ];

            $this->stok->tambah($data);

            $this->session->set_flashdata('flash_sukses', flash_sukses('Barang berhasil ditambahkan'));
            redirect('admin/stok_barang');
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
            $data = [
                "kategori" => htmlspecialchars($this->input->post('kategori', TRUE)),
                "nama_barang" => htmlspecialchars($this->input->post('nama', TRUE)),
                "stok" => htmlspecialchars($this->input->post('stok', TRUE)),
                "normal" => htmlspecialchars($this->input->post('normal', TRUE)),
                "rusak" => htmlspecialchars($this->input->post('rusak', TRUE))
            ];

            $this->stok->edit($data);

            $this->session->set_flashdata('flash_sukses', flash_sukses('Barang berhasil diupdate'));
            redirect('admin/stok_barang');
        }
    }

    public function hapus($id)
    {
        $this->stok->hapus($id);
        $this->session->set_flashdata('flash-sukses', 'Barang berhasil dihapus');
        redirect('admin/barang');
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
            redirect('admin/mahasiswa');
        } else {

            $data_upload = $this->upload->data();

            $excelreader     = new PHPExcel_Reader_Excel2007();
            $loadexcel         = $excelreader->load('excel/' . $data_upload['file_name']); // Load file yang telah diupload ke folder excel
            $sheet             = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

            $data = array();

            $numrow = 1;
            foreach ($sheet as $row) {
                if ($numrow > 1) {
                    array_push($data, array(
                        'kategori' => htmlspecialchars(str_replace('\'', '', $row['B'])),
                        'nama_barang' => htmlspecialchars(str_replace('\'', '',  $row['C'])),
                        'stok' => htmlspecialchars(str_replace('\'', '',  $row['D'])),
                        'normal' => htmlspecialchars(str_replace('\'', '',  $row['E'])),
                        'rusak' => htmlspecialchars(str_replace('\'', '',  $row['F']))
                    ));
                }
                $numrow++;
            }
            $this->db->insert_batch('tb_barang', $data);
            //delete file from server
            unlink(realpath('excel/' . $data_upload['file_name']));

            //upload success
            $this->session->set_flashdata('flash_sukses', flash_sukses('Barang berhasil diimport'));
            //redirect halaman
            redirect('admin/stok_barang');
        }
    }

    public function multiple_delete()
    {
        $id = $this->input->post('id');
        if ($id == NULL) {
            $this->session->set_flashdata('flash_error', flash_error('Pilih data yang akan dihapus !'));
            redirect('admin/stok_barang');
        } else {
            $this->stok->multiple_delete($id);

            $this->session->set_flashdata('flash_sukses', flash_sukses('Barang berhasil dihapus'));
            redirect('admin/stok_barang');
        }
    }
}