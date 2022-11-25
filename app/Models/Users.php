<?php

namespace App\Models;

use CodeIgniter\Model;

class Users extends Model
{
    protected $table      = 'users';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['prefix', 'name', 'surname', 'member_type', 'award_type',
        'assessment_group', 'mobile', 'email', 'username', 'password', 'role_id', 'status',
        'position', 'stage', 'verify_code', 'verify_status', 'verify_date',
        'status', 'status_delete', 'profile'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}