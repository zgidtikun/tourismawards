<?php 
use PHPMailer\PHPMailer\PHPMailer;

function send_email($dataset)
{
    // $email_data = [];
    // $email = 'diaryads0@gmail.com'; 
    // $from = ['email'=>'noreply@chaiyohosting.com', 'name'=>'Tourism Awards 2023'];   //email, name
    // $cc = ['diaryads0@gmail.com'];
    // $bcc = ['kritsana@chaiyohosting.com'];
    
    // $subject = 'ไปไหนมา';
    // $message = view('template_email', $email_data);
    
    // $requestEmail = [
    //     'to' => $email,
    //     'subject' => $subject,
    //     'message' => $message,
    //     'from' => $from,
    //     'cc' => $cc,
    //     'bcc' => $bcc
    // ];
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
    
                    $obj_admin = new \App\Models\Admin();
                    $list_admin = $obj_admin->where('status',1)
                        ->select('email')->findAll();;
    
                    foreach($list_admin as $admin){
                        array_push($_to,$admin->email);
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
                            . '<p>รหัสผ่านใหม่ของท่านคือ'
                            . '<p>New password : '.$dataset->password.'</p>'
                            . '<br>'
                            . 'ท่านสามารถตั่งค่ารหัสผ่าใหม่ได้ที่ <a href="'.base_url('new-password')
                            . '" target="_blank">ตั้งรหัสใหม่</a>'
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
    
                    $obj_user = new \App\Models\Users();
                    $users = $obj_user->whereIn('id',$dataset->user)
                        ->select('email')->findAll();
    
                    foreach($users as $user){
                        array_push($_to,$user->email);
                    }
                break;
                case 'estimate-request':
                    $obj_user = new \App\Models\Users();
                    $user = $obj_user->where('id',$dataset->id)
                        ->select('email, CONCAT(name,\' \',surname) fullname',false)
                        ->first();
    
                    $_header = 'ขอข้อมูลเเพิ่มเติม';                
                    $_message = view('template-frontend-email',[
                        '_header' => $_header,
                        '_content' => '<p>เรียน คุณ'.$user->fullname.'<p>'
                            . '<p>คณะกรรมการได้มีการร้องขอข้อมูลเพิ่มเติมในแบบฟอร์มการระเมินขั้นต้น'
                            . ' ผู้ประกอบการกรุณา <b><a href="'.base_url('login').'" target="_blank">เข้าสู่ระบบ</a></b> '
                            . 'เพื่อส่งข้อมูลเพิ่มเติมและส่งแบบฟอร์มการประเมินอีกครั้ง'
                    ]);
    
                    $_subject = 'แจ้งการขอข้อมูลเเพิ่มเติมในขั้นตอนการประเมินเบื่องต้น';
                    $_to = $user->email;
                    $_from = $email_sys;
                    $_cc = [];
                    $_bcc = [];                
                break;
                case 'estimate-complete':
                    $obj_user = new \App\Models\Users();
                    $user = $obj_user->where('id',$dataset->id)
                        ->select('email, CONCAT(name,\' \',surname) fullname',false)
                        ->first();
                    
                    $_stage = $dataset->stage == 1 ? 'ประเมินขั้นต้น' : 'ลงพื้นที่';
                    $_header = 'ผลการประเมินรอบ '.$_stage;
                    
                    $_message = view('template-frontend-email',[
                        '_header' => $_header,
                        '_content' => '<p>เรียน คุณ'.$user->fullname.'<p>'
                            . '<p>'.$_header.' ของท่านได้ออกมาแล้ว '
                            . ' ผู้ประกอบการกรุณา <b><a href="'.base_url('login').'" target="_blank">เข้าสู่ระบบ</a></b> '
                            . 'เพื่อทำการตรวจผลการประเมินของท่าน'
                    ]);
    
                    $_subject = 'แจ้ง'.$_header;
                    $_to = $user->email;
                    $_from = $email_sys;
                    $_cc = [];
                    $_bcc = []; 
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
}

?>