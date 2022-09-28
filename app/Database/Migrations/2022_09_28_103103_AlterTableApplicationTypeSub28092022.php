<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterTableApplicationTypeSub28092022 extends Migration
{
    public function up()
    {
        $this->db->query("DROP TABLE `application_type_sub`;");
        $this->db->query("CREATE TABLE `application_type_sub` (
            `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `name` varchar(255) NOT NULL COMMENT 'ประเภทสาขารางวัลย่อยเข้าร่วมประกวด*',
            `application_type_id` int(11) NOT NULL COMMENT 'id ประเภทแบบฟอร์มการสมัคร',
            `descreption` text DEFAULT NULL COMMENT 'นิยาม'
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

        $this->db->query("INSERT INTO `application_type_sub` (`id`, `name`, `application_type_id`, `descreption`) VALUES
            (1, 'สาขา Outdoor & Adventure Activities (แหล่งท่องเที่ยวเพื่อการผจญภัย)', 1, NULL),
            (2, 'สาขา Learning & Doing (แหล่งท่องเที่ยวเพื่อการเรียนรู้)', 1, NULL),
            (3, 'สาขา Nature & Park (แหล่งท่องเที่ยวธรรมชาติ)', 1, NULL),
            (4, 'สาขา Recreation & Entertainment (แหล่งท่องเที่ยวนันทนาการและความบันเทิง)', 1, NULL),
            (5, 'สาขา Historical & Culture (แหล่งท่องเที่ยวประวัติศาสตร์และวัฒนธรรม)', 1, NULL),
            (6, 'สาขา Local & Community (แหล่งท่องเที่ยวชุมชน)', 1, NULL),
            (7, 'สาขา Luxury Hotel (ลักซ์ชูรี โฮเทล)', 2, NULL),
            (8, 'สาขา Location Hotel (โลเคชั่น โฮเทล)', 2, NULL),
            (9, 'สาขา Resort (รีสอร์ต)', 2, NULL),
            (10, 'สาขา Design Hotel (ดีไซน์ โฮเทล)', 2, NULL),
            (11, 'สาขา Spa (สปา)', 3, NULL),
            (12, 'สาขา Wellness Retreat (เวลเนส รีทรีต)', 3, NULL),
            (13, 'นวดไทย', 3, NULL);");
    }

    public function down()
    {
        //
    }
}
