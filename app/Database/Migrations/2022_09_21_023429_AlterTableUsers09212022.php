<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterTableUsers09212022 extends Migration
{
    public function up()
    {
        $this->db->query("ALTER TABLE `users` ADD `status_delete` INT(1) NOT NULL DEFAULT '1' COMMENT 'สถานะการลบ 0.ลบ, 1.ใช้งาน' AFTER `status`;");
    }

    public function down()
    {
        $this->db->query("ALTER TABLE `users` DROP `status_delete`;");
    }
}
