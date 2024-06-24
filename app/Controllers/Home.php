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
        if(config(\Config\App::class)->comming_soon) 
            return redirect()->to(base_url('comming-soon'));

        $data = [
            'title' => 'Thailand Tourism Awards',
            '_banner' => true,
        ];

        return view('pages/index',$data);
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

    public function aboutus()
    {
        $data = [ 'title' => 'เกี่ยวกับโครงการ' ];
        return view('pages/about-us',$data);
    }

    public function contactus()
    {
        $data = [
            'title' => 'ติดต่อเรา',
            '_recapcha' => $this->recapcha
        ];

        return view('pages/contact-us',$data);
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

    public function privacypolicy()
    {
        $data = [
            'title' => 'ข้อกำหนดและเงื่อนไขการใช้งาน',
            '_banner' => false,
            'view' => 'privacy-policy'
        ];

        return view('pages/privacy-policy',$data);

    }

    public function winnerinfo()
    {
        $data = [
            'title' => 'ข้อมูลการประกวดรางวัล'
        ];

        return view('pages/awards-info',$data);
    }

    public function winneraward()
    {
        $data = [
            'title' => 'WINNER 2023',
            'view' => 'awards-winner'
        ];

        return view('pages/awards-winner',$data);
    }

    public function winneraward13()
    {
        $data = [
            'title' => 'ผลงานปีที่ได้รับปีที่ผ่านมา'
        ];

        return view('pages/awards-winner-13',$data);

    }

    public function winneraward14($type, $subType = null)
    {
        switch ($type) {
            case 'hall-of-fame':
                $title = 'Hall of Fame';
                $setting = 'hall-of-fame';
                $view = 'pages/awards-hall-of-fame';
            break;
            case 'gold-awards':
                $title = 'Gold Awards';

                if ($subType == null) {
                    $setting = 'gold-awards';
                    $view = 'pages/awards-winner-14';
                }
                else if ($subType == 'low-carbon') {
                    $setting = 'gold-awards-low-carbon';
                    $view = 'pages/awards-low-carbon';
                }
                else return redirect(base_url("awards-winner/$type"));
            break;
            case 'silver-awards':
                $title = 'Sivler Awards';

                if ($subType == null) {
                    $setting = 'silver-awards';
                    $view = 'pages/awards-winner-14';
                }
                else if ($subType == 'low-carbon') {
                    $setting = 'silver-awards-low-carbon';
                    $view = 'pages/awards-low-carbon';
                }
                else return redirect(base_url("awards-winner/$type"));
            break;
            default: return redirect(base_url('awards-winner'));
        }

        $data = [
            'title' => $title,
            'setting' => $setting
        ];

        return view($view,$data);

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
        if(config(\Config\App::class)->comming_soon) return view('pages/comming-soon');
        else return redirect()->to(base_url('home'));
    }

    public function ebook()
    {
        return view('ebook');
    }

    public function error_403()
    {
        return view('errors/html/error_403_c');
    }

    public function error_404()
    {
        return view('errors/html/error_404_c');
    }

    public function error_report()
    {
        return view('errors/html/error_report');
    }
}
