<?php 

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ApplicationForm as AppForm;

class FilesController extends BaseController
{
    public function __construct()
    {
        
    }

    public function downloadApplicationFile($id,$positiion)
    {
        $obj = new AppForm();
        $data = $obj->where('id',$id)->select('pack_file')->first();
        $files = json_decode($data->pack_file,false);

        foreach($files as $file){
            if($file->file_position == $positiion){
                $file_fullpath = FCPATH.$file->file_path;
                $file_name = $file->file_original;

                header('Expires: 0');
                header('Pragma: public');
                header('Cache-Control: must-revalidate');
                header('Content-Length: ' . filesize($file_fullpath));
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="'.$file_name.'"');
                readfile($file_fullpath);
            }
        }
    
    }

}

?>