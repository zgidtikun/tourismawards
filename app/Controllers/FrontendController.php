<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\EstimateScore;
use App\Models\Estimate;
use Exception;

class FrontendController extends BaseController
{
    private $myId;
    public function __construct()
    {
        $this->myId = session()->get('id');

        if(!isset($this->db))
            $this->db = \Config\Database::connect();        
    }

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

    public function notification()
    {
        $data = [
            'title' => 'รายการการแจ้งเตือน',
            'view' => 'frontend/notification',
        ];
        
        return view('frontend/entrepreneur/_template',$data);
    }

    public function profile()
    {
        $users = new \App\Models\Users();
        $user = $users->where('id',$this->myId)->first();
        
        if(!empty($user->profile))
            $user->profile = UPLOAD_FILE_URL.$user->profile;
        else  $user->profile = base_url('assets/images/unknown_user.jpg');

        $user->fullname = $user->name.' '.$user->surname;
        $user->member_type = ($user->member_type == 1) ? 'ผู้ประกอบการ' : 'คณะกรรมการ';

        if($user->role_id == 1){
            $builder = $this->db->table('application_form a')
                ->join('application_type t','a.application_type_id = t.id')
                ->join('application_type_sub ts','a.application_type_sub_id = ts.id','LEFT')
                ->select('a.status, a.attraction_name_th attr, t.name t_name, ts.name ts_name,
                a.require_lowcarbon')
                ->where('created_by',$this->myId)
                ->get();
            
            foreach($builder->getResult() as $val) $app_f = $val;

            if(!empty($app_f)){
                $user->app_sts = $app_f->status;                
                $user->app_attr = !empty($app_f->attr) ? $app_f->attr : '(ยังไม่ได้กรอกแบบฟอร์มใบสมัคร)';
                $user->app_t = !empty($app_f->t_name) ? $app_f->t_name : '(ยังไม่ได้กรอกแบบฟอร์มใบสมัคร)';
                $user->app_ts = !empty($app_f->ts_name) ? $app_f->ts_name : '(ยังไม่ได้กรอกแบบฟอร์มใบสมัคร)';
            } else {
                $user->app_sts = -1;                
                $user->app_attr = '(ยังไม่ได้กรอกแบบฟอร์มใบสมัคร)';
                $user->app_t = '(ยังไม่ได้กรอกแบบฟอร์มใบสมัคร)';
                $user->app_ts = '(ยังไม่ได้กรอกแบบฟอร์มใบสมัคร)';
            }

            if($app_f->require_lowcarbon == 1){
                $user->lowdarbon_sts = true;
                $user->lowcarbon_str = 'ต้องการ';
            } else {
                $user->lowdarbon_sts = false;
                $user->lowcarbon_str = '';
            }

        } else {
            if(!empty($user->award_type)){
                $user->award_type = json_decode($user->award_type,false);

                foreach($user->award_type as $key=>$type){
                    if($type == 1){ $user->award_type[$key] = 'แหล่งท่องเที่ยว (Attraction)'; }
                    elseif($type == 2){ $user->award_type[$key] = 'ที่พักนักท่องเที่ยว (Accommodation)'; }
                    elseif($type == 3){ $user->award_type[$key] = 'การท่องเที่ยวเชิงสุขภาพ (Health and Wellness Tourism)'; }
                    elseif($type == 4){ $user->award_type[$key] = 'รายการนำเที่ยว (Tour Programmes)'; }
                }
            }
            
            if(!empty($user->assessment_group)){
                $user->assessment_group = json_decode($user->assessment_group);

                foreach($user->assessment_group as $key=>$group){
                    if($group == 1){ $user->assessment_group[$key] = 'ด้าน Tourism Excellence (Product/Service)'; }
                    elseif($group == 2){ $user->assessment_group[$key] = 'ด้าน Supporting Business & Marketing Factors'; }
                    elseif($group == 3){ $user->assessment_group[$key] = 'ด้าน Responsibility and Safety & Health Administration'; }
                    elseif($group == 4){ $user->assessment_group[$key] = 'ด้าน Low Carbon & Sustainability'; }
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

    public function AssessmentResults()
    {
        $app = new \Config\App();
        $stage = new \App\Models\UsersStage();
        $prescreen = $stage->where(['user_id' => $this->myId, 'stage' => 1])
            ->select('status')->first();
        $onsite = $stage->where(['user_id' => $this->myId, 'stage' => 2])
            ->select('status')->first();

        if(
            empty($prescreen)
            || !in_array($prescreen->status,[6,7])
        ){
            return redirect()->to(base_url('awards/pre-screen'));
        }        

        $data = (object) [
            'title' => 'สรุปผลการประเมิน',
            'view' => 'frontend/entrepreneur/result',
            'result' => (object) [
                'award_result' => false,
            ]
        ];

        $current = date('Y-m-d');
        $duedate_pre = $app->announcement_pre_date;        
        $duedate_onsite = $app->announcement_ons_date;
        $duedate_reult = $app->announcement_date;

        if($current < $duedate_pre){
            $data->result->sts_title = 'กำลังอยู่ในช่วงขั้นตอนการประเมินขั้นต้น (Pre-screen)';   
            $data->result->sts_content = '';
            $data->result->title = '';
            $data->result->img = base_url('assets/images/prescreen_pass.png');
            $data->result->content = 'ผลงานของท่านอยู่ระหว่างการตรวจประเมินขั้นต้น (Pre-Screen)'
                . '<br>ประกาศผลงานที่ผ่านการประเมินขั้นต้น (Pre-Screen) ในวันที่ '
                . FormatTree($duedate_pre,'thailand');

            return view('frontend/entrepreneur/_template',(array) $data);
        }        

        if($current >= $duedate_onsite && !empty($onsite) && in_array($onsite->status,[6,7])){   

            $data->result->sts_title = 'สรุปผลการประเมินรอบลงพื้นที่เรียบร้อยแล้ว';   
            $data->result->sts_content = 'ระบบได้แจ้งผลการประเมินของท่านเรียบร้อยแล้ว';     
            $data->result->title = 'ผลการประเมินรอบลงพื้นที่';

            if($onsite->status == 6){
                if($current >= $duedate_reult){ 
                    $data->result->award_result = true;                   
                    $data->result->sts_title = 'สรุปผลการประกาศรางวัลเรียบร้อยแล้ว';   
                    $data->result->sts_content = 'ระบบได้แจ้งสรุปผลการประกาศรางวัลของท่านเรียบร้อยแล้ว';     
                    $data->result->title = 'ประกาศผลรางัล';
                    $data->result->img = base_url('assets/images/logo.png');   

                    $award = $this->getAwardResult($this->myId);

                    if($award->type !== 0){
                        $data->result->content = 'ขอแสดงความยินดีด้วย ท่านได้รับรางวัล<br>';
                        $data->result->content .= $award->name;
                    } else {
                        $data->result->content = 'ท่านไม่ผ่านเกณฑ์ประเมินการได้รับรางวัล<br>
                        หากมีข้อสงสัยสามารถสอบถามเพิ่มเติมได้ที่อีเมล : tourismawards14@gmail.com หรือ<br>
                        Line Official : @tourismawards';
                    }
                } else { 
                    $data->result->img = base_url('assets/images/prescreen_pass.png');
                    $data->result->content = 'ผลงานของท่านผ่านการประเมินรอบลงพื้นที่<br>
                        ทางโครงการฯ จะประกาศผลอย่างเป็นทางการอีกครั้ง<br>
                        โดยท่านสามารถดูผลรางวัลได้ที่ https://tourismawards.tourismthailand.org/awards-winner';
                }
            } else {
                $data->result->img = base_url('assets/images/prescreen_uncomplete.png');
                $data->result->content = 'ขอขอบพระคุณผู้ประกอบการที่เข้าร่วมการประกวดรางวัลอุตสาหกรรมท่องเที่ยวไทย ครั้งที่ 14 ประจำปี 2566 
                    <br>ทางโครงการฯ ขอแจ้งว่าผลงานของท่านไม่ผ่านการประเมินรอบลงพื้นที่
                    <br>หากมีข้อสงสัยสามารถสอบถามเพิ่มเติมได้ที่อีเมล : tourismawards14@gmail.com หรือ 
                    <br>Line Official : @tourismawards';
            }
        } else {         
            $data->result->sts_title = 'ผลการประเมินขั้นต้นเรียบร้อยแล้ว (Pre-screen)';   
            $data->result->sts_content = '';
            $data->result->title = '';

            if($prescreen->status == 6){
                $app_f = new \App\Models\ApplicationForm();
                $form = $app_f->where('created_by',$this->myId)
                ->select('application_type_id type_id')
                ->first();
                
                $download_link = 'https://drive.google.com/drive/folders/1BgL5ULFsZZEJTXuGwFVyWFodMSPrSOoT?usp=sharing';

                if(!empty($download_link)){
                    $download_link = "window.open('$download_link','_blank')";
                }

                $data->result->img = base_url('assets/images/prescreen_complete.png');
                $data->result->content = 'ผลงานของท่านผ่านการประเมินขั้นต้น (Pre-Screen)
                    <br>ขอให้ท่านนำส่ง PowerPoint และ Video Clip เพื่อนำเสนอผลงาน
                    <br>ตามหลักเกณฑ์การตัดสินรางวัลฯ ดาวน์โหลดเอกสารได้ที่
                    <br><br>
                    เกณฑ์การประเมินรอบลงพื้นที่<br>
                    <button type="button" class="btn btn-main" style="max-width:190px"
                    onclick="'.$download_link.'">
                        <i class="bi bi-cloud-download"></i> Download File
                    </button>
                    <br><br>
                    ส่งผลงานได้ที่ E-mail : tourismawards14@gmail.com
                    <br>โดยระบุชื่อเรื่อง : ประเภท สาขาที่สมัคร + ชื่อที่ท่านส่งเข้าประกวด
                    <br>ภายในวันที่ 2 - 11 มิถุนายน 2566';
            } else {
                $data->result->img = base_url('assets/images/prescreen_uncomplete.png');
                $data->result->content = 'ขอขอบพระคุณผู้ประกอบการที่เข้าร่วมการประกวดรางวัลอุตสาหกรรมท่องเที่ยวไทย ครั้งที่ 14 ประจำปี 2566'
                    . '<br>ทางโครงการฯ ขอแจ้งว่าผลงานของท่านไม่ผ่านการประเมินขั้นต้น (Pre-Screen)'
                    . '<br>หากมีข้อสงสัยสามารถสอบถามเพิ่มเติมได้ที่อีเมล : tourismawards14@gmail.com หรือ '
                    . '<br>Line Official : @tourismawards';
            }

        }
        
        return view('frontend/entrepreneur/_template',(array) $data);

    }

    private function getAwardResult($id)
    {
        $app = new \Config\App();
        $criteria = $app->JudgingCriteriaScore;
        $obj = new \App\Models\EstimateScore();

        $score = $obj->where(
            "application_id = (
                SELECT id FROM application_form
                WHERE created_by = $id
            )",NULL,false
        )
        ->select('(score_prescreen_tt + score_onsite_tt) total')
        ->first();

        if( $score->total >= $criteria->ttg->low ){
            $award_s = 1;
            $award_n = 'รางวัลยอดเยี่ยม (Thailand Tourism Gold Award)';
        }
        elseif( $score->total >= $criteria->tta->low && $score->total <= $criteria->tta->max ){
            $award_s = 2;
            $award_n = 'รางวัลดีเด่น (Thailand Tourism Silver Award)';
        }
        elseif( $score->total >= $criteria->ttc->low && $score->total <= $criteria->ttc->max ){
            $award_s = 3;
            $award_n = 'เกียรติบัตรรางวัลอุตสาหกรรมท่องเที่ยวไทย<br>(Thailand Tourism Certificate';
        }
        else {
            $award_s = 0; 
            $award_n = 'No Award';     
        }    

        return (object) ['type' => $award_s, 'name' => $award_n];
    }

    public function updateProfile()
    {
        try {
            if(!empty($this->myId) && !is_array($this->myId)){
                $users = new \App\Models\Users();
                $profile = $this->input->getVar('profile');
                $users->where('id',$this->myId)->set($profile)->update();

                save_log_activety([
                    'module' => 'user_profile',
                    'action' => 'update_profile',
                    'bank' => 'frontend',
                    'user_id' => $this->myId,
                    'datetime' => date('Y-m-d H:i:s'),
                    'data' => $this->input->getVar()
                ]);

                $result = ['result' => 'success'];  
            } else {
                $result = ['result' => 'error']; 
            }

            return  $this->response->setJSON($result);
        } catch(Exception $e){
            save_log_error([
                'module' => 'profile_update',
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
                // 'message' => $e->getMessage()
            ];

            return  $this->response->setJSON($result);
        }
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
        $ObjEst = new \App\Controllers\FrontendController();
        $result = [];
        
        $subCommP = $this->db->table('committees')
            ->select('application_form_id afid')
            ->where('assessment_round',1)
            ->where(
                '( admin_id_tourism LIKE \'%"'.$this->myId.'"%\'
                OR admin_id_supporting LIKE \'%"'.$this->myId.'"%\'
                OR admin_id_responsibility LIKE \'%"'.$this->myId.'"%\'
                OR admin_id_lowcarbon LIKE \'%"'.$this->myId.'"%\')')
            ->getCompiledSelect();
        
        $subCommO = $this->db->table('committees')
            ->select('application_form_id afid')
            ->where('assessment_round',2)
            ->where(
                '( admin_id_tourism LIKE \'%"'.$this->myId.'"%\'
                OR admin_id_supporting LIKE \'%"'.$this->myId.'"%\'
                OR admin_id_responsibility LIKE \'%"'.$this->myId.'"%\'
                OR admin_id_lowcarbon LIKE \'%"'.$this->myId.'"%\')')
            ->getCompiledSelect();        

        $subEstInd = $this->db->table('estimate_individual')
            ->select('application_id,score_pre, score_onsite')
            ->where('estimate_by',$this->myId)
            ->getCompiledSelect();
        
        foreach(['pre_wait','pre_comp','inst_wait','inst_comp'] as $key=>$val){            
            $count = 0;

            if(in_array($key,[0,1])){
                $subComm = $subCommP;
            } else {
                $subComm = $subCommO;
            }
                    
            $builder = $this->db->table('application_form af')
                ->select('af.id')
                ->join('application_type at','af.application_type_id = at.id')
                ->join('application_type_sub ats','af.application_type_sub_id = ats.id','LEFT')
                ->join('users_stage us','af.created_by = us.user_id')
                ->join('('.$subComm.') insc','insc.afid = af.id')
                ->join('('.$subEstInd.') es','insc.afid = es.application_id','LEFT');
            
            if(in_array($key,[0,1])){
                $builder = $builder->where('us.stage',1);
            } else {
                $builder = $builder->where('us.stage',2);
            }

            if(in_array($key,[0,2])) {
                $builder = $builder->whereIn('us.status',[1,2,3,4,5]);
            } else {
                $builder = $builder->whereIn('us.status',[1,2,4,5,6,7]);
            }

            $builder = $builder
                ->get();

            foreach($builder->getResult() as $est){
                
                $isFinish = $ObjEst->checkEstimateFinish(
                    $est->id,
                    in_array($val,['pre_wait','pre_comp']) ? 1 : 2,
                    $this->myId
                );

                if(
                    (in_array($val,['pre_wait','inst_wait']) && $isFinish == 'unfinish')
                    || (in_array($val,['pre_comp','inst_comp']) && $isFinish == 'finish')
                ){
                    $count++;
                }
            }

            // $builder = $builder->countAllResults();
            // $result[$val] = $builder;
            $result[$val] = $count;


        }

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

    private function setEstimateDefault($appId,$judgeId,$assign)
    {
        $judgeName = session()->get('user');
        $assessent = implode(', ', $assign);

        $this->db->query(
            "INSERT INTO estimate (application_id, answer_id, question_id, estimate_by, estimate_name)
            SELECT b.id application_id, a.id answer_id, a.question_id, $judgeId estimate_by, '$judgeName' estimate_name
            FROM answer a 
            INNER JOIN application_form b on a.reply_by = b.created_by
            INNER JOIN question c on a.question_id = c.id
            WHERE b.id = $appId
                AND c.assessment_group_id IN ($assessent)
                AND a.id NOT IN (
                    SELECT inna.answer_id
                    FROM estimate inna 
                    WHERE inna.application_id = $appId
                        AND inna.estimate_by = $judgeId
                )"
        );
    }

    public function prescreenEstimate($id)
    {
        if(!acceptEstimate($id,$this->myId,1)){
            return redirect()->to(base_url('boards'));
        }

        $config = new \Config\App();
        $expire_date = $config->Estimate_pre_date;
        $current_date = date('Y-m-d');
        $stage = $this->getStage($id,1);

        if($current_date > $expire_date && !in_array($stage->status,[6,7])){
            $data = [
                'title' => 'ประเมินรอบ Pre-screen',
                'view' => 'frontend/expire/judge-estimate-expire.php',
                'stage' => 1
            ];
        } else {
            $assign = $this->getGroupEstimate($id,$this->myId,1);
            $isFinish = $this->checkEstimateFinish($id,1,$this->myId);
            $this->setEstimateDefault($id,$this->myId,$assign);            

            if($stage->status == 3){
                $judgeRequest = new \App\Controllers\EstimateRequestController();
                $exprireReq = $judgeRequest->get_expire_request($id,$this->myId);
                if($exprireReq->expire_status){
                    if($exprireReq->request_status == 1){
                        $judgeRequest->set_expire_request($id,$this->myId);
                        $stage->status = 5;
                    }
                    else if($exprireReq->request_status == 4){
                        $stage->status = 5;
                    }
                }
                else if(!empty($exprireReq->request_status)){
                    if($exprireReq->request_status == 4){
                        $stage->status = 5;
                    }
                }
            }
            
            $data = [
                'title' => 'ประเมินรอบ Pre-screen',
                'view' => 'frontend/boards/pre-screen-estimate',
                'app_id' => $id,
                'stage' => $stage,
                'assign' => $assign,
                'isFinish' => $isFinish
            ];
        }
        
        return view('frontend/entrepreneur/_template',$data);
    }

    public function onsiteEstimate($id)
    {
        if(!acceptEstimate($id,$this->myId,2)){
            return redirect()->to(base_url('boards'));
        }

        $config = new \Config\App();
        $expire_date = $config->Estimate_ons_date;
        $current_date = date('Y-m-d');
        $stage = $this->getStage($id,2);

        if($current_date > $expire_date && !in_array($stage->status,[6,7])){
            $data = [
                'title' => 'ประเมินรอบ ลงพื้นที่',
                'view' => 'frontend/expire/judge-estimate-expire.php',
                'stage' => 2
            ];
        } else {
            $assign = $this->getGroupEstimate($id,$this->myId,2);
            $isFinish = $this->checkEstimateFinish($id,2,$this->myId);
            $this->setEstimateDefault($id,$this->myId,$assign);    

            $obj_es = new EstimateScore();
            $score = $obj_es->where('application_id',$id)
                ->select('score_prescreen_tt')
                ->first();

            if($stage->status == 3){
                $obj_est = new Estimate();
                $cRequest = $obj_est->where([
                        'application_id' => $id,
                        'estimate_by' => $this->myId,
                        'request_status' => 1
                    ])
                    ->countAllResults();

                if($cRequest <= 0){
                    $stage->status = 2;
                }
            }
            
            $data = [
                'title' => 'ประเมินรอบ ลงพื้นที่',
                'view' => 'frontend/boards/onsite-estimate',
                'app_id' => $id,
                'stage' => $stage,
                'assign' => $assign,
                'score' => $score->score_prescreen_tt,
                'isFinish' => $isFinish
            ];
        }
        
        return view('frontend/entrepreneur/_template',$data);
    }

    public function checkEstimateFinish($id,$stage,$userId)
    {
        $obj_ei = new \App\Models\EstimateIndividual();

        $is_finish = 'unfinish';
        $select = 'score_pre, score_onsite, lowcarbon_status, lowcarbon_score';
        $where = [
            'application_id' => $id,
            'estimate_by' => $userId
        ];

        $ind = $obj_ei->select($select)->where($where)->first();

        if($stage == 1){
            if(!empty($ind->lowcarbon_status) && $ind->lowcarbon_status == 1){
                if(!empty($ind->score_pre) && !empty($ind->lowcarbon_score)){
                    $is_finish = 'finish';
                } else {
                    $is_finish = 'unfinish';
                }
            } else {
                if(!empty($ind->score_pre)){
                    $is_finish = 'finish';
                } else {
                    $is_finish = 'unfinish';
                }
            }
        } else {
            if(!empty($ind->score_onsite)){
                $is_finish = 'finish';
            } else {
                $is_finish = 'unfinish';
            }
        }

        return $is_finish;
    }

    private function getGroupEstimate($appId,$id,$round = null)
    {
        $comm = new \App\Models\Committees();
        $assessment_group = [];

        $builder_t = $comm->select('admin_id_tourism')
            ->where([
                'assessment_round' => $round,
                'application_form_id' => $appId
            ])
            ->like('admin_id_tourism','%"'.$id.'"%')
            ->first();

        $builder_s = $comm->select('admin_id_supporting')
            ->where([
                'assessment_round' => $round,
                'application_form_id' => $appId
            ])
            ->like('admin_id_supporting','%"'.$id.'"%')
            ->first();

        $builder_r = $comm->select('admin_id_responsibility')
            ->where([
                'assessment_round' => $round,
                'application_form_id' => $appId
            ])
            ->like('admin_id_responsibility','%"'.$id.'"%')
            ->first();

        $builder_l = $comm->select('admin_id_lowcarbon')
            ->where([
                'assessment_round' => $round,
                'application_form_id' => $appId
            ])
            ->like('admin_id_lowcarbon','%"'.$id.'"%')
            ->first();

        if(!empty($builder_t->admin_id_tourism)){
            $tourism = json_decode($builder_t->admin_id_tourism,true);
            if(!empty($tourism)){
                $assessment_group[] = 1;
            }
        }
    
        if(!empty($builder_s->admin_id_supporting)){
            $support = json_decode($builder_s->admin_id_supporting,true);
            if(!empty($support)){
                $assessment_group[] = 2;
            }
        }

        if(!empty($builder_r->admin_id_responsibility)){
            $respons = json_decode($builder_r->admin_id_responsibility,true);
            if(!empty($respons)){
                $assessment_group[] = 3;
            }
        }
        
        if(!empty($builder_l->admin_id_lowcarbon)){
            $respons = json_decode($builder_l->admin_id_lowcarbon,true);
            if(!empty($respons)){
                $assessment_group[] = 4;
            }
        }

        return $assessment_group;
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