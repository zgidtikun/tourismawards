<?php

namespace App\Models;

use CodeIgniter\Model;

class Estimate extends Model
{
    protected $table      = 'estimate';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['application_id', 'answer_id', 'question_id', 'score_pre', 
    'tscore_pre', 'score_onsite', 'tscore_onsite', 'comment_pre', 'comment_onsite', 'note_pre', 
    'note_onsite', 'status', 'request_list', 'request_date', 'request_status', 'estimate_by',
    'pack_file'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}