<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;

use App\Models\Users;
use App\Models\UsersStage;
use App\Models\ApplicationForm;
use App\Models\ApplicationType;
use App\Models\ApplicationTypeSub;

class PreScreen extends BaseController
{
    private $Users;
    private $UsersStage;
    private $ApplicationForm;
    private $ApplicationType;
    private $ApplicationTypeSub;

    public function __construct()
    {
        $this->Users = new Users;
        $this->UsersStage = new UsersStage;
        $this->ApplicationForm = new ApplicationForm;
        $this->ApplicationType = new ApplicationType;
        $this->ApplicationTypeSub = new ApplicationTypeSub;
    }

    public function index()
    {
        $like = [];
        $where = [];
        $where_type = [];
        $sub_id = 1;
        // $like['status'] = 0;
        // $like['status'] = 4;
        if (!empty($_GET['keyword']) && $_GET['keyword'] != "") {
            // $like['attraction_name_th'] = $_GET['keyword'];
            $like['company_name'] = $_GET['keyword'];
        }
        if (!empty($_GET['application_type_id']) && $_GET['application_type_id'] != "") {
            $where['application_type_id'] = $_GET['application_type_id'];
            $sub_id = $_GET['application_type_id'];
        }
        if (!empty($_GET['application_type_sub_id']) && $_GET['application_type_sub_id'] != "") {
            $where['application_type_sub_id'] = $_GET['application_type_sub_id'];
        }
        if (!empty($_GET['status']) && $_GET['status'] != "") {
            $like['status'] = $_GET['status'];
        }

        if (!empty(session()->award_type) && session()->award_type != "" && !isAdmin()) {
            $where['application_type_id'] = session()->award_type;
            $where_type['id'] = session()->award_type;
            $sub_id = session()->award_type;
        }

        // $data['result'] = $this->db->table('application_form AP')->select('AP.*, US.stage')->join('users_stage US', 'US.user_id = AP.created_by', 'left')->where('US.stage', 1)->where('AP.status', 3)->like($like, 'match', 'both')->where($where)->orderBy('AP.created_at', 'desc')->get()->getResultObject();
        $data['result'] = $this->db->table('application_form AP')->select('AP.*')->where('AP.status', 3)->like($like, 'match', 'both')->where($where)->orderBy('AP.created_at', 'desc')->get()->getResultObject();
        // pp_sql();
        // px($data['result']);
        $data['application_type'] = $this->ApplicationType->where($where_type)->findAll();
        $data['application_type_sub'] = $this->ApplicationTypeSub->where('application_type_id', $sub_id)->findAll();

        // Template
        $data['title']  = 'ใบสมัครที่ผ่านการอนุมัติ';
        $data['view']   = 'administrator/prescreen/index';
        $data['ci']     = $this;

        return view('administrator/template', $data);
    }

    public function edit($id)
    {
        $data['result'] = $this->ApplicationForm->find($id);
        if (empty($data['result'])) {
            show_404();
        }
        $data['id'] = $id;
        $data['application_type'] = $this->ApplicationType->findAll();
        $data['application_type_sub'] = $this->ApplicationTypeSub->where('application_type_id', $data['result']->application_type_id)->findAll();

        // Template
        $data['title']  = 'ใบสมัครที่ผ่านการอนุมัติ';
        $data['view']   = 'administrator/prescreen/edit';
        $data['ci']     = $this;

        return view('administrator/template', $data);
    }
}
