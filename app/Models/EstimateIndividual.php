<?php

namespace App\Models;

use CodeIgniter\Model;

class EstimateIndividual extends Model
{
    protected $table      = 'estimate_individual';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['application_id', 'estimate_by', 'score_pte', 
    'score_psb', 'score_prs', 'score_pre', 'score_ote', 'score_osb', 'score_ors', 
    'score_onsite'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}