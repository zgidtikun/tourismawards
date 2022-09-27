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

    public function getAdmin()
    {
        $text = $this->input->getVar('text');
        // pp($text);
        $result = $this->db->table('admin')->like('name', $text, 'both')->get()->getResultObject();
        echo json_encode($result);
    }
}
