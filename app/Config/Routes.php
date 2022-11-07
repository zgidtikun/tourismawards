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
$routes->get('contact-us', 'Home::contactus');
$routes->get('judge', 'Home::judge');
$routes->get('awards-winner-13', 'Home::winneraward13');
$routes->get('awards-winner-14', 'Home::winneraward14');
$routes->get('privacy-policy', 'Home::privacypolicy');
$routes->get('new', 'Home::new');
$routes->get('new/(:num)', 'Home::new_detail/$1');
$routes->get('forget-password', 'RegisterController::forgetpass');

$routes->get('login', 'LoginController::index');
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

$routes->group('notification', static function($routes) {
    $routes->get('/', 'FrontendController::notification',['filter' => 'auth']);
});

$routes->group('profile', ['filter' => 'auth:frontend'], static function ($routes) {
    $routes->get('/', 'FrontendController::profile');
});

$routes->group('awards', static function ($routes) {
    $routes->get('/', 'frontend::index', ['filter' => 'auth:frontend']);
    $routes->get('application', 'ApplicationController::formIndex', ['filter' => 'auth:1']);
    $routes->get('pre-screen', 'AnswerController::preScreenIndex', ['filter' => 'auth:1']);
    $routes->get('result', 'FrontendController::AssessmentResults', ['filter' => 'auth:1']);
});

$routes->group('boards', static function ($routes) {
    $routes->get('/', 'FrontendController::boards', ['filter' => 'auth:3']);

    $routes->group('estimate', static function ($routes) {
        $routes->get('pre-screen/(:num)', 'FrontendController::prescreenEstimate/$1', ['filter' => 'auth:3']);
        $routes->get('onsite/(:num)', 'FrontendController::onsiteEstimate/$1', ['filter' => 'auth:3']);
    });
});

$routes->group('inner-api', static function ($routes) {
    $routes->group('noti', static function ($routes) {
        $routes->post('get', 'NotiController::getNoti', ['filter' => 'api']);
    });

    $routes->group('profile', static function ($routes){
        $routes->post('update', 'FrontendController::updateProfile', ['filter' => 'auth:frontend']);
        $routes->post('upload/image', 'FilesController::uploadProfile', ['filter' => 'auth:frontend']);
    });

    $routes->group('app', static function ($routes) {
        $routes->get('detail', 'ApplicationController::getApplicationByAjax', ['filter' => 'api:frontend']);
        $routes->post('draft', 'ApplicationController::draftApp', ['filter' => 'api:frontend']);
        $routes->post('finish', 'ApplicationController::finishApp', ['filter' => 'api:frontend']);
        $routes->get('type-all', 'ApplicationController::getAppTypeAndSubAllByAjax', ['filter' => 'api:frontend']);
        $routes->post('remove/file', 'ApplicationController::removeFiles', ['filter' => 'api:frontend']);
        $routes->post('upload', 'ApplicationController::uploadFiles', ['filter' => 'api:frontend']); 
        $routes->get('download/file/(:num)/(:any)', 'FilesController::downloadApplicationFile/$1/$2', ['filter' => 'auth:frontend']);       
    });
    
    $routes->get('question/get', 'AnswerController::getQuestionByAjax', ['filter' => 'api:frontend']);
    $routes->group('answer', static function ($routes) {
        $routes->get('get/(:any)', 'AnswerController::getAnswerByAjax/$1', ['filter' => 'api:frontend']);
        $routes->post('save', 'AnswerController::saveReply', ['filter' => 'api:frontend']);
        $routes->post('upload', 'AnswerController::uploadFiles', ['filter' => 'api:frontend']);
        $routes->post('remove/file', 'AnswerController::removeFiles', ['filter' => 'api:frontend']);
        $routes->get('download/file/(:num)/(:any)', 'FilesController::downloadAnswerFile/$1/$2', ['filter' => 'auth:frontend']); 
    });

    $routes->group('boards', static function ($routes) {
        $routes->post('/', 'FrontendController::listDataBoards', ['filter' => 'api:3']);
        $routes->get('count-stage', 'FrontendController::sumStage', ['filter' => 'api:3']);
        $routes->get('estimate/(:num)', 'QuestionController::estimateQuestion/$1', ['filter' => 'api:3']);
    });

    $routes->group('estimate', static function ($routes) {
        $routes->group('pre-screen', static function ($routes) {
            $routes->post('draft', 'EstimateController::draftEstimate', ['filter' => 'api:3']);
            $routes->post('request', 'EstimateController::setEstimateRequest', ['filter' => 'api:3']);
            $routes->post('complete', 'EstimateController::setCompleteEstimate', ['filter' => 'api:3']);
        });

        $routes->group('onsite', static function ($routes) {
            $routes->post('draft', 'EstimateController::draftEstimate', ['filter' => 'api:3']);
            $routes->post('complete', 'EstimateController::setCompleteEstimate', ['filter' => 'api:3']);

            $routes->group('files', static function ($routes) {
                $routes->post('upload', 'FilesController::uploadEstimate', ['filter' => 'api:frontend']);
                $routes->get('remove', 'FilesController::removeEstimate', ['filter' => 'api:frontend']);
                $routes->get('download/(:any)/(:any)', 'FilesController::dowanloadEstimateFile/$1/$2', ['filter' => 'api:frontend']);
            });
        });
    });

});

