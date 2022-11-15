<?php
// Complete
namespace App\Controllers\Backend;

use App\Controllers\BaseController;

use App\Models\ApplicationForm;
use App\Models\ApplicationType;
use App\Models\ApplicationTypeSub;

class Complete extends BaseController
{
    public function __construct()
    {
        $this->ApplicationForm = new ApplicationForm;
        $this->ApplicationType = new ApplicationType;
        $this->ApplicationTypeSub = new ApplicationTypeSub;
    }

    public function index()
    {
        $like = [];
        $where = [];
        $sub_id = 1;
        $sort = 'desc';
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
        if (!empty($_GET['sort'])) {
            $sort = $_GET['sort'];
        }

        $data['result'] = $this->db->table('application_form AP')->select('AP.*, US.stage, US.status AS users_stage_status, US.duedate, C.application_form_id, ES.score_prescreen_tt, ES.score_onsite_tt')->join('users_stage US', 'US.user_id = AP.created_by', 'left')->join('committees C', 'C.application_form_id = AP.id', 'left')->join('estimate_score ES', 'ES.application_id = AP.id', 'left')->where('US.stage', 2)->where('AP.status', 6)->orWhere('AP.status', 7)->like($like, 'match', 'both')->where($where)->where('C.application_form_id', NULL)->orderBy('AP.created_at', $sort)->get()->getResultObject();
        pp($data['result']);
        pp_sql();
        exit;

        $data['application_type'] = $this->ApplicationType->findAll();
        $data['application_type_sub'] = $this->ApplicationTypeSub->where('application_type_id', $sub_id)->findAll();

        // Template
        $data['title']  = "ดำเนินการเสร็จสมบูรณ์";
        $data['view']   = 'administrator/complete/index';
        $data['ci']     = $this;

        return view('administrator/template', $data);
    }

    // public function register()
    // {
    //     // pp($_GET);
    //     $like = [];
    //     $where = [];
    //     $sort = 'desc';
    //     if (!empty($_GET['keyword']) && $_GET['keyword'] != "") {
    //         $like['company_name'] = $_GET['keyword'];
    //     }
    //     if (!empty($_GET['application_type_id']) && $_GET['application_type_id'] != "") {
    //         $where['application_type_id'] = $_GET['application_type_id'];
    //     }
    //     if (!empty($_GET['application_type_sub_id']) && $_GET['application_type_sub_id'] != "") {
    //         $where['application_type_sub_id'] = $_GET['application_type_sub_id'];
    //     }
    //     if (!empty($_GET['status']) && $_GET['status'] != "") {
    //         $like['status'] = $_GET['status'];
    //     }
    //     if (!empty($_GET['sort'])) {
    //         $sort = $_GET['sort'];
    //     }

    //     $data['result'] = $this->db->table('application_form AP')->select('AP.*, US.stage, US.status AS users_stage_status, US.duedate, C.application_form_id, ES.score_prescreen_tt, ES.score_onsite_tt')->join('users_stage US', 'US.user_id = AP.created_by', 'left')->join('committees C', 'C.application_form_id = AP.id', 'left')->join('estimate_score ES', 'ES.application_id = AP.id', 'left')->where('US.stage', 2)->where('AP.status', 6)->orWhere('AP.status', 7)->like($like, 'match', 'both')->where($where)->where('C.application_form_id', NULL)->orderBy('AP.created_at', $sort)->get()->getResultObject();
    //     // pp_sql();

        
    //     return view('administrator/export/register', $data);
    // }
}