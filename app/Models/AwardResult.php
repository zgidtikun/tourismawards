<?php

namespace App\Models;

use CodeIgniter\Model;

class AwardResult extends Model
{
    protected $table      = 'award_result';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['application_id', 'user_id', 'app_type_id', 
    'app_type_sub_id', 'award_persent', 'award_type', 'award_status'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}