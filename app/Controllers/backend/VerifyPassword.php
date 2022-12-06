<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;

class VerifyPassword extends BaseController
{

    public function __construct()
    {
        helper('verify');
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
}