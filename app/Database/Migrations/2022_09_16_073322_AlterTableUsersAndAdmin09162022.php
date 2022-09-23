<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterTableUsersAndAdmin09162022 extends Migration
{
    public function up()
    {
        $this->db->query("ALTER TABLE `users` CHANGE `username` `username` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'ชื่อผู้ใช้งาน';");
    }

    public function down()
    {
        $this->db->query("ALTER TABLE `users` CHANGE `username` `username` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'ชื่อผู้ใช้งาน';");
    }
}
