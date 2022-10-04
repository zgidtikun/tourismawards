<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

$routes->get('/', 'Home::index', ['as' => 'Home']);
$routes->get('home', 'Home::index');
$routes->get('forget-password', 'RegisterController::forgetpass');

$routes->get('login', 'LoginController::index',);
$routes->get('login/(:any)', 'LoginController::index/$1');

$routes->group('register', static function ($routes) {
    $routes->get('/', 'RegisterController::signup');
    $routes->post('/', 'RegisterController::signup');
});

$routes->group('auth', static function ($routes) {
    $routes->group('check', static function ($routes) {
        $routes->post('(:any)', 'LoginController::authentication/$1');
    });
    $routes->get('logout', 'LoginController::logout');
    $routes->post('ajax-reset-password', 'RegisterController::resetPassword');
});

$routes->group('frontend', static function ($routes) {

    $routes->get('/', 'Home::frontend', ['filter' => 'auth:frontend']);

    $routes->get('application', 'ApplicationController::formIndex', ['filter' => 'auth:1']);
    $routes->group('app', static function ($routes) {
        $routes->get('detail', 'ApplicationController::getApplicationByAjax', ['filter' => 'api:frontend']);
        $routes->post('draft', 'ApplicationController::draftApp', ['filter' => 'api:frontend']);
        $routes->get('type-all', 'ApplicationController::getAppTypeAndSubAllByAjax', ['filter' => 'api:frontend']);
        $routes->post('remove/file', 'ApplicationController::removeFiles', ['filter' => 'api:frontend']);
        $routes->post('upload', 'ApplicationController::uploadFiles', ['filter' => 'api:frontend']);        
    });

    $routes->get('pre-screen', 'AnswerController::preScreenIndex', ['filter' => 'auth:1']);
    $routes->get('question/get', 'AnswerController::getQuestionByAjax', ['filter' => 'api:frontend']);
    $routes->group('answer', static function ($routes) {
        $routes->get('get/(:any)', 'AnswerController::getAnswerByAjax/$1', ['filter' => 'api:frontend']);
        $routes->post('save', 'AnswerController::saveReply', ['filter' => 'api:frontend']);
    });
});


$routes->group('backend', ['namespace' => 'App\Controllers\Backend'], static function ($routes) {

    $routes->get('login', 'Login::index');
    $routes->get('dashboard', 'Dashboard::index', ['filter' => 'auth:backend']);

    // Users (เฉพาะแอดมินที่เข้าได้)
    $routes->group('Users', static function ($routes) {
        $routes->get('', 'Users::index', ['filter' => 'auth:4']);
        $routes->get('add', 'Users::add', ['filter' => 'auth:4']);
        $routes->get('edit/(:any)', 'Users::edit/$1', ['filter' => 'auth:4']);
        $routes->post('delete', 'Users::delete', ['filter' => 'api:4']);
        $routes->post('active', 'Users::active', ['filter' => 'api:4']);
        $routes->post('saveInsert', 'Users::saveInsert', ['filter' => 'api:4']);
        $routes->post('saveUpdate', 'Users::saveUpdate', ['filter' => 'api:4']);
        $routes->post('checkData', 'Users::checkData', ['filter' => 'api:4']);
    });

    // Admin (เฉพาะแอดมินที่เข้าได้)
    $routes->group('Admin', static function ($routes) {
        $routes->get('', 'Admin::index', ['filter' => 'auth:4']);
        $routes->get('add', 'Admin::add', ['filter' => 'auth:4']);
        $routes->get('edit/(:any)', 'Admin::edit/$1', ['filter' => 'auth:4']);
        $routes->post('delete', 'Admin::delete', ['filter' => 'api:4']);
        $routes->post('saveInsert', 'Admin::saveInsert', ['filter' => 'api:4']);
        $routes->post('saveUpdate', 'Admin::saveUpdate', ['filter' => 'api:4']);
        $routes->post('checkData', 'Admin::checkData', ['filter' => 'api:4']);
    });

    // Officer (เฉพาะแอดมินที่เข้าได้)
    $routes->group('Officer', static function ($routes) {
        $routes->get('', 'Officer::index', ['filter' => 'auth:4']);
        $routes->get('add', 'Officer::add', ['filter' => 'auth:4']);
        $routes->get('edit/(:any)', 'Officer::edit/$1', ['filter' => 'auth:4']);
        $routes->post('saveInsert', 'Officer::saveInsert', ['filter' => 'api:4']);
        $routes->post('saveUpdate', 'Officer::saveUpdate', ['filter' => 'api:4']);
        $routes->post('delete', 'Officer::delete', ['filter' => 'api:4']);
    });
    $routes->group('TAT', static function ($routes) {
        $routes->get('', 'Officer::tat', ['filter' => 'auth:4']);
        $routes->get('add', 'Officer::addTAT', ['filter' => 'auth:4']);
        $routes->get('edit/(:any)', 'Officer::editTAT/$1', ['filter' => 'auth:4']);
        $routes->post('saveInsert', 'Officer::saveInsertTAT', ['filter' => 'api:4']);
        $routes->post('saveUpdate', 'Officer::saveUpdateTAT', ['filter' => 'api:4']);
        $routes->post('delete', 'Officer::delete', ['filter' => 'api:4']);
    });

    // News (แอดมินและเจ้าหน้าที่เข้าถึงได้)
    $routes->group('News', static function ($routes) {
        $routes->get('', 'News::index', ['filter' => 'auth:backend']);
        $routes->get('add', 'News::add', ['filter' => 'auth:backend']);
        $routes->get('edit/(:any)', 'News::edit/$1', ['filter' => 'auth:backend']);
        $routes->post('saveInsert', 'News::saveInsert', ['filter' => 'api:backend']);
        $routes->post('saveUpdate', 'News::saveUpdate', ['filter' => 'api:backend']);
        $routes->post('delete', 'News::delete', ['filter' => 'api:backend']);
    });

    $routes->get('MarkTest', 'MarkTest::index');
    $routes->get('MarkTest/excel', 'MarkTest::excel');
});

$routes->environment('development', static function ($routes) {
    $routes->get('set-session', 'LoginController::setSession');
    $routes->get('show-session', 'LoginController::showSession');
});

$routes->get('403', 'Home::error_403');
$routes->get('404', 'Home::error_404');

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
