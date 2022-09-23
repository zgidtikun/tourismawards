<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableBlogCategory extends Migration
{
    public function up()
    {
        $this->db->query("CREATE TABLE `blog_category` (
            `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `name` varchar(255) NOT NULL
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='หมวดหมู่ของข่าว';");
    }

    public function down()
    {
        $this->db->query("DROP TABLE `blog_category`;");
    }
}
