<?php 

namespace App\Controllers;
use CodeIgniter\Files\File;
use CodeIgniter\Files\FileCollection;
use App\Controllers\BaseController;
use App\Models\AssessmentGroup;
use App\Models\Question;
use App\Models\Answer;
use App\Models\UsersStage;
use App\Models\ApplicationForm;

class AnswerController extends BaseController
{
    private $qt;
    private $assg;
    private $ans;
    private $usStg;
    private $appForm;
    private $myId;

    public function __construct()
    {
        $this->qt = new Question();
        $this->assg = new AssessmentGroup();
        $this->ans = new Answer();
        $this->usStg = new UsersStage();
        $this->appForm = new ApplicationForm();
        $this->myId = session()->get('id');

        if(!isset($this->db))
            $this->db = \Config\Database::connect();
    }

    public function preScreenIndex()
    {
        $app = new \Config\App();    
        $current_date = date('Y-m-d');
        $current_datetime = date('Y-m-d H:i:s');
        
        if(date('Y-m-d',strtotime($current_date)) < date('Y-m-d',strtotime($app->Pre_open))){
            $data = [
                'title' => 'Pre-screen',
                'view' => 'frontend/expire/user-pre-screen-comming-soon',
                'open_date' => FormatTree($app->Pre_open,'thailand')
            ];
            
            return view('frontend/entrepreneur/_template',$data);
        }

        $myApp = $this->appForm->where('created_by',$this->myId)
            ->select(
                'id app_id,application_type_id type_id,
                application_type_sub_id sub_id,
                status')
            ->first();
            
        if(!empty($myApp)){
            if($myApp->status != 3){
                return redirect()->to(base_url('awards/application'));
            }
        } else {
            return redirect()->to(base_url('awards/application'));
        }

        $duedate = (object) [
            'expired_date' => $app->Pre_expired,
            'expired_str' => FormatTree($app->Pre_expired,'thailand'),
            'expired_sts' => $current_date > $app->Pre_expired ? 'true' : 'false',
        ];

        $stage = $this->usStg->where(['user_id' => $this->myId, 'stage' => 1])
            ->select('status,duedate')
            ->first();
        
        $instApp = new \App\Controllers\ApplicationController();
        $requireLowCarbon = $instApp->checkRequireLowCarbon($myApp->app_id);

        $subQAns = $this->db->table('answer')
            ->select('question_id')
            ->where('reply_by',$this->myId)
            ->getCompiledSelect();

        $queryQuestion = $this->db->table('question')
        ->where([
            'application_type_id' => $myApp->type_id,
            'application_type_sub_id' => $myApp->sub_id
        ])
        ->where('id NOT IN ('.$subQAns.')')
        ->select('id')
        ->get();
        
        $myQuestion = $queryQuestion->getResult();
        
        if(!empty($myQuestion)){
            foreach($myQuestion as $mq){
                $this->ans->insert([
                    'question_id' => $mq->id,
                    'reply_by' => $this->myId,
                    'status' => 1,
                    'created_at' => $current_datetime,
                    'updated_at' => $current_datetime
                ]);
            }
        }

        if($requireLowCarbon){
            $myLowcarbon =  $this->qt->where([
                'assessment_group_id ' => 4
            ])
            ->where('id NOT IN ('.$subQAns.')')
            ->select('id')
            ->find();
        
            if(!empty($myLowcarbon)){
                foreach($myLowcarbon as $mq){
                    $this->ans->insert([
                        'question_id' => $mq->id,
                        'reply_by' => $this->myId,
                        'status' => 1,
                        'created_at' => $current_datetime,
                        'updated_at' => $current_datetime
                    ]);
                }
            }
        }

        if(!empty($stage->duedate)) 
            $stage->duedate_str = FormatTree($stage->duedate,'thailand');

        if(!empty($stage)){
            if(in_array($stage->status,[3,5])){
                $duedate->expired_date = $stage->duedate;
                $duedate->expired_str = FormatTree($stage->duedate,'thailand');
                $duedate->expired_sts = $current_datetime > $stage->duedate ? 'true' : 'false';
            }

            if($stage->status == 3){
                if($duedate->expired_sts == 'true'){            
                    $this->usStg->where([
                        'user_id' => $this->myId, 
                        'stage' => 1
                    ])
                    ->set(['status' => 5])
                    ->update();
                }
            }
        } else {
            $stage = (object)[
                'status' => 'null',
                'duedate' => 'null'
            ];
        }

        $data = [
            'title' => 'Pre-screen',
            'view' => 'frontend/entrepreneur/pre-screen',
            'duedate' => $duedate,
            'stage' => $stage
        ];
        
        return view('frontend/entrepreneur/_template',$data);
    }

    public function getQuestionByAjax()
    {
        $result = $this->getQuestion($this->myId);
        return $this->response->setJSON($result);
    }

    public function getQuestion($id)
    {
        $instApp = new \App\Controllers\ApplicationController();
        $instEstimate = new \App\Models\Estimate();
        $app = $instApp->getRequireQuestion($id);
        $requireLowCarbon = $instApp->checkRequireLowCarbon($app->app_id);

        $group = $this->assg->whereIn(
            'id', $requireLowCarbon ? [1,2,3,4] : [1,2,3]
        )
        ->findAll();

        $result = [
            'status' => $this->getPrescreenStatus($this->myId),
            'app_id' => $app->app_id,
            'lowcarbon' => $requireLowCarbon,
            'data' => []
        ];

        $subquery = $this->db->table('answer')
        ->where('reply_by',$this->myId)
        ->getCompiledSelect();
        
        foreach($group as $key=>$asse){
            $counter = 0;
            $temp = ['group' => $asse, 'question' => []];
            
            $where = [];
            $where['q.assessment_group_id'] = $asse->id;

            if($asse->id != 4){
                $where['q.application_type_id'] = $app->type_id;

                if($app->type_id != 4){
                    $where['q.application_type_sub_id'] = $app->sub_type_id;
                }
            }

            $builder = $this->db->table('question q')
                ->select('
                    q.id, q.question, q.remark,
                    a.id reply_id, a.reply, a.pack_file,
                    a.status reply_sts
                ')
                ->join('('.$subquery.') a','q.id = a.question_id','LEFT')
                ->where($where)
                ->orderBy('q.topic_no ASC, q.question_ordering, q.id ASC') 
                ->get();
                
            foreach($builder->getResult() as $val){  
                $val->no = ++$counter;
                $val->images = $val->paper = []; 
                $val->request = [];

                if($val->reply_sts == 3){
                    $val->request = $instEstimate->where('answer_id',$val->reply_id)
                    ->whereIn('request_status',[1])    
                    ->select('request_list')
                        ->findAll();
                }

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

        return $result;
    }

    public function getPrescreenStatus($id)
    {
        $draft = $this->ans->select('status')
            ->where('reply_by',$id)
            ->where('status',1)
            ->countAllResults();

        $finish = $this->ans->select('status')
            ->where('reply_by',$id)
            ->whereIn('status',[2,4])
            ->countAllResults();

        $reject = $this->ans->select('status')
            ->where('reply_by',$id)
            ->where('status',3)
            ->countAllResults();

        $result = $this->usStg->select('stauts')
            ->where('user_id',$id)
            ->where('stage',1)
            ->whereIn('status',[6,7])
            ->countAllResults();
        
        if($draft > 0) return 'draft';
        elseif($reject > 0) return 'reject';
        elseif($result > 0) return 'result';
        elseif($finish > 0) return 'finish';
        else return 'draft';
    }

    public function getAnswerByAjax($qid)
    {
        $result = $this->getAnswer($this->input->getVar('question_id'));
        return $this->response->setJSON($result);
    }

    public function getAnswer($qid)
    {
        $result = ['reply' => [], 'images' => [], 'paper' => []];
        $answer = $this->ans->where('questing_id',$qid)->first();        

        if($answer){
            $files = json_decode($answer->pack_file,false);
            unset($answer->pack_file);
            $result['reply'] = $answer;
            if(!empty($files)){
                foreach($files as $file){
                    if($file->file_position == 'paper')
                        array_push($result['paper'],$file);
                    else array_push($result['images'],$file);
                }
            }
        }

        return $result;
    }

    public function saveReply()
    {
        try{
            switch($this->input->getVar('action')){
                case 'create': 
                    $dtdb = [
                        'question_id' => $this->input->getVar('qid'),
                        'reply' => $this->input->getVar('reply'),
                        'reply_by' => $this->myId,
                        'status' => 1,
                    ]; 

                    $ins = $this->ans->insert($dtdb);
                    $insId = $this->ans->getInsertID();
                    break;
                case 'update':                    
                    $this->ans->where('id',$this->input->getVar('aid'))
                        ->set([ 'reply' => $this->input->getVar('reply') ])
                        ->update();                 
                    $insId = $this->input->getVar('aid');            

                    save_log_activety([
                        'module' => 'user_pre_screen',
                        'action' => 'pre_screen_draft',
                        'bank' => 'frontend',
                        'user_id' => $this->myId,
                        'datetime' => date('Y-m-d H:i:s'),
                        'data' => $this->input->getVar()
                    ]);
                    break;
                case 'finish':
                    $insId = null;
                    $answers = json_decode(json_encode($this->input->getVar('answer')),false);

                    foreach($answers as $ans){
                        if($ans->action == 'create'){
                            $this->ans->insert([
                                'question_id' => $ans->qid,
                                'reply' => $ans->reply,
                                'reply_by' => $this->myId,
                                'status' => 2,
                            ]);
                        } else {
                            $this->ans->where('id',$ans->aid)
                                ->set([ 'reply' => $ans->reply, 'status' => 2 ])
                                ->update();
                        }
                    }

                    $this->ans->where('reply_by', $this->myId)
                        ->set([ 
                            'status' => 2 ,
                            'send_date' => date('Y-m-d H:i:s')
                        ])
                        ->update();

                    $cusstg = $this->usStg->where([
                        'user_id' => $this->myId, 
                        'stage' => 1
                    ])
                    ->select('status')
                    ->first();

                    $isEstimateRequire = false;
                    
                    if(!empty($cusstg)){
                        if($cusstg->status == 3){
                            $this->usStg->where([
                                'user_id' => $this->myId, 
                                'stage' => 1
                            ])
                            ->set(['status' => 4])
                            ->update();

                            $estimate = new \App\Models\Estimate();
                            $estimate->where('application_id',$this->input->getVar('appId'))
                                ->where('request_status',1)
                                ->set('request_status',2)
                                ->update();

                            $judgeRequest = new \App\Controllers\EstimateRequestController();
                            $judgeRequest->respond_request($this->myId);
                            $isEstimateRequire = true;
                        }
                    } else {
                        $this->usStg->insert([
                            'user_id' => $this->myId, 
                            'stage' => 1, 
                            'status' => 1
                        ]);
                    }                    

                    save_log_activety([
                        'module' => 'user_pre_screen',
                        'action' => 'pre_screen_send_sys',
                        'bank' => 'frontend',
                        'user_id' => $this->myId,
                        'datetime' => date('Y-m-d H:i:s'),
                        'data' => $this->input->getVar()
                    ]);
                    save_log_activety([
                        'module' => 'step_flow_checking',
                        'action' => 'application-'.$this->input->getVar('appId'),
                        'bank' => 'frontend',
                        'user_id' => $this->myId,
                        'datetime' => date('Y-m-d H:i:s'),
                        'data' => 'ผู้ประกอบการกดส่งแบบประเมิน'
                    ]);

                    $form = $this->appForm->where('id',$this->input->getVar('appId'))
                        ->select('IFNULL(attraction_name_th,attraction_name_en) place_name',false)
                        ->first();

                    set_multi_noti(
                        get_receive_admin(),
                        (object) [
                            'bank' => 'backend'
                        ],
                        (object) [
                            'message'=> $form->place_name.' ได้ทำการส่งแบบประเมินเข้าสู่ระบบ กรุณามอบหมายกรรมการเพื่อประเมินรอบขั้นต้น (Pre-Screen)',
                            'link' => '',
                            'send_date' => date('Y-m-d H:i:s'),
                            'send_by' => $form->place_name
                        ]);

                    helper('semail');

                    if($isEstimateRequire){
                        send_email_frontend((object)[
                            'appId' => $this->input->getVar('appId'),
                            'tycon' => $form->place_name
                        ],'answer-request-complete');
                    } else {
                        send_email_frontend((object)[
                            'email' => session()->get('account'),
                            'tycon' => session()->get('user')
                        ],'answer-complete');
                    }
                break;
            }
            
            $result = ['result' => 'success', 'id' => $insId, 'message' => 'บันทึกคำตอบแล้ว'];
        } catch(\Exception $e){
            save_log_error([
                'module' => 'user_reply_question',
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
                'message' => ''
                // 'line' => $e->getLine(),
                // 'message' => 'System : '.$e->getMessage()
            ];
        }

        return $this->response->setJSON($result);
    }

    public function uploadFiles()
    {
        try{
            $files_log = [];

            if($files = $this->input->getFiles()){
                $question_id = $this->input->getVar('qid');
                $answer_id = $this->input->getVar('aid');
                $position = $this->input->getVar('position');
                $path = $this->setFilePath($this->myId).'pre-screen/'.$this->input->getVar('path');
                $result = ['result' => 'success', 'message' => 'อัพโหลดไฟล์สำเร็จแล้ว', 'files' => []];
                $files_up = [];

                foreach($files['files'] as $file){
                    if ($file->isValid() && !$file->hasMoved()) {
                        
                        $originalName = $file->getName();
                        $extension = $file->guessExtension();
                        $newName = randomFileName($extension);
                        
                        $file->move(FCPATH.$path, $newName);

                        $tmp_file = array(
                            'file_name' => $newName,
                            'file_original' => $originalName,
                            'file_position' => $position,
                            'file_path' => $path.'/'.$newName,
                            'file_size' => $file->getSizeByUnit('mb'),
                        );
                        
                        array_push($files_up,$tmp_file);                            
                        array_push($files_log,$tmp_file);                            

                    }
                } 

                if($this->input->getVar('action') == 'create'){
                    $dtdb = [
                        'question_id' => $question_id,
                        'reply_by' => $this->myId,
                        'pack_file' => json_encode($files_up),
                        'status' => 1,
                    ]; 

                    $this->ans->insert($dtdb);
                    $insId = $this->ans->getInsertID();
                    $result['id'] = $insId;

                } else {
                    $pack_file = $this->ans->where('id',$answer_id)
                        ->select('pack_file')
                        ->first();
                    
                    if(!empty($pack_file->pack_file)){
                        $pack_file = json_decode($pack_file->pack_file);
                        $files_up = array_merge($pack_file,$files_up);
                    }

                    $this->ans->update($answer_id,['pack_file' => json_encode($files_up)]);
                }

                $files_up = json_decode(json_encode($files_up),false);
                
                foreach($files_up as $file){
                    if($file->file_position == $position)
                        array_push($result['files'],$file);
                }
                
            } else {
                $result = ['result' => 'error', 'message' => 'ไม่พบไฟล์ในการอัพโหลด'];
            }                           

            save_log_activety([
                'module' => 'user_pre_screen',
                'action' => 'pre_screen_upload_file',
                'bank' => 'frontend',
                'user_id' => $this->myId,
                'datetime' => date('Y-m-d H:i:s'),
                'data' => [
                    'input' => $this->input->getVar(),
                    'files' => $files_log
                ]
            ]);
        } catch(\Exception $e){
            save_log_error([
                'module' => 'user_pre_screen_upload_files',
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
                'message' => ''
                // 'message' => 'System : '.$e->getMessage()
            ];
        }

        return $this->response->setJSON($result);
    }

    

    public function removeFiles()
    {

        try{                    

            save_log_activety([
                'module' => 'user_pre_screen',
                'action' => 'pre_screen_remove_file',
                'bank' => 'frontend',
                'user_id' => $this->myId,
                'datetime' => date('Y-m-d H:i:s'),
                'data' => $this->input->getVar()
            ]);

            $answer_id = $this->input->getVar('id');
            $position = $this->input->getVar('position');
            $tmp = [];
            $pack_file = $this->ans->where('id',$answer_id)
                ->select('pack_file')
                ->first();

            $pack_file = json_decode($pack_file->pack_file,false);

            if($this->input->getVar('remove') == 'fixed'){
                if(unlink(FCPATH.$this->input->getVar('file_path'))){
                    $file_name = $this->input->getVar('file_name');
                    $result = ['result' => 'success', 'message' => '', 'files' => []];

                    foreach($pack_file as $file){
                        if($file->file_name != $file_name){
                            array_push($tmp,$file);

                            if($file->file_position == $position){
                                array_push($result['files'],$file);
                            }
                        }
                    }

                    $this->ans->update($answer_id,['pack_file' => json_encode($tmp)]);
                } else {
                    $result = ['result' => 'error', 'message' => 'ไม่พบไฟล์นี้ในระบบ'];
                }
            } else {
                $position = $this->input->getVar('position');

                foreach($pack_file as $file){
                    if($file->file_position == $position){
                        unlink(FCPATH.$file->file_path);
                    } else {
                        array_push($tmp,$file);
                    }
                }

                $this->ans->update($answer_id,['pack_file' => json_encode($tmp)]);
                $result = ['result' => 'success', 'message' => ''];
            }
        } catch(\Exception $e){
            save_log_error([
                'module' => 'user_pre_screen_remove_files',
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
                'message' => ''
                // 'message' => 'System : '.$e->getLine().'-'.$e->getMessage()
            ];
        }

        return $this->response->setJSON($result);
    }

    private function setFilePath($id)
    {
        $form = new \App\Models\ApplicationForm();        
        $at = $form->where('created_by',$id)->select('created_at')->first();
        $year = date('Y',strtotime($at->created_at));
        $month = date('m',strtotime($at->created_at));
        $day = date('d',strtotime($at->created_at));
        $path = 'uploads/'.$year.'/'.$month.'/'.$day.'/'.$this->myId.'/';
        return $path;
    }
}

?>