<?php

namespace App\Models;

use CodeIgniter\Model;

class AnswerFile extends Model
{
    protected $table      = 'answer_file';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['answer_id', 'file_name', 'file_original', 'file_path'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}