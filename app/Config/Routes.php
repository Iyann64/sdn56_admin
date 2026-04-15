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
$routes->get( '/berita',               'BeritaAdmin::index');
$routes->get( '/berita/tambah',        'BeritaAdmin::tambah');
$routes->post('/berita/simpan',        'BeritaAdmin::simpan');
$routes->get( '/berita/edit/(:num)',   'BeritaAdmin::edit/$1');
$routes->post('/berita/update/(:num)', 'BeritaAdmin::update/$1');
$routes->get( '/berita/hapus/(:num)',  'BeritaAdmin::hapus/$1');


// ══════════════════════════════════════════════
// PPDB
// ══════════════════════════════════════════════
$routes->get( '/ppdb',                        'PpdbAdmin::index');
$routes->get( '/ppdb/tambah',                 'PpdbAdmin::tambah');
$routes->post('/ppdb/simpan',                 'PpdbAdmin::simpan');
$routes->get( '/ppdb/status/(:num)/(:alpha)', 'PpdbAdmin::ubahStatus/$1/$2');
$routes->get( '/ppdb/hapus/(:num)',           'PpdbAdmin::hapus/$1');


// ══════════════════════════════════════════════
// AGENDA
// ══════════════════════════════════════════════
$routes->get( '/agenda',               'AgendaAdmin::index');
$routes->get( '/agenda/tambah',        'AgendaAdmin::tambah');
$routes->post('/agenda/simpan',        'AgendaAdmin::simpan');
$routes->get( '/agenda/edit/(:num)',   'AgendaAdmin::edit/$1');
$routes->post('/agenda/update/(:num)', 'AgendaAdmin::update/$1');
$routes->get( '/agenda/hapus/(:num)',  'AgendaAdmin::hapus/$1');


// ══════════════════════════════════════════════
// GALERI
// ══════════════════════════════════════════════
$routes->get( '/galeri',              'GaleriAdmin::index');
$routes->post('/galeri/upload',       'GaleriAdmin::upload');
$routes->get( '/galeri/hapus/(:num)', 'GaleriAdmin::hapus/$1');


// ══════════════════════════════════════════════
// GURU & STAF
// ══════════════════════════════════════════════
$routes->get( '/guru',               'GuruAdmin::index');
$routes->get( '/guru/tambah',        'GuruAdmin::tambah');
$routes->post('/guru/simpan',        'GuruAdmin::simpan');
$routes->get( '/guru/edit/(:num)',   'GuruAdmin::edit/$1');
$routes->post('/guru/update/(:num)', 'GuruAdmin::update/$1');
$routes->get( '/guru/hapus/(:num)',  'GuruAdmin::hapus/$1');


// ══════════════════════════════════════════════
// PENGATURAN
// ══════════════════════════════════════════════
$routes->get( '/settings',              'Settings::index');
$routes->post('/settings/profil',       'Settings::simpanProfil');
$routes->post('/settings/password',     'Settings::ubahPassword');
$routes->post('/settings/sekolah',      'Settings::simpanSekolah');
$routes->post('/settings/ppdb-config',  'Settings::simpanPpdbConfig');