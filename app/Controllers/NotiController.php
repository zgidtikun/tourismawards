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

}