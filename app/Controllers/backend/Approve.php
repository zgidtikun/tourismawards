<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;

use App\Models\Users;
use App\Models\UsersStage;
use App\Models\ApplicationForm;
use App\Models\ApplicationType;
use App\Models\ApplicationTypeSub;

class Approve extends BaseController
{
    public function __construct()
    {
        helper(['semail', 'verify']);

        $this->Users = new Users;
        $this->UsersStage = new UsersStage;
        $this->ApplicationForm = new ApplicationForm;
        $this->ApplicationType = new ApplicationType;
        $this->ApplicationTypeSub = new ApplicationTypeSub;
    }

    public function index()
    {
        // pp($_GET);
        $like = [];
        $where = [];
        $sub_id = 1;
        if (!empty($_GET['keyword']) && $_GET['keyword'] != "") {
            // $like['attraction_name_th'] = $_GET['keyword'];
            $like['company_name'] = $_GET['keyword'];
        }
        if (!empty($_GET['application_type_id']) && $_GET['application_type_id'] != "") {
            $where['application_type_id'] = $_GET['application_type_id'];
            $sub_id = $_GET['application_type_id'];
        }
        if (!empty($_GET['application_type_sub_id']) && $_GET['application_type_sub_id'] != "") {
            $where['application_type_sub_id'] = $_GET['application_type_sub_id'];
            $sub_id = $_GET['application_type_id'];
        }

        if (!empty(session()->award_type) && session()->award_type != "" && !isAdmin()) {
            $where['application_type_id'] = session()->award_type;
            $sub_id = session()->award_type;
        }

        $data['result'] = $this->ApplicationForm->like($like, 'match', 'both')->where($where)->where('status', 2)->orderBy('id', 'desc')->findAll();
        // pp_sql();

        $data['application_type'] = $this->ApplicationType->findAll();
        $data['application_type_sub'] = $this->ApplicationTypeSub->where('application_type_id', $sub_id)->findAll();

        // Template
        $data['title']  = 'ตรวจสอบใบสมัคร';
        $data['view']   = 'administrator/approve/index';
        $data['ci']     = $this;

        return view('administrator/template', $data);
    }

    public function check()
    {
        $data['application_type'] = $this->ApplicationType->findAll();
        $data['application_type_sub'] = $this->ApplicationTypeSub->findAll();
        // px($data['application_type_sub']);

        // Template
        $data['title']  = 'ตรวจสอบใบสมัคร';
        $data['view']   = 'administrator/approve/check';
        $data['ci']     = $this;

        return view('administrator/template', $data);
    }

    public function edit($id)
    {
        $data['result'] = $this->ApplicationForm->find($id);
        if (empty($data['result'])) {
            show_404();
        }
        $data['id'] = $id;
        $data['application_type'] = $this->ApplicationType->findAll();
        $data['application_type_sub'] = $this->ApplicationTypeSub->where('application_type_id', $data['result']->application_type_id)->findAll();

        // Template
        $data['title']  = 'ตรวจสอบใบสมัคร';
        $data['view']   = 'administrator/approve/edit';
        $data['ci']     = $this;

        return view('administrator/template', $data);
    }

    public function history()
    {
        $like = [];
        $where = [];
        $sub_id = 1;
        // $like['status'] = 0;
        // $like['status'] = 4;
        if (!empty($_GET['keyword']) && $_GET['keyword'] != "") {
            // $like['attraction_name_th'] = $_GET['keyword'];
            $like['company_name'] = $_GET['keyword'];
        }
        if (!empty($_GET['application_type_id']) && $_GET['application_type_id'] != "") {
            $where['application_type_id'] = $_GET['application_type_id'];
            $sub_id = $_GET['application_type_id'];
        }
        if (!empty($_GET['application_type_sub_id']) && $_GET['application_type_sub_id'] != "") {
            $where['application_type_sub_id'] = $_GET['application_type_sub_id'];
        }
        if (!empty($_GET['status']) && $_GET['status'] != "") {
            $like['status'] = $_GET['status'];
        }

        if (!empty(session()->award_type) && session()->award_type != "" && !isAdmin()) {
            $where['application_type_id'] = session()->award_type;
            $sub_id = session()->award_type;
        }

        $data['result'] = $this->ApplicationForm->like($like, 'match', 'both')->where($where)->orderBy('id', 'desc')->findAll();
        // pp_sql();
        // exit;
        // pp($data['result']);

        $data['application_type'] = $this->ApplicationType->findAll();
        $data['application_type_sub'] = $this->ApplicationTypeSub->where('application_type_id', $sub_id)->findAll();

        // Template
        $data['title']  = 'ประวัติการตรวจสอบใบสมัคร';
        $data['view']   = 'administrator/approve/history';
        $data['ci']     = $this;

        return view('administrator/template', $data);
    }

    public function getAplicationTypeSub($application_type_id = 1)
    {
        $result = $this->ApplicationTypeSub->where('application_type_id', $application_type_id)->findAll();
        echo json_encode($result);
    }

    public function saveStatus()
    {
        $post = $this->input->getVar();
        $id = $post['insert_id'];
        unset($post['insert_id']);
        $post['approve_by'] = session()->id;
        $post['approve_name'] = session()->user;
        $post['approve_time'] = date('Y-m-d H:i:s');
        // px($post);

        $result = $this->db->table('application_form')->where('id', $id)->update($post);
        if ($result) {
            $result = $this->ApplicationForm->find($id);
            $users = $this->db->table('users')->where('id', $result->created_by)->get()->getRowObject();
            $message = 'แจ้งผลการอนุมัติใบสมัคร';
            if ($post['status'] == 4) {
                $message = 'ใบสมัครของท่านมีการขอข้อมูลเพิ่มเติม';
            } else if ($post['status'] == 3) {
                $message = 'ใบสมัครของท่านได้รับการอนุมัติเรียบร้อยแล้ว';
            } else if ($post['status'] == 0) {
                $message = 'ใบสมัครของท่านไม่ผ่านการอนุมัติ';
            }

            $email_data = [
                '_header' => $message,
                '_content' => 'เรียนคุณ ' . $users->name . ' ' . $users->surname . ' <br>' . $message
            ];

            $requestEmail = [
                'to' => $users->email,
                'subject' => $message,
                'message' => view('administrator/template_email', $email_data),
                // 'from' => $from,
                // 'cc' => [],
                // 'bcc' => []
            ];

            send_email($requestEmail);

            set_noti(
                (object)[
                    'user_id' => $result->created_by,
                    'bank' => 'frontend'
                ],
                (object)[
                    'message' => $message,
                    'link' => base_url('awards/application'),
                    'send_date' => date('Y-m-d H:i:s'),
                    'send_by' => session()->account,
                ]
            );

            if ($post['status'] == 3) {
                $result = $this->db->table('users')->where('id', $result->created_by)->update(['stage' => 2]);
            }
            echo json_encode(['type' => 'success', 'title' => 'สำเร็จ', 'text' => 'แก้ไขข้อมูลสำเร็จ']);
        } else {
            echo json_encode(['type' => 'error', 'title' => 'ผิดพลาด', 'text' => 'แก้ไขข้อมูลไม่สำเร็จ']);
        }
    }
}
