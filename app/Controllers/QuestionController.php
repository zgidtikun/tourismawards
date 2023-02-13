<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\AssessmentGroup;
use Exception;

class QuestionController extends BaseController
{   
    private $myId;

    public function __construct()
    {
        $this->myId = session()->get('id');

        if(!isset($this->db))
            $this->db = \Config\Database::connect();        
    }

    private function checkTargetEstimate($appId,$round)
    {                
        $obj = new \App\Models\Committees();

        $check_normal = $obj->where('application_form_id',$appId)
        ->where('assessment_round',$round)
        ->where(
            '( admin_id_tourism LIKE \'%"'.$this->myId.'"%\'
            OR admin_id_supporting LIKE \'%"'.$this->myId.'"%\'
            OR admin_id_responsibility LIKE \'%"'.$this->myId.'"%\')'
        )
        ->select('CASE WHEN COUNT(id) > 0 THEN TRUE ELSE FALSE END cid')
        ->first();
        
        $check_lowcarbon = $obj->where('application_form_id',$appId)
        ->where('assessment_round',$round)
        ->where('admin_id_lowcarbon LIKE \'%"'.$this->myId.'"%\'')
        ->select('CASE WHEN COUNT(id) > 0 THEN TRUE ELSE FALSE END cid')
        ->first();
            
        if($check_normal->cid && $check_lowcarbon->cid){
            return 3;
        } 
        elseif($check_lowcarbon->cid){
            return 2;
        }
        else {
            return 1;
        }
    }

    private function checkStatusRequest($appId,$judgeId)
    {
        $estimate = new \App\Models\Estimate();
        $request = $estimate->where([
            'application_id' => $appId,
            'estimate_by' => $judgeId
        ])
        ->select('request_status status, COUNT(request_status) count_status')
        ->groupBy('request_status')
        ->findAll();

        $status_null = $status_0 = $status_1 = $status_2 = $stauts_3 = $status_4 = 0;

        foreach($request as $val){
            if(is_numeric($val->status)){
                if($val->status == 0){
                    $status_0 = $val->count_status;
                }
                elseif($val->status == 1){
                    $status_1 = $val->count_status;
                }
                elseif($val->status == 2){
                    $status_2 = $val->count_status;
                }
                elseif($val->status == 3){
                    $stauts_3 = $val->count_status;

                }
                elseif($val->status == 4){
                    $status_4 = $val->count_status;

                }
            } else {
                $status_null = $val->count_status;
            }
        }

        if($status_1 > 0){
            return 3;
        }
        elseif($status_2 > 0){
            return 4;
        }
        elseif($status_4 > 0){
            return 5;
        }
        else {
            return '';
        }
    }

