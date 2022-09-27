<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableDirector extends Migration
{
    public function up()
    {
        $this->db->query("CREATE TABLE `directors` (
            `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `admin_id` int(11) NOT NULL COMMENT 'ไอดีกรรมการ',
            -- `admin_name` varchar(255) NOT NULL COMMENT 'ชื่อกรรมการ',
            `application_form_id` int(11) NOT NULL COMMENT 'ไอดีแบบฟอร์มการสมัคร',
            `assessment_group_id` int(11) NOT NULL COMMENT 'ไอดีหมวดหมู่การตัดสิน'
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='กรรมการประเมินในแต่ละรอบ';");
    }

    public function down()
    {
        $this->db->query("DROP TABLE `directors`;");
    }
}
