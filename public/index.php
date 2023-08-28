<?php 
require_once __DIR__ . '/../includes/app.php';


use MVC\Router;
use Controllers\AppController;
use Controllers\UsuarioController;
use Controllers\RolController;
use Controllers\AdministracionController;
use Controllers\AsignacionController;
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


//asignacion de roles
$router->get('/asignaciones', [AsignacionController::class, 'index']);
$router->post('/API/asignaciones/guardar', [AsignacionController::class, 'guardarAPI']);
$router->post('/API/asignaciones/modificar', [AsignacionController::class, 'modificarAPI']);
$router->post('/API/asignaciones/eliminar', [AsignacionController::class, 'eliminarAPI']);
$router->get('/API/asignaciones/buscar', [AsignacionController::class, 'buscarAPI']);
$router->post('/API/asignaciones/activar', [AsignacionController::class, 'activarAPI']);
$router->post('/API/asignaciones/desactivar', [AsignacionController::class, 'desactivarAPI']);





//asignacion de roles


$router->get('/API/usuarios/rolestado', [GraficoController::class,'rol']);


// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();
