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
                $path = 'uploads/'.date('Y').'/'.date('m').'/'.date('d');
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

                            session()->set('profile',$result['link']);
                        }
                    }
                }
            };
        } catch(Exception $e){
            save_log_error([
                'module' => 'profile_upload',
                'input_data' => $this->input->getVar(),
                'error_date' => date('Y-m-d H:i:s'),
                'error_msg' => [
                    'error_file' => $e->getFile(),
                    'error_line' => $e->getLine(),
                    'error_code' => $e->getCode(),
                    'error_msg' => $e->getMessage()
                ]
            ]);

            $result = [
                'result' => 'error',
                'message' => ''
                // 'message' => $e->getLine().' : '.$e->getMessage()
            ];
        }

        return $this->response->setJSON($result);
    }

    public function uploadEstimate()
    {
        try {
            $files_log = [];

            if($files = $this->input->getFiles()){
                $obj = new \App\Models\Estimate();
                $input = (object) $this->input->getVar();

                if(empty($input->estimate_id)){
                    $estimate = new \App\Models\Estimate();
                    $estimate->insert([
                        'application_id' => $input->app_id,
                        'question_id' => $input->question_id,
                        'estimate_by' => session()->get('id'),
                        'estimate_name' => session()->get('user'),
                        'status_pre' => 1,
                        'status_onsite' => 1,
                    ]);

                    $estimate_id = $estimate->getInsertID();
                } else {
                    $estimate_id = $input->estimate_id;
                }

                $path = 'uploads/'.date('Y').'/'.date('m').'/'.date('d').'/';
                $path .= 'estimate/'.$estimate_id.'/onsite/'.$input->path.'/';

                $result = [
                    'result' => 'success', 
                    'message' => 'อัพโหลดไฟล์สำเร็จแล้ว', 
                    'estimate_id' => $estimate_id,
                    'files' => []
                ];              

                $files_up = [];

                foreach($files['files'] as $file){
                    if ($file->isValid() && !$file->hasMoved()) {
                        
                        $originalName = $file->getName();
                        $extension = $file->guessExtension();
                        $newName = randomFileName($extension);
                        
                        $file->move(FCPATH.$path, $newName);

                        $tmp_file = array(
                            'file_name' => $newName,
                            'file_original' => $originalName,
                            'file_position' => $input->position,
                            'file_path' => $path.'/'.$newName,
                            'file_size' => $file->getSizeByUnit('mb'),
                        );
                        
                        array_push($files_up,$tmp_file);                             
                        array_push($files_log,$tmp_file);                          

                    }
                } 

                $pack = $obj->where('id',$estimate_id)->select('pack_file')->first();

                if(!empty($pack->pack_file)){
                    $pack_file = json_decode($pack->pack_file);
                    $files_up = array_merge($pack_file,$files_up);
                }

                $obj->update($estimate_id,['pack_file' => json_encode($files_up)]);
                $files_up = json_decode(json_encode($files_up),false);

                foreach($files_up as $file){
                    if($file->file_position == $input->position)
                        array_push($result['files'],$file);
                }
            }
            else {
                $result = ['result' => 'error', 'message' => 'ไม่พบไฟล์ในการอัพโหลด'];
            }              

            save_log_activety([
                'module' => 'estimate_onsite',
                'action' => 'estimate_upload_files',
                'bank' => 'frontend',
                'user_id' => session()->get('id'),
                'datetime' => date('Y-m-d H:i:s'),
                'data' => [
                    'input' => $this->input->getVar(),
                    'files' => $files_log
                ]
            ]);
        } catch(\Exception $e){
            save_log_error([
                'module' => 'estimate_upload_files',
                'input_data' => $this->input->getVar(),
                'error_date' => date('Y-m-d H:i:s'),
                'error_msg' => [
                    'error_file' => $e->getFile(),
                    'error_line' => $e->getLine(),
                    'error_code' => $e->getCode(),
                    'error_msg' => $e->getMessage()
                ]
            ]);

            $result = [
                'result' => 'error',  
                'message' => ''
                // 'message' => 'System : '.$e->getMessage()
            ];
        }

        return $this->response->setJSON($result);
    }

    public function removeEstimate()
    {
        try {
            $obj = new \App\Models\Estimate();
            $input = (object) $this->input->getVar();
            $tmp = [];

            $pack = $obj->where('id',$input->id)->select('pack_file')->first();
            $pack_file = json_decode($pack->pack_file,false);

            if($input->remove == 'fixed'){
                if(unlink(FCPATH.$input->file_path)){
                    $file_name = $input->file_name;
                    $result = ['result' => 'success', 'message' => '', 'files' => []];

                    foreach($pack_file as $file){
                        if($file->file_name != $file_name){
                            array_push($tmp,$file);

                            if($file->file_position == $input->position){
                                array_push($result['files'],$file);
                            }
                        }
                    }

                    $obj->update($input->id,['pack_file' => json_encode($tmp)]);
                } else {
                    $result = ['result' => 'error', 'message' => 'ไม่พบไฟล์นี้ในระบบ'];
                }
            } else {
                $position = $this->input->getVar('position');

                foreach($pack_file as $file){
                    if($file->file_position == $position){
                        unlink(FCPATH.$file->file_path);
                    } else {
                        array_push($tmp,$file);
                    }
                }

                $obj->update($input->id,['pack_file' => json_encode($tmp)]);
                $result = ['result' => 'success', 'message' => ''];
            }      

            save_log_activety([
                'module' => 'estimate_onsite',
                'action' => 'estimate_remove_files',
                'bank' => 'frontend',
                'user_id' => session()->get('id'),
                'datetime' => date('Y-m-d H:i:s'),
                'data' => $this->input->getVar()
            ]);

        } catch(\Exception $e){
            save_log_error([
                'module' => 'estimate_remove_files',
                'input_data' => $this->input->getVar(),
                'error_date' => date('Y-m-d H:i:s'),
                'error_msg' => [
                    'error_file' => $e->getFile(),
                    'error_line' => $e->getLine(),
                    'error_code' => $e->getCode(),
                    'error_msg' => $e->getMessage()
                ]
            ]);

            $result = [
                'result' => 'error', 
                'message' => ''
                // 'message' => 'System : '.$e->getLine().'-'.$e->getMessage()
            ];
        }

        return $this->response->setJSON($result);
    }

    public function dowanloadEstimateFile($id,$position)
    {        
        $obj = new \App\Models\Estimate();
        $data = $obj->where('id',$id)->select('pack_file')->first();
        $files = json_decode($data->pack_file,false);
        $this->setZip('estimate',$position,$files);
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