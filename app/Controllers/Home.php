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

    public function frontend()
    {
        if(session()->get('role') == 1)
            return redirect()->to(base_url('frontend/application'));
        else return redirect()->to(base_url('frontend/application'));
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
