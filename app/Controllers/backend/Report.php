<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;

use App\Models\ApplicationType;

class Report extends BaseController
{
    function __construct()
    {
        $this->ApplicationType = new ApplicationType;
    }

    public function index()
    {
        $data['type']   = $this->ApplicationType->findAll();
        
        $data['title']  = 'ส่งออกรายงาน';
        $data['view']   = 'backend/report/index';
        $data['ci']     = $this;

        return view('backend/template', $data);
    }
}
