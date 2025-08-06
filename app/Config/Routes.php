<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/list/user', 'AuthController::getListUser');
$routes->group('/', ['filter' => 'cors'], function($routes) {
    $routes->post('login', 'AuthController::login');
    $routes->post('register', 'AuthController::register');
    $routes->get('delete/(:num)', 'AuthController::delete/$1');
});
