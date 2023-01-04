<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;

class Officer extends BaseController
{
    public function __construct()
    {
        helper(['semail', 'verify', 'log']);
    }

    public function index()
    {
        $where = [];
        if (!empty($_GET['keyword'])) {
            $where['name'] = $_GET['keyword'];
            // $where['surname'] = $_GET['keyword'];
            // $where['email'] = $_GET['keyword'];
        }
        $data['result']  = $this->db->table('users')->where('role_id', 3)->like($where, 'match', 'both')->get()->getResultObject();

        // $data['result'] = $this->db->table('users U')->select('U.*, MT.name AS member_type_name, AT.name AS award_type_name, AG.name AS assessment_group_name')->join('member_type MT', 'MT.id = U.member_type', 'left')->join('award_type AT', 'AT.id = U.award_type', 'left')->join('assessment_group AG', 'AG.id = U.assessment_group', 'left')->where('U.member_type = 3 AND U.status = 1')->orWhere($where)->orderBy('U.id', 'desc')->get()->getResultObject();

        $data['award_type'] = $this->db->table('award_type')->get()->getResultObject();
        $data['assessment_group'] = $this->db->table('assessment_group')->get()->getResultObject();
        $data['type']   = 3;


        // Template
        $data['title']  = 'คณะกรรมการ';
        $data['view']   = 'administrator/officer/index';
        $data['ci']     = $this;

        return view('administrator/template', $data);
    }

    public function add()
    {
        $data['award_type'] = $this->db->table('award_type')->get()->getResultObject();
        $data['assessment_group'] = $this->db->table('assessment_group')->get()->getResultObject();
        // px($data['award_type']);

        // Template
        $data['title']  = 'เพิ่มคณะกรรมการ';
        $data['view']   = 'administrator/officer/edit';
        $data['ci']     = $this;

        return view('administrator/template', $data);
    }

    public function edit($id)
    {
        $data['result'] = $this->db->table('users')->where('id', $id)->get()->getRowObject();
        if (empty($data['result'])) {
            return redirect()->to(session()->_ci_previous_url);
        }
        $data['award_type'] = $this->db->table('award_type')->get()->getResultObject();
        $data['assessment_group'] = $this->db->table('assessment_group')->get()->getResultObject();
        // px($data['result']);

        // Template
        $data['title']  = 'แก้ไขคณะกรรมการ';
        $data['view']   = 'administrator/officer/edit';
        $data['ci']     = $this;

        return view('administrator/template', $data);
    }

