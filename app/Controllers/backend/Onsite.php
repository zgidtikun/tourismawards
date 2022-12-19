<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;

use App\Models\ApplicationForm;
use App\Models\ApplicationType;
use App\Models\ApplicationTypeSub;

class Onsite extends BaseController
{
    public function __construct()
    {
        helper(['semail', 'verify']);

        $this->ApplicationForm = new ApplicationForm;
        $this->ApplicationType = new ApplicationType;
        $this->ApplicationTypeSub = new ApplicationTypeSub;
    }

    public function index()
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

        $data['result'] = $this->db->table('application_form AP')->select('AP.*, US.stage, US.status AS users_stage_status, US.duedate, C.application_form_id, C.assessment_round')->join('users_stage US', 'US.user_id = AP.created_by', 'left')->join('committees C', 'C.application_form_id = AP.id AND C.assessment_round = 2', 'left')->where('C.application_form_id', NULL)->where('US.stage', 2)->where('AP.status', 3)->where('US.status', 1)->like($like, 'match', 'both')->where($where)->orderBy('AP.created_at', 'desc')->get()->getResultObject();

        // pp_sql();
        // px($data['result']);

        $data['application_type'] = $this->ApplicationType->findAll();
        $data['application_type_sub'] = $this->ApplicationTypeSub->where('application_type_id', $sub_id)->findAll();

        // Template
        $data['title']  = "มอบหมายกรรมการรอบลงพื้นที่";
        $data['view']   = 'administrator/onsite/index';
        $data['ci']     = $this;

