<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;

class Setting extends BaseController
{
    public function index()
    {
        $data['title']  = 'การตั้งค่า';
        $data['view']   = 'backend/setting/index';
        $data['ci']     = $this;

        return view('backend/template', $data);
    }
}
