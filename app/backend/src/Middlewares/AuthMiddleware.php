<?php

namespace Nathan\Kabum\Middlewares;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Nathan\Kabum\Core\Application;

class AuthMiddleware
{
    public function handle(Application $app): void
    {
        if (!isset($_SERVER["HTTP_AUTHORIZATION"])) {
            $app->request->response([
                'error' => 'Unauthorized'
            ], 401);
        }

        $authorizationHeader =  $_SERVER["HTTP_AUTHORIZATION"];

        if (substr($authorizationHeader, 0, 7) !== 'Bearer ') {
            $app->request->response([
                'error' => 'Unauthorized'
            ], 401);
        }

        try {
            $token = trim(substr($authorizationHeader, 7));

            JWT::decode($token, new Key($_ENV['JWT_KEY'] ?? 'secret', 'HS256'));
        } catch (Exception $ignored) {
            $app->request->response([
                'error' => 'Unauthorized'
            ], 401);
        }
    }
}
