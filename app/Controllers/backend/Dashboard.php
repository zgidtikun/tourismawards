<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    public function index()
    {
        $data['title']  = 'Thailand Tourism Award';
        $data['view']   = 'backend/dashboard/index';
        $data['ci']     = $this;

        return view('backend/template', $data);
    }
}
