<?php

function foto($id)
{
    $CI = &get_instance();

    $CI->load->model('M_Admin', 'admin');

    $admin = $CI->admin->getOne($CI->session->userdata('id'));

    return $admin[0]['foto'];
}

function nama($id)
{
    $CI = &get_instance();

    $CI->load->model('M_Admin', 'admin');

    $admin = $CI->admin->getOne($CI->session->userdata('id'));

    return $admin[0]['nama'];
}

function level($id)
{
    $CI = &get_instance();

    $CI->load->model('M_Admin', 'admin');

    $admin = $CI->admin->getOne($CI->session->userdata('id'));

    return $admin[0]['level'];
}

function cek_biodata($no_unik)
{
    $CI = &get_instance();

    $CI->load->model('M_Dosen', 'dosen');
    $CI->load->model('M_Mahasiswa', 'mahasiswa');

    if ($CI->session->userdata('status') == "Mahasiswa") {
        $data = $CI->mahasiswa->getOne($no_unik);
    } else {
        $data = $CI->dosen->getOne($no_unik);
    }

    $foto = $data[0]['foto'];
    $no = $data[0]['no_telepon'];
    $email = $data[0]['email'];

    if ($foto == "default.jpg" || $no == null || $email == nulL) {
        $CI->session->set_flashdata('flash-error', 'Lengkapi profile Anda !!');

        if ($CI->session->userdata('status') == "Mahasiswa") {
            redirect('mahasiswa/beranda/profile');
        } else {
            redirect('dosen/beranda/profile');
        }
    }
}

function bulan()
{
    $bulan = Date('m');
    switch ($bulan) {
        case 1:
            $bulan = "Januari";
            break;
        case 2:
            $bulan = "Februari";
            break;
        case 3:
            $bulan = "Maret";
            break;
        case 4:
            $bulan = "April";
            break;
        case 5:
            $bulan = "Mei";
            break;
        case 6:
            $bulan = "Juni";
            break;
        case 7:
            $bulan = "Juli";
            break;
        case 8:
            $bulan = "Agustus";
            break;
        case 9:
            $bulan = "September";
            break;
        case 10:
            $bulan = "Oktober";
            break;
        case 11:
            $bulan = "November";
            break;
        case 12:
            $bulan = "Desember";
            break;

        default:
            $bulan = Date('F');
            break;
    }
    return $bulan;
}


function tanggal_indo()
{
    $tanggal = Date('d') . " " . bulan() . " " . Date('Y');
    return $tanggal;
}

function flash_sukses($pesan)
{
    return
        '<div class="alert alert-success alert-dismissible fade show" role="alert">' .
        $pesan .
        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>';
}

function flash_error($pesan)
{
    return
        '<div class="alert alert-danger alert-dismissible fade show" role="alert">' .
        $pesan .
        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>';
}