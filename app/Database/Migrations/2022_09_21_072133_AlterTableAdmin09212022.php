<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterTableAdmin09212022 extends Migration
{
    public function up()
    {
        $this->db->query("ALTER TABLE `admin` CHANGE `assessment_group` `assessment_group` VARCHAR(255) NOT NULL COMMENT 'กลุ่มการประเมิน\r\n1.ด้าน Tourism Excellence\r\n2.ด้าน Supporting Business & Marketing Factors\r\n3.ด้านความยั่งยืน (Responsibility)\r\n';");

        $this->db->query("ALTER TABLE `admin` CHANGE `award_type` `award_type` VARCHAR(255) NOT NULL COMMENT 'ประเภทการตัดสิน\r\n1.ประเภทแหล่งท่องเที่ยว (Attraction)\r\n2.ประเภทการท่องเที่ยวเชิงสุขภาพ (Health and Wellness Tourism)\r\n3.ประเภทที่พักนักท่องเที่ยว (Accommodation)\r\n4.ประเภทรายการนำเที่ยว (Tour Programmes)';");
    }

    public function down()
    {
        $this->db->query("ALTER TABLE `admin` CHANGE `assessment_group` `assessment_group` VARCHAR(255) NOT NULL COMMENT 'กลุ่มการประเมิน\r\n1.ด้าน Tourism Excellence\r\n2.ด้าน Supporting Business & Marketing Factors\r\n3.ด้านความยั่งยืน (Responsibility)\r\n';");

        $this->db->query("ALTER TABLE `admin` CHANGE `award_type` `award_type` VARCHAR(255) NOT NULL COMMENT 'ประเภทการตัดสิน\r\n1.ประเภทแหล่งท่องเที่ยว (Attraction)\r\n2.ประเภทการท่องเที่ยวเชิงสุขภาพ (Health and Wellness Tourism)\r\n3.ประเภทที่พักนักท่องเที่ยว (Accommodation)\r\n4.ประเภทรายการนำเที่ยว (Tour Programmes)';");
    }
}
