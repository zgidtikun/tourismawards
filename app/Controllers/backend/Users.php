<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;

class Users extends BaseController
{
    public function __construct()
    {
        helper(['semail', 'verify']);
    }

    public function index()
    {
        $where = [];
        if (!empty($_GET['keyword'])) {
            $where['name'] = $_GET['keyword'];
            // $where['surname'] = $_GET['keyword'];
            // $where['email'] = $_GET['keyword'];
        }
        $data['result']  = $this->db->table('users')->where('role_id', 1)->like($where, 'match', 'both')->orderBy('status', 'desc')->get()->getResultObject();

        // $data['result'] = $this->db->table('users U')->select('U.*, MT.name AS member_type_name, AT.name AS award_type_name, AG.name AS assessment_group_name, R.user_groups AS role_name')->join('member_type MT', 'MT.id = U.member_type', 'left')->join('award_type AT', 'AT.id = U.award_type', 'left')->join('assessment_group AG', 'AG.id = U.assessment_group', 'left')->where('U.member_type = 1 AND status_delete = 1')->join('role R', 'R.id = U.role_id', 'left')->orderBy('U.id', 'desc')->get()->getResultObject();

        // Template
        $data['title']  = 'ผู้ประกอบการ';
        $data['view']   = 'administrator/users/index';
        $data['ci']     = $this;

        return view('administrator/template', $data);
    }

    public function add()
    {

        // Template
        $data['title']  = 'เพิ่มผู้ประกอบการ';
        $data['view']   = 'administrator/users/edit';
        $data['ci']     = $this;

        return view('administrator/template', $data);
    }

    public function edit($id)
    {
        $data['result'] = $this->db->table('users')->where('id', $id)->get()->getRowObject();
        // $data['member_type'] = $this->db->table('member_type')->get()->getResultObject();
        if (empty($data['result'])) {
            return redirect()->to(session()->_ci_previous_url);
        }

        // Template
        $data['title']  = 'แก้ไขผู้ประกอบการ';
        $data['view']   = 'administrator/users/edit';
        $data['ci']     = $this;

        return view('administrator/template', $data);
    }

    public function all()
    {
        $where = [];
        if (!empty($_GET['keyword'])) {
            $where['name'] = $_GET['keyword'];
            // $where['surname'] = $_GET['keyword'];
            // $where['email'] = $_GET['keyword'];
        }
        if (!empty($_GET['role']) && $_GET['role'] != 'all') {
            $where['role_id'] = $_GET['role'];
        }
        $data['role']   = $this->db->table("role")->get()->getResultObject();

        $data['users']  = $this->db->table('users')->like($where, 'match', 'both')->get()->getResultObject();
        $data['admin']  = $this->db->table('admin')->like($where, 'match', 'both')->get()->getResultObject();
        // pp_sql();
        // $data['member_type'] = $this->db->table('member_type')->get()->getResultObject();
        // px($data['role']);
        $data['search'] = $_GET;

        // Template
        $data['title']  = 'สมาชิกทั้งหมด';
        $data['view']   = 'administrator/users/all';
        $data['ci']     = $this;

        return view('administrator/template', $data);
    }

    public function saveInsert()
    {
        $post = $this->input->getVar();

        // if (!empty($post['password'])) {
        //     $post['password'] = password_hash($post['password'], PASSWORD_DEFAULT);
        // }
        $verify_code = genVerifyCode();
        $data = [
            // 'id'            => $post['id'],
            'prefix'        => $post['prefix'],
            'name'          => $post['name'],
            'surname'       => $post['surname'],
            'member_type'   => 1,
            'mobile'        => $post['mobile'],
            'email'         => $post['email'],
            'username'      => $post['email'],
            // 'password'      => $post['password'],
            'verify_code'   => $verify_code,
            'stage'         => 1,
            'role_id'       => 1,
            'surname'       => $post['surname'],
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s'),
        ];
        $result = $this->db->table('users')->insert($data);
        $insert_id = $this->db->insertID();
        if ($result) {
            if ($this->input->getFiles('profile')) {
                $imagefile = $this->input->getFiles('profile');
                $img = $imagefile['profile'];
                if ($img->isValid() && !$img->hasMoved()) {
                    $path = FCPATH . 'uploads/profile/images/';
                    $originalName = $img->getName();
                    $extension = $img->guessExtension();
                    $newName = genFileName($extension);
                    $accept = ['jpg', 'jpeg', 'gif', 'png', 'webp'];
                    if (in_array($extension, $accept)) {
                        $img->move($path, $newName);
                        $this->db->table('users')->where('id', $insert_id)->update(['profile' => 'uploads/profile/images/' . $newName]);
                    }
                }
            }
            $data = [];
            $data['users'] = $this->db->table('users')->where('id', $insert_id)->get()->getRowObject();
            $this->sendMail($data);
            echo json_encode(['type' => 'success', 'title' => 'สำเร็จ', 'text' => 'บันทึกข้อมูลสำเร็จ']);
        } else {
            echo json_encode(['type' => 'error', 'title' => 'ผิดพลาด', 'text' => 'บันทึกข้อมูลไม่สำเร็จ']);
        }
    }

