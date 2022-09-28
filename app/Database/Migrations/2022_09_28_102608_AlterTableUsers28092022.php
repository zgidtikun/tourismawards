<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterTableUsers28092022 extends Migration
{
    public function up()
    {
        $this->db->query("DROP TABLE `users`;");
        $this->db->query("CREATE TABLE `users` (
            `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `prefix` varchar(255) NOT NULL COMMENT 'คำนำหน้า',
            `name` varchar(255) NOT NULL COMMENT 'ชื่อ',
            `surname` varchar(255) NOT NULL COMMENT 'นามสกุล',
            `profile` varchar(255) NOT NULL COMMENT 'รูปโปรไฟล์',
            `member_type` varchar(255) NOT NULL COMMENT 'ประเภทสมาชิก',
            `award_type` varchar(255) DEFAULT NULL COMMENT '	ประเภทการตัดสิน 1.ประเภทแหล่งท่องเที่ยว (Attraction) 2.ประเภทการท่องเที่ยวเชิงสุขภาพ (Health and Wellness Tourism) 3.ประเภทที่พักนักท่องเที่ยว (Accommodation) 4.ประเภทรายการนำเที่ยว (Tourism Program)',
            `assessment_group` varchar(255) DEFAULT NULL COMMENT 'กลุ่มการประเมิน 1.ด้าน Tourism Excellence 2.ด้าน Supporting Business & Marketing Factors 3.ด้านความยั่งยืน (Responsibility)',
            `mobile` varchar(25) NOT NULL COMMENT 'เบอร์มือถือ',
            `email` varchar(120) NOT NULL COMMENT 'E-mail',
            `username` varchar(255) NOT NULL COMMENT 'ชื่อผู้ใช้งาน',
            `password` varchar(100) NOT NULL COMMENT 'รหัสผ่าน',
            `captcha` varchar(255) DEFAULT NULL COMMENT 'Captcha',
            `role_id` int(11) NOT NULL COMMENT 'สิทธิ์การใช้งาน',
            `status` int(1) NOT NULL DEFAULT 0 COMMENT '1.active, 0.inactive',
            `status_delete` int(1) NOT NULL DEFAULT 1 COMMENT 'สถานะการลบ 0.ลบ, 1.ใช้งาน',
            `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
    }

    public function down()
    {
        //
    }
}
