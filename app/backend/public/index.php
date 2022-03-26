<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
}

require __DIR__ . '/../src/bootstrap.php';

$app->router->get('/', fn () => $app->request->response([
    'version' => '0.1'
]));

require __DIR__ . '/../src/routes.php';

$app->router->start();