    public function saveUpdate()
    {
        $post = $this->input->getVar();

        $post['profile'] = $post['profile_old'];
        if ($this->input->getFiles('profile')) {
            $imagefile = $this->input->getFiles('profile');
            $img = $imagefile['profile'];

            if ($img->isValid() && !$img->hasMoved()) {
                $path = FCPATH . 'uploads/profile/images/';
                $extension = $img->guessExtension();
                $newName = genFileName($extension);
                $accept = ['jpg', 'jpeg', 'gif', 'png', 'webp'];
                if (in_array($extension, $accept)) {
                    $img->move($path, $newName);
                    $post['profile'] = 'uploads/profile/images/' . $newName;
                    @unlink($path . $post['profile_old']);
                }
            }
        }

        $data = [
            // 'id'            => $post['id'],
            'prefix'        => $post['prefix'],
            'name'          => $post['name'],
            'surname'       => $post['surname'],
            'profile'       => $post['profile'],
            // 'member_type'   => 1,
            'mobile'        => $post['mobile'],
            // 'email'         => $post['email'],
            // 'username'      => $post['email'],
            // 'password'      => $post['password'],
            // 'captcha'       => $post[''],
            'stage'         => 1,
            'role_id'       => 1,
            // 'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s'),
        ];

        // if (!empty($post['password'])) {
        //     $data['password'] = password_hash($post['password'], PASSWORD_DEFAULT);
        // }
        $result = $this->db->table('users')->where('id', $post['insert_id'])->update($data);
        if ($result) {
            echo json_encode(['type' => 'success', 'title' => 'สำเร็จ', 'text' => 'แก้ไขข้อมูลสำเร็จ']);
        } else {
            echo json_encode(['type' => 'error', 'title' => 'ผิดพลาด', 'text' => 'แก้ไขข้อมูลไม่สำเร็จ']);
        }
    }

    public function active()
    {
        $id = $this->input->getVar('id');
        $user = [
            'status' => 1,
            'status_delete' => 1,
            'stage' => 1,
            'verify_status' => 1,
            'verify_date' => date('Y-m-d H:i:s')
        ];
        $result = $this->db->table('users')->where('id', $id)->update($user);
        if ($result) {
            $data = [];
            $data['users'] = $this->db->table('users')->where('id', $id)->get()->getRowObject();
            $this->sendMail($data);

            $notification = set_noti(
                (object)[
                    'user_id' => $id,
                    'bank' => 'frontend'
                ],
                (object)[
                    'message' => 'ระบบได้ทำการยืนยันการสมัครสมาชิกเรียบร้อยแล้ว',
                    'link' => base_url('awards/application'),
                    'send_date' => date('Y-m-d H:i:s'),
                    'send_by' => session()->account,
                ]
            );

            echo json_encode(['type' => 'success', 'title' => 'สำเร็จ', 'text' => 'ทำการยืนยันการสมัครสำเร็จ']);
        } else {
            echo json_encode(['type' => 'error', 'title' => 'ผิดพลาด', 'text' => 'ทำการยืนยันการสมัครไม่สำเร็จ']);
        }
    }

    public function delete()
    {
        $id = $this->input->getVar('id');
        $result = $this->db->table('users')->where('id', $id)->set(['status' => 0, 'status_delete' => 0])->update();
        if ($result) {
            $data = [];
            $data['users'] = $this->db->table('users')->where('id', $id)->get()->getRowObject();
            echo json_encode(['type' => 'success', 'title' => 'สำเร็จ', 'text' => 'ทำการลบข้อมูลสำเร็จ']);
        } else {
            echo json_encode(['type' => 'error', 'title' => 'ผิดพลาด', 'text' => 'ทำการลบข้อมูลไม่สำเร็จ']);
        }
    }

    public function checkData()
    {
        $email = $this->input->getVar('email');
        $result = $this->db->table('users')->where('email', $email)->get()->getRowObject();
        echo json_encode($result);
    }

    public function sendMail($data)
    {
        // pp($data);
        $text = 'โปรดยืนยันตัวตนด้วยการกดที่ลิ้งนี้ <b><a href="' . base_url('verify-password?t=' . vEncryption('users-' . $data['users']->verify_code)) . '"  target="_blank">Verify</a></b>';
        if ($data['users']->password != "") {
            $text = 'โปรดเข้าสู่ระบบด้วยการกดที่ลิ้งนี้ <b><a href="' . base_url() . '" target="_blank">' . base_url() . '</a></b>';
        }
        // px($data['users']);
        $email_data = [
            '_header' => 'สถานะการอนุมัติการเข้าร่วมประกวด',
            '_content' => 'คุณ ' . $data['users']->name . ' ' . $data['users']->surname . ' ได้รับการอนุมัติลงทะเบียนเข้าประกวดรางวัล '
                . 'อุตสาหกรรมท่องเที่ยวไทย ครั้งที่ 14 ประจำปี 2566 (Thailand Tourism Awards 2023) '
                . 'ด้วยอีเมล ' . $data['users']->email . ' '
                . $text
        ];
        // px($email_data);
        $requestEmail = [
            'to' => $data['users']->email,
            'subject' => 'มีการลงทะเบียนผู้ใช้ใหม่บนเว็บไซต์',
            'message' => view('administrator/template_email', $email_data),
            // 'from' => $from,
            // 'cc' => [],
            // 'bcc' => []
        ];

        send_email($requestEmail);
    }
}
