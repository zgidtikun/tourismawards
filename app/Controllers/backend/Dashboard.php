<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    public function index()
    {
        $data['role']   = $this->db->table("role")->get()->getRowObject();
        
        $data['title']  = 'สถิติการใช้งาน';
        $data['view']   = 'administrator/dashboard/index';
        $data['ci']     = $this;

        return view('administrator/template', $data);
    }

    public function getData()
    {
        
        $type_sub   = $this->db->table("application_type_sub")->get()->getResultObject();
        $attraction   = $this->db->table("application_form")->get()->getResultObject();
        $data['type_sub'] = [];
        $data['attraction'] = [];
        if (!empty($type_sub)) {
            foreach ($type_sub as $key => $value) {
                $data['type_sub'][$value->application_type_id][] = $value->name;
                $data['attraction'][$value->application_type_id][$value->id] = [];
            }
        }

        if (!empty($attraction)) {
            foreach ($attraction as $key => $value) {
                $data['attraction'][$value->application_type_id][$value->application_type_sub_id][] = $value->attraction_name_th;
            }
        }
        // px($data);


        echo json_encode($data);
    }
}
