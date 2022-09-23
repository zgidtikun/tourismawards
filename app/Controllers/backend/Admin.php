<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;

class Admin extends BaseController
{
    public function index()
    {
        $data['result'] = $this->db->table('admin A')->select('A.*, MT.name AS member_type_name, AT.name AS award_type_name, AG.name AS assessment_group_name')->join('member_type MT', 'MT.id = A.member_type', 'left')->join('award_type AT', 'AT.id = A.award_type', 'left')->join('assessment_group AG', 'AG.id = A.assessment_group', 'left')->where('A.member_type = 4 AND A.status = 1')->orderBy('A.id', 'desc')->get()->getResultObject();
        $data['award_type'] = $this->db->table('award_type')->get()->getResultObject();
        $data['assessment_group'] = $this->db->table('assessment_group')->get()->getResultObject();


        // Template
        $data['title']  = 'ผู้ดูแลระะบบ';
        $data['view']   = 'backend/admin/index';
        $data['ci']     = $this;

        return view('backend/template', $data);
    }

    public function add()
    {
        $data['award_type'] = $this->db->table('award_type')->get()->getResultObject();
        $data['assessment_group'] = $this->db->table('assessment_group')->get()->getResultObject();
        // px($data['award_type']);

        // Template
        $data['title']  = 'เพิ่มคณะกรรมการ';
        $data['view']   = 'backend/admin/edit';
        $data['ci']     = $this;

        return view('backend/template', $data);
    }

    public function edit($id)
    {
        $data['result'] = $this->db->table('admin')->where('id', $id)->get()->getRowObject();
        $data['award_type'] = $this->db->table('award_type')->get()->getResultObject();
        $data['assessment_group'] = $this->db->table('assessment_group')->get()->getResultObject();

        // Template
        $data['title']  = 'แก้ไขคณะกรรมการ';
        $data['view']   = 'backend/admin/edit';
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
            'password'              => $post["password"],
            'role_id'               => 4,
            'status'                => 1,
            'created_at'            => date('Y-m-d H:i:s'),
            'updated_at'            => date('Y-m-d H:i:s'),
        ];
        $result = $this->db->table('admin')->insert($data);
        if ($result) {
            echo json_encode(['type' => 'success', 'title' => 'สำเร็จ', 'text' => 'บันทึกข้อมูลสำเร็จ']);
        } else {
            echo json_encode(['type' => 'error', 'title' => 'ผิดพลาด', 'text' => 'บันทึกข้อมูลไม่สำเร็จ']);
        }
    }

    public function saveUpdate()
    {
        $post = $this->input->getVar();
        if (!empty($post['password'])) {
            $post['password'] = password_hash($post['password'], PASSWORD_DEFAULT);
        }
        $data = [
            // 'id'                    => $post[""],
            'prefix'                => $post["prefix"],
            'name'                  => $post["name"],
            'surname'               => $post["surname"],
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

        if (!empty($post['password'])) {
            $data['password'] = password_hash($post['password'], PASSWORD_DEFAULT);
        }
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
}
