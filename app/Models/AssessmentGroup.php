<?php

namespace App\Models;

use CodeIgniter\Model;

class AssessmentGroup extends Model
{
    protected $table      = 'assessment_group';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['name'];

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}