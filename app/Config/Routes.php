<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/list/user', 'AuthController::getListUser');
$routes->group('/', ['filter' => 'cors'], function($routes) {
    // Add this line to handle the OPTIONS preflight request
    $routes->options('login', 'AuthController::login');
    $routes->options('register', 'AuthController::register');
    $routes->options('delete/(:num)', 'AuthController::delete/$1');
    $routes->post('login', 'AuthController::login');
    $routes->post('register', 'AuthController::register');
    $routes->get('delete/(:num)', 'AuthController::delete/$1');
});
