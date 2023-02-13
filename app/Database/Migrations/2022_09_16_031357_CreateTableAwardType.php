<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableAwardType extends Migration
{
    public function up()
    {
        $this->db->query("CREATE TABLE `award_type` (
            `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `name` varchar(255) NOT NULL
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
          
        $this->db->query("INSERT INTO `award_type` (`id`, `name`) VALUES
            (1, 'แหล่งท่องเที่ยว (Attraction)'),
            (2, 'การท่องเที่ยวเชิงสุขภาพ (Health and Wellness Tourism)'),
            (3, 'ที่พักนักท่องเที่ยว (Accommodation)'),
            (4, 'รายการนำเที่ยว (Tour Programmes)');");
    }

    public function down()
    {
        $this->db->query("DROP TABLE `award_type`;");
    }
}
