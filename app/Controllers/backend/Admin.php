<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;
use App\Models\ApplicationType;

class Admin extends BaseController
{
    public function __construct()
    {
        helper(['semail', 'verify']);
        $this->ApplicationType = new ApplicationType();
    }

    public function index()
    {
        $data['result'] = $this->db->table('admin A')->select('A.*, MT.name AS member_type_name, AT.name AS award_type_name, AG.name AS assessment_group_name')->join('member_type MT', 'MT.id = A.member_type', 'left')->join('award_type AT', 'AT.id = A.award_type', 'left')->join('assessment_group AG', 'AG.id = A.assessment_group', 'left')->where('A.member_type = 4 AND A.status = 1')->orderBy('A.id', 'desc')->get()->getResultObject();
        $data['award_type'] = $this->db->table('award_type')->get()->getResultObject();
        $data['assessment_group'] = $this->db->table('assessment_group')->get()->getResultObject();

        // Template
        $data['title']  = 'ผู้ดูแลระบบ';
        $data['view']   = 'administrator/admin/index';
        $data['ci']     = $this;

        return view('administrator/template', $data);
    }

    public function add()
    {
        $data['award_type'] = $this->db->table('award_type')->get()->getResultObject();
        $data['assessment_group'] = $this->db->table('assessment_group')->get()->getResultObject();
        // px($data['award_type']);

        // Template
        $data['title']  = 'เพิ่มคณะกรรมการ';
        $data['view']   = 'administrator/admin/edit';
        $data['ci']     = $this;

        return view('administrator/template', $data);
    }

    public function edit($id)
    {
        $data['result'] = $this->db->table('admin')->where('id', $id)->get()->getRowObject();
        $data['award_type'] = $this->db->table('award_type')->get()->getResultObject();
        $data['assessment_group'] = $this->db->table('assessment_group')->get()->getResultObject();
        if (empty($data['result'])) {
            return redirect()->to(session()->_ci_previous_url);
        }

        // Template
        $data['title']  = 'แก้ไขคณะกรรมการ';
        $data['view']   = 'administrator/admin/edit';
        $data['ci']     = $this;

        return view('administrator/template', $data);
    }

    public function saveInsert()
    {
        $post = $this->input->getVar();
        $imagefile = $this->input->getFiles('profile');
        $img = $imagefile['profile'];

        // if (!empty($post['password'])) {
        //     $post['password'] = password_hash($post['password'], PASSWORD_DEFAULT);
        // }
        $verify_code = genVerifyCode();
        $data = [
            // 'id'                    => $post[""],
            'prefix'                => $post["prefix"],
            'name'                  => $post["name"],
            'surname'               => $post["surname"],
            'member_type'           => 4,
            // 'award_type'            => json_encode($post["award_type"]),
            // 'assessment_group'      => json_encode($post["assessment_group"]),
            'mobile'                => $post["mobile"],
            'email'                 => $post["email"],
            'position'              => $post["position"],
            'username'              => $post["email"],
            // 'password'              => $post["password"],
            'verify_code'           => $verify_code,
            'role_id'               => 4,
            'status'                => 1,
            'created_at'            => date('Y-m-d H:i:s'),
            'updated_at'            => date('Y-m-d H:i:s'),
        ];
        $result = $this->db->table('admin')->insert($data);
        $insert_id = $this->db->insertID();
        if ($result) {
            if ($img->isValid() && !$img->hasMoved()) {
                $path = FCPATH . 'uploads/profile/images/';
                $originalName = $img->getName();
                $extension = $img->guessExtension();
                $newName = genFileName($extension);
                $accept = ['jpg', 'jpeg', 'gif', 'png', 'webp'];
                if (in_array($extension, $accept)) {
                    $img->move($path, $newName);
                    $this->db->table('admin')->where('id', $insert_id)->update(['profile' => 'uploads/profile/images/' . $newName]);
                }
            }
            $data = [];
            $data['admin'] = $this->db->table('admin')->where('id', $insert_id)->get()->getRowObject();
            $this->sendMail($data);
            echo json_encode(['type' => 'success', 'title' => 'สำเร็จ', 'text' => 'บันทึกข้อมูลสำเร็จ']);
        } else {
            echo json_encode(['type' => 'error', 'title' => 'ผิดพลาด', 'text' => 'บันทึกข้อมูลไม่สำเร็จ']);
        }
    }

