<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableBlog extends Migration
{
    public function up()
    {
        $this->db->query("CREATE TABLE `blog` (
            `id` int(11) NOT NULL,
            `title` varchar(255) NOT NULL COMMENT 'หัวข้อ',
            `description` longtext NOT NULL COMMENT 'รายละเอียด',
            `image_cover` varchar(255) NOT NULL COMMENT 'รูปหน้าปก',
            `category_id` int(11) NOT NULL COMMENT 'ไอดีหมวดหมู่',
            `status` int(1) NOT NULL DEFAULT 0 COMMENT 'สถานะ 0.ไม่เผยแพร่ , 1.เผยแพร่',
            `publish_start` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'วันที่เผยแพร่เริ่มต้น',
            `publish_end` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'วันที่เผยแพร่สิ้นสุด',
            `created_id` int(11) NOT NULL COMMENT 'ไอดีผู้สร้าง',
            `updated_id` int(11) NOT NULL COMMENT 'ไอดีผู้แก้ไข',
            `created_by` varchar(255) NOT NULL COMMENT 'ชื่อผู้สร้าง',
            `updated_by` varchar(255) NOT NULL COMMENT 'ชื่อผู้แก้ไข',
            `created_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'วันที่สร้าง',
            `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'วันที่แก้ไข'
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='เนื้อหาข่าว';");
    }

    public function down()
    {
        $this->db->query("DROP TABLE `blog`;");
    }
}
