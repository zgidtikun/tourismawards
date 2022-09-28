<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableCommittees extends Migration
{
    public function up()
    {
        $this->db->query("CREATE TABLE `committees` (
            `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `application_form_id` int(11) NOT NULL COMMENT 'แบบฟอร์มใบสมัคร',
            `users_id` int(11) NOT NULL COMMENT 'ผู้สมัคร',
            `admin_id` varchar(255) NOT NULL COMMENT 'กรรมการเก็บในรูปแบบ 1,2,3',
            `assessment_round` int(1) NOT NULL DEFAULT 1 COMMENT '1.Pre-Screen, 2.ลงพื้นที่',
            `created_by` int(11) NOT NULL COMMENT 'ผู้สร้าง',
            `created_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'วันที่สร้าง',
            `updated_by` int(11) NOT NULL COMMENT 'ผู้แก้ไข',
            `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'วันที่แก้ไข'
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='รายชื่อคณะกรรมการสำหรับประเมินใบสมัคร';");
    }

    public function down()
    {
        $this->db->query("DROP TABLE `committees`;");
    }
}
