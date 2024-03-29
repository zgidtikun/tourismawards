<?php
// Complete
namespace App\Controllers\Backend;

use App\Controllers\BaseController;

use App\Models\ApplicationForm;
use App\Models\ApplicationType;
use App\Models\ApplicationTypeSub;

class Complete extends BaseController
{
    private $ApplicationForm;
    private $ApplicationType;
    private $ApplicationTypeSub;
    
    public function __construct()
    {
        helper(['semail', 'verify', 'log']);
        
        $this->ApplicationForm = new ApplicationForm;
        $this->ApplicationType = new ApplicationType;
        $this->ApplicationTypeSub = new ApplicationTypeSub;
    }

    public function index()
    {
        $like = [];
        $where = [];
        $where_type = [];
        $sub_id = 1;
        $sort = 'desc';
        // $like['status'] = 0;
        // $like['status'] = 4;
        if (!empty($_GET['keyword']) && $_GET['keyword'] != "") {
            $like['attraction_name_th'] = $_GET['keyword'];
            // $like['company_name'] = $_GET['keyword'];
            // $like['code'] = $_GET['keyword'];
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
        if (!empty($_GET['sort'])) {
            $sort = $_GET['sort'];
        }

        if (!empty(session()->award_type) && session()->award_type != "" && !isAdmin()) {
            $where['application_type_id'] = session()->award_type;
            $where_type['id'] = session()->award_type;
            $sub_id = session()->award_type;
        }

        $data['result'] = $this->db->table('application_form AP')->select('AP.*, US.stage, US.status AS users_stage_status, US.duedate, ES.score_prescreen_tt, ES.score_onsite_tt')->join('users_stage US', 'US.user_id = AP.created_by AND US.status >= 6', 'left')->join('estimate_score ES', 'ES.application_id = AP.id', 'left')->where('US.stage', 2)->where($where)->like($like, 'match', 'both')->orderBy('AP.created_at', $sort)->get()->getResultObject();

        // pp_sql();
        // px($data['result']);
        $data['assessment_group'] = $this->db->table('assessment_group')->get()->getResultObject();
        $data['application_type'] = $this->ApplicationType->where($where_type)->findAll();
        $data['application_type_sub'] = $this->ApplicationTypeSub->where('application_type_id', $sub_id)->findAll();

        // Template
        $data['title']  = "การประเมินที่เสร็จสมบูรณ์";
        $data['view']   = 'administrator/complete/index';
        $data['ci']     = $this;

        return view('administrator/template', $data);
    }

    public function viewEdit($id)
    {
        $data['result'] = $this->ApplicationForm->find($id);
        if (empty($data['result'])) {
            show_404();
        }
        $data['id'] = $id;
        $data['application_type'] = $this->ApplicationType->findAll();
        $data['application_type_sub'] = $this->ApplicationTypeSub->where('application_type_id', $data['result']->application_type_id)->findAll();

        // Template
        $data['title']  = 'ดำเนินการเสร็จสมบูรณ์';
        $data['view']   = 'administrator/complete/view_edit';
        $data['ci']     = $this;

        return view('administrator/template', $data);
    }

    public function getScore($id)
    {
        $result = $this->db->table('estimate_score')->where('application_id', $id)->get()->getRowObject();
        echo json_encode($result);
    }

    public function reSubmit()
    {
        $post = $this->input->getVar();
        $result = $this->db->table('users_stage')->where('user_id', $post['user_id'])->where('stage', 2)->update(['status' => 2]);
        $result = $this->db->table('estimate_individual')->where('application_id', $post['app_id'])->update(['score_onsite' => NULL]);

        save_log_activety([
            'module' => 'step_flow_checking',
            'action' => 'application-'.$post['app_id'],
            'bank' => 'backend',
            'user_id' => session()->id,
            'datetime' => date('Y-m-d H:i:s'),
            'data' => 'ย้อนสถานะกลับไปประเมินรอบลงพื้นที่'
        ]);

        if ($result) {
            $this->sendMail($post['user_id']);
            echo json_encode(['type' => 'success', 'title' => 'สำเร็จ', 'text' => 'เปิดสิทธิ์ให้กรรมการประเมินรอบลงพื้นที่ใหม่สำเร็จ']);
        } else {
            echo json_encode(['type' => 'error', 'title' => 'ผิดพลาด', 'text' => 'เปิดสิทธิ์ให้กรรมการประเมินรอบลงพื้นที่ใหม่ไม่สำเร็จ']);
        }
    }

    public function sendMail($users_id)
    {
        $app = new \Config\App();

        // ส่ง E-Mail
        $result = $this->db->table('committees CM')->select('CM.*, AF.attraction_name_th')->join('application_form AF', 'AF.id = CM.application_form_id')->where('CM.users_id', $users_id)->where('assessment_round', 2)->get()->getRowObject();

        if (!empty(json_decode($result->admin_id_tourism))) {
            foreach (json_decode($result->admin_id_tourism) as $key => $value) {
                $users = $this->db->table('users')->where('id', $value)->get()->getRowObject();

                $subject = 'แบบประเมินของ ' . $result->attraction_name_th . ' สามารถแก้ไขประเมินได้';
                $message = 'แบบประเมินของ ' . $result->attraction_name_th . ' สามารถแก้ไขผลการประเมินได้ กรุณาล็อกอินเข้าสู่เว็บไซต์ เพื่อแก้ไขผลการประเมิน และส่งผลประเมินเข้าระบบอีกครั้ง หรือหากท่านไม่ต้องการแก้ไขผลการประเมิน ให้ท่านล็อกอินเข้าสู่เว็บไซต์และกดส่งผลประเมินเข้าระบบอีกครั้ง';
                $message_noti = 'แบบประเมินของ ' . $result->attraction_name_th . ' สามารถแก้ไขผลการประเมินได้ เมื่อท่านแก้ไขผลการประเมินเรียบร้อยแล้วให้ส่งผลประเมินเข้าระบบอีกครั้ง หรือหากท่านไม่ต้องการแก้ไขผลการประเมิน ให้กดส่งผลประเมินเข้าระบบอีกครั้ง';
                $email_data = [
                    '_header' => 'เรียนคุณ ' . $users->name . ' ' . $users->surname,
                    '_content' => 'เรียนคุณ ' . $users->name . ' ' . $users->surname . ' <br>' . $message
                ];

                $requestEmail = [
                    'to' => $users->email,
                    'subject' => $subject,
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
                        'message' => $message_noti,
                        'link' => base_url('boards'),
                        'send_date' => date('Y-m-d H:i:s'),
                        'send_by' => session()->account,
                    ]
                );
            }
        }

        if (!empty(json_decode($result->admin_id_supporting))) {
            foreach (json_decode($result->admin_id_supporting) as $key => $value) {
                $users = $this->db->table('users')->where('id', $value)->get()->getRowObject();

                $subject = 'แบบประเมินของ ' . $result->attraction_name_th . ' สามารถแก้ไขประเมินได้';
                $message = 'แบบประเมินของ ' . $result->attraction_name_th . ' สามารถแก้ไขผลการประเมินได้ กรุณาล็อกอินเข้าสู่เว็บไซต์ เพื่อแก้ไขผลการประเมิน และส่งผลประเมินเข้าระบบอีกครั้ง หรือหากท่านไม่ต้องการแก้ไขผลการประเมิน ให้ท่านล็อกอินเข้าสู่เว็บไซต์และกดส่งผลประเมินเข้าระบบอีกครั้ง';
                $message_noti = 'แบบประเมินของ ' . $result->attraction_name_th . ' สามารถแก้ไขผลการประเมินได้ เมื่อท่านแก้ไขผลการประเมินเรียบร้อยแล้วให้ส่งผลประเมินเข้าระบบอีกครั้ง หรือหากท่านไม่ต้องการแก้ไขผลการประเมิน ให้กดส่งผลประเมินเข้าระบบอีกครั้ง';
                $email_data = [
                    '_header' => 'เรียนคุณ ' . $users->name . ' ' . $users->surname,
                    '_content' => 'เรียนคุณ ' . $users->name . ' ' . $users->surname . ' <br>' . $message
                ];
                
                $requestEmail = [
                    'to' => $users->email,
                    'subject' => $subject,
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
                        'message' => $message_noti,
                        'link' => base_url('boards'),
                        'send_date' => date('Y-m-d H:i:s'),
                        'send_by' => session()->account,
                    ]
                );
            }
        }

