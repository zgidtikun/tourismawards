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

        if(!isset($this->db))
            $this->db = \Config\Database::connect();     
    }

    public function exist_judge_request($app_id,$judge_id,$user_id)
    {
        $count = $this->obj->where([
            'application_id' => $app_id,
            'application_of' => $user_id,
            'request_by' => $judge_id
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
            $action = '_create';
        } else {
            $this->obj->where([
                'application_id' => $data['app_id'],
                'application_of' => $data['user_id'],
                'request_by' => $data['judge_id']
            ])
            ->set([
                'request_status' => $data['status'],
                'request_date' => $data['date'],
                'request_duedate' => $data['duedate'],
                'request_update' => $data['update']
            ])
            ->update();
            $action = '_update';
        }                   

        save_log_activety([
            'module' => 'estimate_pre_screen',
            'action' => "estimate_send_request$action",
            'bank' => 'frontend',
            'user_id' => $data['user_id'],
            'datetime' => date('Y-m-d H:i:s'),
            'data' => $data
        ]);
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

    public function user_expire_request($app_id,$user_id,$place_name)
    {
        $judges = $this->obj->where([
            'application_id' => $app_id,
            'application_of' => $user_id,
            'request_status' => 1
        ])
        ->select('request_by id')
        ->findAll();

        $this->obj->where([
            'application_id' => $app_id,
            'request_status' => 1
        ])
        ->set([
            'request_status' => 4,
            'request_update' => date('Y-m-d H:i:s')
        ])
        ->update();

        $this->db->table('estimate')
        ->where([
            'application_id' => $app_id,
            'request_status' => 1
        ])
        ->set('request_status',4)
        ->update();

        $this->db->table('users_stage')
        ->where([
            'user_id' => $user_id, 
            'stage' => 1
        ])
        ->set(['status' => 5])
        ->update();

        $_noti = "$place_name ได้หมดเวลาการส่งคำตอบการประเมินเบื้องต้น (Pre-Screen) เพิ่มเติม "
            . " โปรดทำการประเมินเบื้องต้น (Pre-Screen) อีกครั้ง";

        helper('semail');

        foreach($judges as $judge){
            
            set_noti((object)[
                'user_id' => $judge->id,
                'bank' => 'frontend'
            ],[
                'message' => $_noti,
                'link' => base_url('boards'),
                'send_date' => date('Y-m-d H:i:s'),
                'send_by' => 'System'
            ]); 

            send_email_frontend((object)[
                'appId' => $app_id,
                'judgeId' => $judge->id
            ],'answer-request-expired');
        }
    }

    public function set_expire_request($app_id,$judge_id)
    {
        $this->obj->where([
            'application_id' => $app_id,
            'request_by' => $judge_id,
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
        ->set(['request_status' => 4])
        ->update();

        try {
            $appForm = new \App\Models\ApplicationForm();
            $tycoon = $appForm->where('id',$app_id)
            ->select("attraction_name_th name_th, attraction_name_en name_en")
            ->first();

            $place = !empty($tycoon->name_th) ? $tycoon->name_th : $tycoon->name_en;

            $_noti = "$place ได้หมดเวลาการส่งคำตอบการประเมินเบื้องต้น (Pre-Screen) เพิ่มเติม "
                . " โปรดทำการประเมินเบื้องต้น (Pre-Screen) อีกครั้ง";
            
            set_noti((object)[
                'user_id' => $judge_id,
                'bank' => 'frontend'
            ],[
                'message' => $_noti,
                'link' => base_url('boards'),
                'send_date' => date('Y-m-d H:i:s'),
                'send_by' => 'System'
            ]); 

            helper('semail');
            send_email_frontend((object)[
                'appId' => $app_id,
                'judgeId' => $judge_id
            ],'answer-request-expired');
        } catch(Exception $e){
            return;
        }
    }

    public function respond_request($appId,$user_id,$place_n)
    {        
        helper('semail');
        send_email_frontend((object)[
            'appId' => $appId,
            'tycon' => $place_n
        ],'answer-request-complete');

        $judges = $this->obj->where('application_of',$user_id)
        ->where('request_status',1)
        ->select('application_id,request_by')
        ->findAll();

        $this->obj->where('application_of',$user_id)
        ->whereIn('request_status',[1,4])
        ->set([
            'request_status' => 2,
            'request_update' => date('Y-m-d H:i:s')
        ])
        ->update();

        if(!empty($judges)){
            foreach($judges as $judge){
                set_noti(
                    (object) [
                        'user_id' => $judge->request_by,
                        'bank' => 'frontend'
                    ],
                    [
                        'message' => "$place_n ได้ส่งคำตอบการประเมินเบื้องต้น (Pre-Screen) เพิ่มเติมกลับมาเรียบร้อยแล้ว 
                            กรุณาทำการประเมินเบื้องต้น (Pre-Screen) อีกครั้ง",
                        'link' => base_url('boards/estimate/pre-screen/'.$judge->application_id),
                        'send_date' => date('Y-m-d H:i:s'),
                        'send_by' => $place_n
                    ]
                );
            }
        }
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