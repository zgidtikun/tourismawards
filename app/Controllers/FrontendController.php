<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use Exception;

class FrontendController extends BaseController
{
    public function index()
    {
        if(session()->get('isLoggedIn')){
            if(session()->get('role') == 1){
                return redirect()->to(base_url('awards/application'));
            }
            elseif(session()->get('role') == 3){
                return redirect()->to(base_url('boards'));
            }
            else
                return redirect()->to(base_url('403'));            
        } else {
            return redirect()->to(base_url('login')); 
        }
    }

    public function profile()
    {
        $users = new \App\Models\Users();
        $user = $users->where('id',session()->get('id'))->first();
        
        if(!empty($user->profile))
            $user->profile = base_url($user->profile);
        else  $user->profile = base_url('assets/images/unknown_user.jpg');

        $user->fullname = $user->name.' '.$user->surname;
        $user->member_type = ($user->member_type == 1) ? 'ผู้ประกอบการ' : 'คณะกรรมการ';

        if($user->role_id == 1){
            $builder = $this->db->table('application_form a')
                ->join('application_type t','a.application_type_id = t.id')
                ->join('application_type_sub ts','a.application_type_sub_id = ts.id')
                ->select('a.status, a.attraction_name_th attr, t.name t_name, ts.name ts_name')
                ->where('created_by',session()->get('id'))
                ->get();
            
            foreach($builder->getResult() as $val) $app_f = $val;

            if(!empty($app_f)){
                $user->app_sts = $app_f->status;                
                $user->app_attr = !empty($app_f->attr) ? $app_f->attr : '(ยังไม่ได้กรอกแบบฟอร์มใบสมัคร)';
                $user->app_t = !empty($app_f->t_name) ? $app_f->t_name : '(ยังไม่ได้กรอกแบบฟอร์มใบสมัคร)';
                $user->app_ts = !empty($app_f->ts_name) ? $app_f->t_name : '(ยังไม่ได้กรอกแบบฟอร์มใบสมัคร)';
            } else {
                $user->app_sts = -1;                
                $user->app_attr = '(ยังไม่ได้กรอกแบบฟอร์มใบสมัคร)';
                $user->app_t = '(ยังไม่ได้กรอกแบบฟอร์มใบสมัคร)';
                $user->app_ts = '(ยังไม่ได้กรอกแบบฟอร์มใบสมัคร)';
            }

        } else {
            if(!empty($user->award_type)){
                $user->award_type = json_decode($user->award_type,false);

                foreach($user->award_type as $key=>$type){
                    if($type == 1){ $user->award_type[$key] = 'ประเภทแหล่งท่องเที่ยว'; }
                    elseif($type == 2){ $user->award_type[$key] = 'ประเภทการท่องเที่ยวเชิงสุขภาพ'; }
                    elseif($type == 3){ $user->award_type[$key] = 'ประเภทที่พักนักท่องเที่ยว'; }
                    elseif($type == 4){ $user->award_type[$key] = 'ประเภทรายการนำเที่ยว'; }
                }
            }
            
            if(!empty($user->assessment_group)){
                $user->assessment_group = json_decode($user->assessment_group);

                foreach($user->assessment_group as $key=>$group){
                    if($group == 1){ $user->assessment_group[$key] = 'ด้าน Tourism Excellence'; }
                    elseif($group == 2){ $user->assessment_group[$key] = 'ด้าน Supporting Business & Marketing Factors '; }
                    elseif($group == 3){ $user->assessment_group[$key] = 'ด้านความยั่งยืน (Responsibility)'; }
                }
            }
        }

        $data = [
            'title' => 'Profile',
            'view' => 'frontend/profile',
            'profile' => $user
        ];
        
        return view('frontend/entrepreneur/_template',$data);

    }

    public function updateProfile()
    {
        try {
            $users = new \App\Models\Users();
            $users->update($this->input->getVar('id'),$this->input->getVar('profile'));
            $result = ['result' => 'success'];  

        } catch(Exception $e){
            $result = [
                'result' => 'error',
                'message' => $e->getMessage()
            ];
        }

        return  $this->response->setJSON($result);
    }

    public function boards()
    {
        $data = [
            'title' => 'ระบบการประเมิน',
            'view' => 'frontend/boards/index',
        ];
        
        return view('frontend/entrepreneur/_template',$data);
    }

    public function sumStage()
    {
        $stage = new \App\Models\UsersStage();
        $count_1 = $stage->where('stage',1)->whereIn('status',[1,2,3,4,5])->countAllResults();
        $count_2 = $stage->where('stage',1)->whereIn('status',[6,7])->countAllResults();
        $count_3 = $stage->where('stage',2)->whereIn('status',[1,2,3,4,5])->countAllResults();
        $count_4 = $stage->where('stage',2)->whereIn('status',[6,7])->countAllResults();

        $result = [
            'pre_wait' => $count_1,
            'pre_comp' => $count_2,
            'inst_wait' => $count_3,
            'inst_comp' => $count_4
        ];

        return $this->response->setJSON($result);
    }

    public function listDataBoards()
    {
        $question = new \App\Controllers\QuestionController();
        $input = (object) $this->input->getVar();
        
        switch($input->stage){
            case 'pre-screen':
                $result = $question->getListEstimate($input->stage,$input->status);
            break;
            case 'onsite':
                $result = $question->getListEstimate($input->stage,$input->status);
            break;
            default:
                $result = ['result' => 'success', 'data' => []];
            break;
        }
        
        return $this->response->setJSON($result);
    }

    public function prescreenEstimate($id)
    {
        $stage = $this->getStage($id,1);
        $assign = $this->getGroupEstimate('asm',session()->get('id'));
        
        $data = [
            'title' => 'ประเมินรอบ Pre-screen',
            'view' => 'frontend/boards/pre-screen-estimate',
            'app_id' => $id,
            'stage' => $stage,
            'assign' => $assign
        ];
        
        return view('frontend/entrepreneur/_template',$data);
    }

    public function onsiteEstimate($id)
    {
        $stage = $this->getStage($id,2);
        $assign = $this->getGroupEstimate('asm',session()->get('id'));
        
        $data = [
            'title' => 'ประเมินรอบ ลงพื้นที่',
            'view' => 'frontend/boards/onsite-estimate',
            'app_id' => $id,
            'stage' => $stage,
            'assign' => $assign
        ];
        
        return view('frontend/entrepreneur/_template',$data);
    }

    private function getGroupEstimate($group,$id)
    {
        $user = new \App\Models\Users();

        if($group == 'awt'){
            $result = $user->where('id',$id)
                ->select('award_type')
                ->first();
            return json_decode($result->award_type);
        }
        else {
            $result = $user->where('id',$id)
                ->select('assessment_group')
                ->first();
            return json_decode($result->assessment_group);
        }
    }

    private function getStage($id,$stage)
    {
        $builder = $this->db->table('application_form a')
            ->select('u.stage, u.status')
            ->join('users_stage u','a.created_by = u.user_id')
            ->where(['a.id' => $id, 'u.stage' => $stage])
            ->get();

        foreach($builder->getResult() as $val) $result = $val;
        return $result;
    }
}