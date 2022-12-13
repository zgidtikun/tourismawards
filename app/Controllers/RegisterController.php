<?php 

namespace App\Controllers;
use App\Controllers\BaseController;
use Exception;

class RegisterController extends BaseController
{
    private $user;
    private $recapcha; 

    public function __construct()
    {   
        $_app = new \Config\App();
        $this->recapcha = $_app->RECAPCHA_CK;
        $this->user = new UserController(); 
        $this->encrypter = (object) [
            'key' => md5('ThailandTourismAwards2023'),
            'driver' => 'OpenSSL'
        ];
    }

    public function forgetpass()
    {
        $data = [
            'title' => 'ลืมรหัสผ่าน',
            'view' => 'frontend/forgetpass',
            '_recapcha' => $this->recapcha
        ];
        return view('template-frontend',$data);
    }

    public function signup()
    {
        $status = false;
        $error = array();
        $data = (object) $this->input->getVar();
        $method = strtolower($this->input->getMethod());
        
        if($method !== 'get'){

            if($this->recapcha){
                $checkReCapcha = $this->checkCaptcha($data->recapcha_token);  

                if(!$checkReCapcha->result){
                    $error['recapcha'] = $checkReCapcha->message;    
                    $status = false;
                }      
            }
            
            $valid = $this->validation->run((array)$data,'signup');

            if($valid){  
                helper('verify');
                $verify_code = genVerifyCode();

                $instData = array(
                    'prefix' => $data->prefix,
                    'name' => $data->name,
                    'surname' => $data->surname,
                    'member_type' => $data->role,
                    'mobile' => $data->telephone,
                    'email' => $data->email,
                    'username' => $data->email,
                    'password' => password_hash($data->password,PASSWORD_DEFAULT),
                    'role_id' => $data->role,
                    'verify_code' => $verify_code,
                    'verify_status' => 0,
                    'status' => 0
                );

                if($status){

                    $result = $this->user->insertUser($instData);
                    
                    if(!$result->result){
                        $status = false;
                        $error['insert'] = $result->error;
                    } else {
                        $expire = date('YmdHis',strtotime('+3 days'));
                        $data->user_id = $result->id;
                        $data->verify_token = vEncryption($data->user_id .'-'.$expire.'-'.$verify_code);
                        helper('semail');
                        send_email_frontend($data,'register');
                        $status = true;
                    }

                }
            } else {
                $status = false;
                foreach($data as $key=>$value){
                    if(!empty($this->validation->getError($key))){
                        $error[$key] = $this->validation->getError($key);
                    }
                }
            }
        }

        $data = [
            'title' => 'Register',
            'view' => 'frontend/register',
            '_recapcha' => $this->recapcha,
            '_signup' => (object) array(
                'method' => $method,
                'status' => $status,
                'error' => (object) $error,
                'data' => $data
            )
        ];

        return view('template-frontend',$data);
    }

    public function resetPassword()
    {
        
        $checkReCapcha = $this->checkCaptcha($this->input->getVar('recapcha_token'));

        if(!$checkReCapcha->result){
            $result = array(
                'result' => 'error',
                'message' => $checkReCapcha->message
            );
            return $this->response->setJSON($result);
        }           

        $email = $this->input->getVar('email');
        $exist = $this->user->checkExistEmail($email);

        if($exist){
            $result = array('result' => 'error', 'message' => 'ไม่มีอีเมลนี้ในระบบ');
        } else {
            $user = $this->user->getUserByEmail($email,1);
            $account = $user->account;
            $this->resetPasswordMail($account);
            $result = array('result' => 'success', 'bank' => $user->bank);
        }
        
        return $this->response->setJSON($result);
    }

    private function randomPassword() 
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array();
        $passLength = 8;
        $alphaLength = strlen($alphabet) - 1;
        for ($i = 0; $i < $passLength; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass);
    }

    public function resetPasswordMail($data)
    {
        helper('semail');
        $result = send_email_frontend((object)$data,'reset-pass');
        return $result;
    }

    public function setNewPassword()
    {        
        try {
            $checkReCapcha = $this->checkCaptcha($this->input->getVar('recapcha_token'));

            if(!$checkReCapcha->result){
                $result = array(
                    'result' => 'error',
                    'message' => $checkReCapcha->message
                );
                return $this->response->setJSON($result);
            }
            if(!empty($this->input->getVar('id'))){
                $where = ['id' => $this->input->getVar('id')];
            } else {
                $where = ['email' => $this->input->getVar('email')];
            }

            $obj_user = new \App\Models\Users();
            $update = $obj_user->where($where)
                ->set(['password' => password_hash($this->input->getVar('password'),PASSWORD_DEFAULT)])
                ->update();

            if($update){
                return $this->response->setJSON(['result' => 'success']);
            } else {
                return $this->response->setJSON(['resullt' => 'error', 'อีเมลของคุณไม่ถูกต้อง']);
            }
        } catch(Exception $e){
            return $this->response->setJSON(['result' => 'error', 'message' => $e->getMessage()]);
        }
    }

    private function checkCaptcha($token)
    {
        if($this->recapcha){
            $result_recapcha = verify_recapcha_token($token);
            return $result_recapcha;        
        }
        return (object) array('result' => true);
    }

}