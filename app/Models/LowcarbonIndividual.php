<?php

namespace App\Models;

use CodeIgniter\Model;

class LowcarbonIndividual extends Model
{
    protected $table      = 'lowcarbon_individual';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['application_id', 'estimate_by', 'score_pre', 
    'score_onsite', 'pre_send_date', 'onsite_send_date'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}