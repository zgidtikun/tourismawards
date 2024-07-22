<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;
use Exception;

class Question extends BaseController
{
    private $myId;

    public function __construct()
    {
        $this->myId = session()->get('id');        
    }

    public function index()
    {
        $_type = new \App\Models\ApplicationType();
        $_sub = new \App\Models\ApplicationTypeSub();
        $_asse = new \App\Models\AssessmentGroup();

        $data['types'] = $_type->findAll();
        $data['subs'] = $_sub->findAll();
        $data['asses'] = $_asse->findAll();


        $data['title']  = 'คำถามและเกณฑ์';
        $data['view']   = 'administrator/question/management';

        return view('administrator/template', $data);
    }

    public function add()
    {
        if(!isChaiyo()){
            return redirect()->to(base_url('administrator/question'));
        }

        $_type = new \App\Models\ApplicationType();
        $_sub = new \App\Models\ApplicationTypeSub();
        $_asse = new \App\Models\AssessmentGroup();
        $_topic = new \App\Models\CriteriaTopic();

        $data['types'] = $_type->findAll();
        $data['subs'] = $_sub->findAll();
        $data['asses'] = $_asse->findAll();
        $data['topics'] = $_topic->findAll();

        $data['title']  = 'คำถามและเกณฑ์';
        $data['view']   = 'administrator/question/add';

        return view('administrator/template', $data);
    }

    public function show($id)
    {
        $question = $this->db->table('question a')
        ->select(
            "a.id, b.name as type_name, c.name as sub_name, 
            d.name as assessment_name,
            IFNULL(e.name,'ไม่ได้กำหนด') as topic_name,
            a.topic_no, a.question_ordering as ordering, 
            a.question, a.remark, 
            a.pre_evaluation_criteria as pre_evaluation, 
            a.pre_scoring_criteria as pre_scoring,
            a.onside_evaluation_criteria as onside_evaluation,
            a.onside_scoring_criteria as onside_scoring,
            a.weight, a.pre_score, a.onside_score,
            a.pre_status, a.onside_status, a.lowcarbon_status"
        )
        ->join('application_type b', 'a.application_type_id = b.id')
        ->join('application_type_sub c', 'a.application_type_sub_id = c.id')
        ->join('assessment_group d', 'a.assessment_group_id = d.id')
        ->join('criteria_topic e', 'a.criteria_topic = e.id', 'left')
        ->where('a.id', $id)
        ->get()
        ->getFirstRow();

        if(empty($question)) return redirect()->to(base_url('administrator/question'));

        if(!empty($question->pre_scoring))
            $question->pre_scoring = json_decode($question->pre_scoring,false);

        if(!empty($question->onside_scoring))
            $question->onside_scoring = json_decode($question->onside_scoring,false);

            
        $current_date = date('Y-m-d');
        $dead_line = config(\Config\App::class)->Pre_open;
        
        $data['expired'] = ($current_date > $dead_line);
        $data['question'] = $question;
        $data['title']  = 'คำถามและเกณฑ์';
        $data['view']   = 'administrator/question/show';

        return view('administrator/template', $data);
    }

    public function edit($id)
    {
        $_question = new \App\Models\Question();

        if(!isChaiyo()){
            return redirect()->to(base_url('administrator/question'));
        }

        $data['question'] = $_question->find($id);

        if(empty($data['question'])){
            return redirect()->to(base_url('administrator/question'));
        }

        if(!empty($data['question']->pre_scoring_criteria)){
            $data['question']->pre_scoring_criteria = json_decode($data['question']->pre_scoring_criteria,false);
        }

        if(!empty($data['question']->onside_scoring_criteria)){
            $data['question']->onside_scoring_criteria = json_decode($data['question']->onside_scoring_criteria,false);
        }

        $_type = new \App\Models\ApplicationType();
        $_sub = new \App\Models\ApplicationTypeSub();
        $_asse = new \App\Models\AssessmentGroup();
        $_topic = new \App\Models\CriteriaTopic();

        $data['types'] = $_type->findAll();
        $data['subs'] = $_sub->findAll();
        $data['asses'] = $_asse->findAll();
        $data['topics'] = $_topic->findAll();

        $data['title']  = 'คำถามและเกณฑ์';
        $data['view']   = 'administrator/question/edit';

        return view('administrator/template', $data);
    }

    public function get_list_question() 
    {
        $builder = $this->db->table('question a')
        ->select(
            "0 as no, a.id, a.question_ordering as ordering, a.question,
            b.name as type_name, 
            c.name as sub_name,
            d.name as asses_name"
        )
        ->join('application_type b', 'a.application_type_id = b.id')
        ->join('application_type_sub c', 'a.application_type_sub_id = c.id')
        ->join('assessment_group d', 'a.assessment_group_id = d.id');

        $input = $this->request->getVar();

        if(!empty($input->keyword)){
            $builder = $builder->like('a.question', $input->keyword, 'both');
        }

        if(!empty($input->type)){
            $builder = $builder->where('a.application_type_id', $input->type);
        }

        if(!empty($input->sub_type)){
            $builder = $builder->where('a.application_type_sub_id', $input->subtype);
        }

        if(!empty($input->assessment)){
            $builder = $builder->where('a.assessment_group_id', $input->assessment);
        }

        $builder = $builder->orderBy('a.application_type_id', 'asc')
        ->orderBy('a.application_type_sub_id', 'asc')
        ->orderBy('a.assessment_group_id', 'asc')
        ->orderBy('a.question_ordering', 'asc')
        ->get();

        $result = $builder->getResult();

        return $this->response->setJSON($result??[]);
    }

