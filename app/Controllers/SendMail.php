<?php 
namespace App\Controllers;

use App\Controllers\BaseController;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class SendMail extends BaseController
{
    public function index() 
	{
        
        $mail = new PHPMailer(true);  
		try {
		    // $mail->SMTPDebug = 2;  
			// $mail->SMTPOptions = array(
			// 	'ssl' => array(
			// 		'verify_peer' => false,
			// 		'verify_peer_name' => false,
			// 		'allow_self_signed' => true
			// 	)
			// );
		    // $mail->isSMTP();  
			// $mail->CharSet 		= "utf-8";
		    // $mail->Host         = 'smtp.office365.com'; //smtp.google.com
		    // $mail->SMTPAuth     = true;     
		    // $mail->Username     = 'no-reply@thailandsha.com';  
		    // $mail->Password     = 'SHA@2022!$@#01';
			// $mail->SMTPSecure   = 'tls';  
			// $mail->Port         = 587;  
			// $mail->Subject      = $subject;
			// $mail->Body         = $message;
			// $mail->setFrom('no-reply@thailandsha.com', 'no-reply@thailandsha.com');

			$mail->SMTPDebug = 2;  
		    $mail->isSMTP();  
			$mail->CharSet 		= "utf-8";
			// TCP port to connect to
			$mail->From = 'noreply@thailandtourismawards.com';

			$mail->Host = 'smtp.office365.com';      
			$mail->SMTPAuth = true;                             
			$mail->Username = 'noreply@thailandtourismawards.com';
			$mail->Password = 'Fob13825';
			$mail->SMTPSecure = 'tls';                           
			$mail->Port = 587;

		    // $mail->Host         = 'mail.chaiyohosting.com'; //smtp.google.com
		    // $mail->SMTPAuth     = true;     
		    // $mail->Username     = 'promotion@chaiyohosting.com';  
		    // $mail->Password     = '0wsptFCx';
			// $mail->SMTPSecure   = 'tls';  
			// $mail->Port         = 587;  

			$to          = 'n.techaingkanan@gmail.com';
			$subject        = 'ทดสอบอีเมล Tennis.in.th';
			
			//$message        = 'ส่งอีเมล ณ '.date("F j, Y, g:i a");
			$message = view('template-frontend-email',[
				'_header' => 'เรียน คุณชื่อผู้ประกอบการ',
				'_content' => '<p>ท่านได้ส่งคำร้องขอในการเปลี่ยนรหัสผ่าน กรุณากดที่ลิ้งเพื่อทำการเปลี่ยนรหัสผ่าน '
					. '<b><a href="'.base_url('/')
					. '" target="_blank">หน้าเว็บ</a></b></p>'
			]);

			$mail->Subject      = $subject;
			$mail->Body         = $message;

			$mail->setFrom('noreply@thailandtourismawards.com', 'Thailand Tourism Awards 2023');
//			$mail->addCC('diaryads0@gmail.com');
			// $mail->addBCC('napapat@chaiyohosting.com');
//			$mail->addBCC('kritsana@chaiyohosting.com');
			
			$mail->addAddress($to);  
			$mail->isHTML(true);      

			// echo $message;
			
			if(!$mail->send()) {
			    echo "Something went wrong. Please try again.";
			}
		    else {
			    echo "Email sent successfully.";
		    }
		    
		} catch (Exception $e) {
			print_r($e);
		    echo "Something went wrong. Please try again.";
		}
    }
}