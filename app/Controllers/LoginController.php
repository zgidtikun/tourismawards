<?php 

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\Users;
use App\Models\Admin;

class LoginController extends BaseController
{
    private $recapcha;
    private $instUser;
    private $instAdmin;

    public function __construct()
    {        
        $_app = new \Config\App();
        $this->recapcha = $_app->RECAPCHA_CK;
        $this->instUser = new Users();
        $this->instAdmin = new Admin();
    }

    public function index($bank = 'frontend')
    {   
        if(!in_array($bank,array('frontend','administrator')))
            return redirect()->to(base_url('404'));
            
        if(session()->get('isLoggedIn')){
            if(session()->get('role') == 1){
                return redirect()->to(base_url('awards/application'));
            }
            elseif(session()->get('role') == 3){
                return redirect()->to(base_url('boards'));
            }
            else
                return redirect()->to(base_url('administrator/dashboard'));            
        }
           
        if($bank == 'frontend')
            return view('template-frontend',array(
                'title' => 'Login',
                '_recapcha' => $this->recapcha,
                'view' => 'frontend/login'
            ));
        else
            return redirect()->to(base_url('administrator/login'));
    }

    public function authentication($bank = 'frontend')
    {
        if(!in_array($bank,array('frontend','administrator')))
            return redirect()->to(base_url('404'));

        if($this->recapcha){
            $checkReCapcha = verify_recapcha_token($this->input->getVar('recapcha_token'));

            if(!$checkReCapcha->result){
                $result = array(
                    'result' => 'error',
                    'message' => $checkReCapcha->message
                );
                return $this->response->setJSON($result);
            }            
        }

        if(!$this->validation->run($this->input->getVar(),'signin')){
            return $this->response->setJSON([
                'result' => 'error',
                'message' => 'ไม่สามารถเข้าสู่ระบบได้'
            ]);
        }
        
        $auth = $this->checkUser((object)$this->input->getVar(),$bank);

        if(@$auth->result == 'error')
            return $this->response->setJSON($auth);

        $setting = (object) array(
            'id' => $auth->id,
            'username' => $auth->username,
            'fullname' => $auth->name.' '.$auth->surname,
            'role' => $auth->role_id,
            'award_type' => $auth->award_type,
            'stage' => !empty($auth->stage) ? $auth->stage : '',
            'profile' => !empty($auth->profile) ? UPLOAD_FILE_URL.$auth->profile : base_url('assets/images/unknown_user.jpg'),
            'bank' => $bank
        );
        
        $this->saveLogLogin('success',$setting);
        $this->setLoggedIn($setting);
        
        if($auth->role_id == 1){
            
            if($auth->stage == 3){
                $redirect = base_url('awards/result');
            } elseif($auth->stage == 2){
                $redirect = base_url('awards/pre-screen');
            } elseif($auth->stage == 1){
                $redirect = base_url('awards/application');
            } else {
                $redirect = base_url('404');
            }
        } else {
            $redirect = base_url('boards');
        }

        return $this->response->setJSON(array(
            'result' => 'success', 
            'role' => $auth->role_id,
            'redirect' => @$redirect,
            'message' => 'Login successful.'
        ));
    }

    private function checkUser($requester,$bank)
    {
        $db = $bank == 'frontend' ? $this->instUser : $this->instAdmin;
        $where = array('username' => $requester->username);
        $account = $db->where($where)->first();
        $fail = true;
       
        if($account){
            if(
                $account->status == 1 && 
                $account->verify_status == 1 && 
                $account->status_delete == 1
            ){
                $authenticatePassword = password_verify($requester->password, $account->password);
                if($authenticatePassword){
                    $result = $account;
                    $fail = false;
                }
                else
                    $result = (object) ['result' => 'error', 'message' => 'รหัสผ่านไม่ถูกต้อง'];
            } else {
                if($account->status_delete == 0){
                    $message = 'ผู้ใช้งานนี้ถูกยกเลิกการใช้งาน';
                } else {
                    $message = 'ผู้ใช้งานนี้ยังไม่ได้ยืนยันตัวตน';
                }

                $result = (object) [
                    'result' => 'error', 
                    'message' => $message
                ];
            }
        } else
            $result = (object) ['result' => 'error', 'message' => 'ไม่มีอีเมลนี้ในระบบ'];        
        
        if($fail){
            $setting = (object) [
                'bank' => $bank,
                'username' => $requester->username,
                'message' => $result->message
            ];

            $this->saveLogLogin('fail',$setting);
        }

        return $result;
    }   

