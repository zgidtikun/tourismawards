<?php

namespace App\Controllers;
use App\Controllers\BaseController;

class Home extends BaseController
{
    private $recapcha;
    
    public function __construct()
    {        
        $_app = new \Config\App();
        $this->recapcha = $_app->RECAPCHA_CK;

        if(!isset($this->db))
            $this->db = \Config\Database::connect();    
    }

    public function index()
    {
        $_app = new \Config\App();
        if($_app->comming_soon){
            return redirect()->to(base_url('comming-soon'));
        }

        $data_judge = [];
        $data_news = [];
        
        $judges = $this->db->table('users')
        ->where([
            'role_id' => 3,
            'status' => 1,
            'status_delete' => 1
        ])
        ->select(
            'CONCAT(name,\' \',surname) fullname, profile, position'
        , false)
        ->limit(5)
        ->get();        

        foreach($judges->getResult() as $val){
            $judge = $val;

            if(empty($judge->pofile)){
                $judge->profile = 'assets/images/unknown_user.jpg';
            }

            array_push($data_judge,$judge);
        }

        $news = $this->db->table('news')
            ->where('publish_end >=',"'".date('Y-m-d H:i:s')."'")
            ->select('id, title, description, image_cover, created_by, publish_start')
            ->orderBy('id','desc')
            ->limit(4)
            ->get();
            
        foreach($news->getResult() as $val){
            $new = $val;
            $new->publish_start = docDate($new->publish_start,3,'thailand');
            array_push($data_news,$new);
        }

        $data = [
            'title' => 'Thailand Tourism Awards',
            '_banner' => true,
            'judge' => json_decode(json_encode($data_judge),true),
            'news' => json_decode(json_encode($data_news),true),
            'view' => 'index'
        ];
        return view('template-app',$data);
    }

    public function verifyuser()
    {
        helper('verify');
        $verified = checkVerifyUser($_GET['c']);

        /* Clear current session anyway when click verify link and verified success */
        if($verified->result === true){
            $list = array('isLoggedIn','id','account','user','role','default');
            session()->remove($list);
        }
        
        return view('template-frontend',array(
            'title' => 'Verify User',
            '_id' => $verified->id,
            '_verified' => $verified->result,
            '_password' => $verified->pass,
            // '_expire' => $verified->expire,
            'view' => 'frontend/verify-user'
        ));
    }

    public function newpassword($token = null)
    {
        $obj = new \App\Models\Users();

        if(!empty($token)){
            $decode_token = urldecode($token);
            
            $user = $obj->where(
                "CONCAT(verify_code,id) LIKE '$decode_token'",NULL,false
            )
            ->select('email,id')
            ->first();

            if(empty($user)){
                $user = $obj->where(
                    "CONCAT(verify_code,id) LIKE '$token'",NULL,false
                )
                ->select('email,id')
                ->first();
            };

            if(!empty($user)){
                if(session()->get('isLoggedIn')){
                    if($user->id == session()->get('id')){
                        $id = $user->id;
                        $email = $user->email;
                        $status = true;
                        $message = '';
                    } else {
                        $id = '';
                        $email = '';
                        $status = false;
                        $message = 'Token ของท่านไม่ถูกต้อง';
                    }
                } else {
                    $id = $user->id;
                    $email = $user->email;
                    $status = true;
                    $message = '';
                }
            } else {
                $id = '';
                $email = '';
                $status = false;
                $message = 'Token ของท่านไม่ถูกต้อง';
            }
        } else {
            if(session()->get('isLoggedIn')){            
                $user = $obj->where('id',session()->get('id'))
                ->select('email')
                ->first();

                $id = session()->get('id');
                $email = $user->email;
                $status = true;
                $message = '';
            } else {
                $id = '';
                $email = '';
                $status = false;
                $message = 'Token ของท่านไม่ถูกต้อง';
            }
        }

        $login = !empty(session()->get('isLoggedIn')) ? session()->get('isLoggedIn') : false;

        return view('template-frontend',array(
            'title' => 'ตั้งค่ารหัสผ่านใหม่',
            '_recapcha' => $this->recapcha,
            'id' => !empty($id) ? $id : '',
            'email' => $email,
            'status' => $status,
            'message' => $message,
            'login' => $login,
            'view' => 'frontend/new-password'
        ));
    }

    public function new()
    {
        $obj = new \App\Models\News();
        $news  = $obj->where('publish_end >=',"'".date('Y-m-d H:i:s')."'")
            ->select('id, title, image_cover, created_by, publish_start')
            ->orderBy('id','desc')
            ->findAll();
            
        foreach($news as $new){
            $new->publish_start = docDate($new->publish_start,3,'thailand');
        }

        $data = [
            'title' => 'ข่าวประชาสัมพันธ์',
            '_banner' => false,
            'news' => $news,
            'view' => 'new'
        ];

        return view('template-app',$data);
    }

