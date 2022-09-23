<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableApplicationFile extends Migration
{
    public function up()
    {
        $this->db->query("CREATE TABLE `application_file` (
            `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `application_id` int(11) NOT NULL COMMENT 'Ref Application from',
            `file_name` varchar(255) NOT NULL COMMENT 'File name',
            `file_original` varchar(255) NOT NULL COMMENT 'File name original',
            `file_step` int(1) DEFAULT NULL COMMENT 'In step app form',
            `file_position` varchar(20) DEFAULT NULL COMMENT 'In position app from',
            `file_path` varchar(255) NOT NULL COMMENT 'File path',
            `created_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'วันที่สร้าง',
            `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'วันที่แก้ไข'
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
    }

    public function down()
    {
        $this->db->query("DROP TABLE `application_file`;");
    }
}
