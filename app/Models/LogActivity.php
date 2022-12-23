<?php

namespace App\Models;

use CodeIgniter\Model;

class LogActivity extends Model
{
    protected $table      = 'log_activity';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['action_module', 'action', 'action_bank', 'user_id', 
    'user_ip', 'action_date', 'action_data'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}