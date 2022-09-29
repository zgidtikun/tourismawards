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
        $data = [
            'title' => 'Pre-screen',
            'view' => 'frontend/pre-screen'
        ];

        return view('template-frontend',$data);
    }

    public function getQuestionByAjax()
    {
        $result = $this->getQuestion();
        return $this->response->setJSON($result);
    }

    public function getQuestion()
    {
        $instApp = new \App\Controllers\ApplicationController();
        $app = $instApp->getRequireQuestion(session()->get('id'));
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
        switch($this->input->getVar('action')){
            case 'action': 
                $tmpFiles = [];
                $insd = [
                    'reply' => $this->input->getVar('reply'),
                    'reply_by' => session()->get('id'),
                    'status' => 1,
                    'pack_file' => []
                ];

                if($files = $this->input->getFiles()){
                    
                    $accept = [
                        'input' => ['paperFile','imagesFile'],
                        'types' => ['paper','images'],
                        'path' => 'uploads/per-screen/'.session()->get('id').'/',
                        'paper' => ['pdf','doc','docx'],
                        'images' => ['jpg','jpeg','gif','png','webp']
                    ];

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

                    $insd['pack_file'] = json_encode($tmpFiles);
                }

                break;
            case 'update':
                break;
        }
    }

    private function randomFileName($type)
    {
        return date('Ymd').'_'.bin2hex(random_bytes(6)).'.'.$type;
    }
}

?>