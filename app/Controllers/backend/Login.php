<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;

class Login extends BaseController
{
    private $recapcha = true;

    public function __construct()
    {        
        $_app = new \Config\App();
        $this->recapcha = $_app->RECAPCHA_CK;
    }

    public function index()
    {
        if(!session()->get('isLoggedIn')){
            $data['title']  = 'Tourist Award | Login';
            $data['view']   = 'administrator/login/index';
            $data['ci']     = $this;
            $data['_recapcha'] = $this->recapcha;

            return view('administrator/template_blank', $data);
        } else {
            return redirect()->to(base_url('administrator/dashboard'));
        }
    }
}
