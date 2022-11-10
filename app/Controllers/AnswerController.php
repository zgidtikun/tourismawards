<?php 

namespace App\Controllers;
use CodeIgniter\Files\File;
use CodeIgniter\Files\FileCollection;
use App\Controllers\BaseController;
use App\Models\AssessmentGroup;
use App\Models\Question;
use App\Models\Answer;
use App\Models\UsersStage;


class AnswerController extends BaseController
{
    public function __construct()
    {
        $this->qt = new Question();
        $this->assg = new AssessmentGroup();
        $this->ans = new Answer();
        $this->usStg = new UsersStage();

        if(!isset($this->db))
            $this->db = \Config\Database::connect();
    }

    public function preScreenIndex()
    {
        $app = new \Config\App();
        $duedate = (object) [
            'expired_date' => $app->Pre_expired,
            'expired_str' => FormatTree($app->Pre_expired,'thailand'),
            'expired_sts' => $app->Pre_expired <= date('Y-m-d') ? 'true' : 'false',
        ];

        $stage = $this->usStg->where(['user_id' => session()->get('id'), 'stage' => 1])
            ->select('status,duedate')
            ->first();

        if(!empty($stage->duedate)) 
            $stage->duedate_str = FormatTree($stage->duedate,'thailand');

        if(!empty($stage)){
            if($stage->status == 3){
                $duedate->expired_date = $stage->duedate;
                $duedate->expired_str = FormatTree($stage->duedate,'thailand');
                $duedate->expired_sts = $stage->duedate <= date('Y-m-d') ? 'true' : 'false';
            }

            if($duedate->expired_sts == 'true'){            
                $this->usStg->where([
                    'user_id' => session()->get('id'), 
                    'stage' => 1
                ])
                ->set(['status' => 5])
                ->update();
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
        $result = $this->getQuestion(session()->get('id'));
        return $this->response->setJSON($result);
    }

    public function getQuestion($id)
    {
        $instApp = new \App\Controllers\ApplicationController();
        $instEstimate = new \App\Models\Estimate();
        $app = $instApp->getRequireQuestion($id);
        $group = $this->assg->findAll();
        $result = [
            'status' => $this->getPrescreenStatus(session()->get('id')),
            'data' => []
        ];
        
        foreach($group as $asse){
            $counter = 0;
            $temp = ['group' => $asse, 'question' => []];

            $where = [
                'q.assessment_group_id' => $asse->id,
                'q.application_type_id' => $app->type_id,
                'q.application_type_sub_id' => $app->sub_type_id
            ];

            if(session()->get('role') == 1)
                $where['q.pre_status'] = 1;

            $subquery = $this->db->table('answer')->where('reply_by',session()->get('id'))
                ->getCompiledSelect();

            $builder = $this->db->table('question q')
                ->select('
                    q.id, q.question, q.remark,
                    a.id reply_id, a.reply, a.pack_file,
                    a.status reply_sts
                ')
                ->join('('.$subquery.') a','q.id = a.question_id','LEFT')
                ->where($where)
                ->orderBy('id','ASC')
                ->get();
           
            foreach($builder->getResult() as $val){   
                $val->no = ++$counter;
                $val->images = $val->paper = []; 
                $val->request = [];

                if($val->reply_sts == 3){
                    $val->request = $instEstimate->where('answer_id',$val->reply_id)
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
            ->where('status',2)
            ->countAllResults();

        $reject = $this->ans->select('status')
            ->where('reply_by',$id)
            ->where('status',3)
            ->countAllResults();

        $estimate = $this->ans->select('status')
            ->where('reply_by',$id)
            ->whereIn('status',[4,2])
            ->countAllResults();
        
        if($draft > 0) return 'draft';
        elseif($reject > 0) return 'reject';
        elseif($finish > 0) return 'finish';
        elseif($estimate > 0) return 'estimate'; 
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
                        'reply_by' => session()->get('id'),
                        'status' => 1,
                    ]; 

                    $ins = $this->ans->insert($dtdb);
                    $insId = $this->ans->getInsertID();
                    break;
                case 'update':
                    $upd = $this->ans->update(
                        $this->input->getVar('aid'),
                        [ 'reply' => $this->input->getVar('reply') ] 
                    );                    
                    $insId = $this->input->getVar('aid');
                    break;
                case 'finish':
                    $insId = null;
                    $answers = json_decode(json_encode($this->input->getVar('answer')),false);

                    foreach($answers as $ans){
                        if($ans->action == 'create'){
                            $this->ans->insert([
                                'question_id' => $ans->qid,
                                'reply' => $ans->reply,
                                'reply_by' => session()->get('id'),
                                'status' => 2,
                            ]);
                        } else {
                            $this->ans->update($ans->aid, [ 'reply' => $ans->reply, 'status' => 2 ]);
                        }
                    }

                    $cusstg = $this->usStg->where([
                        'user_id' => session()->get('id'), 
                        'stage' => 1
                    ])->first();
                    
                    if(!empty($cusstg)){
                        $this->usStg->where([
                            'user_id' => session()->get('id'), 
                            'stage' => 1
                        ])
                        ->set(['status' => 4])
                        ->update();
                    } else {
                        $this->usStg->insert([
                            'user_id' => session()->get('id'), 
                            'stage' => 1, 
                            'status' => 1
                        ]);
                    }

                    set_multi_noti(
                        get_receive_noti(session()->get('id')),
                        (object) [
                            'bank' => 'frontend'
                        ],
                        (object) [
                            'message'=> 'มีการส่งแบบประเมินขั้นตัน (Pre-screen) จากคุณ '.session()->get('user'),
                            'link' => base_url('boards/estimate/pre-screen/'.get_app_id(session()->get('id'))),
                            'send_date' => date('Y-m-d H:i:s'),
                            'send_by' => session()->get('user')
                        ]);
                break;
            }
            
            $result = ['result' => 'success', 'id' => $insId, 'message' => 'บันทึกคำตอบแล้ว'];
        } catch(\Exception $e){
            $result = ['result' => 'error', 'message' => 'System : '.$e->getMessage()];
        }

        return $this->response->setJSON($result);
    }

    public function uploadFiles()
    {
        try{
            if($files = $this->input->getFiles()){
                $question_id = $this->input->getVar('qid');
                $answer_id = $this->input->getVar('aid');
                $position = $this->input->getVar('position');
                $path = $this->setFilePath(session()->get('id')).'pre-screen/'.$this->input->getVar('path');
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

                    }
                } 

                if($this->input->getVar('action') == 'create'){
                    $dtdb = [
                        'question_id' => $question_id,
                        'reply_by' => session()->get('id'),
                        'pack_file' => json_encode($files_up),
                        'status' => 1,
                    ]; 

                    $ins = $this->ans->insert($dtdb);
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

                    $upd = $this->ans->update($answer_id,['pack_file' => json_encode($files_up)]);
                }

                $files_up = json_decode(json_encode($files_up),false);
                
                foreach($files_up as $file){
                    if($file->file_position == $position)
                        array_push($result['files'],$file);
                }
                
            }
             else {
                $result = ['result' => 'error', 'message' => 'ไม่พบไฟล์ในการอัพโหลด'];
            }
        } catch(\Exception $e){
            $result = ['result' => 'error', 'message' => 'System : '.$e->getMessage()];
        }

        return $this->response->setJSON($result);
    }

    

    public function removeFiles()
    {

        try{
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
            $result = ['result' => 'error', 'message' => 'System : '.$e->getLine().'-'.$e->getMessage()];
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
        $path = 'uploads/'.$year.'/'.$month.'/'.$day.'/'.session()->get('id').'/';
        return $path;
    }
}

?>