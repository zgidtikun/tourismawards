<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterTableAdmin28092022 extends Migration
{
    public function up()
    {
        $this->db->query("ALTER TABLE `admin` ADD `profile` VARCHAR(255) NOT NULL COMMENT 'รูปโปรไฟล์' AFTER `surname`;");
    }

    public function down()
    {
        $this->db->query("ALTER TABLE `admin` DROP `profile`;");
    }
}
