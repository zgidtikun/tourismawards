<?php

namespace App\Models;

use CodeIgniter\Model;

class ApplicationType extends Model
{
    protected $table      = 'application_type';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['name'];

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}