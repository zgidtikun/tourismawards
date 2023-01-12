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

function acceptEstimate($appId,$judgeId,$stage)
{
    $committees = new \App\Models\Committees();
    $accept = $committees->where([
        'application_form_id' => $appId,
        'assessment_round' => $stage
    ])
    ->where(
        '( admin_id_tourism LIKE \'%"'.$judgeId.'"%\'
        OR admin_id_supporting LIKE \'%"'.$judgeId.'"%\'
        OR admin_id_responsibility LIKE \'%"'.$judgeId.'"%\'
        OR admin_id_lowcarbon LIKE \'%"'.$judgeId.'"%\')'
    )
    ->select('CASE WHEN COUNT(id) > 0 THEN TRUE ELSE FALSE END accept',false)
    ->first();
    return $accept->accept;
}