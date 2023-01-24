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
    }

    public function forgetpass()
    {
        if(session()->get('isLoggedIn')){
            return redirect()->to(base_url('home'));
        }
        
        $data = [
            'title' => 'ลืมรหัสผ่าน',
            'view' => 'frontend/forgetpass',
            '_recapcha' => $this->recapcha
        ];
        return view('template-frontend',$data);
    }

    public function signup()
    {
        if(session()->get('isLoggedIn')){
            return redirect()->to(base_url('home'));
        }

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

                if($checkReCapcha->result){

                    $result = $this->user->insertUser($instData);
                    
                    if(!$result->result){
                        $status = false;
                        $error['insert'] = $result->error;
                    } else {
                        // $expire = date('YmdHis',strtotime('+1 days'));
                        // $data->verify_token = vEncryption($data->user_id .'-'.$expire.'-'.$verify_code);
                        $data->user_id = $result->id;
                        $data->verify_token = vEncryption($data->user_id .'-'.$verify_code);
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

        $_app = new \Config\App();
        $_register_expire = date('Y-m-d') > $_app->Register_expired;

        $data = [
            'title' => 'Register',
            'view' => 'frontend/register',
            '_recapcha' => $this->recapcha,
            '_register_expire' => $_register_expire,
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
            $verify_code = $this->user->updateVerifyCode($account->id);
            $account->verify_code = $verify_code;
            $this->resetPasswordMail($account);
            $result = array('result' => 'success', 'bank' => $user->bank);
        }
        
        return $this->response->setJSON($result);
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

            $obj_user = new \App\Models\Users();

            if($this->input->getVar('lg') == 1){
                $account = $obj_user->where('id',$this->input->getVar('id'))->first();
                
                if(!empty($account)){
                    $authenticatePassword = password_verify($this->input->getVar('password_old'), $account->password);
                    
                    if(!$authenticatePassword){
                        return $this->response->setJSON(['result' => 'error', 'message' => 'รหัสผ่านเดิมไม่ถูกต้อง']);
                    }
                } else {
                    return $this->response->setJSON(['resullt' => 'error', 'อีเมลของคุณไม่ถูกต้อง']);
                }
            }
            
            if(!empty($this->input->getVar('id'))){
                $where = ['id' => $this->input->getVar('id')];
            } else {
                $where = ['email' => $this->input->getVar('email')];
            }

            $update = $obj_user->where($where)
                ->set(['password' => password_hash($this->input->getVar('password'),PASSWORD_DEFAULT)])
                ->update();

            if($update){
                helper('semail');
                send_email_frontend((object)[
                    'user_id' => $this->input->getVar('id')
                ],'change-password-success');

                return $this->response->setJSON(['result' => 'success']);
            } else {
                return $this->response->setJSON(['resullt' => 'error', 'อีเมลของคุณไม่ถูกต้อง']);
            }
        } catch(Exception $e){

            return $this->response->setJSON([
                'result' => 'error', 
                'message' => ''
            ]);
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