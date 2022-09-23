<?php

namespace App\Models;

use CodeIgniter\Model;

class ApplicationTypeSub extends Model
{
    protected $table      = 'application_type_sub';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['name', 'application_type_id'];

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}