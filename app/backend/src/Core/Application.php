<?php

namespace Nathan\Kabum\Core;

use Nathan\Kabum\Core\Route\Request;
use Nathan\Kabum\Core\Route\Router;

class Application
{
    public Request $request;
    public Router $router;

    public function __construct()
    {
        $this->request = new Request;
        $this->router = new Router($this);
    }
}
