<?php

namespace App\Models;

use CodeIgniter\Model;

class News extends Model
{
    protected $table      = 'news';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['title', 'description', 'image_cover', 
    'category_id', 'status', 'publish_start', 'publish_end', 'created_id', 
    'updated_id', 'created_by', 'updated_by'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}