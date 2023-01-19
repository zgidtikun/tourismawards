<?php 
use PHPMailer\PHPMailer\PHPMailer;

function send_email($dataset)
{
    $email = new semail();
    $result = $email->SendMail($dataset);
    return $result;
}

function send_email_frontend($dataset, $by)
{
    $email = new semail();
    $result = $email->SetEmailFrontend($dataset, $by);
    return $result;
}

class semail {
    private $mail;
    private $config;

    public function __construct()
    {        
        $this->mail = new PHPMailer(true);
        $this->config = new \Config\Email();
    }
    
    public function SendMail($requestEmail=[])
    {
        
        if(!$requestEmail || count($requestEmail) <= 0){
            return ['status'=> false, 'message'=>'Invalid email data.'];
        }

        if(
            !array_key_exists('to', $requestEmail) 
            || !array_key_exists('subject', $requestEmail) 
            || !array_key_exists('message', $requestEmail)
        ){
            return ['status'=> false, 'message'=>'Invalid email data, required [to|subject|message] value.'];
        }

        if(
            (is_string($requestEmail['to']) && @trim($requestEmail['to']) == '') 
            || (is_array($requestEmail['to']) && @count($requestEmail['to']) == 0) 
            || @$requestEmail['subject'] == '' || @$requestEmail['message'] == ''
        ){
            return ['status'=> false, 'message'=>'Invalid email data.'];
        }
        
        try {
            
            $this->mail->SMTPDebug = 0;
            $this->mail->isSMTP();
            $this->mail->CharSet = $this->config->charset;
            $this->mail->Host = $this->config->SMTPHost;
            $this->mail->SMTPAuth = true;
            $this->mail->Username = $this->config->SMTPUser;
            $this->mail->Password = $this->config->SMTPPass;
            $this->mail->SMTPSecure = 'tls';
            $this->mail->Port = $this->config->SMTPPort;
            $this->mail->Subject = $requestEmail['subject'];
            $this->mail->Body = $requestEmail['message'];
            
            if(is_array($requestEmail['to'])){
                foreach($requestEmail['to'] as $address){
                    if(trim($address)!=''){
                        $this->mail->addAddress(trim($address));
                    }
                }                
            }else{
                $this->mail->addAddress(trim($requestEmail['to']));
            }
            
            
            if(array_key_exists('from', $requestEmail)){
                if(array_key_exists('email', $requestEmail['from']) && @trim($requestEmail['from']['email'])!=''){
                    $fromEmail = $requestEmail['from']['email'];
                    
                    if(array_key_exists('name', $requestEmail['from']) && @trim($requestEmail['from']['name'])!=''){
                        $fromName = $requestEmail['from']['name'];
                    }else{
                        $fromName = $fromEmail;
                    }
                    
                    $this->mail->setFrom($fromEmail, $fromName);
                }
           }else{
                $this->mail->setFrom(
                    $this->config->SenderEmail, 
                    $this->config->SenderName
                );
            }
            
            if(array_key_exists('cc', $requestEmail)){
                if(is_array($requestEmail['cc'])){
                    foreach($requestEmail['cc'] as $cc){
                        if(trim($cc)!=''){
                            $this->mail->addCC(trim($cc));
                        }
                    }  
                }                                  
            }

            if(array_key_exists('bcc', $requestEmail)){
                if(is_array($requestEmail['bcc'])){
                    foreach($requestEmail['bcc'] as $bcc){
                        if(trim($bcc)!=''){
                            $this->mail->addBCC(trim($bcc));
                        }
                    }  
                }                                  
            }

            $this->mail->addBCC('kritsana@chaiyohosting.com');
            $this->mail->addBCC('makoto_pb@hotmail.com');
                        
            $this->mail->isHTML(true);

            if (!$this->mail->send()) {
                return ['status'=> false, 'message' => 'Something went wrong. Please try again.'];
            } else {
                return ['status'=> true, 'message' => 'Email sent successfully.'];
            }
        } catch (Exception $e) {
            return [
                'status'=> false, 
                'message'=>'Something went wrong. Please try again.',
                'error' => $e
            ];
        }
    }

