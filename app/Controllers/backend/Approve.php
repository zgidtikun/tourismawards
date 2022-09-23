<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;

class Approve extends BaseController
{
    public function index()
    {


        // Template
        $data['title']  = 'ประวัติการอนุมัติใบสมัคร';
        $data['view']   = 'backend/approve/index';
        $data['ci']     = $this;

        return view('backend/template', $data);
    }
}
