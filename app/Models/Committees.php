<?php

namespace App\Models;

use CodeIgniter\Model;

class Committees extends Model
{
    protected $table      = 'committees';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['application_form_id', 'users_id', 'admin_id_tourism', 
    'admin_id_supporting', 'admin_id_responsibility', 'assessment_round', 'created_by', 
    'updated_by'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}