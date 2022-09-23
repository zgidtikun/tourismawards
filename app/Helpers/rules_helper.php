<?php 
function checkLoggedIn($type = 'ajax')
{
    if(!session()->get('isLoggedIn')){
        if($type == 'ajax'){
            echo json_encode(array('result' => 'error_login'));
            exit;
        } else {
            return (object) array('result' => 'error_login');
        }
    }
}

function getMyRole()
{ 
    return session()->get('role'); 
}

function setRules($rules = [])
{
    if(is_array($rules)){
        if(!empty($rules)){
            if(in_array(getMyRole(),$rules))
                return true;
            else return false;
        } else return true;
    } else {
        if(getMyRole() == $rules)
            return true;
        else return false;
    }
}