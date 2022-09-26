<?php 

namespace App\Controllers;
use CodeIgniter\Files\File;
use CodeIgniter\Files\FileCollection;
use App\Controllers\BaseController;
use App\Models\Question;
use App\Models\Answer;
use App\Models\AnswerFile;


class ApplicationController extends BaseController
{
    public function __construct()
    {
        $this->qt = new Question();
        $this->ans = new Answer();
        $this->ansFile = new AnswerFile();

        if(!isset($this->db))
            $this->db = \Config\Database::connect();
    }

    public function getQuestionByAjax()
    {

    }

    public function getQuestion()
    {
        
    }
}

?>