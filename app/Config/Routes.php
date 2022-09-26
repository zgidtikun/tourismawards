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
$routes->setAutoRoute(true);

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
        $routes->get('detail', 'ApplicationController::getApplicationByAjax');
        $routes->post('draft', 'ApplicationController::draftApp');
        $routes->get('type-all', 'ApplicationController::getAppTypeAndSubAllByAjax');
        $routes->post('remove-file', 'ApplicationController::removeFiles');
        $routes->group('upload', static function ($routes) {
            $routes->post('images', 'ApplicationController::uploadImages');
        });
    });
});

$routes->group('backend',['namespace' => 'App\Controllers\Backend'], static function ($routes) {    
    $routes->get('/', 'Dashboard::index', ['filter' => 'auth:backend']);
    $routes->get('login', 'Login::index');
    $routes->get('dashboard', 'Dashboard::index', ['filter' => 'auth:backend']);
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
