<?php 

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\Users;

class UserController extends BaseController
{
    private $instUsers;
    private $instAdmin;

    public function __construct()
    {
        $this->instUsers = new Users();
        
        if(!isset($this->db))
            $this->db = \Config\Database::connect();
    }

    public function getUserByEmail($email,$role)
    {
        if($role == 1){
            $bank = 'frontend';
            $account = $this->instUsers->where('email',$email)->first();
        }

        if($role != 1 || !$account){
            $bank = 'backend';
            $account = $this->instAdmin->where('email',$email)->first();
        }
        
        return (object) array('bank' => $bank, 'account' => $account);
    }

    private function getSelectSameRole($role,$get)
    {
        if($get == 'table')
            return $role == 1 ? 'users' : 'admin';
        else return $role == 1 ? $this->instUsers : $this->instAdmin;
    }

    public function checkExistEmail($email)
    {         
        $countUser = $this->db->table('users')->where('email',$email)
            ->countAllResults();

        $countAdmin = $this->db->table('admin')->where('email',$email)
            ->countAllResults();
        
        if($countUser > 0 || $countAdmin > 0)
            $exist = false;
        else $exist = true;

        return $exist;
    }

    public function insertUser($data)
    {
        $inst = $this->getSelectSameRole($data['role_id'],'instance');
        try { 
            $status = $inst->insert($data); 
            $userId = $inst->getInsertID();
            $result = (object) array('result' => $status, 'id' => $userId);
        } 
        catch(\Exception $e) {
            save_log_error([
                'module' => 'insert_user',
                'input_data' => $data,
                'error_date' => date('Y-m-d H:i:s'),
                'error_msg' => [
                    'error_file' => $e->getFile(),
                    'error_line' => $e->getLine(),
                    'error_code' => $e->getCode(),
                    'error_msg' => $e->getMessage()
                ]
            ]);

            $result = (object) array(
                'result' => false, 
                'error' => 'Database : '.$e->getMessage()
            );
        }

        return $result;
    }

    public function updateUser($data)
    {
        $inst = $this->getSelectSameRole($data['role'],'instance');
        try { 
            $status = $inst->update($data['id'],['password' => password_hash($data['password'],PASSWORD_DEFAULT)]);
            $result = (object) array('result' => $status);
        } 
        catch(\Exception $e) {
            save_log_error([
                'module' => 'update_user',
                'input_data' => $data,
                'error_date' => date('Y-m-d H:i:s'),
                'error_msg' => [
                    'error_file' => $e->getFile(),
                    'error_line' => $e->getLine(),
                    'error_code' => $e->getCode(),
                    'error_msg' => $e->getMessage()
                ]
            ]);

            $result = (object) array(
                'result' => false, 
                'error' => 'Database : '.$e->getMessage()
            );
        }
        return $result;
    }

    public function updateVerifyCode($id)
    {
        helper('verify');
        $code = genVerifyCode();
        $this->instUsers->where('id',$id)
        ->set(['verify_code' => $code])
        ->update();
        return $code;
    }
}