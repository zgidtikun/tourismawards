<?php 

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\Users;
use App\Models\Admin;

class LoginController extends BaseController
{
    private $recapcha = false;
    private $instUser;
    private $instAdmin;

    public function __construct()
    {        
        $this->instUser = new Users();
        $this->instAdmin = new Admin();
    }

    public function index($bank = 'frontend')
    {   
        if(!in_array($bank,array('frontend','backend')))
            return redirect()->to(base_url('404'));
            
        if(session()->get('isLoggedIn')){
            if(session()->get('role') == 1){
                return redirect()->to(base_url('awards/application'));
            }
            elseif(session()->get('role') == 3){
                return redirect()->to(base_url('boards/managment'));
            }
            else
                return redirect()->to(base_url('backend/dashboard'));            
        }
           
        if($bank == 'frontend')
            return view('template-frontend',array(
                'title' => 'Login',
                '_recapcha' => false,
                'view' => 'frontend/login'
            ));
        else
            return redirect()->to(base_url('backend/login'));
    }

    public function authentication($bank = 'frontend')
    {
        if(!in_array($bank,array('frontend','backend')))
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
        
        $auth = $this->checkUser((object)$this->input->getVar(),$bank);

        if(@$auth->result == 'error')
            return $this->response->setJSON($auth);
        
        if($this->input->getVar('memorize')){
            set_cookie("memorizeUser",true,time()+ 3600);
            set_cookie("username",$this->input->getVar("username"),time()+ 3600);
            set_cookie("password",$this->input->getVar("password"),time()+ 3600);
        } else {
            set_cookie("memorizeUser",false);
            set_cookie("username","");
            set_cookie("password","");
        }

        $setting = (object) array(
            'id' => $auth->id,
            'username' => $auth->username,
            'fullname' => $auth->name.' '.$auth->surname,
            'role' => $auth->role_id,
            'profile' => !empty($auth->profile) ? $auth->profile : 'assets/images/unknown_user.jpg',
            'bank' => $bank
        );
        
        $this->saveLogLogin($setting);
        $this->setLoggedIn($setting);
        
        if($auth->role_id == 1){
            
            if($auth->stage == 2){
                $redirect = base_url('awards/pre-screen');
            } elseif($auth->stage == 1){
                $redirect = base_url('awards/application');
            } else {
                $redirect = base_url('404');
            }
        } else {
            $redirect = base_url('boards/management');
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

        if($bank == 'frontend' && !$account)
            $account = $this->instAdmin->where($where)->first();
       
        if($account){
            if($account->status == 0)
                return (object) array('result' => 'error', 'message' => 'ผู้ใช้งานยังไม่ถูกอนุมัติ');

            $authenticatePassword = password_verify($requester->password, $account->password);
            if($authenticatePassword)
                return (object) $account;
            else
                return (object) array('result' => 'error', 'message' => 'รหัสผ่านไม่ถูกต้อง');
        } else
            return (object) array('result' => 'error', 'message' => 'ไม่มีอีเมลนี้ในระบบ');
    }   

    private function saveLogLogin($data)
    {
        $path_log = 'log-login-'.$data->bank;
        $file_name = '/login_'.date('Ymd').'.txt';
        $file_content = 'Login - Time :: '.date('H:i:s')."\n";
        $file_content .= 'Username :: '.$data->username."\n";
        $file_content .= 'Identity name :: '.$data->fullname."\n";
        $file_content .= 'Role :: '.$data->role."\n";
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
            'default' => $data->bank
        ));
    }

    public function logout()
    {    
        $url = session()->get('default') == 'frontend' ? 'login' : 'backend/login';
        $list = array('isLoggedIn','id','account','user','role','default');
        session()->remove($list);
        return redirect()->to(base_url($url));
    }

    public function setSession(){
        if(getenv('CI_ENVIRONMENT') != 'production'){
            session()->set(array(
                'isLoggedIn' => true,
                'role' => 'user'
            ));
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