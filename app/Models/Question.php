<?php

namespace App\Models;

use CodeIgniter\Model;

class Question extends Model
{
    protected $table      = 'question';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['code', 'year', 'application_type_id', 'application_type_sub_id', 
    'criteria_topic', 'question', 'evaluation_criteria', 'file', 'remark', 'image', 
    'scoring_criteria', 'score', 'weight', 'note'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}