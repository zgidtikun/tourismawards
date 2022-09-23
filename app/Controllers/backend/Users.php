<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;

class Users extends BaseController
{
    public function index()
    {
        $where = [];
        $where['status_delete'] = 1;
        $data['result'] = $this->db->table('users U')->select('U.*, MT.name AS member_type_name, R.user_groups AS role_name')->join('member_type MT', 'MT.id = U.member_type', 'left')->join('role R', 'R.id = U.role_id', 'left')->where($where)->orderBy('U.id', 'desc')->get()->getResultObject();

        // Template
        $data['title']  = 'ผู้ประกอบการ';
        $data['view']   = 'backend/users/index';
        $data['ci']     = $this;

        return view('backend/template', $data);
    }

    public function add()
    {

        // Template
        $data['title']  = 'เพิ่มผู้ประกอบการ';
        $data['view']   = 'backend/users/edit';
        $data['ci']     = $this;

        return view('backend/template', $data);
    }

    public function edit($id)
    {
        $data['result'] = $this->db->table('users')->where('id', $id)->get()->getRowObject();
        // $data['member_type'] = $this->db->table('member_type')->get()->getResultObject();

        // Template
        $data['title']  = 'แก้ไขผู้ประกอบการ';
        $data['view']   = 'backend/users/edit';
        $data['ci']     = $this;

        return view('backend/template', $data);
    }

    public function saveInsert()
    {
        $post = $this->input->getVar();

        if (!empty($post['password'])) {
            $post['password'] = password_hash($post['password'], PASSWORD_DEFAULT);
        }
        $data = [
            // 'id'            => $post['id'],
            // 'prefix'        => $post[''],
            'name'          => $post['name'],
            'surname'       => $post['surname'],
            'member_type'   => 2,
            'mobile'        => $post['mobile'],
            'email'         => $post['email'],
            'username'      => $post['email'],
            'password'      => $post['password'],
            // 'captcha'       => $post[''],
            'role_id'       => 1,
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s'),
        ];
        $result = $this->db->table('users')->insert($data);
        if ($result) {
            echo json_encode(['type' => 'success', 'title' => 'สำเร็จ', 'text' => 'บันทึกข้อมูลสำเร็จ']);
        } else {
            echo json_encode(['type' => 'error', 'title' => 'ผิดพลาด', 'text' => 'บันทึกข้อมูลไม่สำเร็จ']);
        }
    }

    public function saveUpdate()
    {
        $post = $this->input->getVar();
        $data = [
            // 'id'            => $post['id'],
            // 'prefix'        => $post[''],
            'name'          => $post['name'],
            'surname'       => $post['surname'],
            'member_type'   => 2,
            'mobile'        => $post['mobile'],
            // 'email'         => $post['email'],
            // 'username'      => $post['email'],
            // 'password'      => $post['password'],
            // 'captcha'       => $post[''],
            'role_id'       => 1,
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s'),
        ];

        if (!empty($post['password'])) {
            $data['password'] = password_hash($post['password'], PASSWORD_DEFAULT);
        }
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
        $result = $this->db->table('users')->where('id', $id)->set(['status' => 1, 'status_delete' => 1])->update();
        if ($result) {
            $data = [];
            $data['users'] = $this->db->table('users')->where('id', $id)->get()->getRowObject();
            $this->sendMail($data);
            echo json_encode(['type' => 'success', 'title' => 'สำเร็จ', 'text' => 'ทำการเปลี่ยนสถานะสำเร็จ']);
        } else {
            echo json_encode(['type' => 'error', 'title' => 'ผิดพลาด', 'text' => 'ทำการเปลี่ยนสถานะไม่สำเร็จ']);
        }
    }

    public function delete()
    {
        $id = $this->input->getVar('id');
        $result = $this->db->table('users')->where('id', $id)->set(['status' => 0, 'status_delete' => 0])->update();
        if ($result) {
            $data = [];
            $data['users'] = $this->db->table('users')->where('id', $id)->get()->getRowObject();
            $this->sendMail($data);
            echo json_encode(['type' => 'success', 'title' => 'สำเร็จ', 'text' => 'ทำการลบข้อมูลสำเร็จ']);
        } else {
            echo json_encode(['type' => 'error', 'title' => 'ผิดพลาด', 'text' => 'ทำการลบข้อมูลไม่สำเร็จ']);
        }
    }

    public function sendMail($data)
    {
        // pp($data);
    }
}
