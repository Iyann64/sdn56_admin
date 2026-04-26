<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */

$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Dashboard');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);


// ══════════════════════════════════════════════
// AUTH — tidak dilindungi AuthFilter
// ══════════════════════════════════════════════
$routes->get( '/login',         'Auth::login');
$routes->post('/login/proses',  'Auth::proses');
$routes->get( '/logout',        'Auth::logout');


// ══════════════════════════════════════════════
// DASHBOARD
// ══════════════════════════════════════════════
$routes->get('/',          'Dashboard::index');
$routes->get('/dashboard', 'Dashboard::index');


// ══════════════════════════════════════════════
// BERITA
// ══════════════════════════════════════════════
$routes->get( '/berita',               'BeritaAdmin::index',            ['filter' => 'role:Super Admin,Kepala Sekolah,Operator']);
$routes->get( '/berita/tambah',        'BeritaAdmin::tambah',           ['filter' => 'role:Super Admin,Operator']);
$routes->post('/berita/simpan',        'BeritaAdmin::simpan',           ['filter' => 'role:Super Admin,Operator']);
$routes->get( '/berita/edit/(:num)',   'BeritaAdmin::edit/$1',          ['filter' => 'role:Super Admin,Operator']);
$routes->post('/berita/update/(:num)', 'BeritaAdmin::update/$1',        ['filter' => 'role:Super Admin,Operator']);
$routes->get( '/berita/hapus/(:num)',  'BeritaAdmin::hapus/$1',         ['filter' => 'role:Super Admin,Operator']);


// ══════════════════════════════════════════════
// PPDB
// ══════════════════════════════════════════════
$routes->get( '/ppdb',                        'PpdbAdmin::index',           ['filter' => 'role:Super Admin,Kepala Sekolah,Operator']);
$routes->get( '/ppdb/tambah',                 'PpdbAdmin::tambah',          ['filter' => 'role:Super Admin,Operator']);
$routes->post('/ppdb/simpan',                 'PpdbAdmin::simpan',          ['filter' => 'role:Super Admin,Operator']);
$routes->get( '/ppdb/status/(:num)/(:alpha)', 'PpdbAdmin::ubahStatus/$1/$2', ['filter' => 'role:Super Admin,Operator']);
$routes->get( '/ppdb/hapus/(:num)',           'PpdbAdmin::hapus/$1',        ['filter' => 'role:Super Admin,Operator']);


// ══════════════════════════════════════════════
// AGENDA
// ══════════════════════════════════════════════
$routes->get( '/agenda',               'AgendaAdmin::index',            ['filter' => 'role:Super Admin,Kepala Sekolah,Operator']);
$routes->get( '/agenda/tambah',        'AgendaAdmin::tambah',           ['filter' => 'role:Super Admin,Operator']);
$routes->post('/agenda/simpan',        'AgendaAdmin::simpan',           ['filter' => 'role:Super Admin,Operator']);
$routes->get( '/agenda/edit/(:num)',   'AgendaAdmin::edit/$1',          ['filter' => 'role:Super Admin,Operator']);
$routes->post('/agenda/update/(:num)', 'AgendaAdmin::update/$1',        ['filter' => 'role:Super Admin,Operator']);
$routes->get( '/agenda/hapus/(:num)',  'AgendaAdmin::hapus/$1',         ['filter' => 'role:Super Admin,Operator']);


// ══════════════════════════════════════════════
// GALERI
// ══════════════════════════════════════════════
$routes->get( '/galeri',              'GaleriAdmin::index',     ['filter' => 'role:Super Admin,Kepala Sekolah,Operator']);
$routes->post('/galeri/upload',       'GaleriAdmin::upload',    ['filter' => 'role:Super Admin,Operator']);
$routes->get( '/galeri/hapus/(:num)', 'GaleriAdmin::hapus/$1',  ['filter' => 'role:Super Admin,Operator']);


// ══════════════════════════════════════════════
// GURU & STAF
// ══════════════════════════════════════════════
$routes->get( '/guru',               'GuruAdmin::index',            ['filter' => 'role:Super Admin,Kepala Sekolah,Operator']);
$routes->get( '/guru/tambah',        'GuruAdmin::tambah',           ['filter' => 'role:Super Admin,Operator']);
$routes->post('/guru/simpan',        'GuruAdmin::simpan',           ['filter' => 'role:Super Admin,Operator']);
$routes->get( '/guru/edit/(:num)',   'GuruAdmin::edit/$1',          ['filter' => 'role:Super Admin,Operator']);
$routes->post('/guru/update/(:num)', 'GuruAdmin::update/$1',        ['filter' => 'role:Super Admin,Operator']);
$routes->get( '/guru/hapus/(:num)',  'GuruAdmin::hapus/$1',         ['filter' => 'role:Super Admin,Operator']);


// ══════════════════════════════════════════════
// PENGATURAN (HANYA SUPER ADMIN)
// ══════════════════════════════════════════════
$routes->get( '/settings',              'Settings::index',           ['filter' => 'role:Super Admin']);
$routes->post('/settings/profil',       'Settings::simpanProfil',    ['filter' => 'role:Super Admin']);
$routes->post('/settings/password',     'Settings::ubahPassword',    ['filter' => 'role:Super Admin']);
$routes->post('/settings/sekolah',      'Settings::simpanSekolah',   ['filter' => 'role:Super Admin']);
$routes->post('/settings/ppdb-config',  'Settings::simpanPpdbConfig', ['filter' => 'role:Super Admin']);