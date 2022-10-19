<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\Estimate;
use Exception;

class EstimateController extends BaseController
{  
    public function __construct()
    {
        $this->estimate = new Estimate();

        if(!isset($this->db))
            $this->db = \Config\Database::connect();
    }

    public function draftEstimateProscreen()
    {
        try {

        } catch(Exception $e) {
            $result = [
                'result' => 'error',
                'message' => $e->getMessage()
            ];
        }

        return $this->response->setJSON($result);
    }
}