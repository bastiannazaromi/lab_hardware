<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Dosen extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (empty($this->session->userdata('data_login'))) {
            $this->session->set_flashdata('flash-error', 'Anda Belum Login');
            redirect('admin/auth', 'refresh');
        }

        $this->load->model('M_Dosen', 'dosen');
    }

    public function index()
    {
        $data['title'] = 'List Dosen';
        $data['page'] = 'admin/backend/dosen';

        $data['dosen'] = $this->dosen->getAll();

        $this->load->view('admin/backend/index', $data);
    }

    public function tambah()
    {
        $this->form_validation->set_rules('nidn', 'NIDN / NIPY', 'required|min_length[3]');
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('username', 'Username', 'required|min_length[5]');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'List Dosen';

            $data['dosen'] = $this->dosen->getAll();

            $data['page'] = 'admin/backend/dosen';

            $this->load->view('admin/backend/index', $data);
        } else {

            $data = [
                "nidn_nipy" => htmlspecialchars($this->input->post('nidn', TRUE)),
                "password" => password_hash($this->input->post('username', TRUE), PASSWORD_DEFAULT),
                "nama" => htmlspecialchars($this->input->post('nama', TRUE)),
                "username" => htmlspecialchars($this->input->post('username', TRUE)),
                "foto" => 'default.jpg'
            ];

            $this->dosen->tambah($data);

            $this->session->set_flashdata('flash_sukses', flash_sukses('Data berhasil ditambahkan'));
            redirect('admin/dosen');
        }
    }

    public function edit()
    {
        $this->form_validation->set_rules('nidn', 'NIDN / NIPY', 'required|min_length[3]');
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('username', 'Username', 'required|min_length[5]');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'List Dosen';

            $data['dosen'] = $this->dosen->getAll();

            $data['page'] = 'admin/backend/dosen';

            $this->load->view('admin/backend/index', $data);
        } else {
            $data = [
                "nidn_nipy" => htmlspecialchars($this->input->post('nidn', TRUE)),
                "password" => password_hash($this->input->post('username', TRUE), PASSWORD_DEFAULT),
                "nama" => htmlspecialchars($this->input->post('nama', TRUE)),
                "username" => htmlspecialchars($this->input->post('username', TRUE)),
            ];

            $this->dosen->edit($data);

            $this->session->set_flashdata('flash_sukses', flash_sukses('Data berhasil diupdate'));
            redirect('admin/dosen');
        }
    }

    public function resetPassword($id)
    {
        $this->db->where('id', $id);

        $data = $this->db->get('tb_dosen')->result_array();

        $data = [
            "password" => password_hash($data[0]['username'], PASSWORD_DEFAULT)
        ];

        $this->dosen->resetPassword($data, $id);

        $this->session->set_flashdata('flash_sukses', flash_sukses('Password berhasil direset !'));
        redirect('admin/dosen');
    }

    public function hapus($id)
    {
        $this->dosen->hapus($id);
        $this->session->set_flashdata('flash-sukses', 'Data berhasil dihapus');
        redirect('admin/dosen');
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
            redirect('admin/dosen');
        } else {

            $data_upload = $this->upload->data();

            $excelreader     = new PHPExcel_Reader_Excel2007();
            $loadexcel         = $excelreader->load('excel/' . $data_upload['file_name']); // Load file yang telah diupload ke folder excel
            $sheet             = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

            $data = array();

            $numrow = 1;
            foreach ($sheet as $row) {
                if ($numrow > 1) {
                    $cek = $this->db->get_where('tb_dosen', ['nidn_nipy' => str_replace('\'', '', $row['B'])])->result_array();

                    if ($row['A'] != null) {
                        if (!$cek) {
                            array_push($data, array(
                                'nidn_nipy' => htmlspecialchars(str_replace('\'', '', $row['B'])),
                                'username' => htmlspecialchars(strtolower(str_replace(' ', '', $row['C']))),
                                'password' => password_hash(strtolower(str_replace(' ', '', $row['C'])), PASSWORD_DEFAULT),
                                'nama' => htmlspecialchars($row['C']),
                                'email' => htmlspecialchars($row['D']),
                                'no_telepon' => htmlspecialchars(str_replace('\'', '', $row['E'])),
                                'foto' => 'default.jpg'
                            ));
                        }
                    }
                }
                $numrow++;
            }
            if (count($data) != 0) {
                $this->db->insert_batch('tb_dosen', $data);

                $this->session->set_flashdata('flash_sukses', flash_sukses('Data berhasil diimport'));
            } else {
                $this->session->set_flashdata('flash_error', flash_error('Gagal import ! Data kosong / sudah ada dalam database'));
            }
            //delete file from server
            unlink(realpath('excel/' . $data_upload['file_name']));

            //redirect halaman
            redirect('admin/dosen');
        }
    }

    public function multiple_delete()
    {
        $id = $this->input->post('id');
        if ($id == NULL) {
            $this->session->set_flashdata('flash_error', flash_error('Pilih data yang akan dihapus !'));
            redirect('admin/dosen');
        } else {
            $this->dosen->multiple_delete($id);

            $this->session->set_flashdata('flash_sukses', flash_sukses('Data berhasil dihapus'));
            redirect('admin/dosen');
        }
    }
}