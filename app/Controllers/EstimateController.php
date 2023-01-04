<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ApplicationForm;
use App\Models\Estimate;
use App\Models\UsersStage;
use App\Models\EstimateIndividual;
use App\Models\EstimateScore;
use App\Models\Committees;
use Exception;

class EstimateController extends BaseController
{  
    private $estimate;
    private $estInd;
    private $estScr;
    private $stage;
    private $appForm;    
    private $commit;
    private $lowcarbon;
    private $myId;

    public function __construct()
    {
        $this->estimate = new Estimate();
        $this->estInd = new EstimateIndividual();
        $this->estScr = new EstimateScore();
        $this->stage = new UsersStage();
        $this->appForm = new ApplicationForm();
        $this->commit = new Committees();  
        $this->myId = session()->get('id');

        if(!isset($this->db))
            $this->db = \Config\Database::connect();
    }

    public function setEstimateRequest()
    {

        try {
            $judgeRequest = new \App\Controllers\EstimateRequestController();
            $currentDate = date('Y-m-d H:i:s');
            $duedate = date('Y-m-d H:i:s',strtotime($currentDate.' + 3 day'));
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
                    'request_date' => $currentDate
                ])       
                ->update();
            
            $judgeRequest->insert_judge_request([
                'app_id' => $appid,
                'judge_id' => $this->myId,
                'user_id' => $form->created_by,
                'status' => 1,
                'date' => date('Y-m-d H:i:s'),
                'duedate' => $duedate,
                'update' => date('Y-m-d H:i:s'),
            ]);

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
                    'estimate_by' => $this->myId
                ])
                ->set(['score_pre' => NULL])
                ->update();                    

            save_log_activety([
                'module' => 'estimate_pre_screen',
                'action' => 'estimate_pre_screen_send_request',
                'bank' => 'frontend',
                'user_id' => $this->myId,
                'datetime' => date('Y-m-d H:i:s'),
                'data' => $this->input->getVar()
            ]);

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
            save_log_error([
                'module' => 'estimate_send_request',
                'input_data' => $this->input->getVar(),
                'error_date' => date('Y-m-d H:i:s'),
                'error_msg' => [
                    'error_file' => $e->getFile(),
                    'error_line' => $e->getLine(),
                    'error_code' => $e->getCode(),
                    'error_msg' => $e->getMessage()
                ]
            ]);

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
                        'estimate_by' => $this->myId,
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
                    $data['estimate_by'] = $this->myId;  
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
                            'estimate_by' => $this->myId,
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
            save_log_error([
                'module' => 'estimate_draft',
                'input_data' => $this->input->getVar(),
                'error_date' => date('Y-m-d H:i:s'),
                'error_msg' => [
                    'error_file' => $e->getFile(),
                    'error_line' => $e->getLine(),
                    'error_code' => $e->getCode(),
                    'error_msg' => $e->getMessage()
                ]
            ]);

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
            
            $input = $this->input->getJsonVar('data',false);    
            $this->lowcarbon = $input->stage == 1 ? $input->lowcarbon : false; 
            $module = 'estimate_'.($input->stage == 1 ? 'pre_screen' : 'onsite');
            
            save_log_activety([
                'module' => $module,
                'action' => $module.'_send_sys',
                'bank' => 'frontend',
                'user_id' => $this->myId,
                'datetime' => date('Y-m-d H:i:s'),
                'data' => $input
            ]);
            
            $reEstimate = $this->reupdateEstimate($input->sourcs);

            if(!$reEstimate['result']){
                $reEstimate['result'] = 'error';
                return $this->response->setJSON($reEstimate);
            }   

            $individuel = (object) $reEstimate['individuel'];
            unset($input->sourcs);
            unset($reEstimate['individuel']);

            $eRequest = new \App\Controllers\EstimateRequestController();
            $eRequest->complete_request($input->appId,$this->myId);
            
            $resultIndividuel = $this->setIndividuel($input,$individuel);

            if(!$resultIndividuel->result){
                $resultIndividuel->result = 'error';
                return $this->response->setJSON($resultIndividuel);
            } 

            if($input->stage == 1 && $this->lowcarbon){
                $individuelLowcarbon = $reEstimate['lowcarbon'];
                unset($reEstimate['lowcarbon']);
                $this->setIndividuelLowcarbon($input,$individuelLowcarbon);
            }           

            if($this->checkFinishEsitmate($input->appId,$input->stage)){
                $resultEstimate = $this->setFinishEstimate($input->appId,$input->stage);
                if($input->stage == 1 && $this->lowcarbon){
                    $this->setFinishLowcarbon($input->appId,$input->stage);
                }
            }

            $this->sendEstimateResult((object)[
                'app_id' => $input->appId,
                'stage' => $input->stage,
                'pass' => $resultEstimate,
            ]);

            $result = ['result' => 'success'];
        } catch(Exception $e) {
            save_log_error([
                'module' => 'estimate_send_sys',
                'input_data' => $this->input->getVar(),
                'error_date' => date('Y-m-d H:i:s'),
                'error_msg' => [
                    'error_file' => $e->getFile(),
                    'error_line' => $e->getLine(),
                    'error_code' => $e->getCode(),
                    'error_msg' => $e->getMessage()
                ]
            ]);

            $result = [
                'result' => 'error',
                'message' => $e->getMessage()
            ];
        }

        return $this->response->setJSON($result);
    }

    private function reupdateEstimate($estimate)
    {
        try {
            $tescore = $sbscoe = $rsscore = $lcscore = 0;
            $ttescore = $tsbscoe = $trsscore = $tlcscore = 0;
            $stescore = $ssbscore = $srsscore = $slcscore = $sscore = 0;
            $te = $sb = $rs = 0;

            foreach($estimate as $list){
                if($list->stage == 1){
                    $score = $list->pre_origin;
                    $tscore = $list->pre_score;
                } else {
                    $score = $list->onsite_origin;
                    $tscore = $list->onside_score;
                }

                if($list->assign == 4 && $this->lowcarbon){
                    $escore = $score;
                    $cscore = $score;
                } else {
                    $escore = $score * $list->weight;
                    $cscore = $score / $tscore;
                }

                if($list->assign == 1){
                    $te = $list->assign_total;
                    $ttescore += $tscore;
                    $tescore += $escore;
                }
                elseif($list->assign == 2){
                    $sb = $list->assign_total;
                    $tsbscoe += $tscore;
                    $sbscoe += $escore;
                }
                elseif($list->assign == 3){
                    $rs = $list->assign_total;
                    $trsscore += $tscore;
                    $rsscore += $escore;                
                } 
                elseif($list->assign == 4){
                    if($this->lowcarbon){
                        $tlcscore += $tscore;
                        $lcscore += $escore; 
                    }
                }

                $update = [];

                if($list->stage == 1){
                    $update['score_pre_origin'] = $score;
                    $update['score_pre'] = $escore;
                    $update['tscore_pre'] = $cscore;
                    $update['status_pre'] = 3;
                    $update['request_status'] = 3;
                } else {                
                    $update['score_onsite_origin'] = $score;
                    $update['score_onsite'] = $escore;
                    $update['tscore_onsite'] = $cscore;
                    $update['status_onsite'] = 3;
                }

                $this->estimate->where('id',$list->est_id)
                ->set($update)
                ->update();
            }

            if($tescore > 0){
                $stescore = ($tescore * $te) / $ttescore;
            }

            if($sbscoe > 0){
                $ssbscore = ($sbscoe * $sb) / $tsbscoe;            
            }

            if($rsscore > 0){
                $srsscore = ($rsscore * $rs) / $trsscore;            
            }

            if($lcscore > 0){
                $slcscore = $lcscore;            
            }

            $sscore = $stescore + $ssbscore + $srsscore;

            $result = [
                'result' => true,
                'individuel' => [
                    'score_te' => $stescore,
                    'score_sb' => $ssbscore,
                    'score_rs' => $srsscore,
                    'score_tt' => $sscore
                ]
            ];

            if($list->stage == 1 && $this->lowcarbon){
                $result['lowcarbon'] = $slcscore;
            }

            return $result;
        } catch(Exception $e) {
            save_log_error([
                'module' => 'estimate_recal',
                'input_data' => $estimate,
                'error_date' => date('Y-m-d H:i:s'),
                'error_msg' => [
                    'error_file' => $e->getFile(),
                    'error_line' => $e->getLine(),
                    'error_code' => $e->getCode(),
                    'error_msg' => $e->getMessage()
                ]
            ]);

            return [
                'result' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    private function setIndividuel($estimate,$score)
    {
        try {
            $current_datetime = date('Y-m-d H:i:s');

            if($estimate->stage == 1){
                $inst_estind['score_pte'] = $score->score_te;
                $inst_estind['score_psb'] = $score->score_sb;
                $inst_estind['score_prs'] = $score->score_rs;
                $inst_estind['score_pre'] = $score->score_tt;
                $inst_estind['pre_send_date'] = $current_datetime;
            }
            else {
                $inst_estind['score_ote'] = $score->score_te;
                $inst_estind['score_osb'] = $score->score_sb;
                $inst_estind['score_ors'] = $score->score_rs;
                $inst_estind['score_onsite'] = $score->score_tt;
                $inst_estind['onsite_send_date'] = $current_datetime;
            }

            $existEstInd = $this->estInd->where([
                'application_id' => $estimate->appId,
                'estimate_by' => $this->myId
            ])
            ->countAllResults();

            if($existEstInd < 1){
                $inst_estind['application_id'] = $estimate->appId;
                $inst_estind['estimate_by'] = $this->myId;
                $result = $this->estInd->insert($inst_estind);
            } else {
                $result = $this->estInd->where([
                    'application_id' => $estimate->appId,
                    'estimate_by' => $this->myId
                ])
                ->set($inst_estind)
                ->update();
            }

            return (object) ['result' => $result];
        } catch(Exception $e) {
            save_log_error([
                'module' => 'estimate_set_individue',
                'input_data' => $this->input->getVar(),
                'error_date' => date('Y-m-d H:i:s'),
                'error_msg' => [
                    'error_file' => $e->getFile(),
                    'error_line' => $e->getLine(),
                    'error_code' => $e->getCode(),
                    'error_msg' => $e->getMessage()
                ]
            ]);

            return (object) [
                'result' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    private function setIndividuelLowcarbon($estimate,$score)
    {
        $eIndividuel = new \App\Models\LowcarbonIndividual();
        $current_datetime = date('Y-m-d H:i:s');
        
        if($estimate->stage == 1){
            $inst_estind['score_pre'] = $score;
            $inst_estind['pre_send_date'] = $current_datetime;
        } else {
            $inst_estind['score_onsite'] = $score;
            $inst_estind['onsite_send_date'] = $current_datetime;

        }

        $existEstInd = $eIndividuel->where([
            'application_id' => $estimate->appId,
            'estimate_by' => $this->myId
        ])
        ->countAllResults();

        if($existEstInd < 1){
            $inst_estind['application_id'] = $estimate->appId;
            $inst_estind['estimate_by'] = $this->myId;
            $result = $eIndividuel->insert($inst_estind);
        } else {
            $result = $eIndividuel->where([
                'application_id' => $estimate->appId,
                'estimate_by' => $this->myId
            ])
            ->set($inst_estind)
            ->update();
        }

        return (object) ['result' => $result];
    }

    private function setFinishEstimate($id,$stage)
    {
        $app = new \Config\App();
        $users = new \App\Models\Users();          
        $answer = new \App\Models\Answer();
        $cJudge = $this->countJudgeEstimate($id,$stage,'main');
        $current_datetime = date('Y-m-d H:i:s');

        if($stage == 1){
            $select_sum = 'SUM(score_pte) score_te, SUM(score_psb) score_sb,
                SUM(score_prs) score_rs, SUM(score_pre) score_tt';
        } else {
            $select_sum = 'SUM(score_ote) score_te, SUM(score_osb) score_sb,
                SUM(score_ors) score_rs, SUM(score_onsite) score_tt';
        }

        $sumScr = $this->estInd->where('application_id',$id)
            ->select($select_sum)
            ->first();

        $avg_te = $sumScr->score_te / $cJudge->tourism;
        $avg_sb = $sumScr->score_sb / $cJudge->support;
        $avg_rs = $sumScr->score_rs / $cJudge->respons;
        $avg_tt = $avg_te + $avg_sb + $avg_rs;

        if($stage == 1) {
            $inst_avg['score_prescreen_te'] = $avg_te;
            $inst_avg['score_prescreen_sb'] = $avg_sb;
            $inst_avg['score_prescreen_rs'] = $avg_rs;
            $inst_avg['score_prescreen_tt'] = $avg_tt;
            $inst_avg['pre_send_date'] = $current_datetime;
        }
        else {
            $inst_avg['score_onsite_te'] = $avg_te;
            $inst_avg['score_onsite_sb'] = $avg_sb;
            $inst_avg['score_onsite_rs'] = $avg_rs;
            $inst_avg['score_onsite_tt'] = $avg_tt;
            $inst_avg['onsite_send_date'] = $current_datetime;
        }

        $existEstScr = $this->estScr->where('application_id',$id)
            ->countAllResults();

        if($existEstScr < 1){
            $inst_avg['application_id'] = $id;
            $this->estScr->insert($inst_avg);
        } else {
            $this->estScr->where('application_id',$id)
                ->set($inst_avg)
                ->update();
        }

        $criteria = $stage == 1 ? $app->JudgingCriteriaPre : $app->JudgingCriteriaOnst;
        $pass = $avg_tt >= $criteria ? true : false;

        $form = $this->appForm->where('id',$id)
                ->select(
                    'created_by app_of,
                    IFNULL(attraction_name_th,attraction_name_en) place_name'
                ,false)
                ->first();

        $this->stage->where([
                'user_id' => $form->app_of, 
                'stage' => $stage
            ])
            ->set(['status' => $pass ? 6 : 7])
            ->update();
        
        $answer->where('reply_by',$form->app_of)
            ->set(['status' => $pass ? 4 : 0])
            ->update();
            
        $users->where('id',$form->app_of)
            ->set(['stage' => 3])
            ->update();

        if($pass && $stage == 1){
            $existStage = $this->stage->where([
                'user_id' => $form->app_of,
                'stage' => 2,
            ])
            ->countAllResults();
            
            if($existStage <= 0){
                $this->stage->insert([
                    'user_id' => $form->app_of,
                    'stage' => 2,
                    'status' => 1
                ]);
            }
        }

        return $pass;
    }

    private function setFinishLowcarbon($id,$stage)
    {
        $eIndividuel = new \App\Models\LowcarbonIndividual();
        $eScore = new \App\Models\LowcarbonScore();
        $cJudge = $this->countJudgeEstimate($id,$stage,'lowcarbon');
        $current_datetime = date('Y-m-d H:i:s');

        $sumScr = $eIndividuel->where('application_id',$id)
        ->select($stage == 1 ? 'SUM(score_pre) score_tt' : 'SUM(score_onsite) score_tt')
        ->first();

        $avg_tt = $sumScr->score_tt / $cJudge->lowcarbon;

        if($stage == 1) {
            $inst_avg['score_prescreen_tt'] = $avg_tt;
            $inst_avg['pre_send_date'] = $current_datetime;
        }
        else {
            $inst_avg['score_onsite_tt'] = $avg_tt;
            $inst_avg['onsite_send_date'] = $current_datetime;
        }

        $existEstScr = $eScore->where('application_id',$id)
            ->countAllResults();

        if($existEstScr < 1){
            $inst_avg['application_id'] = $id;
            $eScore->insert($inst_avg);
        } else {
            $eScore->where('application_id',$id)
                ->set($inst_avg)
                ->update();
        }
    }

    private function countJudgeEstimate($id,$stage,$by)
    {       
        if($by == 'main'){
            $select = 'admin_id_tourism tourism,
                admin_id_supporting support,
                admin_id_responsibility respons';
        } else {
            $select = 'admin_id_lowcarbon lowcarbon';
        }
        
        $cJudge = $this->commit->where([
            'application_form_id' => $id,
            'assessment_round' => $stage
        ])
        ->select($select)
        ->first(); 
            
        if($by == 'main'){
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

            return (object) [
                'tourism' => $ctourism,
                'support' => $csupport,
                'respons' => $crespons
            ];
        } else {
            $clowcarbon = 1;

            if(!empty($cJudge->lowcarbon)){
                $lowcarbon = json_decode($cJudge->lowcarbon,true);
                $clowcarbon = !empty($lowcarbon) ? count($lowcarbon) : 1;
            }

            return (object) [
                'lowcarbon' => $clowcarbon
            ];
        }
    }

    private function checkFinishEsitmate($id,$stage)
    {
        $where_est ='application_id = '.$id;

        if($stage == 1){
            $where_est .= ' AND score_pre IS NOT NULL';
        }
        else {
            $where_est .= ' AND score_onsite IS NOT NULL';
        }     

        $count_adm = $this->commit->where('application_form_id',$id)
            ->select('admin_count')->first();
            
        $count_est = $this->estInd->where($where_est, NULL, FALSE)
            ->countAllResults();

        if($count_est >= $count_adm->admin_count)
            return true;
        else  return false;
        
    }

    private function sendEstimateResult($data)
    {                

        $form = $this->appForm->where('id',$data->app_id)
        ->select(
            'created_by app_of,
            IFNULL(attraction_name_th,attraction_name_en) place_name'
            ,false
        )
        ->first();

        if($data->stage == 1){
            if($data->pass){
                $message_a = $form->place_name.' ได้ทำการส่งแบบประเมินเข้าสู่ระบบ กรุณามอบหมายกรรมการเพื่อประเมินรอบขั้นต้น (Pre-Screen)';                       
            } else {
                $message_a = $form->place_name.' ได้ทำการส่งแบบประเมินขั้นต้น (Pre-screen) เข้าสู่ระบบ';
            }
        } else {
            $message_a = $form->place_name.' ได้ทำการส่งแบบประเมินรอบลงพื้นที่เข้าสู่ระบบ';
        }

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
            'id' => $form->app_of,
            'appId' => $data->app_id,
            'stage' => $data->stage
        ],'estimate-complete');
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
                            $est_by = $app['est_by'];

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

                                $os_stescore = $os_ssbscore = $os_srsscore = $os_sscore = 0;
                                $os_stescore = ($val->ass1_score_onsite * $assg_1->score_onsite) / $val->ass1_max_score_onsite;
                                $os_ssbscore = ($val->ass2_score_onsite * $assg_2->score_onsite) / $val->ass2_score_onsite;
                                $os_srsscore = ($val->ass3_score_onsite * $assg_3->score_onsite) / $val->ass3_max_score_onsite;
                                $os_sscore = $os_stescore + $os_ssbscore + $os_srsscore;

                                $this->estInd->where([
                                    'application_id' => $aid,
                                    'estimate_by' => $est_by
                                ])
                                ->set([
                                    'score_pte' => $p_stescore,
                                    'score_psb' => $p_ssbscore,
                                    'score_prs' => $p_srsscore,
                                    'score_pre' => $p_sscore,
                                    'score_ote' => $os_stescore,
                                    'score_osb' => $os_ssbscore,
                                    'score_ors' => $os_srsscore,
                                    'score_onsite' => $os_sscore
                                ])
                                ->update();
                                
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