    public function store()
    {
        try{
            $_question = new \App\Models\Question();
            $input = $this->request->getVar();
            
            $data = [
                'application_type_id' => $input->type_id,
                'application_type_sub_id' => $input->sub_id,
                'assessment_group_id' => $input->assessmen_id,
                'question_ordering' => $input->ordering,
                'topic_no' => $input->topic_no,
                'criteria_topic' => $input->topic,
                'question' => $input->question,
                'remark' => $input->remark,
                'weight' => $input->weight,
                'pre_score' => $input->pre_score,
                'onside_score' => $input->onside_score,
                'pre_status' => $input->pre_status,
                'onside_status' => $input->onside_status,
                'lowcarbon_status' => $input->lowcarbon_status,
            ];

            if(!empty($input->pre_evaluation)){
                $data['pre_evaluation_criteria'] = $input->pre_evaluation;
            } else $data['pre_evaluation_criteria'] = '';

            if(!empty($input->pre_scoring)){
                $data['pre_scoring_criteria'] = json_encode($input->pre_scoring,JSON_UNESCAPED_UNICODE);
            } else $data['pre_scoring_criteria'] = '';

            if(!empty($input->onside_evaluation)){
                $data['onside_evaluation_criteria'] = $input->onside_evaluation;                
            } else $data['onside_evaluation_criteria'] = '';

            if(!empty($input->onside_scoring)){
                $data['onside_scoring_criteria'] = json_encode($input->onside_scoring,JSON_UNESCAPED_UNICODE);                
            } else $data['onside_scoring_criteria'] = '';

            if($input->action === 'add'){
                $callback = $_question->insert($data);  
            } 
            elseif($input->action === 'edit'){
                $callback = $_question->where('id', $input->id)->set($data)->update();
            }
            else $callback = false;
            
            if($callback){
                save_log_activety([
                    'module' => 'set_question',
                    'action' => 'create_question',
                    'bank' => 'backend',
                    'user_id' => $this->myId,
                    'datetime' => date('Y-m-d H:i:s'),
                    'data' => json_encode($input,JSON_UNESCAPED_UNICODE)
                ]);

                $result = [
                    'result' => 'success',
                    'message' => 'บันทึกคำถามเรียบร้อยแล้ว'
                ];
            } else {
                $result = [
                    'result' => 'error',
                    'message' => 'ไม่สามารถบันทึกคำถามได้'
                ];
            }
        } catch(Exception $e){
            save_log_error([
                'module' => 'create_question',
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
                'line' => $e->getLine(),
                'message' => 'System : '.$e->getMessage()
            ];
        }

        return $this->response->setJSON($result);
    }

    public function destroy($id)
    {
        $_question = new \App\Models\Question();
        $current_date = date('Y-m-d');
        $dead_line = config(\Config\App::class)->Pre_open;

        if($current_date > $dead_line){
            $result = [
                'result' => 'error',
                'message' => 'ได้เริ่มการประเมินแล้ว ไม่สามารถลบคำถามได้'
            ];
        } else {
            $callback = $_question->where('id', $id)->delete();

            if($callback){
                $result = [
                    'result' => 'success',
                    'message' => 'ลบคำถามกเรียบร้อยแล้ว'
                ];
            } else {
                $result = [
                    'result' => 'error',
                    'message' => 'ไม่สามารถลบคำถามได้'
                ];
            }
        }

        return $this->response->setJSON($result);
    }

    public function change_weight()
    {
        try {
            $current_date = date('Y-m-d');
            $dead_line = config(\Config\App::class)->Pre_open;

            if($current_date > $dead_line){
                $result = [
                    'result' => 'error',
                    'message' => 'ได้เริ่มการประเมินแล้ว ไม่สามารถเปลี่ยนน้ำหนักการให้คะแนนได้'
                ];
            } else {
                $_question = new \App\Models\Question();

                $change = $_question->where('id', $this->request->getVar('id'))
                ->set('weight', $this->request->getVar('weight'))
                ->update();

                if($change){
                    $result = [
                        'result' => 'success',
                        'message' => 'เปลี่ยนน้ำหนักการให้คะแนนเรียบร้อยแล้ว'
                    ];
                } else {
                    $result = [
                        'result' => 'error',
                        'message' => 'ไม่สามารถเปลี่ยนน้ำหนักการให้คะแนนได้'
                    ];
                }
            }

        } catch(Exception $e){
            save_log_error([
                'module' => 'change_question_weight',
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
                'line' => $e->getLine(),
                'message' => 'System : '.$e->getMessage()
            ];
        }

        return $this->response->setJSON($result);
    }
}
