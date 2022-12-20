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

            $form = $this->appForm->where('id',$appid)
                ->select('created_by, IFNULL(attraction_name_th,attraction_name_en) place_name',false)
                ->first();

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

            if($input->score != '' && is_numeric($input->score)){
                $data['score_'.$target] = $input->score;
            } else {
                $data['score_'.$target] = NULL;
            }

            if($input->tscore != '' && is_numeric($input->tscore)){
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

            if($input->score_origin != '' && is_numeric($input->score_origin)){
                $data['score_'.$target.'_origin'] = $input->score_origin;
            } else {
                $data['score_'.$target.'_origin'] = NULL;
            }

            if(empty($input->est_id)){
                $cestimate = $this->estimate->where([
                        'estimate_by' => session()->get('id'),
                        'application_id' => $input->application_id,
                        'question_id' => $input->question_id
                    ])
                    ->select('id')
                    ->first();

                if(!empty($cestimate)){
                    $input->est_id = $cestimate->id;
                    $action = 'update';
                } else {
                    $action = 'create';
                }

            } else {
                $action = 'update';
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
           
            switch($action){
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
                ->select('created_by,IFNULL(attraction_name_th,attraction_name_en) place_name',false)
                ->first();

            $answer->where('reply_by',$form->created_by)
                ->set(['status'  => 4])
                ->update();

            $estsf = $input->stage == 1 ? 'status_pre' : 'status_onsite';

            $this->estimate->where('application_id',$input->appId)
                ->set([$estsf => 3, 'request_status' => 3])
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
                $inst_estind['pre_send_date'] = date('Y-m-d H:i:s');
            }
            else {
                $inst_estind['score_ote'] = $input->score_te;
                $inst_estind['score_osb'] = $input->score_sb;
                $inst_estind['score_ors'] = $input->score_rs;
                $inst_estind['score_onsite'] = $input->score_tt;
                $inst_estind['onsite_send_date'] = date('Y-m-d H:i:s');
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
                $where_est .= ' AND score_pre IS NOT NULL';
            else $where_est .= ' AND score_onsite IS NOT NULL';
            
            $count_est = $this->estInd->where($where_est, NULL, FALSE)
                ->countAllResults();
                
            if($count_est >= $count_adm->admin_count){

                if($input->stage == 1){
                    $select_sum = 'SUM(score_pte) score_te, SUM(score_psb) score_sb,
                        SUM(score_prs) score_rs, SUM(score_pre) score_tt';
                } else {
                    $select_sum = 'SUM(score_ote) score_te, SUM(score_osb) score_sb,
                        SUM(score_ors) score_rs, SUM(score_onsite) score_tt';
                }

                $sumScr = $this->estInd->where('application_id',$input->appId)
                    ->select($select_sum)
                    ->first();
                
                $cJudge = $commit->where([
                        'application_form_id' => $input->appId,
                        'assessment_round' => $input->stage == 1 ? 1 : 2
                    ])
                    ->select(
                        'admin_id_tourism tourism,
                        admin_id_supporting support,
                        admin_id_responsibility respons'
                    )->first(); 
                    
                $ctourism = $csupport = $crespons = 1;
                
                if(!empty($cJudge->tourism)){
                    $tourism = json_decode($cJudge->tourism,true);
                    $ctourism = !empty($tourism) ? count($tourism) : 1;
                }

                if(!empty($cJudge->support)){
                    $support = json_decode($cJudge->support,true);
                    $csupport = !empty($support) ? count($support) : 1;
                }

                if(!empty($cJudge->respons)){
                    $respons = json_decode($cJudge->respons,true);
                    $crespons = !empty($respons) ? count($respons) : 1;
                }

                $avg_te = $sumScr->score_te / $ctourism;
                $avg_sb = $sumScr->score_sb / $csupport;
                $avg_rs = $sumScr->score_rs / $crespons;
                $avg_tt = number_format(($avg_te + $avg_sb + $avg_rs),2);
                
                $inst_avg = [];
                $inst_avg['application_id'] = $input->appId;

                if($input->stage == 1) {
                    $inst_avg['score_prescreen_te'] = $avg_te;
                    $inst_avg['score_prescreen_sb'] = $avg_sb;
                    $inst_avg['score_prescreen_rs'] = $avg_rs;
                    $inst_avg['score_prescreen_tt'] = $avg_tt;
                    $inst_avg['pre_send_date'] = date('Y-m-d H:i:s');
                }
                else {
                    $inst_avg['score_onsite_te'] = $avg_te;
                    $inst_avg['score_onsite_sb'] = $avg_sb;
                    $inst_avg['score_onsite_rs'] = $avg_rs;
                    $inst_avg['score_onsite_tt'] = $avg_tt;
                    $inst_avg['onsite_send_date'] = date('Y-m-d H:i:s');
                }

                $existEstScr = $this->estScr->where('application_id',$input->appId)
                    ->countAllResults();

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
                    $existStage = $this->stage->where([
                        'user_id' => $form->created_by,
                        'stage' => 2,
                    ])
                    ->countAllResults();
                    
                    if($existStage <= 0){
                        $this->stage->insert([
                            'user_id' => $form->created_by,
                            'stage' => 2,
                            'status' => 1
                        ]);
                    }
                } 
                
                if($input->stage == 1){
                    if($pass){
                        $message_u = 'แจ้งผลการประเมินขั้นต้น (Pre-screen) ของท่านเรียบร้อยแล้ว';
                        $message_a = $form->place_name.' ได้ทำการส่งแบบประเมินเข้าสู่ระบบ กรุณามอบหมายกรรมการเพื่อประเมินรอบขั้นต้น (Pre-Screen)';                       
                    } else {
                        $message_u = 'ข้อมูลแบบประเมินขั้นต้น (Pre-screen) ของท่านไม่ผ่านเกณฑ์';
                        $message_a = $form->place_name.' ได้ทำการส่งแบบประเมินขั้นต้น (Pre-screen) เข้าสู่ระบบ';
                    }
                } else {
                    $message_u = 'แจ้งผลการประเมินรอบลงพื้นที่ของท่านเรียบร้อยแล้ว';
                    $message_a = $form->place_name.' ได้ทำการส่งแบบประเมินรอบลงพื้นที่เข้าสู่ระบบ';
                }

                set_noti(
                    (object) [
                        'user_id' => $form->created_by,
                        'bank' => 'frontend'
                    ],
                    (object) [
                        'message' => $message_u,
                        'link' => base_url('awards/result'),
                        'send_date' => date('Y-m-d H:i:s'),
                        'send_by' => 'คณะกรรมการ'
                    ]
                );

                set_multi_noti(
                    get_receive_admin(),
                    (object) [
                        'bank' => 'backend'
                    ],
                    (object) [
                        'message'=> $message_a,
                        'link' => '',
                        'send_date' => date('Y-m-d H:i:s'),
                        'send_by' => $form->place_name
                    ]);

                helper('semail');
                send_email_frontend((object)[
                    'id' => $form->created_by,
                    'appId' => $input->appId,
                    'stage' => $input->stage
                ],'estimate-complete');

                // send_email_frontend((object)[
                //     'id' => $form->created_by,
                //     'appId' => $input->appId,
                //     'stage' => $input->stage
                // ],'estimate-complete-sys');

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

    public function reCalEstimateByApp($appId)
    {
        $result = $this->reCalEstimate('app',$appId,'','');
        return $this->response->setJSON($result);
    }

    public function reCalEstimateByType($typeId,$subId)
    {
        $result = $this->reCalEstimate('type','',$typeId,$subId);
        return $this->response->setJSON($result);
    }

    private function reCalEstimate($by,$appId,$typeId,$subId)
    {
        try{
            if(
                ( $by == 'app' && $appId == '' )
                || ($by == 'type' && $typeId == '' && $subId)
            ){
                return [
                    'result' => 'error',
                    'message' => 'Parameter ไม่ครบตามข้อกำหนด'
                ];
            }

            $builder_1 = $this->db->table('estimate e')
                ->join('question q','e.question_id = q.id')
                ->select(
                    "e.id, e.application_id, e.question_id, 
                    IFNULL(e.score_pre_origin,'NULL') per_origin, 
                    IFNULL(e.score_onsite_origin,'NULL') onsite_origin,
                    e.status_pre, e.status_onsite,
                    q.weight, q.pre_score, q.onside_score,
                    e.estimate_by"
                );
            
            if($by == 'type'){
               $where = [
                    'q.application_type_id' => $typeId,
                    'q.application_type_sub_id' => $subId
                ];
            }
            elseif($by == 'app'){
                $where['e.application_id'] = $appId;
            }

            $builder_1 = $builder_1->where($where)
                ->orderBy('e.application_id','ASC')
                ->orderBy('e.estimate_by','ASC');

            $count = $builder_1->countAllResults();
            $builder_1 = $builder_1->get();
            $arrayAppId = [];
            $counter = 0;

            if($count > 0){
                $obj_es = new \App\Models\Estimate();

                foreach($builder_1->getResult() as $val){
                    
                    $set = [];

                    if(!empty($val->per_origin)){
                        $score_pre = $val->per_origin * $val->weight;
                        $tscore_pre = $score_pre / $val->pre_score;
                        $set['score_pre'] = $score_pre;
                        $set['tscore_pre'] = $tscore_pre;
                    }

                    if(!empty($val->onsite_origin)){
                        $score_onsite = $val->onsite_origin * $val->weight;
                        $tscore_onsite = $score_onsite / $val->onside_score;
                        $set['score_onsite'] = $score_onsite;
                        $set['tscore_onsite'] = $tscore_onsite;
                    }

                    if(!empty($set)){
                        $obj_es->where('id',$val->id)
                            ->set([
                                'score_pre' => $score_pre,
                                'tscore_pre' => $tscore_pre,
                                'score_onsite' => $score_onsite,
                                'tscore_onsite' => $tscore_onsite,
                            ])
                            ->update();
                        
                        if(
                            $arrayAppId[$counter-1]['id'] != $val->application_id
                            || ($arrayAppId[$counter-1]['id'] == $val->application_id
                                && $arrayAppId[$counter-1]['est_by'] != $val->estimate_by)
                        ){
                            $arrayAppId[$counter++] = [
                                'id' => $val->application_id, 
                                'est_by' => $val->estimate_by
                            ];
                        }
                    }
                };

                $arrayAppId = array_unique($arrayAppId);                
                    
                $obj_ass = new \App\Models\AssessmentGroup();
                $assg_1 = $obj_ass->where('id',1)
                    ->select('score_prescreen, score_onsite')
                    ->first();

                $assg_2 = $obj_ass->where('id',2)
                    ->select('score_prescreen, score_onsite')
                    ->first();

                $assg_3 = $obj_ass->where('id',3)
                    ->select('score_prescreen, score_onsite')
                    ->first();

                foreach($arrayAppId as $app){
                    $builder_2 = $this->db->table('estimate wie')
                        ->select('(COUNT(wie.id) >= COUNT(wiq.id)) ces',false)
                        ->join('question wiq','wie.application_id = wiq.id')
                        ->where([
                            'wie.application_id' => $app['id'],
                            'wie.estimate_by' => $app['est_by']
                        ])
                        ->get();

                    foreach($builder_2 as $check){
                        if($check->ces){
                            $aid = $app['id'];

                            $builder_3 = $this->db->query(
                                "SELECT a.application_id, a.estimate_by,
                                    IFNULL(b.score_pre,0) ass1_score_pre,
                                    IFNULL(b.max_score_pre,0) ass1_max_score_pre,
                                    IFNULL(b.score_onsite,0) ass1_score_onsite,
                                    IFNULL(b.max_score_onsite,0) ass1_max_score_onsite,
                                    IFNULL(c.score_pre,0) ass2_score_pre,
                                    IFNULL(c.max_score_pre,0) ass2_max_score_pre,
                                    IFNULL(c.score_onsite,0) ass2_score_onsite,
                                    IFNULL(c.max_score_onsite,0) ass2_max_score_onsite,
                                    IFNULL(d.score_pre,0) ass3_score_pre,
                                    IFNULL(d.max_score_pre,0) ass3_max_score_pre,
                                    IFNULL(d.score_onsite,0) ass3_score_onsite,
                                    IFNULL(d.max_score_onsite,0) ass3_max_score_onsite
                                FROM estimate a
                                LEFT JOIN (
                                    SELECT ea.application_id, ea.estimate_by,
                                        SUM(ea.score_pre) score_pre, 
                                        SUM(ea.score_onsite) score_onsite,
                                        SUM(qa.pre_score) max_score_pre,
                                        SUM(qa.onside_score) max_score_onsite
                                    FROM estimate ea 
                                    INNER JOIN question qa ON ea.question_id = qa.id
                                    WHERE ea.application_id = $aid
                                        AND qa.assessment_group_id = 1
                                ) b ON a.application_id = b.application_id AND a.estimate_by = b.estimate_by
                                LEFT JOIN (
                                    SELECT eb.application_id, eb.estimate_by,
                                        SUM(eb.score_pre) score_pre, 
                                        SUM(eb.score_onsite) score_onsite,
                                        SUM(qb.pre_score) max_score_pre,
                                        SUM(qb.onside_score) max_score_onsite
                                    FROM estimate eb 
                                    INNER JOIN question qb ON eb.question_id = qb.id
                                    WHERE eb.application_id = $aid
                                        AND qb.assessment_group_id = 2
                                ) c ON a.application_id = c.application_id AND a.estimate_by = c.estimate_by
                                LEFT JOIN (
                                    SELECT ec.application_id, ec.estimate_by,
                                        SUM(ec.score_pre) score_pre, 
                                        SUM(ec.score_onsite) score_onsite,
                                        SUM(qc.pre_score) max_score_pre,
                                        SUM(qc.onside_score) max_score_onsite
                                    FROM estimate ec 
                                    INNER JOIN question qc ON ec.question_id = qc.id
                                    WHERE ec.application_id = $aid
                                        AND qc.assessment_group_id = 3
                                ) d ON a.application_id = d.application_id AND a.estimate_by = d.estimate_by
                                WHERE a.application_id = $aid"
                            );

                            foreach($builder_3->getResult() as $val){
                                $p_stescore = $p_ssbscore = $p_srsscore = $p_sscore = 0;
                                $p_stescore = ($val->ass1_score_pre * $assg_1->score_prescreen) / $val->ass1_max_score_pre;
                                $p_ssbscore = ($val->ass2_score_pre * $assg_2->score_prescreen) / $val->ass2_max_score_pre;
                                $p_srsscore = ($val->ass3_score_pre * $assg_3->score_prescreen) / $val->ass3_max_score_pre;
                                $p_sscore = $p_stescore + $p_ssbscore + $p_srsscore;
                                
                            }
                        }
                    }
                }
            }
        } catch(Exception $e){
            return ['result' => 'error', 'message' => $e->getMessage()];
        }
    }
}