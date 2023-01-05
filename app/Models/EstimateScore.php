<?php

namespace App\Models;

use CodeIgniter\Model;

class EstimateScore extends Model
{
    protected $table      = 'estimate_score';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['application_id', 'score_prescreen_te', 'score_prescreen_sb', 
    'score_prescreen_rs', 'score_prescreen_tt', 'score_onsite_te', 'score_onsite_sb', 
    'score_onsite_rs', 'score_onsite_tt', 'pre_send_date', 'onsite_send_date',
    'lowcarbon_status', 'lowcarbon_score'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}