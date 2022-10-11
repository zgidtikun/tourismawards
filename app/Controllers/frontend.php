<?php

namespace App\Controllers;
use App\Controllers\BaseController;

class frontend extends BaseController
{
    public function index()
    {
        if(session()->get('isLoggedIn')){
            if(session()->get('role') == 1){
                return redirect()->to(base_url('awards/application'));
            }
            elseif(session()->get('role') == 3){
                return redirect()->to(base_url('awards/application'));
            }
            else
                return redirect()->to(base_url('403'));            
        } else {
            return redirect()->to(base_url('login')); 
        }
    }
}