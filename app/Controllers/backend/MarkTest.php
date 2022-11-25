<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;

use App\Models\Admin;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class MarkTest extends BaseController
{
    public function index()
    {
        exit;
        px($_ENV);
        // pp(session()->get());
        // pp(checkPermission([4]));
        px(password_hash('0000', PASSWORD_DEFAULT));
        $model = new Admin();

        $page    = (int) ($this->request->getGet('page') ?? 1);
        $perPage = 20;
        $total   = 200;

        $data = [
            'users' => $model->paginate(3),
            'pager' => $model->pager,
        ];
        px($model->pager);

        $pager = service('pager');
        $pager->setPath('path/for/my-group', 'my-group'); // Additionally you could define path for every group.
        $pager->makeLinks($page, $perPage, $total, 'template_name', 0, 'my-group');
        echo $pager->links();
    }

    public function excel()
    {
        $taskModel = new Admin();
        $data['result'] = $taskModel->findAll();

        return view('backend/test/excel', $data);
    }

    public function question()
    {
        $where = [];
        $where['weight'] = 0;
        // $where['onside_score'] = 0;
        // $where = "assessment_group_id = 3 AND application_type_id = 1 AND application_type_sub_id = 5";
        $data['fields'] = $this->db->getFieldNames('question');
        $data['result'] = $this->db->table('question')->orderBy('id', 'desc')->where($where)->get()->getResultObject();
        // pp(count($data['result']));
        // pp_sql();
        // pp($data['fields']);

        // Template
        $data['title']  = 'Question';
        $data['view']   = 'backend/test/question';
        $data['ci']     = $this;

        return view('backend/template', $data);
    }

    public function getData()
    {
        $post = $this->input->getVar();
        $result = $this->db->table($post['table'])->where('id', $post['id'])->get()->getRowObject();
        echo json_encode($result);
    }

    public function delete()
    {
        $post = $this->input->getVar();
        $result = $this->db->table($post['table'])->where('id', $post['id'])->delete();
        if ($result) {
            echo json_encode(['type' => 'success', 'title' => 'สำเร็จ', 'text' => 'ทำการลบข้อมูลสำเร็จ']);
        } else {
            echo json_encode(['type' => 'error', 'title' => 'ผิดพลาด', 'text' => 'ทำการลบข้อมูลไม่สำเร็จ']);
        }
    }

    public function saveInsert()
    {
        $post = $this->input->getVar();
        $table = $post['table'];
        unset($post['table']);
        $result = $this->db->table($table)->insert($post);
        if ($result) {
            echo json_encode(['type' => 'success', 'title' => 'สำเร็จ', 'text' => 'บันทึกข้อมูลสำเร็จ']);
        } else {
            echo json_encode(['type' => 'error', 'title' => 'ผิดพลาด', 'text' => 'บันทึกข้อมูลไม่สำเร็จ']);
        }
    }

    public function saveUpdate()
    {
        $post = $this->input->getVar();
        // px($post);
        $id = $post['id'];
        $table = $post['table'];
        unset($post['id']);
        unset($post['table']);
        $result = $this->db->table($table)->where('id', $id)->update($post);
        if ($result) {
            echo json_encode(['type' => 'success', 'title' => 'สำเร็จ', 'text' => 'แก้ไขข้อมูลสำเร็จ']);
        } else {
            echo json_encode(['type' => 'error', 'title' => 'ผิดพลาด', 'text' => 'แก้ไขข้อมูลไม่สำเร็จ']);
        }
    }

    public function Mail()
    {

        $config['protocol'] = 'sendmail';
        $config['mailPath'] = '/usr/sbin/sendmail';
        $config['charset']  = 'iso-8859-1';
        $config['wordWrap'] = true;

        $this->email->initialize($config);

        $email_data = [];

        $subject = 'Test การส่งเมล';
        $body = view('template_email', $email_data);
        $this->email->setFrom($_ENV['email.SMTPUser'], 'ส่งจาก');
        $this->email->setTo('kritsana@chaiyohosting.com');

        $this->email->setSubject($subject);
        $this->email->setMessage($body);

        pp($_ENV);
        pp(121212);
        pp($this->email->send());
        // try {
        //     pp($this->email->send());
        // } catch (\Throwable $th) {
        //     pp($th->getMessage());
        //     // $filename = APPPATH . 'logs/sendmail-log/sendmail-log' . date('Ymd') . '.txt';
        //     // $fp = fopen($filename, 'a+');
        //     // fwrite($fp, "Time :: " . date("Y-m-d H:i:s") . " \n");
        //     // fwrite($fp, date("Y-m-d H:i:s") . ' : Exception : PaymentChannel/place_money_transfer_order() - ' . $th->getMessage());
        //     // fwrite($fp, "\n\n\n");
        //     // fclose($fp);
        // }

        // return view('template_email');
    }
}
