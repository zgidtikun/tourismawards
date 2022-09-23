<?php 

namespace App\Controllers;
use CodeIgniter\Files\File;
use App\Controllers\BaseController;
use App\Models\ApplicationForm as AppForm;
use App\Models\ApplicationType as AppType;
use App\Models\ApplicationTypeSub as AppTypeSub;
use App\Models\ApplicationFiles as AppFiles;

class ApplicationController extends BaseController
{
    public function __construct()
    {
        $this->appForm = new AppForm();
        $this->appType = new AppType();
        $this->appSub = new AppTypeSub();
        $this->appFiles = new AppFiles();

        if(!isset($this->db))
            $this->db = \Config\Database::connect();
    }

    public function formIndex()
    {
        $data = [
            'title' => 'Application Form',
            'view' => 'frontend/app-form'
        ];

        return view('template-frontend',$data);
    }

    public function getAppTypeAndSubAllByAjax()
    {
        $data = $this->getAppTypeAndSubAll();
        return $this->response->setJSON($data);
    }   

    public function getAppTypeAndSubAll()
    {
        $result = array(
            'main' => $this->appType->findAll(),
            'sub' =>  $this->appSub->findAll()
        );

        return (object) $result;
    }

    public function getApplicationByAjax()
    {
        checkLoggedIn();
        $data = $this->getApplication(session()->get('id'));
        return $this->response->setJSON($data);
    }

    public function getApplication($id)
    {
        $detail = $this->appForm->where('created_by',$id)->first();

        if($detail){
            $files = $this->appFiles->where('application_id',$detail->id)->findAll();
            $detail->files = !empty($files) ? $files : array();
            $result = array('result' => 'success', 'data' => $detail);
        } else {
            $instData = array(                
                'application_type_id' => 1,
                'application_type_sub_id' => 1,
                'created_by' => $id,
                'updated_by' => $id
            ); 

            $inst = $this->appForm->insert($instData);
            $instId = $this->appForm->getInsertID();
            $formCode = date('Ym').'-'.str_pad($instId, 4, '0', STR_PAD_LEFT);
            $this->appForm->update($instId,['code' => $formCode]);

            $result = array(
                'result' => 'success',
                'data' => (object) array(
                    'id' => $instId,
                    'application_type_id' => 1,
                    'application_type_sub_id' => 1,
                    'manage_by' => 1,
                    'current_step' => 1,
                    'status' => 1,
                    'files' => array()
                )
            );
        }

        return (object) $result;
    }

    public function draftApp()
    {
        checkLoggedIn();

        try{

        } catch(\Exception $e){
            $result = array('result' => 'error', 'message' => 'System : '.$e->getMessage());
        }

        return $this->response->setJSON($result);
    }

    public function uploadImages()
    {
        checkLoggedIn();

        try{

            if($imagefile = $this->input->getFiles()){
                $app_id = $this->input->getVar('id');
                $step = $this->input->getVar('step');
                $position = $this->input->getVar('position');
                $result = array('result' => 'success', 'images' => array());                
                $totalImage = 0;
                $countUpload = 0;

                foreach($imagefile['images'] as $img){
                    $totalImage++;
                    if ($img->isValid() && !$img->hasMoved()) {

                        $path = 'uploads/app-register/'.session()->get('id');
                        $originalName = $img->getName();
                        $extension = $img->guessExtension();
                        $newName = $this->randomFileName($extension);
                        $accept = array('jpg','jpeg','gif','png','webp');

                        if(in_array($extension,$accept)){
                            $img->move(FCPATH.$path, $newName);
                            $countUpload++;

                            $instData = array(
                                'application_id' => $app_id,
                                'file_name' => $newName,
                                'file_original' => $originalName,
                                'file_step' => $step,
                                'file_position' => $position,
                                'file_path' => $path.'/'.$newName
                            );
                        
                            $this->appFiles->insert($instData);
                            $instId = $this->appFiles->getInsertID();
                            
                            $instData['id'] = $instId;
                            unset($instData['application_id']);
                            array_push($result['images'],$instData);
                        }

                    }
                } 
                
                if($countUpload > 0){
                    $result['upload_c'] = $countUpload;
                    $result['message'] = 'อัโหลดรูปสำเร็จแล้ว '.$countUpload.' รูป';
                } else {
                    $result = array('result' => 'error', 'message' => 'กรุณาตรวจสอบไฟล์ที่คุณอัพโหลด');
                }
            }
             else {
                $result = array('result' => 'error', 'message' => 'ไม่พบไฟล์ในการอัพโหลด');
            }
        } catch(\Exception $e){
            $result = array('result' => 'error', 'message' => 'System : '.$e->getMessage());
        }

        return $this->response->setJSON($result);
    }

    private function randomFileName($type)
    {
        return date('Ymd').'_'.bin2hex(random_bytes(6)).'.'.$type;
    }
}

?>