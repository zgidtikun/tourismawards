<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterTableQuestion27092022 extends Migration
{
    public function up()
    {
        $this->db->query("ALTER TABLE `question` ADD `assessment_group_id` INT NOT NULL COMMENT 'ID กลุ่มการประเมิน' AFTER `application_type_sub_id`;");
    }

    public function down()
    {
        $this->db->query("ALTER TABLE `question` DROP `assessment_group_id`;");
    }
}