        return view('administrator/template', $data);
    }

    public function edit($id)
    {
        $data['result'] = $this->ApplicationForm->find($id);
        // pp($data['result']);
        if (empty($data['result'])) {
            show_404();
        }
        $data['id'] = $id;
        $data['application_type'] = $this->ApplicationType->findAll();
        $data['application_type_sub'] = $this->ApplicationTypeSub->where('application_type_id', $data['result']->application_type_id)->findAll();

        $data['status_1'] = $this->db->table('users')->where('role_id', 3)->like('assessment_group', '"1"', 'both')->get()->getResultObject();
        $data['status_2'] = $this->db->table('users')->where('role_id', 3)->like('assessment_group', '"2"', 'both')->get()->getResultObject();
        $data['status_3'] = $this->db->table('users')->where('role_id', 3)->like('assessment_group', '"3"', 'both')->get()->getResultObject();

        $data['committees'] = $this->db->table('committees')->where('application_form_id', $id)->where('assessment_round', 2)->get()->getRowObject();

        $data['assessment_group'] = $this->db->table('assessment_group')->get()->getResultObject();
        $data['question'] = $this->db->table('question')->where('application_type_sub_id', $data['result']->application_type_sub_id)->where('onside_status', 1)->get()->getResultObject();

        // px($data['question']);
        $question = [];
        if (!empty($data['question'])) {
            foreach ($data['question'] as $key => $value) {
                $question[$value->assessment_group_id][] = $value;
            }
        }
        $data['question'] = $question;

        // Template
        $data['title']  = 'ลงพื้นที่';
        $data['view']   = 'administrator/onsite/edit';
        $data['ci']     = $this;

        return view('administrator/template', $data);
    }

    public function saveInsert()
    {
        $post = $this->input->getVar();
        $count = array_merge($post['tourism'], $post['supporting']);
        $count = array_merge($count, $post['responsibility']);
        $count = array_unique($count);
        $data = [
            // 'id'                        => $post['id'],
            'application_form_id'       => $post['application_form_id'],
            'users_id'                  => $post['users_id'],
            'admin_id_tourism'          => json_encode($post['tourism']),
            'admin_id_supporting'       => json_encode($post['supporting']),
            'admin_id_responsibility'   => json_encode($post['responsibility']),
            'admin_count'               => count($count),
            'assessment_round'          => 2,
            'created_by'                => session()->id,
            'created_at'                => date('Y-m-d H:i:s'),
            'updated_by'                => session()->id,
            'updated_at'                => date('Y-m-d H:i:s'),
        ];

        $result = $this->db->table('committees')->insert($data);
        $insert_id = $this->db->insertID();
        if ($result) {
            $this->sendMail($insert_id);
            echo json_encode(['type' => 'success', 'title' => 'สำเร็จ', 'text' => 'บันทึกข้อมูลสำเร็จ']);
        } else {
            echo json_encode(['type' => 'error', 'title' => 'ผิดพลาด', 'text' => 'บันทึกข้อมูลไม่สำเร็จ']);
        }
    }

    public function saveUpdate()
    {
        $post = $this->input->getVar();
        $count = array_merge($post['tourism'], $post['supporting']);
        $count = array_merge($count, $post['responsibility']);
        $count = array_unique($count);
        // px($count);
        $data = [
            // 'id'                        => $post['id'],
            'application_form_id'       => $post['application_form_id'],
            'users_id'                  => $post['users_id'],
            'admin_id_tourism'          => json_encode($post['tourism']),
            'admin_id_supporting'       => json_encode($post['supporting']),
            'admin_id_responsibility'   => json_encode($post['responsibility']),
            'admin_count'               => count($count),
            'assessment_round'          => 2,
            'created_by'                => session()->id,
            'created_at'                => date('Y-m-d H:i:s'),
            'updated_by'                => session()->id,
            'updated_at'                => date('Y-m-d H:i:s'),
        ];

        $result = $this->db->table('committees')->where('id', $post['insert_id'])->update($data);
        if ($result) {
            echo json_encode(['type' => 'success', 'title' => 'สำเร็จ', 'text' => 'บันทึกข้อมูลสำเร็จ']);
        } else {
            echo json_encode(['type' => 'error', 'title' => 'ผิดพลาด', 'text' => 'บันทึกข้อมูลไม่สำเร็จ']);
        }
    }

    public function getScore($id)
    {
        $result = $this->db->table('estimate_score')->where('application_id', $id)->get()->getRowObject();
        echo json_encode($result);
    }

    public function estimate()
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
            $where['US.status'] = $_GET['status'];
        }

        if (!empty(session()->award_type) && session()->award_type != "" && !isAdmin()) {
            $where['application_type_id'] = session()->award_type;
            $sub_id = session()->award_type;
        }

        $data['result'] = $this->db->table('application_form AP')->select('AP.*, US.stage, US.status AS users_stage_status, US.duedate, C.application_form_id, C.assessment_round')->join('users_stage US', 'US.user_id = AP.created_by', 'left')->join('committees C', 'C.application_form_id = AP.id AND C.assessment_round = 2', 'left')->where('C.application_form_id is NOT NULL', NULL, FALSE)->where('US.stage', 2)->where('AP.status', 3)->like($like, 'match', 'both')->where($where)->orderBy('AP.created_at', 'desc')->get()->getResultObject();

        $data['assessment_group'] = $this->db->table('assessment_group')->get()->getResultObject();
        $data['application_type'] = $this->ApplicationType->findAll();
        $data['application_type_sub'] = $this->ApplicationTypeSub->where('application_type_id', $sub_id)->findAll();

        // Template
        $data['title']  = "การประเมินรอบลงพื้นที่";
        $data['view']   = 'administrator/onsite/estimate';
        $data['ci']     = $this;

        return view('administrator/template', $data);
    }

    public function view($id)
    {
        $data['result'] = $this->ApplicationForm->find($id);
        // pp($data['result']);
        if (empty($data['result'])) {
            show_404();
        }
        $data['id'] = $id;
        $data['application_type'] = $this->ApplicationType->findAll();
        $data['application_type_sub'] = $this->ApplicationTypeSub->where('application_type_id', $data['result']->application_type_id)->findAll();

        $data['status_1'] = $this->db->table('users')->where('role_id', 3)->like('assessment_group', '"1"', 'both')->get()->getResultObject();
        $data['status_2'] = $this->db->table('users')->where('role_id', 3)->like('assessment_group', '"2"', 'both')->get()->getResultObject();
        $data['status_3'] = $this->db->table('users')->where('role_id', 3)->like('assessment_group', '"3"', 'both')->get()->getResultObject();

        $data['committees'] = $this->db->table('committees')->where('application_form_id', $id)->where('assessment_round', 2)->get()->getRowObject();

        $data['assessment_group'] = $this->db->table('assessment_group')->get()->getResultObject();
        $data['question'] = $this->db->table('question')->where('application_type_sub_id', $data['result']->application_type_sub_id)->where('onside_status', 1)->get()->getResultObject();

        // px($data['question']);
        $question = [];
        if (!empty($data['question'])) {
            foreach ($data['question'] as $key => $value) {
                $question[$value->assessment_group_id][] = $value;
            }
        }
        $data['question'] = $question;

        // Template
        $data['title']  = 'ลงพื้นที่';
        $data['view']   = 'administrator/onsite/view_edit';
        $data['ci']     = $this;

        return view('administrator/template', $data);
    }

    public function sendMail($insert_id)
    {
        $app = new \Config\App();

        // ส่ง E-Mail
        $result = $this->db->table('committees CM')->select('CM.*, AF.attraction_name_th')->join('application_form AF', 'AF.id = CM.application_form_id')->where('CM.id', $insert_id)->get()->getRowObject();

        if (!empty(json_decode($result->admin_id_tourism))) {
            foreach (json_decode($result->admin_id_tourism) as $key => $value) {
                $users = $this->db->table('users')->where('id', $value)->get()->getRowObject();

                $message = 'ท่านได้รับการมอบหมายให้ประเมิน ' . $result->attraction_name_th . ' ด้าน Tourism Excellence กรุณาเข้าสู่ระบบเพื่อทำการประเมินภายในวันที่ ' . $app->Pre_expired;
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
                        'user_id' => $users->id,
                        'bank' => 'frontend'
                    ],
                    (object)[
                        'message' => $message,
                        'link' => base_url('awards/boards'),
                        'send_date' => date('Y-m-d H:i:s'),
                        'send_by' => session()->account,
                    ]
                );
            }
        }

        if (!empty(json_decode($result->admin_id_supporting))) {
            foreach (json_decode($result->admin_id_supporting) as $key => $value) {
                $users = $this->db->table('users')->where('id', $value)->get()->getRowObject();

                $message = 'ท่านได้รับการมอบหมายให้ประเมิน ' . $result->attraction_name_th . ' ด้าน Supporting Business & Marketing Factors กรุณาเข้าสู่ระบบเพื่อทำการประเมินภายในวันที่ ' . $app->Pre_expired;
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
                        'user_id' => $users->id,
                        'bank' => 'frontend'
                    ],
                    (object)[
                        'message' => $message,
                        'link' => base_url('awards/application'),
                        'send_date' => date('Y-m-d H:i:s'),
                        'send_by' => session()->account,
                    ]
                );
            }
        }

        if (!empty(json_decode($result->admin_id_responsibility))) {
            foreach (json_decode($result->admin_id_responsibility) as $key => $value) {
                $users = $this->db->table('users')->where('id', $value)->get()->getRowObject();

                $message = 'ท่านได้รับการมอบหมายให้ประเมิน ' . $result->attraction_name_th . ' กรุณาเข้าสู่ระบบเพื่อทำการประเมินภายในวันที่ ' . $app->Pre_expired;
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
                        'user_id' => $users->id,
                        'bank' => 'frontend'
                    ],
                    (object)[
                        'message' => $message,
                        'link' => base_url('awards/application'),
                        'send_date' => date('Y-m-d H:i:s'),
                        'send_by' => session()->account,
                    ]
                );
            }
        }
    }

    public function getAnswer()
    {
        $post = $this->input->getVar();
        $result = $this->db->table('answer')->where('question_id', $post['id'])->where('reply_by', $post['created_by'])->get()->getRowObject();
        echo json_encode($result);
    }
}
