<?php

namespace App\Models;

use CodeIgniter\Model;

class Role extends Model
{
    protected $table      = 'role';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['user_groups', 'front_end', 'back_end'];

    protected $useTimestamps = false;

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}