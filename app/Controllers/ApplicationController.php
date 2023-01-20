<?php 

namespace App\Controllers;
use CodeIgniter\Files\File;
use App\Controllers\BaseController;
use App\Models\ApplicationForm as AppForm;
use App\Models\ApplicationType as AppType;
use App\Models\ApplicationTypeSub as AppTypeSub;

class ApplicationController extends BaseController
{
    private $appForm;
    private $appType;
    private $appSub;
    private $myId;

    private $mapDBFiled = [
        '1' => ['application_type_id','application_type_sub_id','highlights','link',
            'require_lowcarbon'],
        '2' => ['attraction_name_th','attraction_name_en','address_no','address_road',
            'address_sub_district','address_district','address_province','address_zipcode',
            'facebook','instagram','line_id','other_social','google_map'],
        '3' => ['company_name','company_addr_no','company_addr_road','company_addr_sub_district',
            'company_addr_district','company_addr_province','company_addr_zipcode','company_setaddr',
            'mobile','email','line_id'],
        '4' => ['knitter_name','knitter_position','knitter_tel','knitter_email',
            'knitter_line'],
        '5' => ['year_open','year_total','manage_by','buss_license','buss_ckroom','buss_buildExt',
            'buss_cites','admin_nominee','has_outlander','has_effluent']
    ];

    public function __construct()
    {
        $this->appForm = new AppForm();
        $this->appType = new AppType();
        $this->appSub = new AppTypeSub();
        $this->myId = session()->get('id');

        if(!isset($this->db))
            $this->db = \Config\Database::connect();
    }

