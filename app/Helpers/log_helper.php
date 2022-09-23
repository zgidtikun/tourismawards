<?php 

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