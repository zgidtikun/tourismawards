<?php 

function send_email($dataset, $by)
{
    try {
        $email = \Config\Services::email();
        if(getenv('CI_ENVIRONMENT') != 'production'){
            $email_sys = 'noreply@tennis.in.th';
            $email_ct = 's.gidikun@gmail.com';
        } else {
            $email_sys = 'promotion@chaiyohosting.com';
            $email_ct = 'tourismawards.tat@gmail.com';
        }

        switch($by){
            case 'register':
                $email->setTo($dataset->email);
                $email->setFrom($email_sys);
                $email->setSubject('ยืนยันตัวตนการเข้าร่วมประกวด');

                $_view = view('template-frontend-email',[
                    '_header' => 'ยืนยันตัวตนการเข้าร่วมประกวด',
                    '_content' => 'คุณ '.$dataset->name.' '.$dataset->surname.' ได้ลงทะเบียนเข้าาประกวดรางวัล'
                        . 'อุตสาหกรรมท่องเที่ยวไทย ครั้งที่ 14 ประจำปี 2556 (Thailand Tourism Awards 2023) '
                        . 'ดัวยอีเมล '.$dataset->email.' โปรดยืนยันตัวตนด้วยการกดที่ปุ่ม Verify',
                    '_method' => 'register',
                    '_link' => base_url('verify-user?c='.$dataset->verify_token)
                ]);

                $_template = $_view;
                $email->setMessage($_template);
                $_status = $email->send();
                
                $result = [ 'result' => $_status ? 'success' : 'error' ];
            break;
            case 'app': 
                $obj_admin = new \App\Models\Admin();
                $list_admin = $obj_admin->where('status',1)
                    ->select('email')->findAll();

                $email->setFrom($email_sys);
                $email->setSubject('แจ้งผลการส่งใบสัครเข้าระบบจากผู้ประกอบ');

                $_view = view('template-frontend-email',[
                    '_header' => 'แจ้งผลการส่งใบสัครเข้าระบบจากผู้ประกอบ',
                    '_content' => 'มีการส่งใบสมัครจากคุณ '.$dataset->tycon 
                        . ' อีเมล '.$dataset->email.' เข้าสู่ระบบ เจ้าหน้าที่เกี่ยข้อง'
                        . 'กรุณาตรวจสอบและทำการแจ้งผลแก่ผู้ประกอบการ'
                ]);

                $_template = $_view;                
                $email->setMessage($_template);                
                $_list = array();

                foreach($list_admin as $admin){
                    array_push($_list,$admin->email);
                }

                $email->setTo($_list);
                $_status = $email->send();
                $result = [ 'result' => $_status ? 'success' : 'error' ];
            break;
            case 'contact':
                $input = (object) $dataset;
                
                $_message = '<p>'.$input->message.'</p>';
                $_message .= '<p>ผู้ติดต่อ<br>';
                $_message .= 'คุณ '.$input->name;
                $_message .= 'อีเมล '.$input->email.'</p>';

                $_view = view('template-frontend-email',[
                    '_header' => '',
                    '_content' => $_message
                ]);
                
                $_template = $_view;
                $email->setTo($email_ct);
                $email->setFrom($email_sys);
                $email->setSubject('ติดต่อเรื่อง '.$input->subject);
                $email->setMessage($_template);
                $_status = $email->send();
                
                $result = [ 'result' => $_status ? 'success' : 'error' ];
            break;
            case 'reset-pass':
                $_subject = 'Thailand Tourism Awards - Reset Password';
                $_recipient = $dataset->name.' '.$dataset->surname;
                $_from = $email_sys;
                $_to = $dataset->email;
                
                $_header = 'รหัสผ่านใหม่ Thailand Tourism Awards';
                $_message = '<p>';
                $_message .= 'เรียน คุณ'.$_recipient.'</br>';
                $_message .= '</p>';
                $_message .= '<p>New password : '.$dataset->password.'<br></p>';
                $_message .= '<p>ขอแสดงความนับถือ<br>Thailand Tourism Awards</p>';
        
                $_view = view('template-frontend-email',[
                    '_header' => $_header,
                    '_content' => $_message
                ]);
        
                $_template = $_view;
                $email->setTo($_to);
                $email->setFrom($_from);
                $email->setSubject($_subject);
                $email->setMessage($_template);
                $_status = $email->send();
                
                $result = [ 'result' => $_status ? 'success' : 'error' ];
            break;
            case 'answer-complete':
                $obj_user = new \App\Models\Users();
                $users = $obj_user->whereIn('id',$dataset->user)
                    ->select('email')->find();

                $_header = 'แจ้งเตือนการส่งแบบประเมินขั้นต้น';
                $_message = 'มีการส่งแบบประเมินขั้นต้นจากคุณ '.$dataset->tycon;
                $_message .= ' อีเมล '.$dataset->email.' เข้าสู่ระบบ เจ้าหน้าที่เกี่ยข้อง';
                $_message .= 'กรุณาตรวจสอบและทำการแจ้งผลแก่ผู้ประกอบการ';

                $_view = view('template-frontend-email',[
                    '_header' => $_header,
                    '_content' => $_message
                ]);
        
                $_template = $_view;
                $email->setFrom($email_sys);
                $email->setSubject($_header);
                $email->setMessage($_template);
                $_list = array();

                foreach($users as $user){
                    array_push($_list,$user->email);
                }

                $email->setTo($_list);
                $_status = $email->send();
                $result = [ 'result' => $_status ? 'success' : 'error' ];
            break;
            case 'estimate-request':
                $obj_user = new \App\Models\Users();
                $user = $obj_user->where('id',$dataset->id)
                    ->select('email, CONCAT(name,\' \',surname) fullname',false)
                    ->first();

                $_header = 'ขอข้อมูลเเพิ่มเติม';
                $_message = '<p>เรียน คุณ'.$user->fullname.'<p>';
                $_message .= '<p>คณะกรรมการได้มีการร้องขอข้อมูลเพิ่มเติมในแบบฟอร์มการระเมินขั้นต้น';
                $_message .= ' ผู้ประกอบการกรุณา <b><a href="'.base_url('login').'">เข้าสู่ระบบ</a></b> ';
                $_message .= 'เพื่อส่งข้อมูลเพิ่มเติมและส่งแบบฟอร์มการประเมินอีกครั้ง';
                
                $_view = view('template-frontend-email',[
                    '_header' => $_header,
                    '_content' => $_message
                ]);
        
                $_template = $_view;
                $email->setTo($user->email);
                $email->setFrom($email_sys);
                $email->setSubject('แจ้งการขอข้อมูลเเพิ่มเติมในขั้นตอนการประเมินเบื่องต้น');
                $email->setMessage($_template);
                $_status = $email->send();
                
                $result = [ 'result' => $_status ? 'success' : 'error' ];
                
            break;
            case 'estimate-complete':
                $obj_user = new \App\Models\Users();
                $user = $obj_user->where('id',$dataset->id)
                    ->select('email, CONCAT(name,\' \',surname) fullname',false)
                    ->first();
                
                $_stage = $dataset->stage == 1 ? 'ประเมินขั้นต้น' : 'ลงพื้นที่';
                $_header = 'ผลการประเมินรอบ '.$_stage;
                $_subject = 'แจ้ง'.$_header;
                $_message = '<p>เรียน คุณ'.$user->fullname.'<p>';
                $_message .= '<p>'.$_header.' ของท่านได้ออกมาแล้ว ';
                $_message .= ' ผู้ประกอบการกรุณา <b><a href="'.base_url('login').'">เข้าสู่ระบบ</a></b> ';
                $_message .= 'เพื่อทำการตรวจผลการประเมินของท่าน';
                
                $_view = view('template-frontend-email',[
                    '_header' => $_header,
                    '_content' => $_message
                ]);
        
                $_template = $_view;
                $email->setTo($user->email);
                $email->setFrom($email_sys);
                $email->setSubject($_subject);
                $email->setMessage($_template);
                $_status = $email->send();
                
                $result = [ 'result' => $_status ? 'success' : 'error' ];

            break;
        }

        return $result;
    } catch(Exception $e){
        return [ 'result' => false,  'message' => $e->getMessage() ];
    }
}

?>