    public function saveUpdate()
    {
        $post = $this->input->getVar();
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
        } else {
            $post['profile'] = $post['profile_old'];
        }
        
        $data = [
            // 'id'                    => $post[""],
            'prefix'                => $post["prefix"],
            'name'                  => $post["name"],
            'surname'               => $post["surname"],
            'profile'               => $post['profile'],
            // 'member_type'           => 4,
            // 'award_type'            => json_encode($post["award_type"]),
            // 'assessment_group'      => json_encode($post["assessment_group"]),
            'mobile'                => $post["mobile"],
            // 'email'                 => $post["email"],
            'position'              => $post["position"],
            // 'username'              => $post["email"],
            // 'role_id'               => 4,
            // 'status'                => 1,
            // 'created_at'            => date('Y-m-d H:i:s'),
            'updated_at'            => date('Y-m-d H:i:s'),
        ];

        // if (!empty($post['password'])) {
        //     $data['password'] = password_hash($post['password'], PASSWORD_DEFAULT);
        // }
        // px($data);
        $result = $this->db->table('admin')->where('id', $post['insert_id'])->update($data);
        if ($result) {
            echo json_encode(['type' => 'success', 'title' => 'สำเร็จ', 'text' => 'แก้ไขข้อมูลสำเร็จ']);
        } else {
            echo json_encode(['type' => 'error', 'title' => 'ผิดพลาด', 'text' => 'แก้ไขข้อมูลไม่สำเร็จ']);
        }
    }

    public function delete()
    {
        $id = $this->input->getVar('id');
        $result = $this->db->table('admin')->where('id', $id)->set(['status' => 0])->update();
        if ($result) {
            echo json_encode(['type' => 'success', 'title' => 'สำเร็จ', 'text' => 'ทำการลบข้อมูลสำเร็จ']);
        } else {
            echo json_encode(['type' => 'error', 'title' => 'ผิดพลาด', 'text' => 'ทำการลบข้อมูลไม่สำเร็จ']);
        }
    }

    public function checkData()
    {
        $email = $this->input->getVar('email');
        $result = $this->db->table('admin')->where('email', $email)->get()->getRowObject();
        echo json_encode($result);
    }

    public function sendMail($data)
    {
        $text = 'โปรดยืนยันตัวตนด้วยการกดที่ลิ้งนี้ <b><a href="' . base_url('verify-password?t=' . vEncryption('admin-' . $data['admin']->verify_code)) . '"  target="_blank">Verify</a></b>';
        if ($data['admin']->password != "") {
            $text = 'โปรดเข้าสู่ระบบด้วยการกดที่ลิ้งนี้ <b><a href="' . base_url() . '" target="_blank">' . base_url() . '</a></b>';
        }
        $email_data = [
            '_header' => 'มีการลงทะเบียนผู้ใช้ใหม่บนเว็บไซต์',
            '_content' => 'คุณ ' . $data['admin']->name . ' ' . $data['admin']->surname . ' ได้รับการเพิ่มให้เป็นผู้ดูแลระบบ (Admin) '
                . 'อุตสาหกรรมท่องเที่ยวไทย ครั้งที่ 14 ประจำปี 2566 (Thailand Tourism Awards 2023) '
                . 'ด้วยอีเมล ' . $data['admin']->email . ' '
                . $text
        ];
        $requestEmail = [
            'to' => $data['admin']->email,
            'subject' => 'มีการลงทะเบียนผู้ใช้ใหม่บนเว็บไซต์',
            'message' => view('administrator/template_email', $email_data),
            // 'from' => $from,
            // 'cc' => [],
            // 'bcc' => []
        ];

        send_email($requestEmail);
    }
}
