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
    private $Users;
    private $UsersStage;
    private $ApplicationForm;
    private $ApplicationType;
    private $ApplicationTypeSub;

    public function __construct()
    {
        helper(['semail', 'verify', 'log']);

        $this->Users = new Users;
        $this->UsersStage = new UsersStage;
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
        if (!empty($_GET['keyword']) && $_GET['keyword'] != "") {
            $like['attraction_name_th'] = $_GET['keyword'];
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
            $where_type['id'] = session()->award_type;
            $sub_id = session()->award_type;
        }
        if (array_key_exists('status', $_GET) && $_GET['status'] != "") {
            $where['status'] = $_GET['status'];
        } else {
            $where['status >= '] = '2';
        }

        $data['result'] = $this->ApplicationForm->orLike($like, 'match', 'both')->where($where)->orderBy('id', 'desc')->findAll();

        $data['application_type'] = $this->ApplicationType->where($where_type)->findAll();
        $data['application_type_sub'] = $this->ApplicationTypeSub->where('application_type_id', $sub_id)->findAll();

        // Template
        $data['title']  = 'ตรวจสอบสถานะใบสมัคร';
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
        $data['title']  = 'ตรวจสอบสถานะใบสมัคร';
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
        $where_type = [];
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
            $where_type['id'] = session()->award_type;
            $sub_id = session()->award_type;
        }

        $data['result'] = $this->ApplicationForm->like($like, 'match', 'both')->where($where)->orderBy('id', 'desc')->findAll();

        $data['application_type'] = $this->ApplicationType->where($where_type)->findAll();
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
        try {
            $post = $this->input->getVar();
            $id = $post['insert_id'];
            unset($post['insert_id']);
            $post['approve_by'] = session()->id;
            $post['approve_name'] = session()->user;
            $post['approve_time'] = date('Y-m-d H:i:s');

            if ($post['status'] == 4) {
                $post['request_time'] = date('Y-m-d H:i:s');
            }

            $app = $this->db->table('application_form')->where('id', $id)->get()->getRowObject();
            if (!empty($app)) {
                if ($app->status == 0) {
                    echo json_encode(['type' => 'error', 'title' => 'ผิดพลาด', 'text' => 'ใบสมัครนี้ถูกปฏิเสธโดย ' . $app->approve_name]);
                    exit;
                }
                if ($app->status == 3) {
                    echo json_encode(['type' => 'error', 'title' => 'ผิดพลาด', 'text' => 'ใบสมัครนี้ถูกอนุมัติโดย ' . $app->approve_name]);
                    exit;
                }
            }

            $result = $this->db->table('application_form')->where('id', $id)->update($post);
            if ($result) {
                $result = $this->ApplicationForm->find($id);
                $users = $this->db->table('users')->where('id', $result->created_by)->get()->getRowObject();
                if ($post['status'] == 3) {
                    $this->db->table('users')->where('id', $result->created_by)->update(['stage' => 2]);
                }

                save_log_activety([
                    'module' => 'step_flow_checking',
                    'action' => 'application-' . $id,
                    'bank' => 'backend',
                    'user_id' => session()->id,
                    'datetime' => date('Y-m-d H:i:s'),
                    'data' => 'อัพเดตสถานะใบสมัคร (status: ' . $post['status'] . ')'
                ]);

                $subject = '';
                $message = '';

                $link_redirect = base_url('awards/application');
                if ($post['status'] == 4) {
                    $subject = 'ใบสมัครมีการขอข้อมูลเพิ่มเติม';
                    $message = 'ใบสมัครของท่านยังไม่สมบูรณ์ กรุณาล็อกอินเข้าสู่เว็บไซต์เพื่อตรวจสอบการขอข้อมูลเพิ่มเติม และส่งข้อมูลตอบกลับภายใน 24 ชั่วโมง';
                    $message_noti = 'ใบสมัครของท่านยังไม่สมบูรณ์ กรุณาตรวจสอบข้อมูลเพิ่มเติม และส่งข้อมูลตอบกลับภายใน 24 ชั่วโมง';
                } else if ($post['status'] == 3) {
                    $subject = 'อนุมัติใบสมัคร';
                    $message = 'ใบสมัครของท่านได้รับการอนุมัติแล้ว ท่านสามารถล็อกอินเข้าสู่เว็บไซต์เพื่อทำการกรอกข้อมูลแบบประเมินขั้นต้น (Pre-Screen)';
                    $message_noti = 'ใบสมัครของท่านได้รับการอนุมัติแล้ว กรุณาทำการกรอกข้อมูลแบบประเมินขั้นต้น (Pre-Screen) ให้แล้วเสร็จภายในวันที่ 7 พฤษภาคม 2566';
                    $link_redirect = base_url('awards/pre-screen');
                } else if ($post['status'] == 0) {
                    $subject = 'ไม่อนุมัติใบสมัคร';
                    $message = 'ขอขอบพระคุณผู้ประกอบการที่สนใจเข้าร่วมการประกวดรางวัลอุตสาหกรรมท่องเที่ยวไทย ครั้งที่ 14 ประจำปี 2566 <br>';
                    $message .= 'ทางโครงการฯ ขอแจ้งว่าใบสมัครของท่านไม่ได้รับการอนุมัติ <br>';
                    $message .= 'หากมีคำถามเพิ่มเติม กรุณาติดต่อ tourismawards14@gmail.com';
                    $message_noti = 'ใบสมัครของท่านไม่ได้รับการอนุมัติ';
                }

                $email_data = [
                    '_header' => 'เรียนคุณ ' . @$users->name . ' ' . @$users->surname,
                    '_content' => $message
                ];

                $requestEmail = [
                    'to' => @$users->email,
                    'subject' => $subject,
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
                        'message' => $message_noti,
                        'link' => $link_redirect,
                        'send_date' => date('Y-m-d H:i:s'),
                        'send_by' => session()->account,
                    ]
                );

                // เก็บข้อมูลการเปลี่ยนแปลง
                @mkdir(FCPATH . 'logs/backend-approve', 0777, true);
                $fp = fopen(FCPATH . 'logs/backend-approve/application_id_' . $id . '.txt', 'a+');

                fwrite($fp, "====================== Start Log Application " . $id . " ======================\n");
                if ($post['status'] == 4) {
                    fwrite($fp, "มีการขอข้อมูลเพิ่มเติม โดย " . session()->account . " ");
                } else if ($post['status'] == 3) {
                    fwrite($fp, "มีการอนุมัติใบสมัคร โดย " . session()->account . " ");
                } else if ($post['status'] == 0) {
                    fwrite($fp, "มีการ Reject ใบสมัคร โดย " . session()->account . " ");
                }

                fwrite($fp, "เวลา : " . date('Y-m-d H:i:s') . "\n\n");
                fclose($fp);

                echo json_encode(['type' => 'success', 'title' => 'สำเร็จ', 'text' => '']);
            } else {
                echo json_encode(['type' => 'error', 'title' => 'ผิดพลาด', 'text' => 'แก้ไขข้อมูลไม่สำเร็จ']);
            }
        } catch (\Exception $e) {

            save_log_error([
                'module' => 'approve_application_form',
                'input_data' => $this->input->getVar(),
                'error_date' => date('Y-m-d H:i:s'),
                'error_msg' => [
                    'error_file' => $e->getFile(),
                    'error_line' => $e->getLine(),
                    'error_code' => $e->getCode(),
                    'error_msg' => $e->getMessage()
                ]
            ]);

            echo json_encode(['type' => 'error', 'title' => 'ผิดพลาด', 'text' => 'แก้ไขข้อมูลไม่สำเร็จ']);
        }
    }

    function downloadFilePDF()
    {
        $post = $this->input->getVar();
        // px($post);
        // We'll be outputting a PDF  
        header('Content-type: application/pdf');
        // It will be called downloaded.pdf  
        header('Content-Disposition: attachment; filename="' . $post['name'] . '"');
        // The PDF source is in original.pdf  
        readfile($post['url']);
    }
}
