<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;

class Directors extends BaseController
{
    public function index($type = 1)
    {
        $data['type']   = $type;
        if ($type == 1) {
            $title  = 'เพิ่มกรรมการประเมินขั้นต้น';
        } else if ($type == 2) {
            $title  = 'เพิ่มกรรมการรอบลงพื้นที่';
        }

        // Template
        $data['title']  = $title;
        $data['view']   = 'backend/directors/index';
        $data['ci']     = $this;

        return view('backend/template', $data);
    }

    public function initial()
    {

        // Template
        $data['title']  = 'เพิ่มกรรมการประเมินขั้นต้น';
        $data['view']   = 'backend/directors/initial';
        $data['ci']     = $this;

        return view('backend/template', $data);
    }

    public function area()
    {

        // Template
        $data['title']  = 'เพิ่มกรรมการรอบลงพื้นที่';
        $data['view']   = 'backend/directors/area';
        $data['ci']     = $this;

        return view('backend/template', $data);
    }

    public function getUserApprove()
    {
        $data['status_1'] = $this->db->table('users')->like('assessment_group', '"1"', 'both')->get()->getResultObject();
        $data['status_2'] = $this->db->table('users')->like('assessment_group', '"2"', 'both')->get()->getResultObject();
        $data['status_3'] = $this->db->table('users')->like('assessment_group', '"3"', 'both')->get()->getResultObject();
        echo json_encode($data);
    }

    public function saveInsert()
    {
        $post = $this->input->getVar();
        px($post);
        $data = [
            // 'id'                    => $post[''],
            'application_form_id'   => $post['application_form_id'],
            'users_id'              => $post['users_id'],
            'admin_id'              => $post[''],
            'assessment_round'      => $post['assessment_round'],
            'created_by'            => $post[''],
            'created_at'            => date('Y-m-d H:i:s'),
            'updated_by'            => "",
            'updated_at'            => date('Y-m-d H:i:s'),
        ];
        $result = $this->db->table('committees')->insert($data);
        if ($result) {
            echo json_encode(['type' => 'success', 'title' => 'สำเร็จ', 'text' => 'บันทึกข้อมูลสำเร็จ']);
        } else {
            echo json_encode(['type' => 'error', 'title' => 'ผิดพลาด', 'text' => 'บันทึกข้อมูลไม่สำเร็จ']);
        }
    }
}
