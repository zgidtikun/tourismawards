<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableQuestion extends Migration
{
    public function up()
    {
        $this->db->query("CREATE TABLE `question` (
            `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `code` varchar(50) NOT NULL COMMENT 'รหัสแบบฟอร์มการประเมิน',
            `year` int(4) NOT NULL COMMENT 'ปี พ.ศ.',
            `application_type_id` int(11) NOT NULL COMMENT 'ประเภทการประกวด',
            `application_type_sub_id` int(11) NOT NULL COMMENT 'ประเภทสาขารางวัลย่อยเข้าร่วมประกวด*',
            `criteria_topic` text NOT NULL COMMENT 'หัวข้อหลักเกณฑ์',
            `question` text NOT NULL COMMENT 'คำถามที่ใช้ในการประเมอณในแต่ละหมวดหมู่',
            `evaluation_criteria` text NOT NULL COMMENT 'เกณฑ์การประเมินผล',
            `file` text NOT NULL COMMENT 'แนบเอกสารในทุกข้อคำถาม',
            `remark` text NOT NULL COMMENT 'คำถาม-หมายเหตุ',
            `image` text NOT NULL COMMENT 'แนบภาพถ่าย\r\nส่วนนี้จะเปิด Function การถ่ายภาพ ในรอบลงพื้นที่ สำหรับคณะกรรมการ',
            `scoring_criteria` int(11) NOT NULL COMMENT 'เกณฑ์การให้คะแนน',
            `score` int(11) NOT NULL COMMENT 'คะแนนในแต่ละเกณฑ์',
            `weight` int(11) NOT NULL COMMENT 'น้ำหนักการให้คะแนนคำถาม',
            `note` text NOT NULL COMMENT 'ส่วนนี้จะเปิด Note ของทุกรอบสำหรับคณะกรรมการในการจดบันทึก'
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
    }

    public function down()
    {
        $this->db->query("DROP TABLE `question`;");
    }
}
