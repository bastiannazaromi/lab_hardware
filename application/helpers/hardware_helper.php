<?php

function enkrip($string){
	$bumbu = md5(str_replace("=", "", base64_encode("maykomputer.com")));
	$katakata = false;
	$metodeenkrip = "AES-256-CBC";
	$kunci = hash('sha256', $bumbu);
	$kodeiv = substr(hash('sha256', $bumbu), 0, 16);
	
	$katakata = str_replace("=", "", openssl_encrypt($string, $metodeenkrip, $kunci, 0, $kodeiv));
	$katakata = str_replace("=", "", base64_encode($katakata));
	
    return $katakata;
}

function dekrip($string){
	$bumbu = md5(str_replace("=", "", base64_encode("maykomputer.com")));
	$katakata = false;
	$metodeenkrip = "AES-256-CBC";
	$kunci = hash('sha256', $bumbu);
	$kodeiv = substr(hash('sha256', $bumbu), 0, 16);
	
    $katakata = openssl_decrypt(base64_decode($string), $metodeenkrip, $kunci, 0, $kodeiv);
    return $katakata;
}

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

function semester()
{
    $CI = &get_instance();

    $CI->load->model('M_Mahasiswa', 'mahasiswa');

    $CI->db->select('semester');
    $CI->db->from('tb_mahasiswa');
    $CI->db->group_by('semester');
    $CI->db->order_by('semester');

    return $CI->db->get()->result_array();
}

function tempoTgl($maxTgl, $tglKembali)
{
    if (!$tglKembali) {
        $tanggal = date('Y-m-d H:i:s');
        $waktu = strtotime($tanggal);
        $today = date('Y-m-d', $waktu);

        $currentDate  = date_create($today);
        $maxDate = date_create($maxTgl);
        $diff  = date_diff($currentDate, $maxDate);

        $bulan = $diff->m;
        $hari = $diff->d;
        if ($currentDate <= $maxDate) {
            if ($bulan != 0) {
                if ($hari != 0) {
                    return ' - ' . $hari . ' hari ' . $bulan . ' bulan untuk pengembalian';
                } else {
                    return ' - ' . $bulan . ' bulan untuk pengembalian';
                }
            } else {
                if ($hari != 0) {
                    return ' - ' . $hari . ' hari untuk pengembalian';;
                } else {
                    return 'Hari ini terakhir dikembalikan !';
                }
            }
        } else {
            if ($bulan != 0) {
                if ($hari != 0) {
                    return 'Sudah + ' . $hari . ' hari ' . $bulan . ' bulan dari maximal pengembalian !';
                } else {
                    return 'Sudah + ' . $bulan . ' bulan dari maximal pengembalian !';
                }
            } else {
                return 'Sudah + ' . $hari . ' hari dari maximal pengembalian !';
            }
        }
    } else {
        return 'Sudah dikembalikan';
    }
}

function denda($maxTgl, $tglKembali)
{
    if (!$tglKembali) {
        $tanggal = date('Y-m-d H:i:s');
        $waktu = strtotime($tanggal);
        $today = date('Y-m-d', $waktu);

        $currentDate = new DateTime($today);
        $end = new DateTime($maxTgl);
        if ($currentDate >= $end)
        {
            $d = $currentDate->diff($end);
            return $d->days * 1000;
        }
        else{
            return 0;
        }
    } else {
        $currentDate = new DateTime($tglKembali);
        $end = new DateTime($maxTgl);
        if ($currentDate >= $end)
        {
            $d = $currentDate->diff($end);
            return $d->days * 1000;
        }
        else{
            return 0;
        }
    }
}