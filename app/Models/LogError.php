<?php

namespace App\Models;

use CodeIgniter\Model;

class LogError extends Model
{
    protected $table      = 'log_error';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['error_module', 'input_data', 'error_date', 
    'error_msg'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}