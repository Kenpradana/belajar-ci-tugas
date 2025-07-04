<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::index', ['filter' => 'auth']);

$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::login', ['filter' => 'redirect']);
$routes->get('logout', 'AuthController::logout');

$routes->group('produk', ['filter' => 'auth'], function ($routes) {
    $routes->get('', 'ProdukController::index');
    $routes->post('', 'ProdukController::create');
    $routes->post('edit/(:any)', 'ProdukController::edit/$1');
    $routes->get('delete/(:any)', 'ProdukController::delete/$1');
    $routes->get('download', 'ProdukController::download');
});

$routes->group('diskon', ['filter' => 'auth'], function ($routes) {
    $routes->get('', 'DiskonController::index');
    $routes->post('add', 'DiskonController::add');
    $routes->post('edit/(:num)', 'DiskonController::edit/$1');
    $routes->get('delete/(:num)', 'DiskonController::delete/$1');
    $routes->get('check', 'DiskonController::checkDate');
});

$routes->group('keranjang', ['filter' => 'auth'], function ($routes) {
    $routes->get('', 'TransaksiController::index');
    $routes->post('', 'TransaksiController::cart_add');
    $routes->post('edit', 'TransaksiController::cart_edit');
    $routes->get('delete/(:any)', 'TransaksiController::cart_delete/$1');
    $routes->get('clear', 'TransaksiController::cart_clear');
});

$routes->group('produk-kategori', ['filter' => 'auth'], function ($routes) {
    $routes->get('', 'ProdukKategoriController::index');
    $routes->post('', 'ProdukKategoriController::create');
    $routes->post('edit/(:any)', 'ProdukKategoriController::edit/$1');
    $routes->get('delete/(:any)', 'ProdukKategoriController::delete/$1');
});

// $routes->get('keranjang', 'TransaksiController::index', ['filter' => 'auth']);
// $routes->get('profile', 'Home::profile', ['filter' => 'auth']);

$routes->get('faq', 'Home::faq', ['filter' => 'auth']);
$routes->get('contact', 'Home::contact', ['filter' => 'auth']);

// tambahan
$routes->get('checkout', 'TransaksiController::checkout', ['filter' => 'auth']); // Tambahan 1
$routes->get('get-location', 'TransaksiController::getLocation', ['filter' => 'auth']); // Tambahan 1
$routes->get('get-cost', 'TransaksiController::getCost', ['filter' => 'auth']); // Tambahan 1
$routes->post('buy', 'TransaksiController::buy', ['filter' => 'auth']); // Tambahan 1

$routes->get('profile', 'Home::profile', ['filter' => 'auth']); // Tahapan 2
$routes->resource('api', ['controller' => 'apiController']); // Tahapan 2