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

            set_noti(
                (object) [
                    'user_id' => $form->created_by,
                    'bank' => 'frontend'
                ],
                (object) [
                    'message' => 'มีการร้องขอข้อมูลข้อมูลเพิ่มเติมใน แบบประเมินขั้นต้น (Pre-screen) '
                    .'โปรดดูรายละเอียด เพื่อแก้ไขและส่งใบสมัครอีกครั้ง',
                    'link' => base_url('awards/pre-screen'),
                    'send_date' => date('Y-m-d H:i:s'),
                    'send_by' => 'คณะกรรมการ'
                ]
            );
                
            $result = ['result' => 'success'];
        } catch(\Exception $e){
            $result = [
                'result' => 'error',
                'messsage' => $e->getMessage()
            ];
        }

        return $this->response->setJSON($result);
    }

    public function draftEstimate()
    {
        try {
            $input = (object) $this->input->getVar();
            $data = [];

            $target = $input->target == 'pre-screen' ? 'pre' : 'onsite';

            if(!empty($input->answer_id)){
                $data['answer_id'] = $input->answer_id;
            }

            if(!empty($input->score)){
                $data['score_'.$target] = $input->score;
            } else {
                $data['score_'.$target] = NULL;
            }

            if(!empty($input->tscore)){
                $data['tscore_'.$target] = $input->tscore;
            } else {
                $data['tscore_'.$target] = NULL;
            }

            if(!empty($input->comment)){
                $data['comment_'.$target] = $input->comment;
            } else {
                $data['comment_'.$target] = NULL;
            }

            if(!empty($input->note)){
                $data['note_'.$target] = $input->note;
            } else {
                $data['note_'.$target] = NULL;
            }

            if($input->target == 'pre-screen'){
                if(!empty($input->request_list)){
                    $data['request_list'] = $input->request_list;
                    $data['request_date'] = $input->request_date;
                    $data['request_status'] = $input->request_status;
                } else {
                    $data['request_list'] = NULL;
                    $data['request_date'] = NULL;
                    $data['request_status'] = NULL;
                }
            }
            
            $data['application_id'] = $input->application_id;
            $data['question_id'] = $input->question_id;
           
            switch($input->action){
                case 'create':

                    $data['estimate_by'] = session()->get('id');  
                    $data['status_pre'] = 1;
                    $data['status_onsite'] = 1;                          

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
            $commit = new \App\Models\Committees();
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

            if($input->stage == 1){
                $inst_estind['score_pte'] = $input->score_te;
                $inst_estind['score_psb'] = $input->score_sb;
                $inst_estind['score_prs'] = $input->score_rs;
                $inst_estind['score_pre'] = $input->score_tt;
            }
            else {
                $inst_estind['score_ote'] = $input->score_te;
                $inst_estind['score_osb'] = $input->score_sb;
                $inst_estind['score_ors'] = $input->score_rs;
                $inst_estind['score_onsite'] = $input->score_tt;
            }

            $this->estInd->insert($inst_estind);


            $count_adm = $commit->where('application_form_id',$input->appId)
                ->select('admin_count')->first();

            $count_est = $this->estInd->where('application_id',$input->score_tt)
                ->countAll();

            if($count_adm->admin_count >= $count_est){
            
                $avg_te = $input->score_te / $count_est;
                $avg_sb = $input->score_sb / $count_est;
                $avg_rs = $input->score_rs / $count_est;
                $avg_tt = $avg_te + $avg_sb + $avg_rs;

                $inst_avg['application_id'] = $input->appId;

                if($input->stage == 1) {
                    $inst_avg['score_prescreen_te'] = $avg_te;
                    $inst_avg['score_prescreen_sb'] = $avg_sb;
                    $inst_avg['score_prescreen_rs'] = $avg_rs;
                    $inst_avg['score_prescreen_tt'] = $avg_tt;
                }
                else {
                    $inst_avg['score_onsite_te'] = $avg_te;
                    $inst_avg['score_onsite_sb'] = $avg_sb;
                    $inst_avg['score_onsite_rs'] = $avg_rs;
                    $inst_avg['score_onsite_tt'] = $avg_tt;
                }

                $this->estScr->insert($inst_avg);

                $pass = $input->score_tt > $sys->JudgingCriteriaPre ? true : false;

                $this->stage->where(['user_id' => $form->created_by, 'stage' => $input->stage])
                    ->set(['status' => $pass ? 6 : 7])
                    ->update();
                
                $answer->where('reply_by',$form->created_by)
                    ->set(['status' => $pass ? 4 : 0])
                    ->update();
                
                $users = new \App\Models\Users();
                $users->where('id',$form->created_by)
                    ->set(['stage' => 3])
                    ->update();

                if($pass){
                    $this->stage->insert([
                        'user_id' => $form->created_by,
                        'stage' => 2,
                        'status' => 1
                    ]);
                } 
                
                if($input->stage == 1){
                    if($pass){
                        $message = 'แจ้งผลการประเมินขั้นต้น (Pre-screen) ของท่านเรียบร้อยแล้ว';
                    } else {
                        $message = 'ข้อมูลแบบประเมินขั้นต้น (Pre-screen) ของท่านไม่ผ่านเกณฑ์';
                    }
                } else {
                    $message = 'แจ้งผลการประเมินรอบลงพื้นที่ของท่านเรียบร้อยแล้ว';
                }

                set_noti(
                    (object) [
                        'user_id' => $form->created_by,
                        'bank' => 'frontend'
                    ],
                    (object) [
                        'message' => $message,
                        'link' => base_url('awards/result'),
                        'send_date' => date('Y-m-d H:i:s'),
                        'send_by' => 'คณะกรรมการ'
                    ]
                );

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