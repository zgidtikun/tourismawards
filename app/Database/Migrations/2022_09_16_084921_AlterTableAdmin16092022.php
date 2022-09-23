<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterTableAdmin16092022 extends Migration
{
    public function up()
    {
        $this->db->query("ALTER TABLE `admin` ADD `position` VARCHAR(255) NOT NULL COMMENT 'หน่วยงาน' AFTER `email`;");
    }

    public function down()
    {
        $this->db->query("ALTER TABLE `admin` DROP `position`;");
    }
}