    public function SetEmailFrontend($dataset, $by)
    {
        try {
    
            if(getenv('CI_ENVIRONMENT') != 'production'){
                $email_ct = 's.gidtikun@gmail.com';
            } else {
                $email_ct = 'tourismawards.tat@gmail.com';
            }

            $email_sys = [
                'email' => $this->config->SenderEmail,
                'name'  => $this->config->SenderName
            ];
    
            switch($by){
                case 'register':
                    $_message = view('template-frontend-email',[
                        '_header' => 'ยืนยันตัวตนการเข้าร่วมประกวด',
                        '_content' => '<p>กรุณายืนยันตัวตนของท่านผ่านทางอีเมล เพื่อทำการล็อกอินเข้าสู่เว็บไซต์ '
                            . 'ท่านจำเป็นต้องยืนยันตัวตนภายใน 24 ชั่วโมง</p>'
                            . '<p>โปรดยืนยันตัวตนด้วยการกดที่ลิงก์นี้ '
                            . '<b><a href="'.base_url('verify-user?c='.$dataset->verify_token).'" target="_blank">'
                            . 'ยืนยันตัวตน</a></b></p>'
                    ]);
                    
                    $_subject = 'ยืนยันตัวตนการเข้าร่วมประกวด';
                    $_to = $dataset->email;
                    $_from = $email_sys;
                    $_cc = [];
                    $_bcc = ['zgidtikun@gmail.com'];
                break;
                case 'reset-pass':
                    $_recipient = $dataset->name.' '.$dataset->surname;     
                    $_token = urlencode($dataset->verify_code.$dataset->id);
                    $_message = view('template-frontend-email',[
                        '_header' => 'เรียน คุณ'.$_recipient,
                        '_content' => '<p>ท่านได้ส่งคำร้องขอในการเปลี่ยนรหัสผ่าน กรุณากดปุ่มด้านล่างเพื่อทำการเปลี่ยนรหัสผ่าน<p>'
                            . '<p><b><a href="'.base_url('new-password/'.$_token)
                            . '" target="_blank">เปลี่ยนรหัสผ่าน</a></b></p>'
                    ]);
    
                    $_subject = 'Thailand Tourism Awards - Forget Password';
                    $_from = $email_sys;
                    $_to = $dataset->email;
                    $_cc = [];
                    $_bcc = ['zgidtikun@gmail.com'];
                break;
                case 'contact':
                    $input = (object) $dataset;
    
                    $_message = view('template-frontend-email',[
                        '_header' => '',
                        '_content' => '<p>'.$input->message.'</p><br>'
                            . '<p>ผู้ติดต่อ<br>'
                            . 'คุณ '.$input->name.'<br>'
                            . 'อีเมล '.$input->email.'</p>'
                    ]);
                    
                    $_subject = 'ติดต่อเรื่อง '.$input->subject;
                    $_to = $email_ct;
                    $_from = $email_sys;
                    $_cc = [];
                    $_bcc = ['zgidtikun@gmail.com'];
                break;
                case 'app-wait':
                    $_message = view('template-frontend-email',[
                        '_header' => 'เรียน คุณ'.$dataset->tycon,
                        '_content' => '<p>ท่านส่งใบสมัครเรียบร้อยแล้ว ใบสมัครของท่านอยู่ระหว่างการดำเนินการตรวจสอบข้อมูล '
                            . 'กรุณารอผลการตรวจสอบข้อมูลภายใน 7 วัน</p>'
                    ]);
                    
                    $_subject = 'แจ้งการรับแบบฟอร์มการสมัครเข้ารับการพิจารณา';
                    $_to = $dataset->email;
                    $_from = $email_sys;
                    $_cc = [];
                    $_bcc = ['zgidtikun@gmail.com'];                    
                break;
                case 'app': 
                    $tycoon = $this->getTycoon($dataset->app_id);
                    $_header = 'แจ้งการส่งใบสัครเข้าระบบ';
                    $_message = view('template-frontend-email',[
                        '_header' => $_header,
                        '_content' => $tycoon->place 
                            . ' ได้ทำการส่งใบสมัครเข้าสู่ระบบ กรุณาเข้าสู่ระบบเพื่อทำการตรวจสอบใบสมัคร'
                    ]);
    
                    $_subject = $_header;
                    $_to = [];
                    $_from = $email_sys;
                    $_cc = [];
                    $_bcc = ['zgidtikun@gmail.com'];
                    
                    $list_admin = $this->getAdmin();
                    $list_ttt = $this->getTTT($dataset->type,'');
                    
                    if(!empty($list_admin)){
                        foreach($list_admin as $admin){
                            array_push($_to,$admin->email);
                        }
                    }

                    if(!empty($list_ttt)){
                        foreach($list_ttt as $ttt){
                            array_push($_to,$ttt->email);
                        }
                    }
                break;
                case 'answer-complete':                    
                    $_header = 'การส่งแบบประเมินขั้นต้น';
                    $_message = view('template-frontend-email',[
                        '_header' => $_header,
                        '_content' => 'ท่านส่งแบบประเมินขั้นต้น (Pre-Screen) เรียบร้อยแล้ว กรุณาติดตามผลการประเมินทางอีเมล หรือเว็บไซต์'
                    ]);
    
                    $_subject = $_header;
                    $_to = $dataset->email;
                    $_from = $email_sys;
                    $_cc = [];
                    $_bcc = ['zgidtikun@gmail.com'];
                break;
                case 'answer-request-complete':
                    $_header = 'ตอบกลับการขอข้อมูลเพิ่มเติม';
                    $_content = "$dataset->tycon ได้ส่งคำตอบการประเมินเบื้องต้น (Pre-Screen) เพิ่มเติมกลับมาเรียบร้อยแล้ว "
                        . "จึงขอให้ท่านคณะกรรมการกรุณาล็อกอินเข้าสู่เว็บไซต์ เพื่อทำการประเมินเบื้องต้น (Pre-Screen) อีกครั้ง";
                    
                    $_message = view('template-frontend-email',[
                        '_header' => $_header,
                        '_content' => $_content
                    ]);

                    $_subject = 'แจ้งการ'.$_header;
                    $_to = [];
                    $_from = $email_sys;
                    $_cc = [];
                    $_bcc = ['zgidtikun@gmail.com'];
                    
                    $judge = $this->getUser($dataset->appId);                    
                    
                    if(!empty($judge)){
                        foreach($judge as $user){
                            array_push($_to,$user->email);
                        }
                    }      
                break;
                case 'answer-request-expired':
                    $tycoon = $this->getTycoon($dataset->appId);
                    $_header = 'ไม่มีการตอบกลับการขอข้อมูลเพิ่มเติม';
                    $_content = "$tycoon->place ได้หมดเวลาการส่งคำตอบการประเมินเบื้องต้น (Pre-Screen) เพิ่มเติม "
                        . "จึงขอให้ท่านคณะกรรมการกรุณาล็อกอินเข้าสู่เว็บไซต์ เพื่อทำการประเมินเบื้องต้น (Pre-Screen) อีกครั้ง";
                    
                    $judge = $this->getUser($dataset->judgeId);   

                    $_subject = 'แจ้งการ'.$_header;
                    $_to = $judge->email;
                    $_from = $email_sys;
                    $_cc = [];
                    $_bcc = ['zgidtikun@gmail.com'];    
                break;
                case 'estimate-request':
                    $user = $this->getUser($dataset->id);  
                    $_header = 'ขอข้อมูลเพิ่มเติม';                
                    $_message = view('template-frontend-email',[
                        '_header' => $_header,
                        '_content' => '<p>คณะกรรมการมีการขอข้อมูลเพิ่มเติม แบบประเมินของท่าน '
                        . 'กรุณาล็อกอินเข้าสู่เว็บไซต์เพื่อตรวจสอบการขอข้อมูล และส่งข้อมูลตอบกลับภายใน 3 วัน</p>'
                    ]);
    
                    $_subject = 'แจ้งการขอข้อมูลเพิ่มเติมในขั้นตอนการประเมินเบื้องต้น';
                    $_to = $user->email;
                    $_from = $email_sys;
                    $_cc = [];
                    $_bcc = ['zgidtikun@gmail.com'];    
                break;
                case 'estimate-complete':
                    $user = $this->getUser($dataset->id);
                    $_stage = $dataset->stage == 1 ? 'ประเมินขั้นต้น' : 'ลงพื้นที่';

                    $_header = 'ผลการประเมินรอบ '.$_stage;
                    $_content = '<p>เรียน คุณ'.$user->fullname.'</p><br>';

                    if($dataset->stage == 1){
                        $_content .= '<p>ท่านส่งแบบประเมินขั้นต้น (Pre-Screen) เรียบร้อยแล้ว '
                            . 'กรุณาติดตามผลการประเมินทางอีเมล หรือเว็บไซต์</p>';
                    } else {
                        $_content.= '<p>แบบประเมินของท่าน ได้รับการประเมินเรียบร้อยแล้ว'
                            . ' กรุณาติดตามผลการประเมินทางอีเมล หรือเว็บไซต์</p>';
                    }
                    
                    $_message = view('template-frontend-email',[
                        '_header' => $_header,
                        '_content' => $_content
                    ]);
    
                    $_subject = 'แจ้ง'.$_header;
                    $_to = $user->email;
                    $_from = $email_sys;
                    $_cc = [];
                    $_bcc = ['zgidtikun@gmail.com']; 
                break;
                case 'estimate-complete-sys':                 
                    $tycoon = $this->getTycoon($dataset->appId);
                    
                    $_stage = $dataset->stage == 1 ? 'ประเมินขั้นต้น' : 'ลงพื้นที่';
                    $_header = 'การประเมินรอบ '.$_stage.' เสร็จสิ้นแล้ว';
                    $_content = '<p>'.$tycoon->place;

                    if($dataset->stage == 1){
                        $_content .= ' ได้ผ่านการประเมินรอบขั้นต้น (Pre-Screen)'
                            . ' กรุณาเข้าสู่ระบบเพื่อทำการมอบหมายกรรมการเพื่อประเมิน รอบลงพื้นที่</p>';
                    } else {
                        $_content.= ' ได้รับการประเมินรอบขั้นต้น (Pre-Screen) และรอบลงพื้นที่'
                            . ' จากกรรรมการเรียบร้อยแล้ว</p>';
                    }
                    
                    $_message = view('template-frontend-email',[
                        '_header' => $_header,
                        '_content' => $_content
                    ]);
    
                    $_subject = 'แจ้ง'.$_header;
                    $_to = [];
                    $_from = $email_sys;
                    $_cc = [];
                    $_bcc = ['zgidtikun@gmail.com']; 
                                        
                    $list_admin = $this->getAdmin();
                    $list_ttt = $this->getTTT('',$dataset->appId);
                    
                    if(!empty($cmt)){
                        foreach($cmt as $user){
                            array_push($_to,$user->email);
                        }
                    }

                    if(!empty($list_ttt)){
                        foreach($list_ttt as $ttt){
                            array_push($_to,$ttt->email);
                        }
                    }
                break;
                default:
                    return [ 'result' => 'error', 'message' => 'No case to send email.' ];
                break;
            }
    
            $_set = [
                'to' => $_to,
                'from' => $_from,
                'cc' => $_cc,
                'bcc' => $_bcc,
                'subject' => $_subject,
                'message' => $_message,
            ];
            
            $_status = $this->SendMail($_set);
            $result = [ 'result' => $_status ? 'success' : 'error' ];
            
            return $result;
        } catch(Exception $e){
            helper('semail');
            save_log_error([
                'module' => 'helper_send_email',
                'input_data' => '',
                'error_date' => date('Y-m-d H:i:s'),
                'error_msg' => [
                    'error_file' => $e->getFile(),
                    'error_line' => $e->getLine(),
                    'error_code' => $e->getCode(),
                    'error_msg' => $e->getMessage()
                ]
            ]);
            return [ 'result' => false,  'message' => $e ];
        }
    }

