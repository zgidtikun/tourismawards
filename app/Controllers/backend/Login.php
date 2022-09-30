<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;

class Login extends BaseController
{
    public function index()
    {
        if(!session()->get('isLoggedIn')){
            $data['title']  = 'Tourist Award | Login';
            $data['view']   = 'backend/login/index';
            $data['ci']     = $this;
            $data['_recapcha'] = false;

            return view('Backend/template_blank', $data);
        } else {
            return redirect()->to(base_url('backend/dashboard'));
        }
    }
}
