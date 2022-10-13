<?php 

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Files\File;
use Exception;

class FilesController extends BaseController
{
    public function __construct(){}

    public function uploadProfile()
    {
        try {
            $id = $this->input->getVar('id');

            if($images = $this->input->getFiles()){
                $path = 'uploads/'.date('Y').'/'.date('d').'/'.date('m');
                foreach($images['image'] as $image){
                    if($image->isValid() && !$image->hasMoved()){
                        $extension = $image->guessExtension();
                        $name = 'profile_'.$id.'_'.randomFileName($extension);
                        $full_path = $path.'/'.$name;

                        if($image->move(FCPATH.$path, $name)){
                            $obj = new \App\Models\Users();                        
                            $user = $obj->where('id',$id)->select('profile')->first();

                            if(!empty($user->profile)){
                                unlink(FCPATH.$user->profile);
                            }

                            $obj->update($id,['profile' => $full_path]);
                            $result = [
                                'result' => 'success',
                                'link' => base_url($full_path)
                            ];
                        }
                    }
                }
            };
        } catch(Exception $e){
            $result = [
                'result' => 'error',
                'message' => $e->getLine().' : '.$e->getMessage()
            ];
        }

        return $this->response->setJSON($result);
    }

    public function downloadApplicationFile($id,$position)
    {
        $obj = new \App\Models\ApplicationForm();
        $data = $obj->where('id',$id)->select('pack_file')->first();
        $files = json_decode($data->pack_file,false);
        $this->setZip('application',$position,$files);
    }

    public function downloadAnswerFile($id,$position)
    {
        $obj = new \App\Models\Answer();
        $data = $obj->where('id',$id)->select('pack_file')->first();
        $files = json_decode($data->pack_file,false);
        $this->setZip('prescreen',$position,$files);    
    }

    private function setZip($sys,$position,$files)
    {
        $zip = new \ZipArchive();
        
        $tmp_file = "{$sys}_paper_".date('Ymd');
        $zip->open($tmp_file, \ZipArchive::CREATE);
        
        foreach($files as $file){
            if($file->file_position == $position){
                $file_fullpath = FCPATH.$file->file_path;
                $download_file = file_get_contents($file_fullpath);
                $zip->addFromString($file->file_original,$download_file);
            }
        }

        $zip->close();
        
        header('Content-disposition: attachment; filename='.$tmp_file.'.zip');
        header('Content-type: application/zip');
        readfile($tmp_file);

        if (file_exists($tmp_file)) {
            unlink($tmp_file);	
        }
    }

}

?>