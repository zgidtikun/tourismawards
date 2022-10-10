<?php

namespace App\Models;

use CodeIgniter\Model;

class ApplicationForm extends Model
{
    protected $table      = 'application_form';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['code', 'year', 'application_type_id', 'application_type_sub_id', 
    'definition_of_award', 'highlights', 'link', 'attraction_name_th', 'attraction_name_en', 
    'address_no', 'address_road', 'address_sub_district', 'address_district', 'address_province', 
    'address_zipcode', 'facebook', 'instagram', 'line_id', 'other_social', 'google_map', 'company_name', 
    'company_addr_no', 'company_addr_road', 'company_addr_sub_district', 'company_addr_district', 
    'company_addr_province', 'company_addr_zipcode', 'mobile', 'email', 'knitter_name', 
    'knitter_position', 'knitter_tel', 'knitter_email', 'knitter_line', 'year_open', 
    'year_total', 'manage_by', 'buss_license', 'buss_ckroom', 'company_setaddr',
    'pack_file', 'current_step', 'status', 'created_by', 'updated_by'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}