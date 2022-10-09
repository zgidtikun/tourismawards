<?php 

namespace App\Controllers;
use CodeIgniter\Files\File;
use CodeIgniter\Files\FileCollection;
use App\Controllers\BaseController;
use App\Models\ApplicationForm as AppForm;
use App\Models\ApplicationType as AppType;
use App\Models\ApplicationTypeSub as AppTypeSub;
class ApplicationController extends BaseController
{

    private $mapDBFiled = [
        '1' => ['application_type_id','application_type_sub_id','highlights','link'],
        '2' => ['attraction_name_th','attraction_name_en','address_no','address_road',
            'address_sub_district','address_district','address_province','address_zipcode',
            'facebook','instagram','line_id','other_social','google_map'],
        '3' => ['company_name','company_addr_no','company_addr_road','company_addr_sub_district',
            'company_addr_district','company_addr_province','company_addr_zipcode',
            'mobile','email','line_id'],
        '4' => ['knitter_name','knitter_position','knitter_tel','knitter_email',
            'knitter_line'],
        '5' => ['year_open','year_total','manage_by','buss_license','buss_ckroom',
            'buss_cites','admin_nominee','has_outlander']
    ];

    public function __construct()
    {
        $this->appForm = new AppForm();
        $this->appType = new AppType();
        $this->appSub = new AppTypeSub();

        if(!isset($this->db))
            $this->db = \Config\Database::connect();
    }

    public function formIndex()
    {
        $app = new \Config\App();
        $duedate = (object) [
            'expired_date' => $app->APPForm_expired,
            'expired_str' => 'ภายในวันที่ '.FormatTree($app->APPForm_expired,'thailand')
        ];

        $data = [
            'title' => 'Application Form',
            'view' => 'frontend/entrepreneur/application',
            'duedate' => $duedate
        ];

        return view('frontend/entrepreneur/_template',$data);
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
        $data = $this->getApplication(session()->get('id'));
        return $this->response->setJSON($data);
    }

    public function getApplication($id)
    {
        $detail = $this->appForm->where('created_by',$id)->first();

        if($detail){
            if(!empty($detail->pack_file))
                $detail->pack_file = json_decode($detail->pack_file);
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
                    'pack_file' => array()
                )
            );
        }

        return (object) $result;
    }

    public function draftApp()
    {

        try{    
            $step = $this->input->getVar('step');
            $input = $this->input->getVar();
            $maps = $this->mapDBFiled[$step];            
            $app_id = $input['id'];

            $updd = [
                'step' => $step, 
                'status' => 1,
                'updated_by' => session()->get('id'),
            ];

            foreach($maps as $map){
                $updd[$map] = $input[$map];
            }

            $update = $this->appForm->update($app_id,$updd);
            $result = ['result' => 'success', 'message' => 'บันทึกร่างแบบฟอร์มเรียบร้อยแล้ว'];

        } catch(\Exception $e){
            $result = [
                'result' => 'error', 
                'message' => 'Line : '.$e->getLine().' : '.$e->getMessage()
            ];
        }

        return $this->response->setJSON($result);
    }

    public function finishApp()
    {

        try{    
            $step = $this->input->getVar('step');
            $input = $this->input->getVar();

            $map = array_merge(
                $this->mapFiled['step1'],$this->mapFiled['step2'],
                $this->mapFiled['step3'],$this->mapFiled['step4'],
                $this->mapFiled['step5']
            );
            
            $app_id = $input['id'];
            $updd = [
                'step' => 'finish', 
                'status' => 2,
                'updated_by' => session()->get('id'),
            ];

            foreach($maps as $map){
                $updd[$map] = $input[$map];
            }

            $update = $this->appForm->update($app_id,$updd);
            $result = ['result' => 'success', 'message' => 'บันทึกข้อมูลเรียบร้อยแล้ว'];

        } catch(\Exception $e){
            $result = [
                'result' => 'error', 
                'message' => 'Line : '.$e->getLine().' : '.$e->getMessage()
            ];
        }

        return $this->response->setJSON($result);
    }

    public function uploadFiles()
    {

        try{
            if($files = $this->input->getFiles()){
                $app_id = $this->input->getVar('id');
                $path = $this->setFilePath($app_id).'app-register/'.$this->input->getVar('path');
                $result = ['result' => 'success', 'message' => 'อัพโหลดไฟล์สำเร็จแล้ว', 'files' => []];
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
                            'file_position' => $this->input->getVar('position'),
                            'file_path' => $path.'/'.$newName,
                            'file_size' => $file->getSizeByUnit('mb'),
                        );
                        
                        array_push($files_up,$tmp_file);                            

                    }
                } 

                $pack_file = $this->appForm->where('id',$app_id)
                    ->select('pack_file')
                    ->first();
                
                if(!empty($pack_file->pack_file)){
                    $pack_file = json_decode($pack_file->pack_file);
                    $updd = array_merge($pack_file,$files_up);
                } else {
                    $updd = $files_up;
                }

                $this->appForm->update($app_id,['pack_file' => json_encode($updd)]);
                $result['files'] = $updd;
                
            }
             else {
                $result = ['result' => 'error', 'message' => 'ไม่พบไฟล์ในการอัพโหลด'];
            }
        } catch(\Exception $e){
            $result = ['result' => 'error', 'message' => 'System : '.$e->getMessage()];
        }

        return $this->response->setJSON($result);
    }

    private function setFilePath($id)
    {
        $at = $this->appForm->where('id',$id)->select('created_at')->first();
        $year = date('Y',strtotime($at->created_at));
        $month = date('m',strtotime($at->created_at));
        $day = date('d',strtotime($at->created_at));
        $path = 'uploads/'.$year.'/'.$month.'/'.$day.'/'.session()->get('id').'/';
        return $path;
    }

    public function removeFiles()
    {

        try{
            $files = new FileCollection();
            $app_id = $this->input->getVar('id');
            $tmp = [];
            $pack_file = $this->appForm->where('id',$app_id)
                ->select('pack_file')
                ->first();

            $pack_file = json_decode($pack_file->pack_file,false);

            if($this->input->getVar('remove') == 'fixed'){
                if($files->removeFile(FCPATH.$this->input->getVar('file_path'))){
                    $file_name = $this->input->getVar('file_name');

                    foreach($pack_file as $file){
                        if($file->file_name != $file_name){
                            array_push($tmp,$file);
                        }
                    }

                    $this->appForm->update($app_id,['pack_file' => json_encode($tmp)]);
                    $result = ['result' => 'success', 'message' => '', 'files' => $tmp];
                } else {
                    $result = ['result' => 'error', 'message' => 'ไม่พบไฟล์นี้ในระบบ'];
                }
            } else {
                $position = $this->input->getVar('position');

                foreach($pack_file as $file){
                    if($file->file_position == $position){
                        $files->removeFile(FCPATH.$file->file_path);
                    } else {
                        array_push($tmp,$file);
                    }
                }

                $this->appForm->update($app_id,['pack_file' => json_encode($tmp)]);
                $result = ['result' => 'success', 'message' => '', 'files' => $tmp];
            }
        } catch(\Exception $e){
            $result = ['result' => 'error', 'message' => 'System : '.$e->getLine().'-'.$e->getMessage()];
        }

        return $this->response->setJSON($result);
    }

    public function getRequireQuestion($uid)
    {
        $require = $this->appForm->select('application_type_id type_id,application_type_sub_id sub_type_id')
            ->where('created_by',$uid)
            ->first();
        return $require;
    }
}

?>