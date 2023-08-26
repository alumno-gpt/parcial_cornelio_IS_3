<?php

namespace Controllers;

use Exception;
use Model\Rol;
use MVC\Router;

class RolController {
    public static function index(Router $router){
        $router->render('roles/index', []);
    }
}