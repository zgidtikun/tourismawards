<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;

class LowCarbon extends BaseController
{
    function __construct()
    {
        helper(['log']);
    }

    public function index()
    {
        $data['result']   = $this->db->table('application_form AP')->select('AP.*, CM.admin_id_lowcarbon')->join('committees CM', 'CM.application_form_id = AP.id AND CM.assessment_round = 1')->where('AP.require_lowcarbon', 1)->get()->getResultObject();
        // px($data['result']);

        $data['title']  = 'Low Carbon & Sustainability';
        $data['view']   = 'administrator/lowcarbon/index';
        $data['ci']     = $this;

        return view('administrator/template', $data);
    }


    public function edit($app_id, $user_id = '')
    {
        $data['result'] = $this->db->table('application_form')->where('id', $app_id)->get()->getRowObject();
        if (empty($data['result']) || $user_id == '') {
            show_404();
        }
        $data['app_id'] = $app_id;
        $data['user_id'] = $user_id;
        $data['user_name'] = usersName($user_id);
        $data['estimate'] = $this->db->table('estimate ET')->select('ET.*, QU.id AS qu_id, QU.question')->join('question QU', 'QU.id = ET.question_id AND QU.assessment_group_id = 4')->where('ET.application_id', $app_id)->where('estimate_by', $user_id)->orderBy('QU.id', 'ASC')->get()->getResultObject();
        // pp_sql();
        // pp($data);
        $data['status'] = [];
        if (empty($data['estimate'])) {
            $data['status']['error'] = 'ไม่พบคำตอบของกรรมการ กรุณาติดต่อกรรมการเพื่อส่งแบบประเมิน';
        }
        // px($data);

        $data['title']  = 'Low Carbon & Sustainability';
        $data['view']   = 'administrator/lowcarbon/edit';
        $data['ci']     = $this;

        return view('administrator/template', $data);
    }

    public function print($app_id, $user_id = '')
    {
        $data['result'] = $this->db->table('application_form')->where('id', $app_id)->get()->getRowObject();
        if (empty($data['result']) || $user_id == '') {
            show_404();
        }
        $data['user_name'] = usersName($user_id);
        $data['estimate'] = $this->db->table('estimate ET')->select('ET.*, QU.id AS qu_id, QU.question')->join('question QU', 'QU.id = ET.question_id AND QU.assessment_group_id = 4')->where('ET.application_id', $app_id)->where('estimate_by', $user_id)->orderBy('QU.id', 'ASC')->get()->getResultObject();
        // pp_sql();
        // pp($data);
        return view('administrator/lowcarbon/a4', $data);
    }

    public function changeScore()
    {
        $post = $this->input->getVar();

        // update step 1 table estimate
        $data = [
            // 'score_pre'         => $post['score'],
            // 'tscore_pre'        => $post['score'],
            'score_pre_origin'  => $post['score'],
            'updated_by'        => session()->id,
            'updated_name'      => session()->user,
            'updated_at'        => date('Y-m-d H:i:s'),
        ];
        $result = $this->db->table('estimate')->where('question_id', $post['question_id'])->where('application_id', $post['application_id'])->where('estimate_by', $post['user_id'])->update($data);

        
        // update step 2 table estimate_individual
        $estimate = $this->db->table('estimate_individual')->where('application_id', $post['application_id'])->where('estimate_by', $post['user_id'])->get()->getRowObject();
        if (!empty($estimate)) {
            if ($post['score'] == 0) {
                $estimate->lowcarbon_score = $estimate->lowcarbon_score - 1;
            } else if ($post['score'] == 1) {
                $estimate->lowcarbon_score = $estimate->lowcarbon_score + 1;
            }
            $data = [
                'lowcarbon_score' => $estimate->lowcarbon_score,
            ];
            $result = $this->db->table('estimate_individual')->where('application_id', $post['application_id'])->where('estimate_by', $post['user_id'])->update($data);
        }

        
        // update step 3 table estimate_score
        $estimate = $this->db->table('estimate_individual')->where('application_id', $post['application_id'])->where('lowcarbon_status', 1)->get()->getResultObject();
        // pp($estimate);
        if (!empty($estimate)) {
            $total_lowcarbon_score = 0;
            foreach ($estimate as $key => $value) {
                $total_lowcarbon_score += $value->lowcarbon_score;
            }
            $result_sum = $total_lowcarbon_score / count($estimate);
            // pp($result_sum);
            $data = [
                'lowcarbon_score' => $result_sum,
            ];
            $result = $this->db->table('estimate_score')->where('application_id', $post['application_id'])->where('lowcarbon_status', 1)->update($data);
        }

        save_log_activety([
            'module' => 'step_flow_checking',
            'action' => 'application-'.$post['application_id'],
            'bank' => 'backend',
            'user_id' => session()->id,
            'datetime' => date('Y-m-d H:i:s'),
            'data' => 'ปรับคะแนน Low Carbon'
        ]);

        if ($result) {
            echo json_encode(['type' => 'success', 'title' => 'สำเร็จ', 'text' => 'มีการแก้ไขคะแนนเรียบร้อยแล้ว']);
        }else{
            echo json_encode(['type' => 'error', 'title' => 'ผิดพลาด', 'text' => 'แก้ไขคะแนนไม่สำเร็จโปรดลองใหม่อีกครั้ง']);
        }
    }
}
