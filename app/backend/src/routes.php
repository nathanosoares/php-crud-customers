<?php

$app->router->registerMiddleware('auth', 'Middlewares\AuthMiddleware::handle');

$app->router->post('/auth/login', 'Controllers\LoginController::login');

$app->router->get('/auth/refresh', 'Controllers\LoginController::refresh', ['auth']);

$app->router->get('/customers', 'Controllers\CustomersController::list');
$app->router->post('/customers', 'Controllers\CustomersController::create', ['auth']);
$app->router->post('/customers/{customer}', 'Controllers\CustomersController::update', ['auth']);
$app->router->delete('/customers/{customer}', 'Controllers\CustomersController::delete', ['auth']);

$app->router->post('/customers/{customer}/addresses', 'Controllers\AddressesController::create', ['auth']);
$app->router->post('/customers/{customer}/addresses/{address}', 'Controllers\AddressesController::update', ['auth']);
$app->router->delete('/customers/{customer}/addresses/{address}', 'Controllers\AddressesController::delete', ['auth']);

