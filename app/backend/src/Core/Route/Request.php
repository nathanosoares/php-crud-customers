<?php

namespace Nathan\Kabum\Core\Route;

class Request
{

    private $inputContents;

    public function getMethod(): string
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function getPath()
    {
        $path = $_SERVER['REQUEST_URI'] ?? '/';

        $pos = strpos($path, '?');

        return $pos ? substr($path, 0, $pos) : $path;
    }

    public function getPostInput($name, $defaultValue = null): mixed
    {
        if ("post" !== $this->getMethod() && "delete" !== $this->getMethod()) {
            return $defaultValue;
        }

        if ($this->inputContents == null) {
            $this->inputContents = file_get_contents('php://input');
        }

        $data = json_decode($this->inputContents, true);

        return $data[$name] ?? $defaultValue;
    }

    public function response(mixed $data, int $statusCode = 200): void
    {
        header('Content-Type: application/json; charset=utf-8');
        http_response_code($statusCode);
        echo json_encode($data);
        exit(0);
    }
}
