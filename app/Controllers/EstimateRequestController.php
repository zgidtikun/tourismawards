<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\EstimateRequest;
use Exception;

class EstimateRequestController extends BaseController
{
    private $obj;
    
    public function __construct()
    {
        $this->obj = new EstimateRequest();
    }

    public function exist_judge_request($app_id,$judge_id,$user_id)
    {
        $count = $this->obj->where([
            'application_id' => $app_id,
            'application_of' => $judge_id,
            'request_by' => $user_id
        ])
        ->countAllResults();
        return $count == 0 ? true : false;
    }

    public function insert_judge_request($data)
    {
        if($this->exist_judge_request($data['app_id'],$data['judge_id'],$data['user_id'])){
            $this->obj->insert([
                'application_id' => $data['app_id'],
                'application_of' => $data['user_id'],
                'request_by' => $data['judge_id'],
                'request_status' => $data['status'],
                'request_date' => $data['date'],
                'request_duedate' => $data['duedate'],
                'request_update' => $data['update']
            ]);
        } else {
            $this->obj->where([
                'application_id' => $data['app_id'],
                'application_of' => $data['judge_id'],
                'request_by' => $data['user_id']
            ])
            ->set([
                'request_status' => $data['status'],
                'request_date' => $data['date'],
                'request_duedate' => $data['duedate'],
                'request_update' => $data['update']
            ])
            ->update();
        }
    }

    public function get_expire_request($app_id,$judge_id)
    {
        $current_date = date('Y-m-d H:i:s');
        $request = $this->obj->where([
            'application_id' => $app_id,
            'request_by' => $judge_id,
        ])
        ->select('request_status, request_duedate')
        ->first();

        if(!empty($request->request_duedate)){
            $expire_sts = $request->request_duedate < $current_date ? true : false;
            return (object) [
                'request_status' => $request->request_status,
                'request_duedate' => $request->request_duedate,
                'current_date' => $current_date,
                'expire_status' => $expire_sts
            ];
        } else {
            return (object) [
                'expire_status' => false
            ];
        }
    }

    public function set_expire_request($app_id,$judge_id)
    {
        $this->obj->where([
            'application_id' => $app_id,
            'application_of' => $judge_id,
            'request_status' => 1
        ])
        ->set([
            'request_status' => 4,
            'request_update' => date('Y-m-d H:i:s')
        ])
        ->update();

        $estimateJudge = new \App\Models\Estimate();
        $estimateJudge->where([            
            'application_id' => $app_id,
            'estimate_by' => $judge_id,
            'request_status' => 1
        ])
        ->set(['request_status' => 0])
        ->update();
    }

    public function respond_request($user_id)
    {
        $this->obj->where('application_of',$user_id)
        ->whereIn('request_status',[1,4])
        ->set([
            'request_status' => 2,
            'request_update' => date('Y-m-d H:i:s')
        ])
        ->update();
    }

    public function complete_request($app_id,$judge_id)
    {
        $this->obj->where('application_id',$app_id)
        ->where('request_by',$judge_id)
        ->set([
            'request_status' => 3,
            'request_update' => date('Y-m-d H:i:s')
        ])
        ->update();
    }
}