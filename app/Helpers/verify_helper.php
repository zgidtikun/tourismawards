<?php

function genVerifyCode()
{
    $str = bin2hex(random_bytes(12));
    return $str;
}

function vEncryption($code)
{
    $obj = new Encrypter();
    $cipher = $obj->encryption($code);
    return $cipher;
}

function vDecryption($code)
{
    $obj = new Encrypter();
    $cipher = $obj->decryption($code);
    return $cipher;
}

function checkVerifyUser($code)
{    
    $obj_user = new \App\Models\Users();
    $code = vDecryption($code);    
    $carray = explode('-',$code);
    
    $id = $carray[0];
    $vcode = $carray[1];

    $cresult = $obj_user->where([
            'id' => $id,
            'verify_code' => $vcode
        ])
        ->select('password')
        ->first();

    if(!empty($cresult)){
        $obj_user->where('id',$id)
            ->set([
                'status' => 1,
                'stage' => 1,
                'verify_status' => 1,
                'verify_date' => date('Y-m-d H:i:s')
            ])
            ->update();
        
        $userId = $id;
        $existPass = empty($cresult->password) ? true : false;
        $verified = true;
    } else {
        $userId = '';
        $existPass = false;
        $verified = false;
    }

    return (object) [
        'id' => $id,
        'result' => $verified,
        'pass' => $existPass
    ];
}

class Encrypter {
    private $ciphering = 'AES-128-CTR';
    private $options = 0;
    private $iv = '6468499879976200';
    private $key = 'ThailandTourismAwards';

    public function encryption($code)
    {
        $cipher = openssl_encrypt(
            $code, $this->ciphering, $this->key, 
            $this->options, $this->iv
        );

        return $cipher;
    }

    public function decryption($code)
    {
        $cipher = openssl_decrypt(
            $code, $this->ciphering, $this->key, 
            $this->options, $this->iv
        );

        return $cipher;
    }
}
?>