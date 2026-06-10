<?php

namespace App\Controllers;

use App\Models\BeritaModel;
use App\Models\PpdbModel;
use App\Models\AgendaModel;
use App\Models\GuruModel;

/**
 * Dashboard Controller — sdn56_admin
 * GET /  |  GET /dashboard
 */
class Dashboard extends BaseController
{
    public function index(): string
    {
        try {
            $beritaModel = new BeritaModel();
            $ppdbModel   = new PpdbModel();
            $agendaModel = new AgendaModel();
            $guruModel   = new GuruModel();

            return $this->render('pages/dashboard', [
                'title'     => 'Dashboard',
                'page_icon' => '📊',
                'stats' => [
                    'total_siswa'   => 512,
                    'total_guru'    => $guruModel->jumlahAktif(),
                    'berita_terbit' => $beritaModel->where('status','Terbit')->countAllResults(),
                    'ppdb_pending'  => $ppdbModel->where('status','Menunggu')->countAllResults(),
                ],
                'berita_terbaru'   => $beritaModel->orderBy('tanggal','DESC')->limit(5)->findAll(),
                'ppdb_pending'     => $ppdbModel->where('status','Menunggu')->limit(5)->findAll(),
                'agenda_aktif'     => $agendaModel->getAktif(5),
                'distribusi_kelas' => [
                    'Kelas 1'=>88,'Kelas 2'=>82,'Kelas 3'=>90,
                    'Kelas 4'=>76,'Kelas 5'=>84,'Kelas 6'=>92,
                ],
            ]);
        } catch (\Throwable $e) {
            die('ERROR: ' . $e->getMessage() . '<br>File: ' . $e->getFile() . '<br>Line: ' . $e->getLine());
        }
    }

    /**
     * Mengambil data terbaru untuk update dashboard secara real-time via AJAX
     */
    public function getUpdates(): \CodeIgniter\HTTP\Response
    {
        $beritaModel = new BeritaModel();
        $ppdbModel   = new PpdbModel();
        $agendaModel = new AgendaModel();
        $guruModel   = new GuruModel();

        return $this->response->setJSON([
            'stats' => [
                'total_siswa'   => 512,
                'total_guru'    => $guruModel->jumlahAktif(),
                'berita_terbit' => $beritaModel->where('status','Terbit')->countAllResults(),
                'ppdb_pending'  => $ppdbModel->where('status','Menunggu')->countAllResults(),
            ],
            'berita_terbaru' => $beritaModel->orderBy('tanggal','DESC')->limit(5)->findAll(),
            'ppdb_pending'   => $ppdbModel->where('status','Menunggu')->limit(5)->findAll(),
            'agenda_aktif'   => $agendaModel->getAktif(5),
        ]);
    }
}