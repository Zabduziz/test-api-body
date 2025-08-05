<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->post('/login', 'AuthController::login');
$routes->post('/register', 'AuthController::register');
$routes->get('/delete/(:num)', 'AuthController::delete/$1');
$routes->get('/list/user', 'AuthController::getListUser');
