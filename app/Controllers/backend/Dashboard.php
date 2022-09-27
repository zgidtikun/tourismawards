<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    public function index()
    {
        $data['title']  = 'สถิติการใช้งาน';
        $data['view']   = 'backend/dashboard/index';
        $data['ci']     = $this;

        return view('backend/template', $data);
    }
}
