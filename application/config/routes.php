<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

$route['default_controller'] = 'login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['belakang'] = 'admin/dashboard';
$route['belakang/dashboard'] = 'admin/dashboard';

$route['belakang/login']                            = 'admin/auth';
$route['belakang/prosesLogin']                      = 'admin/auth/login';
$route['belakang/logout']                           = 'admin/auth/logout';
$route['belakang/profile']                          = 'admin/admin/profile';
$route['belakang/updateFoto']                       = 'admin/admin/updateFoto';
$route['belakang/updatePass']                       = 'admin/admin/updatePass';

$route['belakang/admin']                            = 'admin/admin';
$route['belakang/admin/tambah']                     = 'admin/admin/tambah';
$route['belakang/admin/edit']                       = 'admin/admin/edit';
$route['belakang/admin/hapus']                      = 'admin/admin/multiple_delete';
$route['belakang/admin/resetPassword/(:any)']       = 'admin/admin/resetPassword/$1';

$route['belakang/mahasiswa']                        = 'admin/mahasiswa/semester';
$route['belakang/mahasiswa/semester']               = 'admin/mahasiswa/semester';
$route['belakang/mahasiswa/semester/(:any)']        = 'admin/mahasiswa/semester/$1';
$route['belakang/mahasiswa/hapus']                  = 'admin/mahasiswa/multiple_delete';
$route['belakang/mahasiswa/resetPassword/(:any)']   = 'admin/mahasiswa/resetPassword/$1';
$route['belakang/mahasiswa/tambah']                 = 'admin/mahasiswa/tambah';
$route['belakang/mahasiswa/edit']                   = 'admin/mahasiswa/edit';
$route['belakang/mahasiswa/import']                 = 'admin/mahasiswa/import';

$route['belakang/dosen']                            = 'admin/dosen';
$route['belakang/dosen/hapus']                      = 'admin/dosen/multiple_delete';
$route['belakang/dosen/resetPassword/(:any)']       = 'admin/dosen/resetPassword/$1';
$route['belakang/dosen/tambah']                     = 'admin/dosen/tambah';
$route['belakang/dosen/edit']                       = 'admin/dosen/edit';
$route['belakang/dosen/import']                     = 'admin/dosen/import';

$route['belakang/stok']                             = 'admin/stok_barang';
$route['belakang/stok/hapus']                       = 'admin/stok_barang/multiple_delete';
$route['belakang/stok/tambah']                      = 'admin/stok_barang/tambah';
$route['belakang/stok/edit']                        = 'admin/stok_barang/edit';
$route['belakang/stok/import']                      = 'admin/stok_barang/import';

$route['belakang/pinjaman/mahasiswa']               = 'admin/barang_pinjam/pinjaman/mahasiswa';
$route['belakang/lewat_batas/mahasiswa']            = 'admin/barang_pinjam/lewat_batas/mahasiswa';
$route['belakang/pinjaman/dosen']                   = 'admin/barang_pinjam/pinjaman/dosen';
$route['belakang/lewat_batas/dosen']                = 'admin/barang_pinjam/lewat_batas/dosen';
$route['belakang/pinjaman/update']                  = 'admin/barang_pinjam/update';
$route['belakang/pinjaman/hapus']                   = 'admin/barang_pinjam/multiple_delete';

$route['belakang/pinjaman/cek/(:any)/(:any)/(:any)'] = 'admin/barang_pinjam/cek/$1/$2/$3';

$route['belakang/rekap/mahasiswa']                  = 'admin/rekap/barang/mahasiswa';
$route['belakang/rekap/dosen']                      = 'admin/rekap/barang/dosen';
$route['belakang/rekap/update']                     = 'admin/rekap/update';
$route['belakang/rekap/hapus']                      = 'admin/rekap/multiple_delete';

$route['belakang/kategori']                         = 'admin/kategori';
$route['belakang/kategori/hapus']                   = 'admin/kategori/multiple_delete';
$route['belakang/kategori/tambah']                  = 'admin/kategori/tambah';
$route['belakang/kategori/edit']                    = 'admin/kategori/edit';

$route['dashboard']                                 = 'login';
$route['dashboard/login']                           = 'login';
$route['dashboard/login/proses']                    = 'login/login';
$route['dashboard/mahasiswa']                       = 'mahasiswa/beranda';
$route['dashboard/dosen']                           = 'dosen/beranda';

$route['dashboard/dosen/profile']                   = 'dosen/beranda/profile';
$route['dashboard/mahasiswa/profile']               = 'mahasiswa/beranda/profile';
$route['dashboard/dosen/updatePass']                = 'dosen/beranda/updatePass';
$route['dashboard/mahasiswa/updatePass']            = 'mahasiswa/beranda/updatePass';

$route['dashboard/mahasiswa/pinjaman/(:any)']       = 'mahasiswa/beranda/pinjaman/$1';
$route['dashboard/mahasiswa/pinjam']                = 'mahasiswa/beranda/pinjam';
$route['dashboard/mahasiswa/cari_barang']           = 'mahasiswa/beranda/cari_barang';
$route['dashboard/mahasiswa/tambah']                = 'mahasiswa/beranda/tambah';
$route['dashboard/mahasiswa/edit']                  = 'mahasiswa/beranda/edit';
$route['dashboard/mahasiswa/hapus/(:any)']          = 'mahasiswa/beranda/hapus/$1';
$route['dashboard/mahasiswa/checkout']              = 'mahasiswa/beranda/checkout';

$route['dashboard/dosen/pinjaman/(:any)']           = 'dosen/beranda/pinjaman/$1';
$route['dashboard/dosen/pinjam']                    = 'dosen/beranda/pinjam';
$route['dashboard/dosen/cari_barang']               = 'dosen/beranda/cari_barang';
$route['dashboard/dosen/tambah']                    = 'dosen/beranda/tambah';
$route['dashboard/dosen/edit']                      = 'dosen/beranda/edit';
$route['dashboard/dosen/hapus/(:any)']          = 'dosen/beranda/hapus/$1';
$route['dashboard/dosen/checkout']                  = 'dosen/beranda/checkout';

$route['dashboard/logout']                          = 'login/logout';