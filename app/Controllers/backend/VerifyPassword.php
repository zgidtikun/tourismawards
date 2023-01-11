<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;

class VerifyPassword extends BaseController
{

    public function __construct()
    {
        helper(['semail', 'verify']);
    }

    public function index()
    {
        // pp($_GET['t']);
        // px(vDecryption($_GET['t']));
        if (!empty($_GET['t'])) {
            $token = explode('-', vDecryption($_GET['t']));

            if ($token[0] == 'users') {
                $data['result'] = $this->db->table('users')->where('verify_code', $token[1])->get()->getRowObject();
            } else if ($token[0] == 'admin') {
                $data['result'] = $this->db->table('admin')->where('verify_code', $token[1])->get()->getRowObject();
            }
            if (empty($data['result'])) {
                show_404();
            }

            $data['type']   = $token[0];
            $data['code']   = $token[1];

            $data['title_name']  = 'ยืนยันการลงทะบียน';

            $data['title']  = 'Tourist Award | Verify Password';
            $data['view']   = 'administrator/verify/index';
            $data['ci']     = $this;

            return view('administrator/template_blank', $data);
        } else {
            show_404();
        }
    }

    public function savePassword()
    {
        $post = $this->input->getVar();

        $data = [
            'password'      => password_hash($post['password'], PASSWORD_DEFAULT),
            'status'        => 1,
            'verify_status' => 1,
            'verify_date'   => date('Y-m-d H:i:s'),
        ];

        if ($post['type'] == 'users') {
            $result = $this->db->table('users')->where('username', $post['username'])->where('verify_code', $post['code'])->update($data);
        } else if ($post['type'] == 'admin') {
            $result = $this->db->table('admin')->where('username', $post['username'])->where('verify_code', $post['code'])->update($data);
        }

        if ($result) {
            $this->session->setFlashdata(['success' => 'ระบบได้ทำการบันทึกรหัสผ่านเรียบร้อย กรุณาเข้าสู่ระบบ']);

            if ($post['type'] == 'users') {
                return redirect()->to(base_url('login'));
            } else if ($post['type'] == 'admin') {
                return redirect()->to(base_url('administrator'));
            }
        } else {
            $this->session->setFlashdata(['error' => 'ระบบทำการบันทึกไม่สำเร็จกรุณาทำรายการอีกครั้งหรือติดต่อเจ้าหน้าที่']);
            return redirect()->to(base_url());
        }
    }

    public function forgotPassword()
    {
        $data['title_name']  = 'ลืมรหัสผ่าน';

        $data['title']  = 'Tourist Award | Forgot Password';
        $data['view']   = 'administrator/verify/forgot_password';
        $data['ci']     = $this;

        return view('administrator/template_blank', $data);
    }

    public function saveForgotPassword()
    {
        $post = $this->input->getVar();
        $admin = $this->db->table('admin')->where('username', $post['username'])->get()->getRowObject();
        $verify_code = genVerifyCode();
        if (empty($admin)) {
            echo json_encode(['type' => 'error', 'title' => 'ผิดพลาด', 'text' => 'ไม่พบ E-Mail นี้ในระบบ กรุณาตรวจสอบข้อมูล']);
            exit;
        }

        $result = $this->db->table('admin')->where('username', $post['username'])->update(['verify_code' => $verify_code]);
        if ($result) {
            $data = [];
            $data['admin'] = $this->db->table('admin')->where('id', $admin->id)->get()->getRowObject();
            $this->sendMail($data);
            echo json_encode(['type' => 'success', 'title' => 'แจ้งเปลี่ยนรหัสผ่านสำเร็จ', 'text' => 'กรุณาตรวจสอบ E-Mail เพื่อยืนยันการเปลี่ยนรหัสผ่าน']);
        } else {
            echo json_encode(['type' => 'error', 'title' => 'ผิดพลาด', 'text' => 'ไม่สามารถเปลี่ยนรหัสผ่านได้กรุณาตรวจสอบ E-Mail']);
        }
    }

    public function sendMail($data)
    {
        $text = 'โปรดยืนยันตัวตนด้วยการกดที่ลิ้งนี้ <b><a href="' . base_url('verify-password?t=' . vEncryption('admin-' . $data['admin']->verify_code)) . '"  target="_blank">Verify</a></b>';
        $email_data = [
            '_header' => 'มีการแก้ไขข้อมูลผู้ใช้งานบนเว็บไซต์',
            '_content' => 'เรียนคุณ ' . $data['admin']->name . ' ' . $data['admin']->surname . ' ท่านได้ส่งคำร้องขอในการเปลี่ยนรหัสผ่าน '
                . 'ด้วยอีเมล ' . $data['admin']->email . ' '
                . $text
        ];
        $requestEmail = [
            'to' => $data['admin']->email,
            'subject' => 'มีการแก้ไขข้อมูลผู้ใช้งานบนเว็บไซต์',
            'message' => view('administrator/template_email', $email_data),
            // 'from' => $from,
            // 'cc' => [],
            // 'bcc' => []
        ];

        send_email($requestEmail);
    }
}