$routes->group('administrator', ['namespace' => 'App\Controllers\Backend'], static function ($routes) {

    $routes->get('login', 'Login::index');

    $routes->get('', 'Dashboard::index', ['filter' => 'auth:backend']);
    $routes->get('dashboard', 'Dashboard::index', ['filter' => 'auth:backend']);

    // Users (เฉพาะแอดมินที่เข้าได้)
    $routes->group('Users', static function ($routes) {
        $routes->get('', 'Users::index', ['filter' => 'auth:4']);
        $routes->get('all', 'Users::all', ['filter' => 'auth:4']);
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
        $routes->post('delete', 'Officer::deleteTAT', ['filter' => 'api:4']);
    });

    // News (แอดมินและเจ้าหน้าที่เข้าถึงได้)
    $routes->group('News', static function ($routes) {
        $routes->get('', 'News::index', ['filter' => 'auth:backend']);
        $routes->get('add', 'News::add', ['filter' => 'auth:backend']);
        $routes->get('edit/(:any)', 'News::edit/$1', ['filter' => 'auth:backend']);
        $routes->post('saveInsert', 'News::saveInsert', ['filter' => 'api:backend']);
        $routes->post('saveUpdate', 'News::saveUpdate', ['filter' => 'api:backend']);
        $routes->post('delete', 'News::delete', ['filter' => 'api:backend']);
        $routes->post('uploadImage', 'News::uploadImage', ['filter' => 'api:backend']);
        $routes->post('removeImage', 'News::removeImage', ['filter' => 'api:backend']);
    });

    // Approve (แอดมินและเจ้าหน้าที่เข้าถึงได้)
    $routes->group('Approve', static function ($routes) {
        $routes->get('', 'Approve::index', ['filter' => 'auth:backend']);
        $routes->get('history', 'Approve::history', ['filter' => 'auth:backend']);
        $routes->get('check', 'Approve::check', ['filter' => 'auth:backend']);
        $routes->get('edit/(:any)', 'Approve::edit/$1', ['filter' => 'auth:backend']);
        $routes->post('saveStatus', 'Approve::saveStatus', ['filter' => 'auth:backend']);
        $routes->post('getAplicationTypeSub/(:any)', 'Approve::getAplicationTypeSub/$1', ['filter' => 'auth:backend']);
    });

    // PreScreen (แอดมินและเจ้าหน้าที่เข้าถึงได้)
    $routes->group('PreScreen', static function ($routes) {
        $routes->get('', 'PreScreen::index', ['filter' => 'auth:backend']);
        $routes->get('edit/(:any)', 'PreScreen::edit/$1', ['filter' => 'auth:backend']);
    });

    // Estimate (แอดมินและเจ้าหน้าที่เข้าถึงได้)
    $routes->group('Estimate', static function ($routes) {
        $routes->get('', 'Estimate::index', ['filter' => 'auth:backend']);
        $routes->get('edit/(:any)', 'Estimate::edit/$1', ['filter' => 'auth:backend']);
        $routes->post('saveInsert', 'Estimate::saveInsert', ['filter' => 'api:backend']);
        $routes->post('saveUpdate', 'OnSide::saveUpdate', ['filter' => 'api:backend']);

        $routes->get('prescreen', 'Estimate::prescreen', ['filter' => 'auth:backend']);
        $routes->get('view/(:any)', 'Estimate::viewEdit/$1', ['filter' => 'auth:backend']);
    });

    // OnSide (แอดมินและเจ้าหน้าที่เข้าถึงได้)
    $routes->group('OnSide', static function ($routes) {
        $routes->get('', 'OnSide::index', ['filter' => 'auth:backend']);
        $routes->get('edit/(:any)', 'OnSide::edit/$1', ['filter' => 'auth:backend']);
        $routes->post('saveInsert', 'OnSide::saveInsert', ['filter' => 'api:backend']);
        $routes->post('saveUpdate', 'OnSide::saveUpdate', ['filter' => 'api:backend']);
        
        $routes->post('getScore/(:any)', 'OnSide::getScore/$1', ['filter' => 'api:backend']);
        $routes->get('estimate', 'OnSide::estimate', ['filter' => 'auth:backend']);
        $routes->get('view/(:any)', 'OnSide::view/$1', ['filter' => 'auth:backend']);
    });

    // Complete (แอดมินและเจ้าหน้าที่เข้าถึงได้)
    $routes->group('Complete', static function ($routes) {
        $routes->get('', 'Complete::index', ['filter' => 'auth:4']);
        $routes->get('register', 'Complete::register', ['filter' => 'api:backend']);
    });

    // Report (แอดมินและเจ้าหน้าที่เข้าถึงได้)
    $routes->group('Report', static function ($routes) {
        $routes->get('', 'Report::index', ['filter' => 'auth:4']);
    });

    // MarkTest is Controller for Test Only
    $routes->get('MarkTest', 'MarkTest::index');
    $routes->get('Question', 'MarkTest::question');
    $routes->get('MarkTest/excel', 'MarkTest::excel');
    $routes->post('MarkTest/getData', 'MarkTest::getData');
    $routes->post('MarkTest/delete', 'MarkTest::delete');
    $routes->post('MarkTest/saveInsert', 'MarkTest::saveInsert');
    $routes->post('MarkTest/saveUpdate', 'MarkTest::saveUpdate');

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
