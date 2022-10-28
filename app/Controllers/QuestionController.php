<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\UsersStage;
use App\Models\AssessmentGroup;
use App\Models\ApplicationForm;
use App\Models\Question;
use App\Models\Answer;
use Exception;

class QuestionController extends BaseController
{   
    public function __construct()
    {
        if(!isset($this->db))
            $this->db = \Config\Database::connect();        
    }

    public function getListEstimate($round,$status = 'wait')
    {
        try{
            $subquery = $this->db->table('estimate')
                ->select('application_id app_id, MAX(updated_at) updated_at',false)
                ->groupBy('application_id')
                ->getCompiledSelect();

            $builder = $this->db->table('application_form af')
                ->select(
                    'af.id, af.attraction_name_th att_name, at.name type, ats.name section,
                    us.stage, us.status, 
                    IFNULL(ina.updated_at,\'-\') updated_at,
                    IFNULL(es.score_prescreen,0) score_pre,
                    IFNULL(es.score_onsite,0) score_onsite'
                )
                ->join('application_type at','af.application_type_id = at.id')
                ->join('application_type_sub ats','af.application_type_sub_id = ats.id')
                ->join('users_stage us','af.created_by = us.user_id')
                ->join('estimate_score es','af.id = es.id','LEFT')
                ->join('('.$subquery.') ina','af.id = ina.app_id','LEFT');

            if($round == 'pre-screen'){
                $builder = $builder->where('us.stage',1);
            } else {
                $builder = $builder->where('us.stage',2);
            }

            if($status == 'wait'){
                $builder = $builder->whereIn('us.status',[1,2,3,4,5]);
            } else {
                $builder = $builder->whereIn('us.status',[6,7]);
            }

            $builder = $builder->get();
            $list = [];
            
            foreach($builder->getResult() as $val){
                $val->no = 0;

                if(!empty($val->updated_at))
                    $val->updated_at = date('d-m-Y',strtotime($val->updated_at));

                array_push($list,$val);
            }
            
            $result = ['result' => 'success', 'data' => $list];
        } catch(Exception $e){
            $result = [
                'result' => 'error',
                'message' => $e->getMessage(),
                'data' => []
            ];
        }

        return $result;
    }

    public function estimateQuestion($id)
    {        
        $result = ['result' => 'success', 'tycoon'=> null, 'data' => []];

        $tycoon = $this->db->table('application_form af')
            ->join('application_type at','af.application_type_id = at.id')
            ->join('application_type_sub ats','af.application_type_sub_id = ats.id')
            ->where('af.created_by',$id)
            ->select(
                'af.code, at.name t_name, ats.name ts_name,
                af.knitter_name, af.attraction_name_th attn_th, af.attraction_name_en attn_en,
                af.knitter_email, af.knitter_tel, af.updated_at'
            )
            ->get();

        foreach($tycoon->getResult() as $val)
            $result['tycoon']  = $val;
        
        $instApp = new \App\Controllers\ApplicationController();
        $app = $instApp->getRequireQuestion($id);
            
        $assg = new AssessmentGroup();
        $group = $assg->findAll();

        foreach($group as $asse){
            $counter = 0;
            $temp = ['group' => $asse, 'question' => []];

            $where = [
                'q.assessment_group_id' => $asse->id,
                'q.application_type_id' => $app->type_id,
                'q.application_type_sub_id' => $app->sub_type_id
            ];

            $sqans = $this->db->table('answer')->where('id',$id)
                ->getCompiledSelect();

            $sqset = $this->db->table('estimate')
                ->where('estimate_by',session()->get('id'))
                ->select('
                    id, question_id, score_pre, score_onsite, comment_pre, 
                    comment_onsite, note_pre, note_onsite, status, request_list, 
                    request_date, request_status, estimate_by, tscore_pre,
                    tscore_onsite'
                )
                ->getCompiledSelect();

            $builder = $this->db->table('question q')
                ->select('
                    q.id, q.question, q.remark, q.pre_status, onside_status,
                    q.pre_evaluation_criteria pre_eva, q.pre_scoring_criteria pre_scor,
                    q.pre_score, q.onside_evaluation_criteria os_eva,
                    q.onside_scoring_criteria os_scor, q.onside_score, q.weight,
                    a.id reply_id, a.reply, a.pack_file,
                    b.id est_id, b.score_pre, b.score_onsite, b.comment_pre, 
                    b.comment_onsite, b.note_pre, b.note_onsite, b.status, b.request_list, 
                    b.request_date, b.request_status, b.estimate_by, b.tscore_pre,
                    b.tscore_onsite
                ')
                ->join('('.$sqans.') a','q.id = a.question_id','LEFT')
                ->join('('.$sqset.') b','q.id = b.question_id','LEFT')
                ->where($where)
                ->orderBy('id','ASC')
                ->get();
        
            foreach($builder->getResult() as $val){   
                $val->no = ++$counter;
                $val->images = $val->paper = []; 
                $val->estimate = false;

                if(empty($val->reply_id)) $val->reply_id = '';
                if(empty($val->reply)) $val->reply = '';

                if(!empty($val->pack_file)){
                    $files = json_decode($val->pack_file);
                    foreach($files as $file){
                        if($file->file_position == 'paper')
                            array_push($val->paper,$file);
                        else array_push($val->images,$file);
                    }
                }
                
                unset($val->pack_file);                
                array_push($temp['question'],$val);
            }

            array_push($result['data'],$temp);

        }

        return $this->response->setJSON($result);
    }
}

?>