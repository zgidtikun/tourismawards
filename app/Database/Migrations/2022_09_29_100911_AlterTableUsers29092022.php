<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterTableUsers29092022 extends Migration
{
    public function up()
    {
        $this->db->query("ALTER TABLE `users` ADD `position` VARCHAR(255) NOT NULL COMMENT 'หน่วยงาน' AFTER `role_id`;");
    }

    public function down()
    {
        $this->db->query("ALTER TABLE `users` DROP `position`;");
    }
}
