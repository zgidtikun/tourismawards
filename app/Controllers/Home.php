<?php

namespace App\Controllers;
use App\Controllers\BaseController;

class Home extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Amazing Thailand Safety and Health Administration (SHA)',
            '_recapcha' => false,
            '_banner' => true,
            'view' => 'index'
        ];
        return view('template-app',$data);
    }
    public function indexBackend()
    {
        $data['title']  = 'สถิติการใช้งาน';
        $data['view']   = 'backend/dashboard/index';
        $data['ci']     = $this;

        return view('backend/template', $data);
    }

    public function error_403()
    {
        return view('errors/html/error_403_c');
    }

    public function error_404()
    {
        return view('errors/html/error_404_c');
    }
}
