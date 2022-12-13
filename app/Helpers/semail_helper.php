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

    public function __construct()
    {        
        $this->mail = new PHPMailer(true);
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
            $this->mail->CharSet = $_ENV['email.charset'];
            $this->mail->Host = $_ENV['email.SMTPHost'];
            $this->mail->SMTPAuth = true;
            $this->mail->Username = $_ENV['email.SMTPUser'];
            $this->mail->Password = $_ENV['email.SMTPPass'];
            $this->mail->SMTPSecure = 'tls';
            $this->mail->Port = $_ENV['email.SMTPPort'];
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
                $this->mail->setFrom($_ENV['email.senderEmail'], $_ENV['email.senderName']);
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
                'email' => $_ENV['email.senderEmail'],
                'name'  => $_ENV['email.senderName']
            ];
    
            switch($by){
                case 'register':
                    $_message = view('template-frontend-email',[
                        '_header' => 'ยืนยันตัวตนการเข้าร่วมประกวด',
                        '_content' => '<p>เรียนคุณ '.$dataset->name.' '.$dataset->surname.'</p><br>'
                            . '<p>กรุณายืนยันตัวตนผ่านทางอีเมล เพื่อทำการเข้าสู่ระบบท่านจำเป็นต้องยืนยันตัวตนภายใน 3 วัน</p>'
                            . '<p>โปรดยืนยันตัวตนด้วยการกดที่ลิ้งนี้ '
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
                    $_message = view('template-frontend-email',[
                        '_header' => 'เรียน คุณ'.$_recipient,
                        '_content' => '<p>ท่านได้ส่งคำร้องขอในการเปลี่ยนรหัสผ่าน กรุณากดที่ลิ้งเพื่อทำการเปลี่ยนรหัสผ่าน '
                            . '<b><a href="'.base_url('new-password/'.$dataset->id)
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
                        '_content' => '<p>ท่านส่งใบสมัครเรียบร้อยแล้ว ใบสมัครของท่านอยู่ระหว่างการดำเนินการตรวจสอบ'
                            .' กรุณารอผลการตรวจสอบภายใน 7 วัน</p>'
                            . '<p>เมื่อทำการพิจารณาเสร็จแลัวจะส่งผ่านทางอีเมลนี้ กรุณารอการตอบกลับที่กล่องจดหมายหรือจดหมายขยะ</p>'
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
                    $tycoon = $this->getTycoon($dataset->app_id);
                    $_header = 'แจ้งเตือนการส่งแบบประเมินขั้นต้น';
                    $_message = view('template-frontend-email',[
                        '_header' => $_header,
                        '_content' => $tycoon->place 
                            . ' ได้ทำการส่งแบบประเมินเข้าสู่ระบบ กรุณาเข้าสู่ระบบเพื่อทำการมอบหมายกรรมการเพื่อประเมินรอบขั้นต้น (Pre-Screen)'
                    ]);
    
                    $_subject = $_header;
                    $_to = [];
                    $_from = $email_sys;
                    $_cc = [];
                    $_bcc = ['zgidtikun@gmail.com'];
                                       
                    $list_admin = $this->getAdmin();
                    
                    if(!empty($list_admin)){
                        foreach($list_admin as $admin){
                            array_push($_to,$admin->email);
                        }
                    }
                break;
                case 'estimate-request':
                    $user = $this->getUser($dataset->id);  
                    $_header = 'ขอข้อมูลเพิ่มเติม';                
                    $_message = view('template-frontend-email',[
                        '_header' => $_header,
                        '_content' => '<p>เรียน คุณ'.$user->fullname.'</p><br>'
                            . '<p>แบบประเมินของท่านมีการร้องขอข้อมูลเพิ่มเติม กรุณาเข้าสู่ระบบเพื่อตรวจสอบการร้องขอข้อมูล</p>'
                    ]);
    
                    $_subject = 'แจ้งการขอข้อมูลเเพิ่มเติมในขั้นตอนการประเมินเบื่องต้น';
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
                        $_content .= '<p>แบบประเมินของท่าน ผ่านการประเมินรอบประเมินขั้นต้น (Pre-Screen)'
                            . ' กรุณาส่ง VDO และ Power Point xxxxxxx ไปที่อีเมล '.$email_ct
                            . ' เพื่อใช้ในการประเมินรอบก่อนลงพื้นที่</p>';
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
            ->select('admin_id_tourism, admin_id_supporting, admin_id_responsibility')
            ->first();

        $tourism = json_decode($data->admin_id_tourism,true);
        $support = json_decode($data->admin_id_supporting,true);
        $respons = json_decode($data->admin_id_responsibility,true);
        $judge = array_unique(array_merge($tourism,$support,$respons));

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