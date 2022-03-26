<?php

namespace Nathan\Kabum\Middlewares;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Pecee\Http\Middleware\IMiddleware;
use Pecee\Http\Request;

class AuthMiddleware implements IMiddleware
{
    public function handle(Request $request): void
    {
        if (!isset(request()->getHeaders()['http_authorization'])) {
            response()->httpCode(401)->json([
                "error" => "Sem permissão1"
            ]);
        }

        $authorizationHeader = request()->getHeaders()['http_authorization'];

        if (substr($authorizationHeader, 0, 7) !== 'Bearer ') {
            response()->httpCode(401)->json([
                "error" => "Sem permissão2"
            ]);
        }

        try {
            $token = trim(substr($authorizationHeader, 7));

            JWT::decode($token, new Key($_ENV['JWT_KEY'] ?? 'secret', 'HS256'));
        } catch (Exception $ignored) {
            response()->httpCode(401)->json([
                "error" => "Sem permissão3"
            ]);
        }
    }
}
