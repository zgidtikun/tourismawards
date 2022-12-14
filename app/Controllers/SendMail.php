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
		$email          = 'n.techaingkanan@gmail.com';
        $subject        = 'ทดสอบอีเมล Tennis.in.th';
        $message        = 'ส่งอีเมล ณ '.date("F j, Y, g:i a");
        
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

			$mail->Host = 'smtp.office365.com';      
			$mail->SMTPAuth = true;                             
			$mail->Username = 'noreply@thailandtourismawards.com';
			$mail->Password = 'Fob13825';
			$mail->SMTPSecure = 'tls';                           
			$mail->Port = 587;
			// TCP port to connect to
			$mail->From = 'noreply@thailandtourismawards.com';

			$mail->SMTPDebug = 2;  
		    $mail->isSMTP();  
			$mail->CharSet 		= "utf-8";
		    $mail->Host         = 'mail.chaiyohosting.com'; //smtp.google.com
		    $mail->SMTPAuth     = true;     
		    $mail->Username     = 'promotion@chaiyohosting.com';  
		    $mail->Password     = '0wsptFCx';
			$mail->SMTPSecure   = 'tls';  
			$mail->Port         = 587;  
			$mail->Subject      = $subject;
			$mail->Body         = $message;
			$mail->setFrom('noreply@chaiyohosting.com', 'Tourism Awards 2023');
//			$mail->addCC('diaryads0@gmail.com');
			$mail->addBCC('napapat@chaiyohosting.com');
//			$mail->addBCC('kritsana@chaiyohosting.com');
			
			$mail->addAddress($email);  
			$mail->isHTML(true);      
			
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