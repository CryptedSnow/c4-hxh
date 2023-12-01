<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\TipoHunterController;
use App\Controllers\Home;
use App\Controllers\HunterController;

/**
 * @var RouteCollection $routes
 */

 $routes->setDefaultNamespace('App\Controllers');

// API Restful (Address)
// GET: localhost:8080/tipo-hunter
// POST: localhost:8080/tipo-hunter
// GET: localhost:8080/tipo-hunter/{id}
// PATCH: localhost:8080/tipo-hunter/{id}
// DELETE: localhost:8080/tipo-hunter/{id}
$routes->resource('tipo-hunter', ['controller' => TipoHunterController::class]);

$routes->get('/', 'Home::index');

$routes->get('hunter/index', [HunterController::class, 'index']);
$routes->get('hunter/create', [HunterController::class, 'create']);
$routes->post('hunter/store', [HunterController::class, 'store']);
$routes->get('hunter/view/(:num)', [HunterController::class, 'view']);
$routes->get('hunter/edit/(:num)', [HunterController::class, 'edit']);
$routes->post('hunter/update/(:num)', [HunterController::class, 'update']);
$routes->delete('hunter/delete/(:num)', [HunterController::class, 'delete']);