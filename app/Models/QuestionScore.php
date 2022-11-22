<?php

namespace App\Models;

use CodeIgniter\Model;

class QuestionScore extends Model
{
    protected $table      = 'question_score';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['type_id', 'type_sub_id', 'ttsc_prescreen', 
    'ttsc_onsite', 'total_net'];

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}