    public function saveInsert()
    {
        $post = $this->input->getVar();
        $imagefile = $this->input->getFiles('profile');
        $img = $imagefile['profile'];

        // if (!empty($post['password'])) {
        //     $post['password'] = password_hash($post['password'], PASSWORD_DEFAULT);
        // }
        if (empty($post["award_type"])) {
            $post["award_type"] = [];
        }
        if (empty($post["assessment_group"])) {
            $post["assessment_group"] = [];
        }

        $verify_code = genVerifyCode();
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
            // 'password'              => $post["password"],
            'verify_code'           => $verify_code,
            'role_id'               => 3,
            'status'                => 0,
            'created_at'            => date('Y-m-d H:i:s'),
            'updated_at'            => date('Y-m-d H:i:s'),
        ];
        $result = $this->db->table('users')->insert($data);
        $insert_id = $this->db->insertID();
        if ($result) {
            if ($img->isValid() && !$img->hasMoved()) {
                $path = FCPATH . 'uploads/profile/images/';
                $originalName = $img->getName();
                $extension = $img->guessExtension();
                $newName = genFileName($extension);
                $accept = ['jpg', 'jpeg', 'gif', 'png', 'webp'];
                if (in_array($extension, $accept)) {
                    $img->move($path, $newName);
                    $this->db->table('users')->where('id', $insert_id)->update(['profile' => 'uploads/profile/images/' . $newName]);
                }
            }
            $data = [];
            $data['users'] = $this->db->table('users')->where('id', $insert_id)->get()->getRowObject();
            $data['verify_code'] = vEncryption('users-' . $data['users']->verify_code);
            $this->sendMail($data);
            
            // เก็บข้อมูลการเปลี่ยนแปลง
            // @mkdir(FCPATH . 'logs/backend-users', 0777, true);
            // $fp = fopen(FCPATH . 'logs/backend-users/users_id_' . $insert_id . '.txt', 'a+');
            // fwrite($fp, "====================== Start Log User " . $insert_id . " ======================\n");
            // fwrite($fp, "มีการเพิ่มคณะกรรมการ โดย " . session()->account ." \n");
            // fwrite($fp, "เวลา : " . date('Y-m-d H:i:s') . "\n\n");
            // fclose($fp);

            $setting = [
                'users_id' => $insert_id,
                'text'  => "มีการเพิ่มคณะกรรมการ โดย " . session()->account,
            ];
            save_log_activety([
                'module' => '',
                'action' => '',
                'bank' => 'backend',
                'user_id' => session()->get('id'),
                'datetime' => date('Y-m-d H:i:s'),
                'data' => json_encode($setting),
            ]);

            echo json_encode(['type' => 'success', 'title' => 'สำเร็จ', 'text' => 'บันทึกข้อมูลสำเร็จ']);
        } else {
            echo json_encode(['type' => 'error', 'title' => 'ผิดพลาด', 'text' => 'บันทึกข้อมูลไม่สำเร็จ']);
        }
    }

    public function saveUpdate()
    {
        $post = $this->input->getVar();

        $post['profile'] = $post['profile_old'];
        if ($this->input->getFiles('profile')) {
            $imagefile = $this->input->getFiles('profile');
            $img = $imagefile['profile'];

            if ($img->isValid() && !$img->hasMoved()) {
                $path = FCPATH . 'uploads/profile/images/';
                $extension = $img->guessExtension();
                $newName = genFileName($extension);
                $accept = ['jpg', 'jpeg', 'gif', 'png', 'webp'];
                if (in_array($extension, $accept)) {
                    $img->move($path, $newName);
                    $post['profile'] = 'uploads/profile/images/' . $newName;
                    @unlink($path . $post['profile_old']);
                }
            }
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
            'profile'               => $post['profile'],
            // 'member_type'           => 3,
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

        // if (!empty($post['password'])) {
        //     $data['password'] = password_hash($post['password'], PASSWORD_DEFAULT);
        // }
        $result = $this->db->table('users')->where('id', $post['insert_id'])->update($data);
        if ($result) {
            
            // เก็บข้อมูลการเปลี่ยนแปลง
            // @mkdir(FCPATH . 'logs/backend-users', 0777, true);
            // $fp = fopen(FCPATH . 'logs/backend-users/users_id_' . $post['insert_id'] . '.txt', 'a+');
            // fwrite($fp, "====================== Start Log User " . $post['insert_id'] . " ======================\n");
            // fwrite($fp, "มีการแก้ไขคณะกรรมการ โดย " . session()->account ." \n");
            // fwrite($fp, "เวลา : " . date('Y-m-d H:i:s') . "\n\n");
            // fclose($fp);

            $setting = [
                'users_id' => $post['insert_id'],
                'text'  => "มีการแก้ไขคณะกรรมการ โดย " . session()->account,
            ];
            save_log_activety([
                'module' => '',
                'action' => '',
                'bank' => 'backend',
                'user_id' => session()->get('id'),
                'datetime' => date('Y-m-d H:i:s'),
                'data' => json_encode($setting),
            ]);

            echo json_encode(['type' => 'success', 'title' => 'สำเร็จ', 'text' => 'แก้ไขข้อมูลสำเร็จ']);
        } else {
            echo json_encode(['type' => 'error', 'title' => 'ผิดพลาด', 'text' => 'แก้ไขข้อมูลไม่สำเร็จ']);
        }
    }

    public function tat()
    {
        $where = [];
        if (!empty($_GET['keyword'])) {
            $where['name'] = $_GET['keyword'];
            // $where['surname'] = $_GET['keyword'];
            // $where['email'] = $_GET['keyword'];
        }
        $data['result']  = $this->db->table('admin')->where('role_id', 2)->like($where, 'match', 'both')->get()->getResultObject();

        // $data['result'] = $this->db->table('admin A')->select('A.*, MT.name AS member_type_name, AT.name AS award_type_name, AG.name AS assessment_group_name')->join('member_type MT', 'MT.id = A.member_type', 'left')->join('award_type AT', 'AT.id = A.award_type', 'left')->join('assessment_group AG', 'AG.id = A.assessment_group', 'left')->where("A.member_type = 2 AND A.status = 1 AND $or_where")->orderBy('A.id', 'desc')->get()->getResultObject();
        // pp_sql();
        $data['award_type'] = $this->db->table('award_type')->get()->getResultObject();
        $data['assessment_group'] = $this->db->table('assessment_group')->get()->getResultObject();
        $data['type']   = 1;

        // Template
        $data['title']  = 'เจ้าหน้าที่ ททท.';
        $data['view']   = 'administrator/officer/tat';
        $data['ci']     = $this;

        return view('administrator/template', $data);
    }


    public function addTAT()
    {
        $data['award_type'] = $this->db->table('award_type')->get()->getResultObject();

        // Template
        $data['title']  = 'เพิ่มเจ้าหน้าที่ ททท.';
        $data['view']   = 'administrator/officer/edit_tat';
        $data['ci']     = $this;

        return view('administrator/template', $data);
    }

    public function editTAT($id)
    {
        $data['result'] = $this->db->table('admin')->where('id', $id)->get()->getRowObject();
        if (empty($data['result'])) {
            return redirect()->to(session()->_ci_previous_url);
        }
        $data['award_type'] = $this->db->table('award_type')->get()->getResultObject();

        // Template
        $data['title']  = 'แก้ไขเจ้าหน้าที่ ททท.';
        $data['view']   = 'administrator/officer/edit_tat';
        $data['ci']     = $this;

        return view('administrator/template', $data);
    }

    public function saveInsertTAT()
    {
        $post = $this->input->getVar();

        // if (!empty($post['password'])) {
        //     $post['password'] = password_hash($post['password'], PASSWORD_DEFAULT);
        // }
        if (empty($post["assessment_group"])) {
            $post["assessment_group"] = [];
        }
        $verify_code = genVerifyCode();
        $data = [
            // 'id'                    => $post[""],
            'prefix'                => $post["prefix"],
            'name'                  => $post["name"],
            'surname'               => $post["surname"],
            'member_type'           => 2,
            'award_type'            => $post["award_type"],
            // 'assessment_group'      => json_encode($post["assessment_group"]),
            'mobile'                => $post["mobile"],
            'email'                 => $post["email"],
            'position'              => $post["position"],
            'username'              => $post["email"],
            // 'password'              => $post["password"],
            'verify_code'           => $verify_code,
            'role_id'               => 2,
            'status'                => 0,
            'created_at'            => date('Y-m-d H:i:s'),
            'updated_at'            => date('Y-m-d H:i:s'),
        ];
        $result = $this->db->table('admin')->insert($data);
        $insert_id = $this->db->insertID();
        if ($result) {
            if ($this->input->getFiles('profile')) {
                $imagefile = $this->input->getFiles('profile');
                $img = $imagefile['profile'];
                if ($img->isValid() && !$img->hasMoved()) {
                    $path = FCPATH . 'uploads/profile/images/';
                    $originalName = $img->getName();
                    $extension = $img->guessExtension();
                    $newName = genFileName($extension);
                    $accept = ['jpg', 'jpeg', 'gif', 'png', 'webp'];
                    if (in_array($extension, $accept)) {
                        $img->move($path, $newName);
                        $this->db->table('admin')->where('id', $insert_id)->update(['profile' => 'uploads/profile/images/' . $newName]);
                    }
                }
            }
            $data = [];
            $data['users'] = $this->db->table('admin')->where('id', $insert_id)->get()->getRowObject();
            $data['verify_code'] = vEncryption('admin-' . $data['users']->verify_code);
            $this->sendMail($data);
            
            // เก็บข้อมูลการเปลี่ยนแปลง
            // @mkdir(FCPATH . 'logs/backend-admin', 0777, true);
            // $fp = fopen(FCPATH . 'logs/backend-admin/admin_id_' . $insert_id . '.txt', 'a+');
            // fwrite($fp, "====================== Start Log Admin " . $insert_id . " ======================\n");
            // fwrite($fp, "มีการเพิ่มเจ้าหน้าที่ ททท. โดย " . session()->account ." \n");
            // fwrite($fp, "เวลา : " . date('Y-m-d H:i:s') . "\n\n");
            // fclose($fp);

            $setting = [
                'admin_id' => $insert_id,
                'text'  => "มีการเพิ่มเจ้าหน้าที่ ททท. โดย " . session()->account,
            ];
            save_log_activety([
                'module' => '',
                'action' => '',
                'bank' => 'backend',
                'user_id' => session()->get('id'),
                'datetime' => date('Y-m-d H:i:s'),
                'data' => json_encode($setting),
            ]);

            echo json_encode(['type' => 'success', 'title' => 'สำเร็จ', 'text' => 'บันทึกข้อมูลสำเร็จ']);
        } else {
            echo json_encode(['type' => 'error', 'title' => 'ผิดพลาด', 'text' => 'บันทึกข้อมูลไม่สำเร็จ']);
        }
    }

    public function saveUpdateTAT()
    {
        $post = $this->input->getVar();

        $post['profile'] = $post['profile_old'];
        if ($this->input->getFiles('profile')) {
            $imagefile = $this->input->getFiles('profile');
            $img = $imagefile['profile'];

            if ($img->isValid() && !$img->hasMoved()) {
                $path = FCPATH . 'uploads/profile/images/';
                $extension = $img->guessExtension();
                $newName = genFileName($extension);
                $accept = ['jpg', 'jpeg', 'gif', 'png', 'webp'];
                if (in_array($extension, $accept)) {
                    $img->move($path, $newName);
                    $post['profile'] = 'uploads/profile/images/' . $newName;
                    @unlink($path . $post['profile_old']);
                }
            }
        }

        if (empty($post["assessment_group"])) {
            $post["assessment_group"] = [];
        }

        $data = [
            // 'id'                    => $post[""],
            'prefix'                => $post["prefix"],
            'name'                  => $post["name"],
            'surname'               => $post["surname"],
            'profile'               => $post["profile"],
            // 'member_type'           => 2,
            'award_type'            => $post["award_type"],
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

        // if (!empty($post['password'])) {
        //     $data['password'] = password_hash($post['password'], PASSWORD_DEFAULT);
        // }
        $result = $this->db->table('admin')->where('id', $post['insert_id'])->update($data);
        if ($result) {
            
            // เก็บข้อมูลการเปลี่ยนแปลง
            // @mkdir(FCPATH . 'logs/backend-admin', 0777, true);
            // $fp = fopen(FCPATH . 'logs/backend-admin/admin_id_' . $post['insert_id'] . '.txt', 'a+');
            // fwrite($fp, "====================== Start Log Admin " . $post['insert_id'] . " ======================\n");
            // fwrite($fp, "มีการแก้ไขเจ้าหน้าที่ ททท. โดย " . session()->account ." \n");
            // fwrite($fp, "เวลา : " . date('Y-m-d H:i:s') . "\n\n");
            // fclose($fp);

            $setting = [
                'admin_id' => $post['insert_id'],
                'text'  => "มีการแก้ไขเจ้าหน้าที่ ททท. โดย " . session()->account,
            ];
            save_log_activety([
                'module' => '',
                'action' => '',
                'bank' => 'backend',
                'user_id' => session()->get('id'),
                'datetime' => date('Y-m-d H:i:s'),
                'data' => json_encode($setting),
            ]);

            echo json_encode(['type' => 'success', 'title' => 'สำเร็จ', 'text' => 'แก้ไขข้อมูลสำเร็จ']);
        } else {
            echo json_encode(['type' => 'error', 'title' => 'ผิดพลาด', 'text' => 'แก้ไขข้อมูลไม่สำเร็จ']);
        }
    }

    public function delete()
    {
        $id = $this->input->getVar('id');
        $result = $this->db->table('users')->where('id', $id)->set(['status' => 0, 'status_delete' => 0])->update();
        if ($result) {
            echo json_encode(['type' => 'success', 'title' => 'สำเร็จ', 'text' => 'ทำการลบข้อมูลสำเร็จ']);
        } else {
            echo json_encode(['type' => 'error', 'title' => 'ผิดพลาด', 'text' => 'ทำการลบข้อมูลไม่สำเร็จ']);
        }
    }

    public function deleteTAT()
    {
        $id = $this->input->getVar('id');
        $result = $this->db->table('admin')->where('id', $id)->set(['status' => 0])->update();
        if ($result) {
            echo json_encode(['type' => 'success', 'title' => 'สำเร็จ', 'text' => 'ทำการลบข้อมูลสำเร็จ']);
        } else {
            echo json_encode(['type' => 'error', 'title' => 'ผิดพลาด', 'text' => 'ทำการลบข้อมูลไม่สำเร็จ']);
        }
    }

    public function sendMail($data)
    {
        // px(vDecryption($data['verify_code']));
        // px($data);
        $text = 'โปรดยืนยันตัวตนด้วยการกดที่ลิ้งนี้ <b><a href="' . base_url('verify-password?t=' . $data['verify_code']) . '"  target="_blank">Verify</a></b>';
        if ($data['users']->password != "") {
            $text = 'โปรดเข้าสู่ระบบด้วยการกดที่ลิ้งนี้ <b><a href="' . base_url() . '" target="_blank">' . base_url() . '</a></b>';
        }
        $email_data = [
            '_header' => 'มีการลงทะเบียนผู้ใช้ใหม่บนเว็บไซต์',
            '_content' => 'คุณ ' . $data['users']->name . ' ' . $data['users']->surname . ' ได้รับการสมัครเป็นคณะกรรมการการตัดสิน '
                . 'อุตสาหกรรมท่องเที่ยวไทย ครั้งที่ 14 ประจำปี 2566 (Thailand Tourism Awards 2023) '
                . 'ด้วยอีเมล ' . $data['users']->email . ' '
                . $text
        ];
        $requestEmail = [
            'to' => $data['users']->email,
            'subject' => 'มีการลงทะเบียนผู้ใช้ใหม่บนเว็บไซต์',
            'message' => view('administrator/template_email', $email_data),
            // 'from' => $from,
            // 'cc' => [],
            // 'bcc' => []
        ];

        send_email($requestEmail);
    }
}
