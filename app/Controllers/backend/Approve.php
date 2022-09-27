<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;
use App\Models\ApplicationType;
use App\Models\ApplicationTypeSub;

class Approve extends BaseController
{
    public function __construct()
    {
        $this->ApplicationType = new ApplicationType;
        $this->ApplicationTypeSub = new ApplicationTypeSub;
    }

    public function index()
    {

        // Template
        $data['title']  = 'ตรวจสอบใบสมัคร';
        $data['view']   = 'backend/approve/index';
        $data['ci']     = $this;

        return view('backend/template', $data);
    }

    public function check()
    {
        $data['application_type'] = $this->ApplicationType->findAll();
        $data['application_type_sub'] = $this->ApplicationTypeSub->where('application_type_id', 1)->findAll();
        // px($data['application_type_sub']);

        // Template
        $data['title']  = 'ตรวจสอบใบสมัคร';
        $data['view']   = 'backend/approve/check';
        $data['ci']     = $this;

        return view('backend/template', $data);
    }

    public function history()
    {

        // Template
        $data['title']  = 'ประวัติการตรวจสอบใบสมัคร';
        $data['view']   = 'backend/approve/history';
        $data['ci']     = $this;

        return view('backend/template', $data);
    }

    public function getAplicationTypeSub($application_type_id = 1)
    {
        $result = $this->ApplicationTypeSub->where('application_type_id', $application_type_id)->findAll();
        echo json_encode($result);
    }
}
