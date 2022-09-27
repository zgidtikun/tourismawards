<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableAnswer extends Migration
{
    public function up()
    {
        $this->db->query("CREATE TABLE `answer` (
            `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `reply` text NOT NULL COMMENT 'คำตอบ',
            `reply_by` int(11) NOT NULL COMMENT 'ตอบโดย',
            `question_id` int(11) NOT NULL COMMENT 'reference question',
            `pack_file` text DEFAULT NULL COMMENT 'Pack json file',
            `created_at` datetime NOT NULL DEFAULT current_timestamp(),
            `updated_at` datetime NOT NULL DEFAULT current_timestamp()
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
    }

    public function down()
    {
        $this->db->query("DROP TABLE `answer`;");
    }
}
