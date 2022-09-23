<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableMemberType extends Migration
{
    public function up()
    {
        $this->db->query("CREATE TABLE `member_type` (
            `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `name` varchar(255) NOT NULL
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
          
        $this->db->query("INSERT INTO `member_type` (`id`, `name`) VALUES
            (1, 'ผู้ประกอบการ'),
            (2, 'เจ้าหน้าที่ ททท.'),
            (3, 'คณะกรรมการ'),
            (4, 'ผู้ดูแลระบบ');");
    }

    public function down()
    {
        $this->db->query("DROP TABLE `member_type`;");
    }
}
