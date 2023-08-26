<?php

namespace Controllers;

use Exception;
use Model\Usuario;
use MVC\Router;

class UsuarioController {
    public static function usuariosfun(Router $router){
        $router->render('usuarios/index', []);
    }
}