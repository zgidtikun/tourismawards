<?php
function verify_recapcha_token($token){
    $config = new \Config\App();

    $link = 'https://www.google.com/recaptcha/api/siteverify?secret='.$config->RECAPCHA_SECRETKEY;
    $link .= '&response='.$token;
    $request_recapcha = file_get_contents($link);
    $result_recapcha = (object) json_decode($request_recapcha);

    if(
        !$result_recapcha
        || @$result_recapcha['success'] == false
        || (@$result_recapcha->success == true && @$result_recapcha->score <= 0.3)
    ){
        $result = array(
            'result' => false,
            'message' => 'โทเค็น reCAPTCHA ไม่ถูกต้อง'
        );
        if(@$result_recapcha->success == false && getenv('CI_ENVIRONMENT') != 'production'){
            $message = (isset($result_recapcha->{'error-codes'})? ', '.$result_recapcha->{'error-codes'}[0]:'');
            $result['message'] .= $message;
        }
        return (object) $result;
    } 

    return (object) array('result' => true);
}
?>