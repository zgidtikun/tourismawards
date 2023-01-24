<?php
function verify_recapcha_token($token){
    $config = new \Config\App();
    $http_user_agent = $_SERVER['HTTP_USER_AGENT'];

    $link = 'https://www.google.com/recaptcha/api/siteverify?secret='.$config->RECAPCHA_SECRETKEY;
    $link .= '&response='.$token;
    $request_recapcha = file_get_contents($link);
    $callback_recapcha = json_decode($request_recapcha,false);
    $result = ['result' => true, 'message' => ''];

    if(
        !$callback_recapcha
        || @$callback_recapcha->success == false
        || (@$callback_recapcha->success == true && @$callback_recapcha->score <= 0.3)
    ){
        $result['result'] = false;
        $result['message'] = 'โทเค็น reCAPTCHA ไม่ถูกต้อง';

        if(@$callback_recapcha->success == false && getenv('CI_ENVIRONMENT') != 'production'){
            if(isset($callback_recapcha->{'error-codes'})){
                $error_code = $callback_recapcha->{'error-codes'}[0];
                
                if($error_code == 'browser-error'){
                    if (strpos($http_user_agent, 'Safari') === true){
                        $result['result'] = true;
                        $result['message'] = '';
                    } else {
                        $result['message'] .= ", $error_code";
                    }
                } else {
                    $result['message'] .= ", $error_code";
                }
            }
        }
        
    } 

    return (object) $result;
}
?>