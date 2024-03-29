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
    private $mail_bcc;

    public function __construct()
    {        
        $this->mail = new PHPMailer(true);
        $this->config = new \Config\Email();
        $this->mail_bcc = 'gidtikun@chaiyohosting.com';
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
            save_log_error([
                'module' => 'send_mail_center',
                'input_data' => $requestEmail,
                'error_date' => date('Y-m-d H:i:s'),
                'error_msg' => [
                    'error_file' => $e->getFile(),
                    'error_line' => $e->getLine(),
                    'error_code' => $e->getCode(),
                    'error_msg' => $e->getMessage()
                ]
            ]);

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
            $email_ct = 'tourismawards14@gmail.com';
            $email_sys = [
                'email' => $this->config->SenderEmail,
                'name'  => $this->config->SenderName
            ];
    
            switch($by){
                case 'register':
                    $_message = view('template-frontend-email',[
                        '_header' => 'ยืนยันตัวตนการเข้าร่วมประกวด',
                        '_content' => '<p>กรุณายืนยันตัวตนของท่านผ่านทางอีเมล เพื่อทำการล็อกอินเข้าสู่เว็บไซต์ '
                            . 'ท่านจำเป็นต้องยืนยันตัวตน</p>'
                            . '<p>โปรดยืนยันตัวตนด้วยการกดที่ลิงก์นี้ '
                            . '<b><a href="'.base_url('verify-user?c='.$dataset->verify_token).'" target="_blank">'
                            . 'ยืนยันตัวตน</a></b></p>'
                    ]);
                    
                    $_subject = 'ยืนยันตัวตนการเข้าร่วมประกวด';
                    $_to = $dataset->email;
                    $_from = $email_sys;
                    $_cc = [];
                    $_bcc = [$this->mail_bcc];
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
                    $_bcc = [$this->mail_bcc];
                break;
                case 'change-password-success':                    
                    $user = $this->getUser($dataset->user_id); 
                    $_message = view('template-frontend-email',[
                        '_header' => 'แก้ไขรหัสผ่านเรียบร้อย',
                        '_content' => '<p>เรียน คุณ '.$user->fullname.'<br>
                            ท่านได้ทำการเปลี่ยนรหัสผ่านสำเร็จแล้ว<br>
                            ขณะนี้สามารถทำการล็อกอินเข้าสู่เว็บไซต์ด้วยรหัสผ่านใหม่ของท่านได้ทันที<br>
                            <b style="color:#dc3545;">*รหัสผ่านของท่านเป็นความลับ จึงไม่ควรเปิดเผยต่อผู้อื่นทราบ<b></p>'
                    ]);
                    
                    $_subject = 'แก้ไขรหัสผ่านเรียบร้อย';
                    $_to = $user->email;
                    $_from = $email_sys;
                    $_cc = [];
                    $_bcc = [$this->mail_bcc];  
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
                    $_bcc = [$this->mail_bcc];
                break;
                case 'app-wait':                                        
                    $user = $this->getUser($dataset->user_id);
                    $_header =  'เรียน คุณ'.$user->fullname;
                    $_content = '<p>ท่านส่งใบสมัครเรียบร้อยแล้ว ใบสมัครของท่านอยู่ระหว่างการดำเนินการตรวจสอบข้อมูล '
                    . 'กรุณารอผลการตรวจสอบข้อมูลภายใน 7 วัน</p>';

                    $_message = view('template-frontend-email',[
                        '_header' => $_header,
                        '_content' => $_content
                    ]);
                    
                    $_subject = 'ส่งใบสมัครเรียบร้อยแล้ว';
                    $_to = $user->email;
                    $_from = $email_sys;
                    $_cc = [];
                    $_bcc = [$this->mail_bcc];                   
                break;
                case 'answer-complete':                    
                    $_header = 'ส่งแบบประเมินขั้นต้น (Pre-Screen)';
                    $_message = view('template-frontend-email',[
                        '_header' => $_header,
                        '_content' => 'ท่านส่งแบบประเมินขั้นต้น (Pre-Screen) เรียบร้อยแล้ว กรุณาติดตามผลการประเมินทางอีเมล หรือเว็บไซต์'
                    ]);
    
                    $_subject = 'ท่านส่งแบบประเมินขั้นต้น (Pre-Screen) เรียบร้อยแล้ว';
                    $_to = $dataset->email;
                    $_from = $email_sys;
                    $_cc = [];
                    $_bcc = [$this->mail_bcc];
                break;
                case 'answer-request-complete':
                    $_header = 'ตอบกลับการขอข้อมูลเพิ่มเติม';
                    $_content = "$dataset->tycon ได้ส่งคำตอบการประเมินเบื้องต้น (Pre-Screen) เพิ่มเติมกลับมาเรียบร้อยแล้ว " 
                                . "จึงขอให้ท่านคณะกรรมการกรุณาล็อกอินเข้าสู่เว็บไซต์ เพื่อทำการประเมินเบื้องต้น (Pre-Screen) อีกครั้ง ภายในวันที่ 25 พฤษภาคม 2566";
                    
                    $_message = view('template-frontend-email',[
                        '_header' => $_header,
                        '_content' => $_content
                    ]);

                    $_subject = "$dataset->tycon ได้ตอบกลับการขอข้อมูลเพิ่มเติมของท่านเรียบร้อยแล้ว";
                    $_to = [];
                    $_from = $email_sys;
                    $_cc = [];
                    $_bcc = [$this->mail_bcc];
                    
                    $judge = $this->getJudgeEstimateRequest($dataset->appId);
                    
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
                    
                    $_message = view('template-frontend-email',[
                        '_header' => $_header,
                        '_content' => $_content
                    ]);   

                    $_subject = "ไม่มีการตอบกลับการขอข้อมูลเพิ่มเติมจาก $tycoon->place";
                    $_to = $judge->email;
                    $_from = $email_sys;
                    $_cc = [];
                    $_bcc = [$this->mail_bcc];    
                break;
                case 'estimate-request':
                    $user = $this->getUser($dataset->id); 
                              
                    $_message = view('template-frontend-email',[
                        '_header' => 'ขอข้อมูลเพิ่มเติม',
                        '_content' => '<p>คณะกรรมการมีการขอข้อมูลเพิ่มเติม แบบประเมินของท่าน '
                        . $dataset->assessent
                        . ' กรุณาล็อกอินเข้าสู่เว็บไซต์เพื่อตรวจสอบการขอข้อมูล และส่งข้อมูลตอบกลับภายใน 72 ชั่วโมง</p>'
                    ]);
                    
                    $_subject = 'แบบประเมินขั้นต้น (Pre-Screen) มีการขอข้อมูลเพิ่มเติม';
                    $_to = $user->email;
                    $_from = $email_sys;
                    $_cc = [];
                    $_bcc = [$this->mail_bcc];    
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
                    $_bcc = [$this->mail_bcc]; 
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
            
            helper('log');
            save_log_activety([
                'module' => 'send_email',
                'action' => $by,
                'bank' => 'frontend',
                'user_id' => session()->get('id'),
                'datetime' => date('Y-m-d H:i:s'),
                'data' => [
                    'to' => $_to,
                    'from' => $_from,
                    'cc' => $_cc,
                    'bcc' => $_bcc,
                    'subject' => $_subject,
                    'status' => $_status 
                ]
            ]);

            $result = [ 'result' => $_status ? 'success' : 'error' ];
            
            return $result;
        } catch(Exception $e){
            helper('log');
            save_log_error([
                'module' => 'helper_send_email',
                'input_data' => ['dataset' => $dataset, 'by' => $by],
                'error_date' => date('Y-m-d H:i:s'),
                'error_msg' => [
                    'error_file' => $e->getFile(),
                    'error_line' => $e->getLine(),
                    'error_code' => $e->getCode(),
                    'error_msg' => $e->getMessage()
                ]
            ]);
            return [ 'result' => false,  'message' => '' ];
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
    
    private function getJudgeEstimateRequest($app_id)
    {
        $db = \Config\Database::connect();

        $judge = $db->table('users a')
        ->select('a.email')
        ->join('estimate_request b','a.id = b.request_by')
        ->where('b.application_id',$app_id)
        ->whereIn('b.request_status',[1,3])
        ->groupBy('a.id')
        ->get()
        ->getResult();
        
        return $judge;
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