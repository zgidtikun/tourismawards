<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableAssessmentGroup extends Migration
{
    public function up()
    {
        $this->db->query("CREATE TABLE `assessment_group` (
            `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `name` varchar(255) NOT NULL
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
          
        $this->db->query("INSERT INTO `assessment_group` (`id`, `name`) VALUES
            (1, 'Tourism Excellence (Product/Service)'),
            (2, 'Supporting Business & Marketing Factors'),
            (3, 'Responsibility and Safety & Health Administration');");
    }

    public function down()
    {
        $this->db->query("DROP TABLE `assessment_group`;");
    }
}
