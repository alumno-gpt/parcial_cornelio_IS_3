<?php 
require_once __DIR__ . '/../includes/app.php';


use MVC\Router;
use Controllers\AppController;
use Controllers\UsuarioController;
use Controllers\RolController;
use Controllers\AdministracionController;
$router = new Router();
$router->setBaseURL('/' . $_ENV['APP_NAME']);

$router->get('/', [AppController::class,'index']);

//usuarios
$router->get('/usuarios', [UsuarioController::class,'usuariosfun']);
$router->post('/API/usuarios/guardar', [UsuarioController::class,'guardarAPI']);


//roles
$router->get('/roles', [RolController::class,'rolesfun']);
$router->get('/API/roles/buscar', [RolController::class,'buscarApi']);
$router->post('/API/roles/guardar', [RolController::class,'guardarApi']);
$router->post('/API/roles/modificar', [RolController::class,'modificarApi']);
$router->post('/API/roles/eliminar', [RolController::class,'eliminarApi']);

//administracion
$router->get('/usuarios/administrar', [AdministracionController::class,'userAdmin']);
$router->get('/API/administraciones/buscar', [AdministracionController::class,'buscarApi']);
$router->post('/API/administraciones/guardar', [AdministracionController::class,'guardarApi']);
$router->post('/API/administraciones/modificar', [AdministracionController::class,'modificarApi']);
$router->post('/API/administraciones/eliminar', [AdministracionController::class,'eliminarApi']);


$router->get('/API/usuarios/rolestado', [GraficoController::class,'rol']);


// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();
