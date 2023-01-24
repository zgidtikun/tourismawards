<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;


use App\Models\ApplicationForm;
use App\Models\ApplicationType;
use App\Models\ApplicationTypeSub;

class TourismAwards extends BaseController
{
    private $ApplicationForm;
    private $ApplicationType;
    private $ApplicationTypeSub;
    
    public function __construct()
    {
        helper(['semail', 'verify', 'log']);
        
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

        if (!empty(session()->award_type) && session()->award_type != "" && !isAdmin()) {
            $where['application_type_id'] = session()->award_type;
            $where_type['id'] = session()->award_type;
            $sub_id = session()->award_type;
        }

        $data['result'] = $this->db->table('application_form AP')->select('AP.*, US.stage, US.status AS users_stage_status, US.duedate, ES.score_prescreen_tt, ES.score_onsite_tt')->join('users_stage US', 'US.user_id = AP.created_by AND US.status >= 6', 'left')->join('estimate_score ES', 'ES.application_id = AP.id', 'left')->where('US.stage', 2)->like($like, 'match', 'both')->where($where)->orderBy('AP.created_at', $sort)->get()->getResultObject();

        // pp_sql();
        // px($data['result']);
        $data['assessment_group'] = $this->db->table('assessment_group')->get()->getResultObject();
        $data['application_type'] = $this->ApplicationType->where($where_type)->findAll();
        $data['application_type_sub'] = $this->ApplicationTypeSub->where('application_type_id', $sub_id)->findAll();

        // Template
        $data['title']  = "รางวัลกินรีครั้งที่ 14";
        $data['view']   = 'administrator/tourismawards/index';
        $data['ci']     = $this;

        return view('administrator/template', $data);
    }
}
