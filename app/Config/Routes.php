<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('item', 'Item::index');
$routes->get('item/create', 'Item::create');
$routes->post('item/store', 'Item::store');
$routes->get('item/edit/(:num)', 'Item::edit/$1');
$routes->post('item/update/(:num)', 'Item::update/$1');
$routes->get('item/delete/(:num)', 'Item::delete/$1');
