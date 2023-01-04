<?php

namespace App\Models;

use CodeIgniter\Model;

class EstimateRequest extends Model
{
    protected $table      = 'estimate_request';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'application_id', 'application_of', 
    'request_by', 'request_status', 'request_date', 'request_duedate',
    'request_update'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}