    public function getListEstimate($round,$status = 'wait')
    {
        try{
            $obj_ass = new \App\Models\AssessmentGroup();
            $assessment = $obj_ass->findAll();

            $subEstimateSelect = 'application_id app_id, MAX(updated_at) updated_at,
                MIN(request_status) request_status';
                
            if($round == 'pre-screen'){
                $subEstimateSelect .= ', MIN(status_pre) show_status';
            } else {
                $subEstimateSelect .= ', MIN(status_onsite) show_status';
            }

            $subEstimate = $this->db->table('estimate')
                ->select(
                    $subEstimateSelect
                )
                ->where([
                    'estimate_by' => $this->myId
                ])
                ->groupBy('application_id')
                ->getCompiledSelect();
            
            $subComm = $this->db->table('committees')
                ->select('application_form_id afid')
                ->where('assessment_round',($round == 'pre-screen' ? 1 : 2))
                ->where(
                    '( admin_id_tourism LIKE \'%"'.$this->myId.'"%\'
                    OR admin_id_supporting LIKE \'%"'.$this->myId.'"%\'
                    OR admin_id_responsibility LIKE \'%"'.$this->myId.'"%\'
                    OR admin_id_lowcarbon LIKE \'%"'.$this->myId.'"%\')')
                ->getCompiledSelect();

            $subEstInd = $this->db->table('estimate_individual')
                ->select(
                    'application_id, 
                    score_pte, score_psb, score_prs,
                    score_ote, score_osb, score_ors,
                    score_pre, score_onsite,
                    lowcarbon_status, lowcarbon_score'
                )
                ->where('estimate_by',$this->myId)
                ->getCompiledSelect();
                      
            $builder = $this->db->table('application_form af')
                ->select(
                    'af.id, af.attraction_name_th att_name, at.name type, 
                    ats.name section, us.stage, us.status, us.duedate,
                    us.id stage_id,
                    IFNULL(inse.updated_at,\'\') updated_at,
                    IFNULL(inse.request_status,\'\') request_status,
                    IFNULL(inse.show_status,\'\') show_status,
                    IFNULL(es.score_pte,\'\') score_pte,
                    IFNULL(es.score_psb,\'\') score_psb,
                    IFNULL(es.score_prs,\'\') score_prs,
                    IFNULL(es.score_pre,\'\') score_pre,
                    IFNULL(es.score_ote,\'\') score_ote,
                    IFNULL(es.score_osb,\'\') score_osb,
                    IFNULL(es.score_ors,\'\') score_ors,
                    IFNULL(es.score_onsite,\'\') score_onsite,
                    IFNULL(es.lowcarbon_status,2) lowcarbon_status,
                    IFNULL(es.lowcarbon_score,\'\') lowcarbon_score'                    
                )
                ->join('application_type at','af.application_type_id = at.id')
                ->join('application_type_sub ats','af.application_type_sub_id = ats.id','LEFT')
                ->join('users_stage us','af.created_by = us.user_id')
                ->join('('.$subComm.') insc','insc.afid = af.id')
                ->join('('.$subEstInd.') es','insc.afid = es.application_id','LEFT')
                ->join('('.$subEstimate.') inse','af.id = inse.app_id','LEFT');

            if($round == 'pre-screen'){
                $builder = $builder->where('us.stage',1);
            } else {
                $builder = $builder->where('us.stage',2);
            }

            if($status == 'wait'){
                $builder = $builder->whereIn('us.status',[1,2,3,4,5]);
            } else {
                $builder = $builder->whereIn('us.status',[1,2,4,5,6,7]);
            }
            
            $builder = $builder->get();
            $list = [];
            $UsersStage = new \App\Models\UsersStage();
            $estimate = new \App\Models\Estimate();
            $judgeRequest = new \App\Controllers\EstimateRequestController();
            $ObjEst = new \App\Controllers\FrontendController();
            $current_date = date('Y-m-d H:i:s');
            
            foreach($builder->getResult() as $val){
                $isFinish = $ObjEst->checkEstimateFinish(
                    $val->id,
                    $round == 'pre-screen' ? 1 : 2,
                    $this->myId
                );

                if($round == 'pre-screen'){
                    $targetEstimate = $this->checkTargetEstimate($val->id,($round == 'pre-screen' ? 1 : 2));
                    $val->targetEstimate = $targetEstimate;
                } else {
                    $val->targetEstimate = 1;
                }

                if(
                    ($status == 'wait' && $isFinish == 'unfinish')
                    || ($status == 'finish' && $isFinish == 'finish')
                ){
                    $val->no = 0;

                    if(!empty($val->updated_at))
                        $val->updated_at = date('d-m-Y',strtotime($val->updated_at));

                    array_push($list,$val);

                    if($isFinish == 'unfinish'){
                        $rq_status = $this->checkStatusRequest($val->id,$this->myId);
                        
                        if($val->status == 3 && $rq_status == 3){  
                            if($current_date > $val->duedate){
                                
                                $UsersStage->where('id',$val->stage_id)
                                    ->set(['status' => 5])
                                    ->update();

                                $judgeRequest->set_expire_request($val->id,$this->myId);
                                $val->status = 5;
                                $val->request_status = 4;
                            } else {
                                $exprireReq = $judgeRequest->get_expire_request($val->id,$this->myId);
                                if($exprireReq->expire_status){
                                    if($exprireReq->request_status == 1){
                                        $judgeRequest->set_expire_request($val->id,$this->myId);
                                        $val->status = 5;
                                        $val->request_status = 4;
                                    }
                                    else if($exprireReq->request_status == 4){
                                        $val->status = 5;
                                        $val->request_status = 4;
                                    }
                                }
                                else if(!empty($exprireReq->request_status)){
                                    if($exprireReq->request_status == 4){
                                        $val->status = 5;
                                        $val->request_status = 4;
                                    }                                    
                                }
                            }

                        } else {
                            if($rq_status != ''){
                                $val->status = $rq_status;
                                $val->request_status = $rq_status;
                            }
                        }
                    } else {
                        // if(!in_array($val->status,[6,7]))
                            $val->status = 6;
                    }

                    unset($val->duedate);
                    unset($val->stage_id);
                }
            }
            
            $result = [
                'result' => 'success', 
                'assessment' => $assessment,
                'data' => $list
            ];
        } catch(Exception $e){
            save_log_error([
                'module' => 'estimate_get_list',
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
                'message' => '',
                'data' => []
                // 'message' => $e->getMessage(),
            ];
        }

        return $result;
    }

    public function estimateQuestion($id)
    {        
        $result = [
            'result' => 'success', 
            'tycoon'=> null, 
            'data' => [], 
            'request' => false
        ];

        $tycoon = $this->db->table('application_form af')
            ->join('application_type at','af.application_type_id = at.id')
            ->join('application_type_sub ats','af.application_type_sub_id = ats.id','LEFT')
            ->where('af.id',$id)
            ->select(
                'af.code, at.name t_name, ats.name ts_name,
                af.application_type_id type_id, af.application_type_sub_id sub_type_id,
                af.knitter_name, af.attraction_name_th attn_th, af.attraction_name_en attn_en,
                af.knitter_email, af.knitter_tel, af.updated_at, af.created_by,
                af.send_date, af.require_lowcarbon'
            )
            ->get();

        foreach($tycoon->getResult() as $val){
            $result['tycoon']  = $val;
            $result['tycoon']->send_date = FormatTree($val->send_date,'thailand');
            $userId = $val->created_by;
            $type_id = $val->type_id;
            $sub_type_id = $val->sub_type_id;
            $lowcarbon = $val->require_lowcarbon;
            $result['lowcarbon'] = $lowcarbon == 1 ? true : false;
        }
            
        $assg = new AssessmentGroup();
        $group = $assg->whereIn(
            'id', $lowcarbon == 1 ? [1,2,3,4] : [1,2,3]
        )->findAll();

        foreach($group as $asse){
            $counter = 0;
            $temp = ['group' => $asse, 'question' => []];
            
            $where = [];
            $where['q.assessment_group_id'] = $asse->id;

            if($asse->id != 4){
                $where['q.application_type_id'] = $type_id;

                if($type_id != 4){
                    $where['q.application_type_sub_id'] = $sub_type_id;
                }
            }

            $sqans = $this->db->table('answer')->where('reply_by',$userId)
                ->getCompiledSelect();
            
            $sqset = $this->db->table('estimate')
                ->where('application_id',$id)
                ->where('estimate_by',$this->myId)
                ->select('
                    id, question_id, score_pre, score_onsite, comment_pre, 
                    comment_onsite, note_pre, note_onsite, status_pre, status_onsite, 
                    request_list, request_date, request_status, estimate_by, tscore_pre,
                    tscore_onsite, pack_file, score_pre_origin, score_onsite_origin'
                )
                ->getCompiledSelect();
                
            $builder = $this->db->table('question q')
                ->select('
                    q.id, q.question, q.remark, q.pre_status, onside_status,
                    q.pre_evaluation_criteria pre_eva, q.pre_scoring_criteria pre_scor,
                    q.pre_score, q.onside_evaluation_criteria os_eva,
                    q.onside_scoring_criteria os_scor, q.onside_score, q.weight,
                    q.topic_no, q.question_ordering, q.criteria_topic,
                    a.id reply_id, a.reply, a.pack_file,
                    b.id est_id, b.score_pre, b.score_onsite, b.comment_pre, 
                    b.comment_onsite, b.note_pre, b.note_onsite, b.status_pre, b.status_onsite, 
                    b.request_list, b.request_date, b.request_status, b.estimate_by, b.tscore_pre,
                    b.tscore_onsite, b.pack_file est_files, b.score_pre_origin, b.score_onsite_origin
                ')
                ->join('('.$sqans.') a','q.id = a.question_id','LEFT')
                ->join('('.$sqset.') b','q.id = b.question_id','LEFT')
                ->where($where)
                ->orderBy('q.topic_no ASC, q.question_ordering ASC, q.id ASC') 
                ->get();
        
            foreach($builder->getResult() as $val){   
                $val->no = ++$counter;
                $val->images = $val->paper = []; 
                $val->estFiles = (object) ['paper' => [], 'images' => [], 'camera' => []];
                $val->estimate = false;

                if($val->request_status == 1){
                    $result['request'] = true;
                }

                if(empty($val->reply_id)) $val->reply_id = '';
                if(empty($val->reply)) $val->reply = '';

                if(!empty($val->pack_file)){
                    $files = json_decode($val->pack_file,false);
                    foreach($files as $file){
                        if($file->file_position == 'paper')
                            array_push($val->paper,$file);
                        else array_push($val->images,$file);
                    }
                }

                if(!empty($val->est_files)){
                    $files = json_decode($val->est_files,false);
                    foreach($files as $file){
                        if($file->file_position == 'paper')
                            array_push($val->estFiles->paper,$file);
                        elseif($file->file_position == 'images')
                            array_push($val->estFiles->images,$file);
                        else array_push($val->estFiles->camera,$file);
                    }
                }
                
                unset($val->est_files);  
                unset($val->pack_file);                
                array_push($temp['question'],$val);
            }

            array_push($result['data'],$temp);

        }

        return $this->response->setJSON($result);
    }

    public function calQuestionScore()
    {
        $obj_q = new \App\Models\Question();
        $obj_qs = new \App\Models\QuestionScore();
        $result = [];

        $scores = $obj_q->select(
                'application_type_id type_id, application_type_sub_id sub_id,
                SUM(pre_score) ttps, SUM(onside_score) ttos'
            ,false)
            ->groupBy('type_id, sub_id')
            ->findAll();

        foreach($scores as $sc){
            $temp = (object) $sc;
            $temp->tt = $sc->ttps + $sc->ttos;
            $temp = [
                'type_id' => $sc->type_id,
                'type_sub_id' => $sc->sub_id,
                'ttsc_prescreen' => $sc->ttps,
                'ttsc_onsite' => $sc->ttos,
                'total_net' => $sc->ttps + $sc->ttos
            ];
            
            $obj_qs->insert($temp);;
        }
    }
}

?>