<?php

namespace App\Models;

use CodeIgniter\Model;

class Answer extends Model
{
    protected $table      = 'answer';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['reply', 'reply_by', 'question_id', 'pack_file', 
    'status', 'send_date', 'created_at', 'updated_at'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}