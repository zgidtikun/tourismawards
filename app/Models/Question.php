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

    protected $allowedFields = ['code', 'year', 'application_type_id', 
    'application_type_sub_id', 'assessment_group_id', 'topic_no', 
    'question_ordering', 'criteria_topic', 'question', 'remark', 
    'pre_evaluation_criteria', 'pre_scoring_criteria', 'weight', 
    'pre_score', 'onside_score', 'onside_evaluation_criteria', 
    'onside_scoring_criteria', 'image', 'file', 'note', 'pre_status', 
    'onside_status', 'lowcarbon_status'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}