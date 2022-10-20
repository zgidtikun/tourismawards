<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\ApplicationForm;
use App\Models\Estimate;
use App\Models\UsersStage;
use Exception;

class EstimateController extends BaseController
{  
    public function __construct()
    {
        $this->estimate = new Estimate();
        $this->stage = new UsersStage();
        $this->appForm = new ApplicationForm();

        if(!isset($this->db))
            $this->db = \Config\Database::connect();
    }

    public function setEstimateRequest()
    {

        try {
            $current = date('Y-m-d');
            $duedate = date('Y-m-d',strtotime($current.' + 5 day'));
            $appid = $this->input->getVar('application_id');
            $form = $this->appForm->where('id',$appid)->select('created_by')->first();

            $this->estimate->where([
                    'application_id' => $appid,
                    'request_status' => 0
                ])            
                ->update([ 
                    'request_status' => 1,
                    'request_date' => $current
                ]);

            $this->db->table('answer a')
                ->join('estimate e','a.id = e.answer_id')
                ->where([
                    'e.application_id' => $this->input->getVar('application_id'),
                    'e.request_status' => 1
                ])
                ->set(['a.status' => 3])
                ->update();
            
            $this->stage->where(['user_id' => $form->create_by, 'stage' => 1 ])
                ->set(['status' => 3, 'duedate' => $duedate])
                ->update();
            
            $result = ['result' => 'success'];
        } catch(Exception $e){
            $result = [
                'result' => 'error',
                'messsage' => $e->getMessage()
            ];
        }

        return $this->response->setJSON($result);
    }

    public function draftEstimateProscreen()
    {
        try {
            $input = (object) $this->input->getVar();
            $data = [];

            if(!empty($input->answer_id)){
                $data['answer_id'] = $input->answer_id;
            }

            if(!empty($input->score_pre)){
                $data['score_pre'] = $input->score_pre;
            } else {
                $data['score_pre'] = NULL;
            }

            if(!empty($input->tscore_per)){
                $data['tscore_per'] = $input->tscore_per;
            } else {
                $data['tscore_per'] = NULL;
            }

            if(!empty($input->comment_pre)){
                $data['comment_pre'] = $input->comment_pre;
            } else {
                $data['comment_pre'] = NULL;
            }

            if(!empty($input->note_pre)){
                $data['note_pre'] = $input->instd;
            } else {
                $data['note_pre'] = NULL;
            }

            if(!empty($input->request_list)){
                $data['request_list'] = $input->request_list;
                $data['request_date'] = $input->request_date;
                $data['request_status'] = $input->request_status;
            } else {
                $data['request_list'] = NULL;
                $data['request_date'] = NULL;
                $data['request_status'] = NULL;
            }
            
            $data['application_id'] = $input->application_id;
            $data['question_id'] = $input->question_id;

            switch($input->action){
                case 'create':

                    $data['estimate_by'] = session()->get('id');  
                    $data['status'] = 1;                   

                    $this->estimate->insert($data);
                    $instId = $this->estimate->getInsertID();

                    $result = [
                        'result' => 'success',
                        'id' => $instId
                    ];

                    break;
                case 'update':
                    $this->estimate->update($input->est_id,$data);
                    $result = ['result' => 'success'];
                    break;
            }

            $form = $this->appForm->where('id',$input->application_id)
                ->select('created_by')
                ->first();
            
            $this->stage->where(['user_id' => $form->create_by, 'stage' => 1 ])
                ->set(['status' => 2])
                ->update();
        } catch(Exception $e) {
            $result = [
                'result' => 'error',
                'message' => $e->getMessage()
            ];
        }

        return $this->response->setJSON($result);
    }
}