<?php 

namespace App\Controllers;
use App\Controllers\BaseController;
use Exception;

class RegisterController extends BaseController
{
    private $user;
    private $recapcha = false; 
    private $encrypter;

    public function __construct()
    {   
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
            '_recapcha' => false
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
            } else $checkReCapcha = (object) array('result' => true);
            
            if($checkReCapcha->result){
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

                    $result = $this->user->insertUser($instData);
                    
                    if(!$result->result){
                        $status = false;
                        array_push($error,$result->error);
                    } else {
                        $data->user_id = $result->id;
                        $data->verify_token = vEncryption($data->user_id .'-'.$verify_code);
                        helper('semail');
                        send_email($data,'register');
                        $status = true;
                    }
                } else {
                    $status = false;
                    foreach($data as $key=>$value){
                        if(!empty($this->validation->getError($key)))
                            array_push($error,$this->validation->getError($key));
                    }
                }
            } else {
                $status = false;
                array_push($error,$checkReCapcha->message);
            }
        }

        $data = [
            'title' => 'Register',
            'view' => 'frontend/register',
            '_recapcha' => false,
            '_signup' => (object) array(
                'method' => $method,
                'status' => $status,
                'error' => $error,
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
            $newPassword = $this->randomPassword();
            
            $updData = array(
                'role' => $user->account->role_id,
                'id' => $user->account->id,
                'password' => $newPassword,
            );

            $update = $this->user->updateUser($updData);

            if($update->result){
                $account = $user->account;
                $account->password = $newPassword;
                $sendEmail = $this->resetPasswordMail($account);
                // return $this->response->setJSON($sendEmail);
                $result = array('result' => 'success', 'bank' => $user->bank);
            } else {
                $result = array('result' => 'error', 'message' => 'ไม่สามารถรีเซ็ตรหัสผ่านได้');
            }
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
        $result = send_email((object)$data,'reset-pass');
        return $result;
    }

    public function setNewPassword()
    {
        $checkReCapcha = $this->checkCaptcha($this->input->getVar('recapcha_token'));

        if(!$checkReCapcha->result){
            $result = array(
                'result' => 'error',
                'message' => $checkReCapcha->message
            );
            return $this->response->setJSON($result);
        } 
        
        try {
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