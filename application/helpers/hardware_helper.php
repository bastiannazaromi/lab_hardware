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

function cek_biodata($nim)
{
    $CI = &get_instance();

    $mahasiswa = $CI->mahasiswa->getOne($nim);

    $foto = $mahasiswa[0]['foto'];
    $no = $mahasiswa[0]['no_telepon'];
    $email = $mahasiswa[0]['email'];

    if ($foto == "default.jpg" || $no == null || $email == nulL) {
        $CI->session->set_flashdata('flash-error', 'Lengkapi profile Anda !!');
        redirect('mahasiswa/beranda/profile');
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