    public function formIndex()
    {
        $app = new \Config\App();

        $duedate = (object) [
            'expired_date' => $app->APPForm_expired,
            'expired_str' => 'ภายในวันที่ '.FormatTree($app->APPForm_expired,'thailand'),
            'expired_sts' => $app->APPForm_expired <= date('Y-m-d') ? true : false,
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
        $data = $this->getApplication($this->myId);
        return $this->response->setJSON($data);
    }

    public function getApplication($id)
    {
        $detail = $this->appForm->where('created_by',$id)->first();
        $pre_status = 'none';
        $result_status = false;

        if(!empty($detail)){
            if(!empty($detail->pack_file)){
                $detail->pack_file = json_decode($detail->pack_file);
            }
            
            if(!empty($detail->request_time)){
                $request_time = date('Y-m-d',strtotime($detail->request_time.' + 1 day'));
                $detail->request_time_str = FormatTree($request_time,'thailand');

                $current_date = date("Y-m-d H:i:s");
                $expired_date = date("Y-m-d H:i:s", strtotime($detail->request_time."+1 day"));
                if($current_date <= $expired_date){
                    $detail->request_expired = false;
                } else {
                    $detail->request_expired = true;
                }
            }

            if($detail->status == 3){     
                $answer = new \App\Controllers\AnswerController();
                $pre_status = $answer->getPrescreenStatus($this->myId);

                $userStage = new \App\Models\UsersStage();
                $stage = $userStage->where([
                    'user_id' => $this->myId,
                    'stage' => 1
                ])
                ->select('status')
                ->first();

                if(!empty($stage)){
                    if(in_array($stage->status,[6,7])){                        
                        $result_status = true;
                    }
                }
            }

            $result = array(
                'result' => 'success', 
                'pre_status' => $pre_status, 
                'result_status' => $result_status, 
                'data' => $detail
            );
        } else {
            $instData = array(                
                'application_type_id' => 1,
                'application_type_sub_id' => 1,
                'created_by' => $id,
                'updated_by' => $id
            ); 

            $this->appForm->insert($instData);
            $instId = $this->appForm->getInsertID();
            $formCode = date('Ym').'-'.str_pad($instId, 4, '0', STR_PAD_LEFT);
            $this->appForm->update($instId,['code' => $formCode]);

            $result = array(
                'result' => 'success',
                'pre_status' => $pre_status,
                'result_status' => $result_status, 
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
            $input = $this->input->getVar();  
            $step = $input['step'];
            $maps = $this->mapDBFiled[$step];            
            $app_id = $input['id'];
            unset($input['step']);
            unset($input['id']);

            $updd = [
                'step' => $step, 
                'updated_by' => $this->myId,
            ];

            foreach($maps as $map){
                if(array_key_exists($map,$input)){
                    $updd[$map] = $input[$map] != "" ? $input[$map] : NULL;
                }
            }
            
            $this->appForm->update($app_id,$updd);                      

            save_log_activety([
                'module' => 'user_application',
                'action' => 'application_draft',
                'bank' => 'frontend',
                'user_id' => $this->myId,
                'datetime' => date('Y-m-d H:i:s'),
                'data' => $this->input->getVar()
            ]);
            
            $result = ['result' => 'success', 'message' => 'บันทึกร่างแบบฟอร์มเรียบร้อยแล้ว'];

        } catch(\Exception $e){
            save_log_error([
                'module' => 'user_draft_application',
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
            ];
        }

        return $this->response->setJSON($result);
    }

    private function getCurrentStatus($id)
    {
        $form = $this->appForm->where('id',$id)
        ->select('status')
        ->first();
        return !empty($form->status) ? $form->status : 0;
    }

    public function finishApp()
    {

        try{    
            $input = $this->input->getVar();

            $maps = array_merge(
                $this->mapDBFiled['1'],$this->mapDBFiled['2'],
                $this->mapDBFiled['3'],$this->mapDBFiled['4'],
                $this->mapDBFiled['5']
            );
            
            $app_id = $input['id'];
            $status = $this->getCurrentStatus($app_id);

            if(in_array($status,[1,4])){
                $updd = [
                    'step' => $this->input->getVar('step'),
                    'status' => 2,
                    'updated_by' => $this->myId,
                    'send_date' => date('Y-m-d H:i:s')
                ];

                foreach($maps as $map){
                    if(array_key_exists($map,$input)){
                        $updd[$map] = $input[$map] != "" ? $input[$map] : NULL;
                    }
                }
                    
                $this->appForm->update($app_id,$updd);

                save_log_activety([
                    'module' => 'user_application',
                    'action' => 'application_send_sys',
                    'bank' => 'frontend',
                    'user_id' => $this->myId,
                    'datetime' => date('Y-m-d H:i:s'),
                    'data' => $this->input->getVar()
                ]);

                save_log_activety([
                    'module' => 'step_flow_checking',
                    'action' => 'application-'.$app_id,
                    'bank' => 'frontend',
                    'user_id' => $this->myId,
                    'datetime' => date('Y-m-d H:i:s'),
                    'data' => 'ผู้ประกอบการกดส่งใบสมัครประกวด'
                ]);

                $form = $this->appForm->where('id',$app_id)
                    ->select('IFNULL(attraction_name_th,attraction_name_en) place_name',false)
                    ->first();

                set_multi_noti(
                    get_receive_admin(),
                    (object) [
                        'bank' => 'backend'
                    ],
                    (object) [
                        'message' => $form->place_name.' ได้ทำการส่งใบสมัครเข้าสู่ระบบ กรุณาทำการตรวจสอบใบสมัคร',
                        'link' => base_url('awards/result'),
                        'send_date' => date('Y-m-d H:i:s'),
                        'send_by' => $form->place_name
                    ]
                );
                
                helper('semail');
                send_email_frontend((object)[
                    'email' => session()->get('account'),
                    'tycon' => session()->get('user')
                ],'app-wait');
            }

            $result = ['result' => 'success', 'message' => 'บันทึกข้อมูลเรียบร้อยแล้ว'];

        } catch(\Exception $e){
            save_log_error([
                'module' => 'user_send_application',
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
                $files_log = [];

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
                        array_push($files_log,$tmp_file);    
                    }
                }                 

                save_log_activety([
                    'module' => 'user_application',
                    'action' => 'application_upload_file',
                    'bank' => 'frontend',
                    'user_id' => $this->myId,
                    'datetime' => date('Y-m-d H:i:s'),
                    'data' => [
                        'input' => $this->input->getVar(),
                        'files' => $files_log
                    ]
                ]);

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
                $result['files'] = $files_up;
                
            }
             else {
                $result = ['result' => 'error', 'message' => 'ไม่พบไฟล์ในการอัพโหลด'];
            }
        } catch(\Exception $e){
            save_log_error([
                'module' => 'user_application_upload_files',
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
            ];
        }

        return $this->response->setJSON($result);
    }

    private function setFilePath($id)
    {
        $at = $this->appForm->where('id',$id)->select('created_at')->first();
        $year = date('Y',strtotime($at->created_at));
        $month = date('m',strtotime($at->created_at));
        $day = date('d',strtotime($at->created_at));
        $path = 'uploads/'.$year.'/'.$month.'/'.$day.'/'.$this->myId.'/';
        return $path;
    }

    public function removeFiles()
    {

        try{                        

            save_log_activety([
                'module' => 'user_application',
                'action' => 'application_remove_file',
                'bank' => 'frontend',
                'user_id' => $this->myId,
                'datetime' => date('Y-m-d H:i:s'),
                'data' => $this->input->getVar()
            ]);

            $app_id = $this->input->getVar('id');
            $tmp = [];
            $pack_file = $this->appForm->where('id',$app_id)
                ->select('pack_file')
                ->first();

            $pack_file = json_decode($pack_file->pack_file,false);

            if($this->input->getVar('remove') == 'fixed'){
                if(unlink(FCPATH.$this->input->getVar('file_path'))){
                    $file_name = $this->input->getVar('file_name');

                    foreach($pack_file as $file){
                        if($file->file_name != $file_name){
                            array_push($tmp,$file);
                        }
                    }

                    $package_file = !empty($tmp) ? json_encode($tmp) : NULL;
                    $this->appForm->update($app_id,['pack_file' => $package_file]);
                    $result = ['result' => 'success', 'message' => '', 'files' => $tmp];
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

                $package_file = !empty($tmp) ? json_encode($tmp) : NULL;
                $this->appForm->update($app_id,['pack_file' => $package_file]);
                $result = ['result' => 'success', 'message' => ''];
            }
        } catch(\Exception $e){
            save_log_error([
                'module' => 'user_application_remove_files',
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
            ];
        }

        return $this->response->setJSON($result);
    }

    public function getRequireQuestion($uid)
    {
        $require = $this->appForm->select(
                'id app_id,application_type_id type_id, application_type_sub_id sub_type_id'
            )
            ->where('created_by',$uid)
            ->first();
        return $require;
    }

    public function checkRequireLowCarbon($id)
    {
        $require = $this->appForm->where('id',$id)
            ->select('require_lowcarbon')
            ->first();
            
        $require = $require->require_lowcarbon;
        return !empty($require) && $require == 1 ? true : false;
    }
}

?>