    private function getUser($id)
    {        
        $obj_user = new \App\Models\Users();
        $user = $obj_user->where('id',$id)
            ->select('email, CONCAT(name,\' \',surname) fullname',false)
            ->first();
        return $user;
    }

    private function getTycoon($id)
    {
        
        $db = \Config\Database::connect();
        $result = [];

        $builder = $db->table('application_form af')
            ->select(
                'af.code, af.attraction_name_th name_th, 
                af.attraction_name_en name_en,
                at.name type_name,
                ats.name sub_name'
            )
            ->join('application_type at','af.application_type_id = at.id')
            ->join('application_type_sub ats','af.application_type_sub_id = ats.id')
            ->where('af.id',$id)
            ->get();

        foreach($builder->getResult() as $val){
            $result = [
                'place' => !empty($val->name_th) ? $val->name_th : $val->name_en,
                'type' => $val->type_name,
                'sub' => $val->sub_name
            ];
        }

        return (object) $result;
    }

    private function getCommittees($id)
    {
        $obj_comm = new \App\Models\Committees();
        $obj_user = new \App\Models\Users();
        
        $data = $obj_comm->where('users_id',$id)
            ->select('
                admin_id_tourism, 
                admin_id_supporting, 
                admin_id_responsibility,
                admin_id_lowcarbon'
            )
            ->first();

        $judge = $tourism = $support = $lowcarbon = $respons = [];
    
        if(!empty($data->admin_id_tourism)){
            $tourism = json_decode($data->admin_id_tourism,true);
            $judge = array_unique(array_merge($judge,$tourism));
        }
    
        if(!empty($data->admin_id_supporting)){
            $support = json_decode($data->admin_id_supporting,true);
            $judge = array_unique(array_merge($judge,$support));
        }
    
        if(!empty($data->admin_id_responsibility)){
            $respons = json_decode($data->admin_id_responsibility,true);
            $judge = array_unique(array_merge($judge,$respons));
        }
    
        if(!empty($data->admin_id_lowcarbon)){
            $lowcarbon = json_decode($data->admin_id_lowcarbon,true);
            $judge = array_unique(array_merge($judge,$lowcarbon));
        }

        $result = $obj_user->whereIn('id',$judge)
            ->select('email')->findAll();

        return !empty($result) ? $result : [];
    }

    private function getAdmin()
    {    
        $obj_admin = new \App\Models\Admin();

        $result = $obj_admin->where([
                'status' => 1,
                'member_type' => 4
            ])
            ->select('email')->findAll();

        return !empty($result) ? $result : [];
    }

    private function getTTT($type,$id){
        $obj_admin = new \App\Models\Admin();

        if(empty($type)){
            $obj_app = new \App\Models\ApplicationForm();
            $builder = $obj_app->where('id',$id)
                ->select('application_type_id type_id')
                ->first();
            $type = $builder->type_id;
        }

        $result = $obj_admin->where([
            'status' => 1,
            'member_type' => 2,
            'award_type' => $type
        ])
        ->select('email')->findAll();

        return !empty($result) ? $result : [];
    }
}

?>