    public function new_detail($id)
    {
        $obj = new \App\Models\News();
        $new  = $obj->where('id',$id)
            ->select('id, title, description, image_cover, created_by, 
            publish_start')
            ->first();

        $data = [
            'title' => 'ข่าวประชาสัมพันธ์',
            '_banner' => false,
            'new' => $new,
            'view' => 'new-detail'
        ];

        return view('template-app',$data);
    }

    public function aboutus()
    {
        $data = [
            'title' => 'เกี่ยวกับโครงการ',
            '_banner' => false,
            'view' => 'about-us'
        ];

        return view('template-app',$data);
    }

    public function contactus()
    {
        $data = [
            'title' => 'ติดต่อเรา',
            '_recapcha' => $this->recapcha,
            '_banner' => false,
            'view' => 'contact-us'
        ];

        return view('template-app',$data);
    }

    public function sendEmailContact()
    {
        $checkReCapcha = $this->checkCaptcha($this->input->getVar('recapcha_token'));
        if(!$checkReCapcha->result){
            $result = array(
                'result' => 'error',
                'message' => $checkReCapcha->message
            );
            return $this->response->setJSON($result);
        } 

        $valid = $this->validation->run($this->input->getVar(),'contactus');

        if(!$valid){
            return $this->response->setJSON([
                'result' => 'error',
                'message' => 'กรุณาตรวจสอบข้อมูลของคุณอีกครั้ง'
            ]);
        }
        
        helper('semail');
        $result = send_email_frontend($this->input->getVar(),'contact');        
        return $this->response->setJSON($result);
    }    

    private function checkCaptcha($token)
    {
        if($this->recapcha){
            $result_recapcha = verify_recapcha_token($token);
            return $result_recapcha;        
        }
        return (object) array('result' => true);
    }

    public function judge()
    {
        $obj = new \App\Models\Users();
        $judge = $obj->where([
                'role_id' => 3,
                'status' => 1,
                'status_delete' => 1
            ])
            ->where('award_type IS NOT NULL',NULL,false)
            ->select(
                'CONCAT(name,\' \',surname) fullname, profile, 
                award_type, position'
            , false)
            ->findAll();

        foreach($judge as $val){
            $val->award_type = json_decode($val->award_type,false);

            if(empty($val->pofile))
                $val->profile = 'assets/images/unknown_user.jpg';
        }
        
        $data = [
            'title' => 'คณะกรรมการ',
            '_banner' => false,
            'judge' => $judge,
            'view' => 'judge'
        ];

        return view('template-app',$data);
    }

    public function privacypolicy()
    {
        $data = [
            'title' => 'ข้อกำหนดและเงื่อนไขการใช้งาน',
            '_banner' => false,
            'view' => 'privacy-policy'
        ];

        return view('template-app',$data);

    }

    public function appguide()
    {
        $data = [
            'title' => 'คู่มือการสมัคร',
            '_banner' => false,
            'view' => 'application-guide'
        ];

        return view('template-app',$data);        
    }

    public function winnerinfo()
    {
        $data = [
            'title' => 'ข้อมูลการประกวดรางวัล',
            '_banner' => false,
            'view' => 'awards-info'
        ];

        return view('template-app',$data);
    }

    public function winneraward()
    {
        $data = [
            'title' => 'WINNER 2023',
            '_banner' => false,
            'view' => 'awards-winner'
        ];

        return view('template-app',$data);
    }

    public function winneraward13()
    {
        $data = [
            'title' => 'ผลงานปีที่ได้รับปีที่ผ่านมา',
            '_banner' => false,
            'view' => 'awards-winner-13'
        ];

        return view('template-app',$data);

    }

    public function winneraward14($param)
    {
        switch($param){
            case 'attraction': $tid = 1; break;
            case 'accommodation': $tid = 2; break;
            case 'health-and-wellness-tourism': $tid = 3; break;
            case 'tourism-program': $tid = 4; break;
        }

        $app = new \Config\App();
        $type = new \App\Models\ApplicationType();
        $type_s = new \App\Models\ApplicationTypeSub();

        $duedate = $app->announcement_date;
        $current = date('Y-m-d');

        $main = $type->where('id',$tid)
            ->select('id, name')
            ->first();
        
        $sub = $type_s->where('application_type_id',$tid)
            ->select('id, name')
            ->findAll();

        $data = [
            'title' => 'ผลงานที่ได้รับรางวัลอุตสาหกรรมท่องเที่ยวไทย ครั้งที่ 14 ปี 2566',
            '_banner' => false,
            'tid' => $tid,
            'main' => $main,
            'sub' => $sub,
            'duedate' => $current >= $duedate,
            'view' => 'awards-winner-14'
        ];

        return view('template-app',$data);

    }

    public function indexBackend()
    {
        $data['title']  = 'สถิติการใช้งาน';
        $data['view']   = 'administrator/dashboard/index';
        $data['ci']     = $this;

        return view('administrator/template', $data);
    }

    public function comming_soon()
    {        
        $_app = new \Config\App();
        if($_app->comming_soon){
            return view('comming-soon');
        } else {
            return redirect()->to(base_url('home'));
        }
    }

    public function error_403()
    {
        return view('errors/html/error_403_c');
    }

    public function error_404()
    {
        return view('errors/html/error_404_c');
    }
}
