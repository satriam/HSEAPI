<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index', ['filter' => 'auth']);
$routes-> resource('Auth');
$routes-> resource('Me');
$routes-> resource('loading');
$routes-> resource('dumping');
$routes-> resource('hauling');
$routes-> resource('Readcheckin');
$routes-> resource('Safety');
$routes-> resource('Checkin');
$routes-> resource('pengaduan');



$routes->put('auth','Auth::index',['filter'=>'auth']);
// $routes->resource('login');
$routes->post('register', 'Register::index');
$routes->post('login', 'Login::index');

$routes->get('checkin','Checkin::index',['filter'=>'auth']);
$routes->get('checkin','Checkin::indexall');
$routes->post('checkin','Checkin::store',['filter'=>'auth']);

$routes->get('masteraccess','Masterrole::index');
$routes->post('masteraccess','Masterrole::create',['filter'=>'auth']);

$routes->get('authall','Auth::indexall');

$routes->get('dashboard','dashboard::index');
$routes->get('dashboard/kc','dashboard::kenaikancheckin');
$routes->get('dashboard/persen','dashboard::persentase');

$routes->get('dashboard/roles','dashboard::roles');


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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
