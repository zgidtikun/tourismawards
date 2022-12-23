<?php 
function save_log_activety($setting){
    $obj = new \App\Models\LogActivity();

    try {
        if(empty($setting)){
            return false;
        }

        if(!empty($setting['data'])){
            if(is_array($setting['data']) || is_object($setting['data'])){
                $data = json_encode($setting['data'],JSON_UNESCAPED_UNICODE);
            } else {
                $data = $setting['data'];
            }
        } else {
            $data = NULL;
        }

        $obj->insert([
            'action_module' => $setting['module'],
            'action' => $setting['action'],
            'action_bank' => $setting['bank'],
            'user_id' => !empty($setting['user_id']) ? $setting['user_id'] : NULL,
            'user_ip' => getUserIpAddr(),
            'action_date' => $setting['datetime'],
            'action_data' => $data
        ]);
    } catch(Exception $e) {
        save_log_error([
            'module' => 'save_log_activety',
            'input_data' => $setting,
            'error_date' => date('Y-m-d H:i:s'),
            'error_data' => [
                'error_file' => $e->getFile(),
                'error_line' => $e->getLine(),
                'error_code' => $e->getCode(),
                'error_msg' => $e->getMessage()
            ]
        ]);
    }
}

function getUserIpAddr(){
    if(!empty($_SERVER['HTTP_CLIENT_IP'])){
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }else{
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

function save_log_error($setting){
    $obj = new \App\Models\LogError();

    try {
        if(empty($setting)){
            return false;
        }

        if(!empty($setting['input_data'])){
            if(is_array($setting['input_data']) || is_object($setting['input_data'])){
                $input_data = json_encode($setting['input_data'],JSON_UNESCAPED_UNICODE);
            } else {
                $input_data = $setting['input_data'];
            }
        } else {
            $input_data = NULL;
        }

        if(!empty($setting['error_data'])){
            if(is_array($setting['error_data']) || is_object($setting['error_data'])){
                $error_data = json_encode($setting['error_data'],JSON_UNESCAPED_UNICODE);
            } else {
                $error_data = $setting['error_data'];
            }
        } else {
            $error_data = NULL;
        }

        $obj->insert([
            'error_module' => $setting['module'],
            'input_data' => $input_data,
            'error_date' => $setting['error_date'],
            'error_msg' => $error_data
        ]);

        return true;
    } catch(Exception $e) {
        return save_log_error([
            'module' => 'save_log_error',
            'input_data' => $setting,
            'error_date' => date('Y-m-d H:i:s'),
            'error_msg' => [
                'error_file' => $e->getFile(),
                'error_line' => $e->getLine(),
                'error_code' => $e->getCode(),
                'error_msg' => $e->getMessage()
            ]
        ]);
    }
}

function create_log_file_path($path = ''){

    $log_path = 'logs/'.$path;
    $dirs = explode('/', $log_path);
    $checked_log_Path = '';
    $pieces = array();

    foreach ($dirs as $dir) {
        if (trim($dir) != '') {
            $pieces[] = $dir;
            $checked_log_Path = implode('/', $pieces);
            if (!is_dir($checked_log_Path)) 
                mkdir($checked_log_Path, 0777, TRUE);
        }
    }

    $log_file_path = $checked_log_Path;

    return $log_file_path;
}

function create_log_file($path,$file_name,$file_content){
    $path = create_log_file_path($path);
    file_put_contents($path.$file_name,$file_content,FILE_APPEND);
}

?>