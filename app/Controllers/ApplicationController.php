<?php 

namespace App\Controllers;
use CodeIgniter\Files\File;
use CodeIgniter\Files\FileCollection;
use App\Controllers\BaseController;
use App\Models\ApplicationForm as AppForm;
use App\Models\ApplicationType as AppType;
use App\Models\ApplicationTypeSub as AppTypeSub;
use App\Models\ApplicationFiles as AppFiles;

class ApplicationController extends BaseController
{
    private $validRules = [
        'step1' => 'appregister.step1',
        'step2' => 'appregister.step2',
        'step3' => 'appregister.step3',
        'step4' => 'appregister.step4',
        'step5' => 'appregister.step5',
        'finish' => 'appregister.finish'
    ];

    private $mapDBFiled = [
        'step1' => ['application_type_id','application_type_sub_id','desc','link'],
        'step2' => ['attraction_name_th','attraction_name_en','address_no','address_road',
            'address_sub_district','address_district','address_province','address_zipcode',
            'facebook','instagram','line_id','other_social'],
        'step3' => ['company_name','company_addr_no','company_addr_road','company_addr_sub_district',
            'company_addr_district','company_addr_province','company_addr_zipcode',
            'mobile','email','line_id'],
        'step4' => ['knitter_name','knitter_position','knitter_tel','knitter_email',
            'knitter_line'],
        'step5' => ['year_open','year_total','manage_by']
    ];

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
            $temp = $this->input->getVar('step');
            $step = $temp != 'finish' ? 'step'.$temp : $temp;
            $rules = $this->validRules[$step];
            $input = $this->input->getVar();
            $valid = $this->validation->run($input,$rules);

            if($valid){

                if($step != 'finish')
                    $maps = $this->mapDBFiled[$step];
                else {
                    $map = array_merge(
                        $this->mapFiled['step1'],$this->mapFiled['step2'],
                        $this->mapFiled['step3'],$this->mapFiled['step4'],
                        $this->mapFiled['step5']
                    );
                }
                
                $app_id = $input['id'];
                $updd = [
                    'step' => $step != 'finish' ? $step : 5, 
                    'status' => $input['status'],
                    'updated_by' => session()->get('id'),
                ];

                foreach($maps as $map){
                    $updd[$map] = $input[$map];
                }

                $update = $this->appForm->update($app_id,$updd);
                $result = ['result' => 'success', 'message' => '', 'files' => []];

                $ipf = [
                    'step1' => ['detailFiles','paperFiles'],
                    'step5' => ['landOwnerFiles','businessCertFiles','otherCertFiles'],
                    'accept' => ['jpg','jpeg','gif','png','webp','pdf','doc','docx']
                ];

                if(in_array($step,[1,2,'finish'])){
                    if($files = $this->input->getFiles()){
                        if($step != 'finish')
                            $mapFile = (object) $ipf[$step];
                        else $mapFile = (object) array_merge($ipf['step1'],$ipf['step2']);

                        $path = 'uploads/app-register/'.session()->get('id').'/paper';

                        foreach($mapFile as $map){
                            if(isset($files[$map]) && !empty($files[$map])){
                                foreach($files[$map] as $file){
                                    if($file->isValid() && !$file->hasMoved()){
                                        $originalName = $file->getName();
                                        $extension = $file->guessExtension();
                                        $newName = $this->randomFileName($extension);

                                        if(in_array($extension,$ipf['accept'])){
                                            $file->move(FCPATH.$path, $newName);

                                            $instData = array(
                                                'application_id' => $app_id,
                                                'file_name' => $newName,
                                                'file_original' => $originalName,
                                                'file_position' => $map,
                                                'file_path' => $path.'/'.$newName
                                            );
                                        
                                            $this->appFiles->insert($instData);
                                            $instId = $this->appFiles->getInsertID();
                                            
                                            $instData['id'] = $instId;
                                            unset($instData['application_id']);
                                            array_push($result['files'],$instData);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }

            } else {
                $error = [];                
                foreach($input as $key=>$value){
                    if(!empty($this->validation->getError($key)))
                        array_push($error,['api' => $key, 'e' => $this->validation->getError($key)]);
                }

                $result = [
                    'result' => 'error', 
                    'message' => 'กรุณาตรวจทานข้อมูลอีกครั้ง',
                    'error' => $error
                ];
            }

        } catch(\Exception $e){
            $result = [
                'result' => 'error', 
                'message' => 'System : '.$e->getMessage(),
                'error' => []
            ];
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

                        $path = 'uploads/app-register/'.session()->get('id').'/images';
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
                    $result = ['result' => 'error', 'message' => 'กรุณาตรวจสอบไฟล์ที่คุณอัพโหลด'];
                }
            }
             else {
                $result = ['result' => 'error', 'message' => 'ไม่พบไฟล์ในการอัพโหลด'];
            }
        } catch(\Exception $e){
            $result = ['result' => 'error', 'message' => 'System : '.$e->getMessage()];
        }

        return $this->response->setJSON($result);
    }

    private function randomFileName($type)
    {
        return date('Ymd').'_'.bin2hex(random_bytes(6)).'.'.$type;
    }

    public function removeFiles()
    {
        checkLoggedIn();

        try{
            $files = new FileCollection();

            if($files->removeFile(FCPATH.$this->innput->getVar('path'))){
                $this->appFile->delete($this->input->getVar('id'));
                $result = ['result' => 'success', 'message' => ''];
            } else {
                $result = ['result' => 'error', 'message' => 'ไม่พบไฟล์นี้ในระบบ'];
            }
        } catch(\Exception $e){
            $result = ['result' => 'error', 'message' => 'System : '.$e->getMessage()];
        }

        return $this->response->setJSON($result);
    }
}

?>