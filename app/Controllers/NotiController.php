<?php 

namespace App\Controllers;

use App\Controllers\BaseController;

class NotiController extends BaseController
{

    public function __construct()
    {
        if(!isset($this->db))
            $this->db = \Config\Database::connect();
    }

    public function getNoti()
    {
        $result = get_noti((object) [
                'user_id' => session()->get('id'),
                'bank' => session()->get('default')
            ],
            $this->input->getVar('limit')
        );

        return $this->response->setJSON($result);
    }

    public function saveLogErrorPage()
    {
        save_log_error([            
            'module' => $this->input->getVar('error_message'),
            'input_data' => '',
            'error_date' => date('Y-m-d H:i:s'),
            'error_msg' => $this->input->getVar('error_message')
        ]);
    }

}