<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterTableApplicationForm21092022 extends Migration
{
    public function up()
    {
        $this->db->query("DROP TABLE `application_form`;");

        $this->db->query("CREATE TABLE `application_form` (
            `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `code` varchar(20) DEFAULT NULL COMMENT 'รหัสแบบฟอร์ม',
            `year` varchar(4) DEFAULT NULL COMMENT 'ปี พ.ศ.',
            `application_type_id` int(11) DEFAULT NULL COMMENT 'สาขารางวัลย่อยเข้าร่วมประกวด',
            `application_type_sub_id` int(11) DEFAULT NULL COMMENT 'สาขารางวัลย่อยเข้าร่วมประกวด',
            `definition_of_award` text DEFAULT NULL COMMENT 'นิยามรางวัลแต่ละประเภท',
            `highlights` text DEFAULT NULL COMMENT 'อธิบายจุดเด่นของผลงานที่ต้องการส่งเข้าประกวด',
            `link` varchar(255) DEFAULT NULL COMMENT 'ลิงค์เว็บไซต์ หรือ ลิงค์วีดีโอ',
            `attraction_name_th` varchar(255) DEFAULT NULL COMMENT 'ชื่อแหล่งท่องเที่ยว/สถานประกอบการ/รายการนำเที่ยว (TH)',
            `attraction_name_en` varchar(255) DEFAULT NULL COMMENT 'ชื่อแหล่งท่องเที่ยว/สถานประกอบการ/รายการนำเที่ยว (EN)',
            `address_no` varchar(50) DEFAULT NULL COMMENT 'ที่ตั้ง เลขที่',
            `address_road` varchar(255) DEFAULT NULL COMMENT 'ถนน',
            `address_sub_district` varchar(255) DEFAULT NULL COMMENT 'แขวง/ตำบล',
            `address_district` varchar(255) DEFAULT NULL COMMENT 'เขต/อำเภอ',
            `address_province` varchar(255) DEFAULT NULL COMMENT 'จังหวัด',
            `address_zipcode` int(5) DEFAULT NULL COMMENT 'รหัสไปรษณีย์',
            `facebook` varchar(255) DEFAULT NULL COMMENT 'Facebook',
            `instagram` varchar(255) DEFAULT NULL COMMENT 'Instagram',
            `line_id` varchar(255) DEFAULT NULL COMMENT 'Line ID',
            `other_social` varchar(255) DEFAULT NULL COMMENT 'โซเชียลมีเดียอื่นๆ',
            `company_name` varchar(255) DEFAULT NULL COMMENT 'ชื่อหน่วยงาน/บริษัท',
            `company_addr_no` varchar(50) DEFAULT NULL COMMENT 'เลขที่บริษัท',
            `company_addr_road` varchar(255) DEFAULT NULL COMMENT 'ถนน',
            `company_addr_sub_district` varchar(255) DEFAULT NULL COMMENT 'แขวง/ตำบล',
            `company_addr_district` varchar(255) DEFAULT NULL COMMENT 'เขต/อำเภอ',
            `company_addr_province` varchar(255) DEFAULT NULL COMMENT 'จังหวัด',
            `company_addr_zipcode` varchar(5) DEFAULT NULL COMMENT 'รหัสไปรษณีย์',
            `mobile` varchar(20) DEFAULT NULL COMMENT 'มือถือ',
            `email` varchar(255) DEFAULT NULL COMMENT 'E-Mail',
            `knitter_name` varchar(255) DEFAULT NULL COMMENT 'ชื่อผู้ประสานงาน',
            `knitter_position` varchar(100) DEFAULT NULL COMMENT 'ตำแหน่งประสานงาน',
            `knitter_tel` varchar(50) DEFAULT NULL COMMENT 'เบอร์ประสานงาน',
            `knitter_email` varchar(100) DEFAULT NULL COMMENT 'อีเมลประสานงาน',
            `knitter_line` varchar(50) DEFAULT NULL COMMENT 'ไลน์ประสานงาน',
            `year_open` int(4) DEFAULT NULL COMMENT 'ปีที่เปิด',
            `year_total` int(4) DEFAULT NULL COMMENT 'รวมปี',
            `manage_by` int(1) DEFAULT NULL COMMENT '1 รัฐบาล, 2 ชุมชน, 3 เอกชน',
            `current_step` int(11) NOT NULL DEFAULT 1 COMMENT 'step ปัจจุบัน',
            `status` int(1) NOT NULL DEFAULT 1 COMMENT '1 draft, 2 finished, 3 approve, 4 reject',
            `created_by` int(11) NOT NULL COMMENT 'ผู้สร้างเอกสาร',
            `updated_by` int(11) NOT NULL COMMENT 'ผู้แก้ไขเอกสาร',
            `created_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'วันที่สร้าง',
            `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'วันที่แก้ไข'
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
    }

    public function down()
    {
        $this->db->query("DROP TABLE `application_form`;");
        
        $this->db->query("CREATE TABLE `application_form` (
            `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `code` varchar(20) DEFAULT NULL COMMENT 'รหัสแบบฟอร์ม',
            `year` varchar(4) DEFAULT NULL COMMENT 'ปี พ.ศ.',
            `application_type_id` int(11) DEFAULT NULL COMMENT 'สาขารางวัลย่อยเข้าร่วมประกวด',
            `application_type_sub_id` int(11) DEFAULT NULL COMMENT 'สาขารางวัลย่อยเข้าร่วมประกวด',
            `definition_of_award` text DEFAULT NULL COMMENT 'นิยามรางวัลแต่ละประเภท',
            `highlights` text DEFAULT NULL COMMENT 'อธิบายจุดเด่นของผลงานที่ต้องการส่งเข้าประกวด',
            `link` varchar(255) DEFAULT NULL COMMENT 'ลิงค์เว็บไซต์ หรือ ลิงค์วีดีโอ',
            `attraction_name_th` varchar(255) DEFAULT NULL COMMENT 'ชื่อแหล่งท่องเที่ยว/สถานประกอบการ/รายการนำเที่ยว (TH)',
            `attraction_name_en` varchar(255) DEFAULT NULL COMMENT 'ชื่อแหล่งท่องเที่ยว/สถานประกอบการ/รายการนำเที่ยว (EN)',
            `address_no` varchar(50) DEFAULT NULL COMMENT 'ที่ตั้ง เลขที่',
            `address_road` varchar(255) DEFAULT NULL COMMENT 'ถนน',
            `address_sub_district` varchar(255) DEFAULT NULL COMMENT 'แขวง/ตำบล',
            `address_district` varchar(255) DEFAULT NULL COMMENT 'เขต/อำเภอ',
            `address_province` varchar(255) DEFAULT NULL COMMENT 'จังหวัด',
            `address_zipcode` int(5) DEFAULT NULL COMMENT 'รหัสไปรษณีย์',
            `facebook` varchar(255) DEFAULT NULL COMMENT 'Facebook',
            `instagram` varchar(255) DEFAULT NULL COMMENT 'Instagram',
            `line_id` varchar(255) DEFAULT NULL COMMENT 'Line ID',
            `other_social` varchar(255) DEFAULT NULL COMMENT 'โซเชียลมีเดียอื่นๆ',
            `company_name` varchar(255) DEFAULT NULL COMMENT 'ชื่อหน่วยงาน/บริษัท',
            `company_addr_no` varchar(50) DEFAULT NULL COMMENT 'เลขที่บริษัท',
            `company_addr_road` varchar(255) DEFAULT NULL COMMENT 'ถนน',
            `company_addr_sub_district` varchar(255) DEFAULT NULL COMMENT 'แขวง/ตำบล',
            `company_addr_district` varchar(255) DEFAULT NULL COMMENT 'เขต/อำเภอ',
            `company_addr_province` varchar(255) DEFAULT NULL COMMENT 'จังหวัด',
            `company_addr_zipcode` varchar(5) DEFAULT NULL COMMENT 'รหัสไปรษณีย์',
            `mobile` varchar(20) DEFAULT NULL COMMENT 'มือถือ',
            `email` varchar(255) DEFAULT NULL COMMENT 'E-Mail',
            `knitter_name` varchar(255) DEFAULT NULL COMMENT 'ชื่อผู้ประสานงาน',
            `knitter_position` varchar(100) DEFAULT NULL COMMENT 'ตำแหน่งประสานงาน',
            `knitter_tel` varchar(50) DEFAULT NULL COMMENT 'เบอร์ประสานงาน',
            `knitter_email` varchar(100) DEFAULT NULL COMMENT 'อีเมลประสานงาน',
            `knitter_line` varchar(50) DEFAULT NULL COMMENT 'ไลน์ประสานงาน',
            `year_open` int(4) DEFAULT NULL COMMENT 'ปีที่เปิด',
            `year_total` int(4) DEFAULT NULL COMMENT 'รวมปี',
            `manage_by` int(1) DEFAULT NULL COMMENT '1 รัฐบาล, 2 ชุมชน, 3 เอกชน',
            `current_step` int(11) NOT NULL DEFAULT 1 COMMENT 'step ปัจจุบัน',
            `status` int(1) NOT NULL DEFAULT 1 COMMENT '1 draft, 2 finished, 3 approve, 4 reject',
            `created_by` int(11) NOT NULL COMMENT 'ผู้สร้างเอกสาร',
            `updated_by` int(11) NOT NULL COMMENT 'ผู้แก้ไขเอกสาร',
            `created_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'วันที่สร้าง',
            `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'วันที่แก้ไข'
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
    }
}
