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
                        '_content' => 'คุณ '.$dataset->name.' '.$dataset->surname.' ได้ลงทะเบียนเข้าาประกวดรางวัล'
                            . 'อุตสาหกรรมท่องเที่ยวไทย ครั้งที่ 14 ประจำปี 2565 (Thailand Tourism Awards 2023) '
                            . 'ดัวยอีเมล '.$dataset->email.' โปรดยืนยันตัวตนด้วยการกดที่ลิ้งนี้ '
                            . '<b><a href="'.base_url('verify-user?c='.$dataset->verify_token).'" target="_blank">'
                            . 'Verify</a></b>'
                    ]);
                    
                    $_subject = 'ยืนยันตัวตนการเข้าร่วมประกวด';
                    $_to = $dataset->email;
                    $_from = $email_sys;
                    $_cc = [];
                    $_bcc = [];
                break;
                case 'app-wait':
                    $_message = view('template-frontend-email',[
                        '_header' => 'เรียน คุณ'.$dataset->tycon,
                        '_content' => '<p>ทางผู้ดำเนินงานประกวดรางวัลอุตสาหกรรมท่องเที่ยวไทย ครั้งที่ 14 ประจำปี 2565 (Thailand Tourism Awards 2023) '
                            . 'ได้รับแบบฟอร์มการสมัครแล้ว ทางคณะทำงานกำลังทำการพิจารณาท่านโดยเร็วที่สุด</p>'
                            . '<br><p>เมื่อทำการพิจารณาเสร็จแลัวจะส่งผ่านทางอีเมลนี้ กรุณารอการตอบกลับนี้ด้วย</p>'
                    ]);
                    
                    $_subject = 'แจ้งการรับแบบฟอร์มการสมัครเข้ารับการพิจารณา';
                    $_to = $dataset->email;
                    $_from = $email_sys;
                    $_cc = [];
                    $_bcc = [];                    
                break;
                case 'app': 
                    $_header = 'แจ้งการส่งใบสัครเข้าระบบจากผู้ประกอบ';
                    $_message = view('template-frontend-email',[
                        '_header' => $_header,
                        '_content' => 'มีการส่งใบสมัครจากคุณ '.$dataset->tycon 
                            . ' อีเมล '.$dataset->email.' เข้าสู่ระบบ เจ้าหน้าที่เกี่ยข้อง'
                            . 'กรุณาตรวจสอบและทำการแจ้งผลแก่ผู้ประกอบการ'
                    ]);
    
                    $_subject = $_header;
                    $_to = [];
                    $_from = $email_sys;
                    $_cc = [];
                    $_bcc = [];
                    
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
                case 'contact':
                    $input = (object) $dataset;
    
                    $_message = view('template-frontend-email',[
                        '_header' => '',
                        '_content' => '<p>'.$input->message.'</p>'
                            . '<p>ผู้ติดต่อ<br>'
                            . 'คุณ '.$input->name.'<br>'
                            . 'อีเมล '.$input->email.'</p>'
                    ]);
                    
                    $_subject = 'ติดต่อเรื่อง '.$input->subject;
                    $_to = $email_ct;
                    $_from = $email_sys;
                    $_cc = [];
                    $_bcc = [];
                break;
                case 'reset-pass':
                    $_recipient = $dataset->name.' '.$dataset->surname;          
                    $_message = view('template-frontend-email',[
                        '_header' => 'รหัสผ่านใหม่ Thailand Tourism Awards',
                        '_content' => '<p>เรียน คุณ'.$_recipient.'</p><br>'
                            . '<p>รหัสผ่านใหม่ของท่านคือ<p/>'
                            . '<p>New password : '.$dataset->password.'</p>'
                            . '<br>'
                            . 'ท่านสามารถตั่งค่ารหัสผ่านใหม่ได้เมื่อท่านเข้าสู่ระบบ <a href="'.base_url('login')
                            . '" target="_blank">เข้าสู่ระบบ</a>'
                    ]);
    
                    $_subject = 'Thailand Tourism Awards - Reset Password';
                    $_from = $email_sys;
                    $_to = $dataset->email;
                    $_cc = [];
                    $_bcc = [];
                break;
                case 'answer-complete':
                    $_header = 'แจ้งเตือนการส่งแบบประเมินขั้นต้น';
                    $_message = view('template-frontend-email',[
                        '_header' => $_header,
                        '_content' => 'มีการส่งแบบประเมินขั้นต้นจากคุณ '.$dataset->tycon
                            . ' อีเมล '.$dataset->email.' เข้าสู่ระบบ เจ้าหน้าที่เกี่ยข้อง'
                            . 'กรุณาตรวจสอบและทำการแจ้งผลแก่ผู้ประกอบการ'
                    ]);
    
                    $_subject = $_header;
                    $_to = [];
                    $_from = $email_sys;
                    $_cc = [];
                    $_bcc = [];

                    $cmt = $this->getCommittees($dataset->app_id);                    
                    $list_admin = $this->getAdmin();
                    
                    if(!empty($cmt)){
                        foreach($cmt as $user){
                            array_push($_to,$user->email);
                        }
                    }
                    
                    if(!empty($list_admin)){
                        foreach($list_admin as $admin){
                            array_push($_to,$admin->email);
                        }
                    }
                break;
                case 'estimate-request':
                    $user = $this->getUser($dataset->id);    
                    $_header = 'ขอข้อมูลเเพิ่มเติม';                
                    $_message = view('template-frontend-email',[
                        '_header' => $_header,
                        '_content' => '<p>เรียน คุณ'.$user->fullname.'</p>'
                            . '<p>คณะกรรมการได้มีการร้องขอข้อมูลเพิ่มเติมในแบบฟอร์มการระเมินขั้นต้น'
                            . ' ผู้ประกอบการกรุณา <b><a href="'.base_url('login').'" target="_blank">เข้าสู่ระบบ</a></b> '
                            . 'เพื่อส่งข้อมูลเพิ่มเติมและส่งแบบฟอร์มการประเมินอีกครั้ง</p>'
                    ]);
    
                    $_subject = 'แจ้งการขอข้อมูลเเพิ่มเติมในขั้นตอนการประเมินเบื่องต้น';
                    $_to = $user->email;
                    $_from = $email_sys;
                    $_cc = [];
                    $_bcc = [];                
                break;
                case 'estimate-complete':
                    $user = $this->getUser($dataset->id);
                    $_stage = $dataset->stage == 1 ? 'ประเมินขั้นต้น' : 'ลงพื้นที่';
                    $_header = 'ผลการประเมินรอบ '.$_stage;
                    
                    $_message = view('template-frontend-email',[
                        '_header' => $_header,
                        '_content' => '<p>เรียน คุณ'.$user->fullname.'</p>'
                            . '<p>'.$_header.' ของท่านได้ออกมาแล้ว '
                            . ' ผู้ประกอบการกรุณา <b><a href="'.base_url('login').'" target="_blank">เข้าสู่ระบบ</a></b> '
                            . 'เพื่อทำการตรวจผลการประเมินของท่าน</p>'
                    ]);
    
                    $_subject = 'แจ้ง'.$_header;
                    $_to = $user->email;
                    $_from = $email_sys;
                    $_cc = [];
                    $_bcc = []; 
                break;
                case 'estimate-complete-sys':                    
                    // $user = $this->getUser($dataset->id);
                    $tycoon = $this->getTycoon($dataset->appId);
                    
                    $_stage = $dataset->stage == 1 ? 'ประเมินขั้นต้น' : 'ลงพื้นที่';
                    $_header = 'การประเมินรอบ '.$_stage.' เสร็จสิ้นแล้ว';
                    
                    $_message = view('template-frontend-email',[
                        '_header' => $_header,
                        '_content' => '<p>เรียน เจ้าหน้าที่ ททท. และแอ็ดมิน</p>'
                            . '<p>คณะกรรมการได้ทำการประเมินรอบ '.$_stage.' ของสถานที่ '
                            . $tycoon->place
                            . ' ประเภท '.$tycoon->type
                            . ' สาขา '.$tycoon->sub
                            .' เสร็จสิ้นแล้ว'
                    ]);
    
                    $_subject = 'แจ้ง'.$_header;
                    $_to = [];
                    $_from = $email_sys;
                    $_cc = [];
                    $_bcc = []; 
                                        
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