<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;

use App\Models\Admin;
use App\Models\LogActivity;


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class MarkTest extends BaseController
{
    private $LogActivity;

    public function __construct()
    {
        helper('verify');

        $this->LogActivity = new LogActivity;
    }

    public function index()
    {
        // pp();
        // pp(PasswordEncrypt('637cec9879aaa569c44e277a'));
        // px(PasswordDecrypt(PasswordEncrypt('637cec9879aaa569c44e277a')));
        show_404();
        $log = $this->LogActivity->findAll();
        // px(session()->get());
        $url = 'https://www.tennis.in.th/uploads/2023/01/12/13/app-register/paper/20230112_212a53e787e5.pdf';
        $new_name = '115544sdsdsdsds.pdf';
        pp($url);
        // We'll be outputting a PDF  
        header('Content-type: application/pdf');

        // It will be called downloaded.pdf  
        header('Content-Disposition: attachment; filename="5555.pdf"');

        // The PDF source is in original.pdf  
        readfile($url);
        exit;

        px(mb_substr("แหล่งท่องเที่ยว", 0, 1));
        // px(password_hash('1qazxsw2+-+', PASSWORD_DEFAULT));
        // px($_COOKIE);
        // px(session()->get());
        // $data = 'user-' . genVerifyCode();
        // pp(vEncryption('user-' . genVerifyCode()));
        // pp(vDecryption(vEncryption($data)));
        // $array = explode('&', $data);
        // pp($array);

        // exit;
        // px($_ENV);
        // // pp(session()->get());
        // // pp(checkPermission([4]));
        // px(password_hash('0000', PASSWORD_DEFAULT));
        // $model = new Admin();

        // $page    = (int) ($this->request->getGet('page') ?? 1);
        // $perPage = 20;
        // $total   = 200;

        // $data = [
        //     'users' => $model->paginate(3),
        //     'pager' => $model->pager,
        // ];
        // px($model->pager);

        // $pager = service('pager');
        // $pager->setPath('path/for/my-group', 'my-group'); // Additionally you could define path for every group.
        // $pager->makeLinks($page, $perPage, $total, 'template_name', 0, 'my-group');
        // echo $pager->links();
    }

    public function excel()
    {
        $taskModel = new Admin();
        $data['result'] = $taskModel->findAll();

        return view('backend/test/excel', $data);
    }

    public function question()
    {
        show_404();
        $where = [];
        // $where['weight'] = 0;
        // $where['onside_score'] = 0;
        // $where['lowcarbon_status'] = 1;
        // $where = "assessment_group_id = 3 AND application_type_id = 1 AND application_type_sub_id = 5";
        $data['fields'] = $this->db->getFieldNames('question');
        $data['result'] = $this->db->table('question')->orderBy('id', 'desc')->where($where)->get()->getResultObject();
        // pp(count($data['result']));
        // pp_sql();
        // pp($data['fields']);

        // Template
        $data['title']  = 'Question';
        $data['view']   = 'backend/test/question';
        $data['ci']     = $this;

        return view('backend/template', $data);
    }

    public function getData()
    {
        $post = $this->input->getVar();
        $result = $this->db->table($post['table'])->where('id', $post['id'])->get()->getRowObject();
        echo json_encode($result);
    }

    public function delete()
    {
        $post = $this->input->getVar();
        $result = $this->db->table($post['table'])->where('id', $post['id'])->delete();
        if ($result) {
            echo json_encode(['type' => 'success', 'title' => 'สำเร็จ', 'text' => 'ทำการลบข้อมูลสำเร็จ']);
        } else {
            echo json_encode(['type' => 'error', 'title' => 'ผิดพลาด', 'text' => 'ทำการลบข้อมูลไม่สำเร็จ']);
        }
    }

    public function saveInsert()
    {
        $post = $this->input->getVar();
        // px($post);
        $table = $post['table'];
        unset($post['table']);
        $result = $this->db->table($table)->insert($post);
        if ($result) {
            echo json_encode(['type' => 'success', 'title' => 'สำเร็จ', 'text' => 'บันทึกข้อมูลสำเร็จ']);
        } else {
            echo json_encode(['type' => 'error', 'title' => 'ผิดพลาด', 'text' => 'บันทึกข้อมูลไม่สำเร็จ']);
        }
    }

    public function saveUpdate()
    {
        $post = $this->input->getVar();
        // px($post);
        $id = $post['id'];
        $table = $post['table'];
        unset($post['id']);
        unset($post['table']);
        $result = $this->db->table($table)->where('id', $id)->update($post);
        if ($result) {
            echo json_encode(['type' => 'success', 'title' => 'สำเร็จ', 'text' => 'แก้ไขข้อมูลสำเร็จ']);
        } else {
            echo json_encode(['type' => 'error', 'title' => 'ผิดพลาด', 'text' => 'แก้ไขข้อมูลไม่สำเร็จ']);
        }
    }

    public function Mail()
    {
        // $mail_config['mailpath']     = "/usr/bin/sendmail"; // or "/usr/sbin/sendmail"
        // $mail_config['protocol']     = "smtp"; //use 'mail' instead of 'sendmail or smtp'
        // $mail_config['smtp_host']    = "mail.tennis.in.th";
        // $mail_config['smtp_user']    = "noreply@tennis.in.th";
        // $mail_config['smtp_pass']    = "0vHghYGKa";
        // $mail_config['smtp_port']    = 587;
        // $mail_config['smtp_timeout'] = "";
        // $mail_config['mailtype']     = "html";
        // $mail_config['charset']      = "utf-8";
        // $mail_config['newline']      = "\r\n";
        // $mail_config['wordwrap']     = TRUE;
        // $mail_config['validate']     = FALSE;


        // $this->email->initialize($mail_config);

        $email_data = [];

        $subject = 'Test การส่งเมล';
        // $body = view('template_email', $email_data);
        $body = '123454564asdadddas';
        $this->email->setFrom($_ENV['email.SMTPUser'], 'ส่งจาก');
        // $this->email->setFrom($mail_config['smtp_user'], 'ส่งจาก');
        $this->email->setTo('diaryads0@gmail.com');
        // $this->email->setBCC('kritsana@chaiyohosting.com,napapat@chaiyohosting.com');

        $this->email->setSubject($subject);
        $this->email->setMessage($body);

        pp($_ENV);
        pp($this->email);
        try {
            // pp(1221);
            pp($this->email->send());
            echo $this->email->printDebugger(['header']);
            // pp(222);
        } catch (\Throwable $th) {
            // pp($th);
            pp($th->getMessage());
        }

        // return view('template_email');
    }

    public function Mailer()
    {
        $email_data = [];
        $email = 'diaryads0@gmail.com';     //'diaryads0@gmail.com', ['diaryads0@gmail.com', 'diaryads0@gmail.com']
        $from = ['email' => 'noreply@chaiyohosting.com', 'name' => 'Tourism Awards 2023'];   //email, name
        $cc = ['diaryads0@gmail.com'];
        $bcc = ['kritsana@chaiyohosting.com'];

        $subject = 'ไปไหนมา';
        $message = view('template_email', $email_data);

        $requestEmail = [
            'to' => $email,
            'subject' => $subject,
            'message' => $message,
            'from' => $from,
            'cc' => $cc,
            'bcc' => $bcc
        ];

        try {

            $response = $this->SendMail($requestEmail);
            echo $response['message'];
        } catch (Exception $e) {
            print_r($e);
            echo "Something went wrong. Please try again.";
        }
    }

    private function SendMail($requestEmail = [])
    {

        if (!$requestEmail || count($requestEmail) <= 0) {
            return ['status' => false, 'message' => 'Invalid email data.'];
        }
        if (!array_key_exists('to', $requestEmail) || !array_key_exists('subject', $requestEmail) || !array_key_exists('message', $requestEmail)) {
            return ['status' => false, 'message' => 'Invalid email data, required [to|subject|message] value.'];
        }
        if ((is_string($requestEmail['to']) && @trim($requestEmail['to']) == '') || (is_array($requestEmail['to']) && @count($requestEmail['to']) == 0) || @$requestEmail['subject'] == '' || @$requestEmail['message'] == '') {
            return ['status' => false, 'message' => 'Invalid email data.'];
        }

        try {
            $mail = new PHPMailer(true);

            $mail->SMTPDebug = 2;
            $mail->isSMTP();
            $mail->CharSet = $_ENV['email.charset'];
            $mail->Host = $_ENV['email.SMTPHost']; //smtp.google.com
            $mail->SMTPAuth = true;
            $mail->Username = $_ENV['email.SMTPUser'];
            $mail->Password = $_ENV['email.SMTPPass'];
            $mail->SMTPSecure = 'tls';
            $mail->Port = $_ENV['email.SMTPPort'];
            $mail->Subject = $requestEmail['subject'];
            $mail->Body = $requestEmail['message'];

            if (is_array($requestEmail['to'])) {
                foreach ($requestEmail['to'] as $address) {
                    if (trim($address) != '') {
                        $mail->addAddress(trim($address));
                    }
                }
            } else {
                $mail->addAddress(trim($requestEmail['to']));
            }


            if (array_key_exists('from', $requestEmail)) {
                if (array_key_exists('email', $requestEmail['from']) && @trim($requestEmail['from']['email']) != '') {
                    $fromEmail = $requestEmail['from']['email'];

                    if (array_key_exists('name', $requestEmail['from']) && @trim($requestEmail['from']['name']) != '') {
                        $fromName = $requestEmail['from']['name'];
                    } else {
                        $fromName = $fromEmail;
                    }

                    $mail->setFrom($fromEmail, $fromName);
                }
                //            }else{
                //                $mail->setFrom($_ENV['email.SMTPUser'], $_ENV['email.SMTPUser']);
            }

            if (array_key_exists('cc', $requestEmail)) {
                if (is_array($requestEmail['cc'])) {
                    foreach ($requestEmail['cc'] as $cc) {
                        if (trim($cc) != '') {
                            $mail->addCC(trim($cc));
                        }
                    }
                }
            }
            if (array_key_exists('bcc', $requestEmail)) {
                if (is_array($requestEmail['bcc'])) {
                    foreach ($requestEmail['bcc'] as $bcc) {
                        if (trim($bcc) != '') {
                            $mail->addBCC(trim($bcc));
                        }
                    }
                }
            }

            $mail->isHTML(true);

            if (!$mail->send()) {
                return ['status' => false, 'message' => 'Something went wrong. Please try again.'];
            } else {
                return ['status' => true, 'message' => 'Email sent successfully.'];
            }
        } catch (Exception $e) {
            print_r($e);
            return ['status' => false, 'message' => 'Something went wrong. Please try again.'];
        }
    }
}
