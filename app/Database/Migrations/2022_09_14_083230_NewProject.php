<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class NewProject extends Migration
{
    public function up()
    {
        $path       = __DIR__ . "/../tourismawards.sql";
        $sql        = file_get_contents($path);
        $sql_arr    = explode(';', $sql);

        array_pop($sql_arr);
        foreach ($sql_arr as $statement) {
            $statment = $statement . ";";
            try {
                $this->db->query($statement);
            } catch (\Throwable $th) {
                //throw $th;
            }
        }
    }

    public function down()
    {
        $this->db->query("DROP TABLE `admin`, `application_form`, `application_type`, `application_type_sub`, `question`, `role`, `users`;");
    }
}