    private function saveLogLogin($status,$data)
    {
        $path_log = 'log-login-'.$data->bank;
        $file_name = '/login_'.date('Ymd').'.txt';
        $file_content = 'Login - Time :: '.date('H:i:s')."\n";
        $file_content .= 'Username :: '.$data->username."\n";

        if($status == 'success'){
            $file_content .= "Status :: Success\n";
            $file_content .= 'Identity name :: '.$data->fullname."\n";
            $file_content .= 'Role :: '.$data->role."\n";
        } else {            
            $file_content .= "Status :: Fail\n";
            $file_content .= 'Message :: '.$data->message."\n";
        }

        $file_content .= 'IP :: '.$this->request->getIPAddress()."\n\n";

        create_log_file($path_log,$file_name,$file_content);
    }

    private function setLoggedIn($data)
    {
        session()->set(array(
            'isLoggedIn' => true,
            'id' => $data->id,
            'account' => $data->username,
            'user' => $data->fullname,
            'role' => $data->role,
            'profile' => $data->profile,
            'award_type' => $data->award_type,
            'stage' => $data->stage,
            'default' => $data->bank
        ));
    }

    public function logout()
    {    
        if(in_array(session()->get('role'),[1,3])){
            $url = 'login';
        }
        elseif(in_array(session()->get('role'),[2,4])){
            $url = 'administrator/login';
        }
        else {
            $url = 'home';
        }

        $list = array('isLoggedIn','id','account','user','role','profile','award_type','stage','default');
        session()->remove($list);
        return redirect()->to(base_url($url));
    }

    public function setSession(){
        if(getenv('CI_ENVIRONMENT') != 'production'){
            helper('semail');
            send_email_frontend((object)[
                'appId' => 2,
                'tycon' => 'ทดสอบส่งอีเมล answer-request-complete'
            ],'answer-request-complete');

            // $years = ["2564","2562","2560","2558","2556","2553","2551","2549","2547","2545","2543","2541","2539"];
            // $groups = [
            //     [
            //         'group' => 1,
            //         'name' => 'attraction',
            //         'title' => '<h2>ประเภทแหล่งท่องเที่ยว (Attraction)</h2>'
            //     ],
            //     [
            //         'group' => 2,
            //         'name' => 'accommodation',
            //         'title' => '<h2>ประเภทที่พักนักท่องเที่ยว (Accommodation)</h2>'
            //     ],
            //     [
            //         'group' => 3,
            //         'name' => 'health',
            //         'title' => '<h2>ประเภทการท่องเที่ยวเชิงสุขภาพ (Health and Wellness Tourism)</h2>'
            //     ]
            // ];

            // $types = [[ 'type' => 1, 'name' => 'great'],[ 'type' => 2, 'name' => 'good']];

            // $result = [];

            // foreach($years as $year){
            //     $result[$year] = [];

            //     foreach($groups as $group){
            //         $result[$year][$group['name']] = [
            //             'title' => $group['title']
            //         ];

            //         foreach($types as $type){
            //             $builder = $this->db->query(
            //                 "SELECT place_name name, place_province province
            //                 FROM award_old 
            //                 WHERE award_group = {$group['group']}
            //                     AND award_$year = {$type['type']}"
            //             )
            //             ->getResult();
                        
            //             $result[$year][$group['name']][$type['name']] = !empty($builder) ? $builder : [];
            //         }
            //     }
            // }

            // return $this->response->setJSON($result);
        }
        else return $this->response->redirect(base_url('403'));
    }

    public function showSession(){
        if(getenv('CI_ENVIRONMENT') != 'production'){
            echo password_hash('123456',PASSWORD_DEFAULT);
            var_dump(get_cookie('username'));
            return $this->response->setJSON(session()->get());
        }
        else return redirect()->to(base_url(base_url('403')));
    }
}