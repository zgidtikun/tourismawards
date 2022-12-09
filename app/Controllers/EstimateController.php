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

            $this->estInd->where([
                    'application_id' => $appid,
                    'estimate_by' => session()->get('id')
                ])
                ->set(['score_pre' => NULL])
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

            helper('semail');
            send_email_frontend((object)[
                'id' => $form->created_by,
            ],'estimate-request');
                
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
           
            switch($input->action){
                case 'create':                    
            
                    $data['application_id'] = $input->application_id;
                    $data['question_id'] = $input->question_id;
                    $data['estimate_by'] = session()->get('id');  
                    $data['estimate_name'] = session()->get('user');  
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
                    $this->estimate->where([
                            'id' => $input->est_id,
                            'estimate_by' => session()->get('id'),
                        ])
                        ->set($data)
                        ->update();
                    $result = ['result' => 'success'];
                    break;
            }

            $form = $this->appForm->where('id',$input->application_id)
                ->select('created_by')
                ->first();
            
            $this->stage->where([
                    'user_id' => $form->created_by, 
                    'stage' => $target == 'pre' ? 1 : 2 
                ])
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

            $existEstInd = $this->estInd->where([
                    'application_id' => $input->appId,
                    'estimate_by' => session()->get('id')
                ])
                ->countAllResults();

            if($existEstInd <= 0){
                $inst_estind = [
                    'application_id' => $input->appId,
                    'estimate_by' => session()->get('id')
                ];
            }

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

            if($existEstInd <= 0){
                $this->estInd->insert($inst_estind);
            } else {
                $this->estInd->where([
                    'application_id' => $input->appId,
                    'estimate_by' => session()->get('id')
                ])
                ->set($inst_estind)
                ->update();
            }

            $count_adm = $commit->where('application_form_id',$input->appId)
                ->select('admin_count')->first();

            $where_est ='application_id = '.$input->appId;
            if($input->stage == 1)
                $where_est = ' AND score_pre NOT NULL';
            else $where_est = ' AND score_onsite NOT NULL';

            $count_est = $this->estInd->where($where_est)
                ->countAllResults();

            if($count_est >= $count_adm->admin_count){

                $existEstScr = $this->estScr->where('application_id',$input->appId)
                    ->countAllResults();
            
                $avg_te = $input->score_te / $count_est;
                $avg_sb = $input->score_sb / $count_est;
                $avg_rs = $input->score_rs / $count_est;
                $avg_tt = ($input->score_te + $input->score_sb + $input->score_rs) / $count_est;

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

                if($existEstScr <= 0){
                    $this->estScr->insert($inst_avg);
                } else {
                    $this->estScr->where('application_id',$input->appId)
                        ->set($inst_avg)
                        ->update();
                }

                $pass = $input->score_tt > $sys->JudgingCriteriaPre ? true : false;

                $this->stage->where([
                        'user_id' => $form->created_by, 
                        'stage' => $input->stage
                    ])
                    ->set(['status' => $pass ? 6 : 7])
                    ->update();
                
                $answer->where('reply_by',$form->created_by)
                    ->set(['status' => $pass ? 4 : 0])
                    ->update();
                
                $users = new \App\Models\Users();
                $users->where('id',$form->created_by)
                    ->set(['stage' => 3])
                    ->update();

                if($pass && $input->stage == 1){
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

                helper('semail');
                send_email_frontend((object)[
                    'id' => $form->created_by,
                    'appId' => $input->appId,
                    'stage' => $input->stage
                ],'estimate-complete');

                send_email_frontend((object)[
                    'id' => $form->created_by,
                    'appId' => $input->appId,
                    'stage' => $input->stage
                ],'estimate-complete-sys');

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

    public function setAwardResut()
    {
        $app = new \Config\App();
        $award = new \App\Models\AwardResult();
        $ass = new \App\Models\AssessmentGroup();

        $subQuery = $this->db->table('users_stage us')
            ->select(
                'af.id, af.created_by,          
                af.application_type_id type_id, af.application_type_sub_id sub_id'
            )
            ->join('application_form af','us.user_id = af.created_by')
            ->where([
                'us.stage' => 2,
                'us.status' => 6
            ])
            ->getCompiledSelect();

        $score = $this->db->table('estimate_score es')
                ->join('('.$subQuery.') ap', 'es.application_id = ap.id')
                ->select(
                    'es.application_id app_id, ap.created_by,
                    ap.type_id, ap.sub_id,
                    (es.score_prescreen_tt + es.score_onsite_tt) score_tt'                    
                )
                ->get();
                    
        $builder = $ass->select('(SUM(score_prescreen) + SUM(score_onsite)) total_score');
        $builder = $builder->whereIn('id',[1,2,3])->first();
        $total_net = $builder->total_score;
        
        foreach($score->getResult() as $v){
            $persent = $v->score_tt * 100 / $total_net;
            $judge = $app->JudgingCriteriaScore;

            if( $persent >= $judge->ttg->low )
                $award_s = 1;
            elseif( $persent >= $judge->tta->low && $persent <= $judge->tta->max )
                $award_s = 2;
            elseif( $persent >= $judge->ttc->low && $persent <= $judge->ttc->max )
                $award_s = 3;
            else $award_s = 0;
            

            $temp = [
                'application_id' => $v->app_id,
                'user_id' => $v->created_by,
                'app_type_id' => $v->type_id,
                'app_type_sub_id' => $v->sub_id,
                'award_persent' => $persent,
                'award_type' => $award_s,
                'award_status' => 0,
            ];
            
            $award->insert($temp);
        }
    }

    public function getAwardResut()
    {
        $gold = [];
        $silver = [];
        $input =  (object) $this->input->getVar();
        $where_type = [1,2];

        foreach($where_type as $type){
            $builder = $this->db->table('award_result ar')
                ->join('application_form af','ar.application_id = af.id')
                ->select(
                    "IFNULL(af.attraction_name_th, af.attraction_name_en) place_name,
                    af.address_province province, af.address_no, af.address_road, 
                    af.address_sub_district, af.address_district, af.address_province, 
                    af.address_zipcode, mobile, af.other_social web, af.facebook fb,
                    af.google_map gps"
                ,false)
                ->where([
                    'app_type_id' => $input->type,
                    'app_type_sub_id' => $input->sub,
                    'award_type' => $type,
                ])
                ->get();

            foreach($builder->getResult() as $v){
                if($type == 1) array_push($gold,$v);
                else array_push($silver,$v);
            }
        }

        $result = ['gold' => $gold, 'silver' => $silver];
        return $this->response->setJSON($result);
    }
}