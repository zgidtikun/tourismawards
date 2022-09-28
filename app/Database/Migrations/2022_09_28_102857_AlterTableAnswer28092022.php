<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterTableAnswer28092022 extends Migration
{
    public function up()
    {
        $this->db->query("DROP TABLE `answer`;");
        $this->db->query("CREATE TABLE `answer` (
            `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `reply` text NOT NULL COMMENT 'คำตอบ',
            `reply_by` int(11) NOT NULL COMMENT 'ตอบโดย',
            `question_id` int(11) NOT NULL COMMENT 'reference question',
            `pack_file` text DEFAULT NULL COMMENT 'Pack json file',
            `status` int(1) NOT NULL DEFAULT 1 COMMENT '1 draft, 2 send, 3 reject,\r\n4 ขอเอการเพิ่มเติม, 0 no pass',
            `created_at` datetime NOT NULL DEFAULT current_timestamp(),
            `updated_at` datetime NOT NULL DEFAULT current_timestamp()
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
    }

    public function down()
    {
        //
    }
}
