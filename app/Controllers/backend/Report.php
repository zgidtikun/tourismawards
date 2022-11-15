<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;

use App\Models\ApplicationForm;
use App\Models\ApplicationType;
use App\Models\ApplicationTypeSub;

class Report extends BaseController
{
    function __construct()
    {
        $this->ApplicationForm = new ApplicationForm;
        $this->ApplicationType = new ApplicationType;
        $this->ApplicationTypeSub = new ApplicationTypeSub;
    }

    public function index()
    {
        // $data['type']   = $this->ApplicationType->findAll();

        $data['title']  = 'ส่งออกรายงาน';
        $data['view']   = 'administrator/export/index';
        $data['ci']     = $this;

        return view('administrator/template', $data);
    }

    public function export($page)
    {
        if ($page == 'register') {
            $this->register();
        } else if ($page == 'pre_officer') {
            $this->pre_officer();
        } else {
            show_404();
        }
    }

    public function register()
    {
        $data['result'] = $this->db->table('application_form AP')->select('AP.*, U.email AS user_email, U.mobile AS user_mobile')->join('users U', 'U.id = AP.created_by')->get()->getResultObject();

        return view('administrator/export/register', $data);
    }

    public function pre_officer()
    {
        $data['result'] = $this->db->table('application_form AP')->select('AP.*, U.email AS user_email, U.mobile AS user_mobile')->join('users U', 'U.id = AP.created_by')->get()->getResultObject();

        return view('administrator/export/pre_officer', $data);
    }
}
