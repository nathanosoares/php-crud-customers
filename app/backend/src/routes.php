<?php

// Admin Auth
$app->router->post('/auth/login', 'LoginController::login');

$app->router->get('/auth/refresh', 'LoginController::refresh');

$app->router->get('/customers', 'CustomersController::list');
$app->router->post('/customers', 'CustomersController::create');
$app->router->post('/customers/{customer}', 'CustomersController::update');
$app->router->delete('/customers/{customer}', 'CustomersController::delete');

$app->router->post('/customers/{customer}/addresses', 'AddressesController::create');
$app->router->post('/customers/{customer}/addresses/{address}', 'AddressesController::update');
$app->router->delete('/customers/{customer}/addresses/{address}', 'AddressesController::delete');

