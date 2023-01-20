<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;
    protected $session;
    protected $db;
    protected $email;
    protected $validation;
    protected $input;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = ['url','log','recapcha','cookie','main','form','rules','files','noti'];

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        $this->session      = \Config\Services::session();
        $this->db           = \Config\Database::connect();
        $this->email        = \Config\Services::email();        
        $this->validation   = \Config\Services::validation();
        $this->input        = $request;
        $sel = "SELECT assessment_group.id, assessment_group.name 
            FROM (SELECT * FROM estimate WHERE application_id=1 AND request_status=1) estimate
            INNER JOIN question ON estimate.question_id=question.id
            INNER JOIN assessment_group ON question.assessment_group_id=assessment_group.id
            GROUP BY assessment_group.id";
    }

    
}
