<?php 

namespace App\Controllers;
use CodeIgniter\Files\File;
use CodeIgniter\Files\FileCollection;
use App\Controllers\BaseController;
use App\Models\AssessmentGroup;
use App\Models\Question;
use App\Models\Answer;

class AnswerController extends BaseController
{
    public function __construct()
    {
        $this->qt = new Question();
        $this->assg = new AssessmentGroup();
        $this->ans = new Answer();

        if(!isset($this->db))
            $this->db = \Config\Database::connect();
    }

    public function preScreenIndex()
    {
        $app = new \Config\App();
        $duedate = (object) [
            'expired_date' => $app->Pre_expired,
            'expired_str' => 'ภายในวันที่ '.FormatTree($app->Pre_expired,'thailand'),
            'expired_sts' => $app->Pre_expired <= date('Y-m-d') ? true : false,
        ];

        $data = [
            'title' => 'Pre-screen',
            'view' => 'frontend/entrepreneur/pre-screen',
            'duedate' => $duedate
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
        $app = $instApp->getRequireQuestion($id);
        $group = $this->assg->findAll();
        $result = [];
        
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

            $builder = $this->db->table('question q')
                ->select('q.id,q.question,q.remark,a.id reply_id,a.reply,a.pack_file')
                ->join('answer a','q.id = a.question_id','left')
                ->where($where)
                ->orderBy('id','ASC')
                ->get();
           
            foreach($builder->getResult() as $val){   
                $val->no = ++$counter;
                $val->images = $val->paper = (object) ['list' => []]; 

                if(!empty($val->pack_file)){
                    $files = json_decode($val->pack_file);
                    foreach($files as $file){
                        if($file['type'] == 'paper')
                            array_push($val->paper->list,$file);
                        else array_push($val->images->list,$file);
                    }
                }
                
                unset($val->pack_file);                
                array_push($temp['question'],$val);
            }

            array_push($result,$temp);
        }

        return $result;
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
            $files = json_decode($answer->pack_file);
            unset($answer->pack_file);
            $result['reply'] = $answer;
            if(!empty($files)){
                foreach($files as $file){
                    if($file['type'] == 'paper')
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
            $tmpFiles = [];                      
            $accept = [
                'input' => ['paperFile','imagesFile'],
                'types' => ['paper','images'],
                'path' => 'uploads/per-screen/'.session()->get('id').'/',
                'paper' => ['pdf','doc','docx'],
                'images' => ['jpg','jpeg','gif','png','webp']
            ];

            $dtdb = [
                'reply' => $this->input->getVar('reply'),
                'reply_by' => session()->get('id'),
                'status' => 1,
                'pack_file' => $this->input->getVar('oldFiles')
            ];  
            
            if($files = $this->input->getFiles()){
                foreach($accept['input'] as $key=>$index){
                    foreach($files[$index] as $file){
                        if($file->isValid() && !$file->hasMoved()){
                            $originalName = $file->getName();
                            $extension = $file->guessExtension();
                            $newName = $this->randomFileName($extension);

                            if(in_array($extension,$accept[$accept['type'][$key]])){
                                $path = $accept['path'].$accept['types'][$key];
                                $file->move(FCPATH.$path, $newName);
                                array_push($tmpFiles,[
                                    'file_name' => $newName,
                                    'file_original' => $originalName,
                                    'file_type' => $accept['types'][$key],
                                    'file_path' => $path.'/'.$newName
                                ]);
                            }
                        }
                    }
                }
                
                $dtdb['pack_file'] = json_encode(array_merge($dtdb['pack_file'],$tmpFiles));
            }

            switch($this->input->getVar('action')){
                case 'action': 
                    $ins = $this->ans->insert($dtdb);
                    $insId = $this->ans->getInsertID();
                    $answer = $this->ans->find($insId)->first();
                    $result = ['result' => 'success', 'data' => $answer];
                    break;
                case 'update':
                    if(!empty($this->input->getVar('deleteFies'))){
                        $collect = new FileCollection();
                        foreach($this->input->getVar('deleteFies') as $path){
                            $collect->removeFile(FCPATH.$this->innput->getVar('path'));
                        }
                    }

                    $upd = $this->ans->update($this->input->getVar('id'),$dtdb);                    
                    $answer = $this->ans->find($this->input->getVar('id'))->first();
                    $result = ['result' => 'success', 'data' => $answer];
                    break;
            }
        } catch(\Exception $e){
            $result = ['result' => 'error', 'message' => 'System : '.$e->getMessage()];
        }

        return $this->response->setJSON($result);
    }

    private function randomFileName($type)
    {
        return date('Ymd').'_'.bin2hex(random_bytes(6)).'.'.$type;
    }
}

?>