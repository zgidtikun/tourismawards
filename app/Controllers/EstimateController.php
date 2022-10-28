<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\ApplicationForm;
use App\Models\Estimate;
use App\Models\UsersStage;
use App\Models\EstimateIndividual;
use App\Models\EstimateScore;
use Exception;

class EstimateController extends BaseController
{  
    public function __construct()
    {
        $this->estimate = new Estimate();
        $this->estInd = new EstimateIndividual();
        $this->estScr = new EstimateScore();
        $this->stage = new UsersStage();
        $this->appForm = new ApplicationForm();

        if(!isset($this->db))
            $this->db = \Config\Database::connect();
    }

    public function setEstimateRequest()
    {

        try {
            $current = date('Y-m-d');
            $duedate = date('Y-m-d',strtotime($current.' + 3 day'));
            $appid = $this->input->getVar('application_id');
            $form = $this->appForm->where('id',$appid)->select('created_by')->first();

            $this->estimate->where([
                    'application_id' => $appid,
                    'request_status' => 0
                ])     
                ->set([ 
                    'request_status' => 1,
                    'request_date' => $current
                ])       
                ->update();

            $this->db->query(
                "UPDATE answer a INNER JOIN estimate e ON a.id = e.answer_id
                SET a.status = 3
                WHERE e.application_id = $appid
                    AND e.request_status = 1;"
            );
            
            $this->stage->where([
                    'user_id' => $form->created_by, 
                    'stage' => 1 
                ])
                ->set(['status' => 3, 'duedate' => $duedate])
                ->update();
                
            $result = ['result' => 'success'];
        } catch(\Exception $e){
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

            if(!empty($input->tscore_pre)){
                $data['tscore_pre'] = $input->tscore_pre;
            } else {
                $data['tscore_pre'] = NULL;
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
            
            $this->stage->where(['user_id' => $form->created_by, 'stage' => 1 ])
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

    public function setCompleteEstimate()
    {
        try {     
            $sys = new \Config\App();         
            $answer = new \App\Models\Answer();
            $input = (object) $this->input->getVar();

            $form = $this->appForm->where('id',$input->appId)
                ->select('created_by')
                ->first();

            $answer->where('reply_by',$form->created_by)
                ->set(['status'  => 4])
                ->update();

            $this->estimate->where('application_id',$input->appId)
                ->set(['status' => 3, 'request_status' => 3])
                ->update();

            $inst_estind = [
                'application_id' => $input->appId,
                'estimate_by' => session()->get('id')
            ];

            if($input->stage == 1)
                $inst_estind['score_pre'] = $input->score;
            else $inst_estind['score_onsite'] = $input->score;

            $this->estInd->insert($inst_estind);

            $count_est = $this->estInd->where('application_id',$input->appId)
                ->countAll();
                
            $avg = $input->score / $count_est;

            $inst_avg['application_id'] = $input->appId;

            if($input->stage == 1) 
                $inst_avg['score_prescreen'] = $avg;
            else $inst_avg['score_onsite'] = $avg;

            $this->estScr->insert($inst_avg);

            $pass = $input->score > $sys->JudgingCriteriaPre ? true : false;

            $this->stage->where(['user_id' => $form->created_by, 'stage' => $input->stage])
                ->set(['status' => $pass ? 6 : 7])
                ->update();

            if($pass){
                $this->stage->insert([
                    'user_id' => $form->created_by,
                    'stage' => 2,
                    'status' => 1
                ]);
            }

            $result = ['result' => 'success'];
        } catch(Exception $e) {
            $result = [
                'result' => 'error',
                'message' => $e->getMessage()
            ];
        }

        return $this->response->setJSON($result);
    }
}