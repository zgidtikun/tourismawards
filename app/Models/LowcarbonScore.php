<?php

namespace App\Models;

use CodeIgniter\Model;

class LowcarbonScore extends Model
{
    protected $table      = 'lowcarbon_score';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['application_id', 'score_prescreen_tt', 
    'score_onsite_tt', 'pre_send_date', 'onsite_send_date'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}