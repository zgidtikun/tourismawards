<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;

class Login extends BaseController
{
    public function index()
    {
        $data['title']  = 'Amazing Thailand Safety and Health Administration (SHA)';
        $data['view']   = 'backend/login/index';
        $data['ci']     = $this;
        $data['_recapcha'] = false;

        return view('Backend/template_blank', $data);
    }
}
