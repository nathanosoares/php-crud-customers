<?php

namespace Nathan\Kabum\Controllers;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Nathan\Kabum\Core\Application;

class LoginController
{

    public function login(Application $app): void
    {
        $username = $app->request->getPostInput('username');
        $password = $app->request->getPostInput('password');

        if (!$username || strlen($username) < 2 || strlen($username) > 32) {
            $app->request->response([
                'success' => false,
                'error' => 'O campo usuário está inválido.'
            ], 400);
        }

        if (!$password || strlen($password) < 1) {
            $app->request->response([
                'success' => false,
                'error' => 'O campo senha está inválido.'
            ], 400);
        }

        $adminUser = $_ENV['ADMIN_USER'] ?? 'admin';
        $adminPass = $_ENV['ADMIN_PASS'] ?? 'secret';

        if ($adminUser == $username && $adminPass == $password) {
            $app->request->response([
                'success' => true,
                'token' => $this->generateJWTToken()
            ]);
        }

        $app->request->response([
            'success' => false,
            'error' => 'Usuário ou senha incorretos.'
        ], 400);
    }

    public function refresh(Application $app): void
    {
        try {
            $app->request->response([
                'success' => true,
                'token' => $this->generateJWTToken()
            ]);
        } catch (Exception $ignored) {
            $app->request->response([
                'error' => 'Unauthorized'
            ], 401);
        }
    }

    private function generateJWTToken(): string
    {
        return JWT::encode([], $_ENV['JWT_KEY'] ?? 'secret', 'HS256');
    }
}
