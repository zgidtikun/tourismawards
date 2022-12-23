<?php
namespace App\Validation;
use App\Controllers\Backend\Users;

class CustomRules 
{
    private $recapcha = false;
    public function password_format(string $str, string $fields, array $data){
        
        $checkstep = 0;
        
        if(preg_match('/[a-z]+/',$data['password'])) 
            $checkstep++;
            
        if(preg_match('/[A-Z]+/',$data['password'])) 
            $checkstep++;
            
        if(preg_match('/[0-9]+/',$data['password'])) 
            $checkstep++;
            
        // if(preg_match('/[$@#&!]+/',$data['password'])) 
        //     $checkstep++; 

        return $checkstep < 3 ? false : true;

    }

    public function name_format($str){

        $checkstep = 0;
        
        if(preg_match('/[a-z]+/',$str)) {
            $checkstep++;
        }
            
        if(preg_match('/[A-Z]+/',$str)) {
            $checkstep++;
        }

        if (preg_match('/\p{Thai}/u', $str) === 1) {
            $checkstep++;
        }

        return $checkstep < 3 ? false : true;
    }

    public function special_str($str){
        return preg_match('/^[\x{0E00}-\x{0E7F}A-Za-z0-9\s]+$/u', $str) ? true : false;
    }

    public function unique_email(string $str, string $fields, array $data){
        $db = \Config\Database::connect();
        $email = $data['email'];
        $role = $data['role'];
        $table = $role == 1 ? 'users' : 'admin';
        $countUser = $db->table($table)->where('email',$email)
            ->countAllResults();

        $countAdmin = $db->table($table)->where('email',$email)
            ->countAllResults();
        
        if($countUser > 0 || $countAdmin > 0)
            $exist = false;
        else $exist = true;
           
        return $exist;
    }
}