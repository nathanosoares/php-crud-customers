<?php

declare(strict_types=1);

use Nathan\Kabum\Core\Application;
use Nathan\Kabum\Core\Database\DB;

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->safeLoad();

$app = new Application;

new DB(
    host: $_ENV['DATABASE_HOST'] ?? '127.0.0.1',
    port: (int) $_ENV['DATABASE_PORT'] ?? 3306,
    database: $_ENV['DATABASE_NAME'],
    user: $_ENV['DATABASE_USER'],
    password: $_ENV['DATABASE_PASS']
);
