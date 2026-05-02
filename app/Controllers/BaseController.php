<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Parent semua controller panel admin.
 */
abstract class BaseController extends Controller
{
    protected $helpers = ['url', 'form', 'html', 'text', 'permission'];

    protected array $data = [];

    public function initController(
        RequestInterface  $request,
        ResponseInterface $response,
        LoggerInterface   $logger
    ): void {
        parent::initController($request, $response, $logger);

        $this->data = [
            'site_name'  => 'SD Negeri 56 Prabumulih',
            'site_email' => 'sdnegeri56pbm@gmail.com',
            'logo_url'   => base_url('assets/img/logo.jpg'),
            'web_url'    => 'http://localhost:8080',
            'upload_url' => 'http://sekolah1.test/uploads/', // URL folder upload di web publik
            'public_uploads_path' => FCPATH . '../../sekolah1/public/uploads/', // Path fisik ke folder uploads web publik
        ];
    }

    /**
     * Render halaman admin via layouts/main.php
     */
    protected function render(string $page, array $extra = []): string
    {
        $data                 = array_merge($this->data, $extra);
        $data['content_view'] = $page;
        $data['admin_user']   = session()->get('admin_user') ?? [];
        return view('layouts/main', $data);
    }
}