<?php 
require_once __DIR__ . '/../includes/app.php';


use MVC\Router;
use Controllers\AppController;
use Controllers\UsuarioController;
use Controllers\RolController;
$router = new Router();
$router->setBaseURL('/' . $_ENV['APP_NAME']);

$router->get('/', [AppController::class,'index']);

//usuarios
$router->get('/usuarios', [UsuarioController::class,'usuariosfun']);
$router->get('/API/usuarios/buscar', [UsuarioController::class,'buscarApi']);
$router->post('/API/usuarios/guardar', [UsuarioController::class,'guardarApi']);
$router->post('/API/usuarios/modificar', [UsuarioController::class,'modificarApi']);
$router->post('/API/usuarios/eliminar', [UsuarioController::class,'eliminarApi']);

//roles
$router->get('/roles', [RolController::class,'rolesfun']);
$router->get('/API/roles/buscar', [RolController::class,'buscarApi']);
$router->post('/API/roles/guardar', [RolController::class,'guardarApi']);
$router->post('/API/roles/modificar', [RolController::class,'modificarApi']);
$router->post('/API/roles/eliminar', [RolController::class,'eliminarApi']);


// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();
