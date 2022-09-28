<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;

class Officer extends BaseController
{
    public function index()
    {
        $data['result'] = $this->db->table('users U')->select('U.*, MT.name AS member_type_name, AT.name AS award_type_name, AG.name AS assessment_group_name')->join('member_type MT', 'MT.id = U.member_type', 'left')->join('award_type AT', 'AT.id = U.award_type', 'left')->join('assessment_group AG', 'AG.id = U.assessment_group', 'left')->where('U.member_type = 3 AND U.status = 1')->orderBy('U.id', 'desc')->get()->getResultObject();
        $data['award_type'] = $this->db->table('award_type')->get()->getResultObject();
        $data['assessment_group'] = $this->db->table('assessment_group')->get()->getResultObject();
        $data['type']   = 3;


        // Template
        $data['title']  = 'คณะกรรมการ';
        $data['view']   = 'backend/officer/index';
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
        $data['view']   = 'backend/officer/edit';
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
        $data['view']   = 'backend/officer/edit';
        $data['ci']     = $this;

        return view('backend/template', $data);
    }

    public function saveInsert()
    {
        $post = $this->input->getVar();
        if (!empty($post['password'])) {
            $post['password'] = password_hash($post['password'], PASSWORD_DEFAULT);
        }
        if (empty($post["award_type"])) {
            $post["award_type"] = [];
        }
        if (empty($post["assessment_group"])) {
            $post["assessment_group"] = [];
        }
        $data = [
            // 'id'                    => $post[""],
            'prefix'                => $post["prefix"],
            'name'                  => $post["name"],
            'surname'               => $post["surname"],
            'member_type'           => 3,
            'award_type'            => json_encode($post["award_type"]),
            'assessment_group'      => json_encode($post["assessment_group"]),
            'mobile'                => $post["mobile"],
            'email'                 => $post["email"],
            'position'              => $post["position"],
            'username'              => $post["email"],
            'password'              => $post["password"],
            'role_id'               => 3,
            'status'                => 1,
            'created_at'            => date('Y-m-d H:i:s'),
            'updated_at'            => date('Y-m-d H:i:s'),
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
        if (!empty($post['password'])) {
            $post['password'] = password_hash($post['password'], PASSWORD_DEFAULT);
        }
        if (empty($post["award_type"])) {
            $post["award_type"] = [];
        }
        if (empty($post["assessment_group"])) {
            $post["assessment_group"] = [];
        }
        $data = [
            // 'id'                    => $post[""],
            'prefix'                => $post["prefix"],
            'name'                  => $post["name"],
            'surname'               => $post["surname"],
            'member_type'           => 3,
            'award_type'            => json_encode($post["award_type"]),
            'assessment_group'      => json_encode($post["assessment_group"]),
            'mobile'                => $post["mobile"],
            // 'email'                 => $post["email"],
            'position'              => $post["position"],
            // 'username'              => $post["email"],
            // 'role_id'               => 3,
            // 'status'                => 1,
            // 'created_at'            => date('Y-m-d H:i:s'),
            'updated_at'            => date('Y-m-d H:i:s'),
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

    public function tat()
    {
        $data['result'] = $this->db->table('admin A')->select('A.*, MT.name AS member_type_name, AT.name AS award_type_name, AG.name AS assessment_group_name')->join('member_type MT', 'MT.id = A.member_type', 'left')->join('award_type AT', 'AT.id = A.award_type', 'left')->join('assessment_group AG', 'AG.id = A.assessment_group', 'left')->where('A.member_type = 2 AND A.status = 1')->orderBy('A.id', 'desc')->get()->getResultObject();
        $data['award_type'] = $this->db->table('award_type')->get()->getResultObject();
        $data['assessment_group'] = $this->db->table('assessment_group')->get()->getResultObject();
        $data['type']   = 1;

        // Template
        $data['title']  = 'เจ้าหน้าที่ ททท.';
        $data['view']   = 'backend/officer/tat';
        $data['ci']     = $this;

        return view('backend/template', $data);
    }


    public function addTAT()
    {
        // Template
        $data['title']  = 'เพิ่มเจ้าหน้าที่ ททท.';
        $data['view']   = 'backend/officer/edit_tat';
        $data['ci']     = $this;

        return view('backend/template', $data);
    }

    public function editTAT($id)
    {
        $data['result'] = $this->db->table('admin')->where('id', $id)->get()->getRowObject();

        // Template
        $data['title']  = 'แก้ไขเจ้าหน้าที่ ททท.';
        $data['view']   = 'backend/officer/edit_tat';
        $data['ci']     = $this;

        return view('backend/template', $data);
    }

    public function saveInsertTAT()
    {
        $post = $this->input->getVar();
        if (!empty($post['password'])) {
            $post['password'] = password_hash($post['password'], PASSWORD_DEFAULT);
        }
        if (empty($post["award_type"])) {
            $post["award_type"] = [];
        }
        if (empty($post["assessment_group"])) {
            $post["assessment_group"] = [];
        }
        $data = [
            // 'id'                    => $post[""],
            'prefix'                => $post["prefix"],
            'name'                  => $post["name"],
            'surname'               => $post["surname"],
            'member_type'           => 2,
            // 'award_type'            => json_encode($post["award_type"]),
            // 'assessment_group'      => json_encode($post["assessment_group"]),
            'mobile'                => $post["mobile"],
            'email'                 => $post["email"],
            'position'              => $post["position"],
            'username'              => $post["email"],
            'password'              => $post["password"],
            'role_id'               => 2,
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

    public function saveUpdateTAT()
    {
        $post = $this->input->getVar();
        if (!empty($post['password'])) {
            $post['password'] = password_hash($post['password'], PASSWORD_DEFAULT);
        }
        if (empty($post["award_type"])) {
            $post["award_type"] = [];
        }
        if (empty($post["assessment_group"])) {
            $post["assessment_group"] = [];
        }
        $data = [
            // 'id'                    => $post[""],
            'prefix'                => $post["prefix"],
            'name'                  => $post["name"],
            'surname'               => $post["surname"],
            // 'member_type'           => 2,
            // 'award_type'            => json_encode($post["award_type"]),
            // 'assessment_group'      => json_encode($post["assessment_group"]),
            'mobile'                => $post["mobile"],
            // 'email'                 => $post["email"],
            'position'              => $post["position"],
            // 'username'              => $post["email"],
            // 'role_id'               => 3,
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
