<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterTableUsersAndAdmin09152022 extends Migration
{
    public function up()
    {
        $this->db->query("ALTER TABLE `admin` ADD `status` INT(1) NOT NULL DEFAULT '0' COMMENT '1.active, 0.inactive' AFTER `role_id`;");
        $this->db->query("ALTER TABLE `users` ADD `status` INT(1) NOT NULL DEFAULT '0' COMMENT '1.active, 0.inactive' AFTER `role_id`;");
    }

    public function down()
    {
        $this->db->query("ALTER TABLE `admin` DROP `status`;");
        $this->db->query("ALTER TABLE `users` DROP `status`;");
    }
}