        if (!empty(json_decode($result->admin_id_responsibility))) {
            foreach (json_decode($result->admin_id_responsibility) as $key => $value) {
                $users = $this->db->table('users')->where('id', $value)->get()->getRowObject();

                $subject = 'แบบประเมินของ ' . $result->attraction_name_th . ' สามารถแก้ไขประเมินได้';
                $message = 'แบบประเมินของ ' . $result->attraction_name_th . ' สามารถแก้ไขผลการประเมินได้ กรุณาล็อกอินเข้าสู่เว็บไซต์ เพื่อแก้ไขผลการประเมิน และส่งผลประเมินเข้าระบบอีกครั้ง หรือหากท่านไม่ต้องการแก้ไขผลการประเมิน ให้ท่านล็อกอินเข้าสู่เว็บไซต์และกดส่งผลประเมินเข้าระบบอีกครั้ง';
                $message_noti = 'แบบประเมินของ ' . $result->attraction_name_th . ' สามารถแก้ไขผลการประเมินได้ เมื่อท่านแก้ไขผลการประเมินเรียบร้อยแล้วให้ส่งผลประเมินเข้าระบบอีกครั้ง หรือหากท่านไม่ต้องการแก้ไขผลการประเมิน ให้กดส่งผลประเมินเข้าระบบอีกครั้ง';
                $email_data = [
                    '_header' => 'เรียนคุณ ' . $users->name . ' ' . $users->surname,
                    '_content' => 'เรียนคุณ ' . $users->name . ' ' . $users->surname . ' <br>' . $message
                ];

                $requestEmail = [
                    'to' => $users->email,
                    'subject' => $subject,
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
                        'message' => $message_noti,
                        'link' => base_url('boards'),
                        'send_date' => date('Y-m-d H:i:s'),
                        'send_by' => session()->account,
                    ]
                );
            }
        }
    }
}
