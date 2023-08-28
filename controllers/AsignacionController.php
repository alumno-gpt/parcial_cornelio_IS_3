<?php

namespace Controllers;

use Exception;
use Model\Asignacion;
use Model\Usuario;
use Model\Rol;
use MVC\Router;

class AsignacionController
{
    public static function index(Router $router){
        $usuarios = static::buscarUsuario();
        $roles = static::buscarRol();
        $asignaciones = Asignacion::all();

        $router->render('asignaciones/index', [
            'usuarios' => $usuarios,
            'roles' => $roles,
            'asignaciones' => $asignaciones,
        ]);
    }
    public static function buscarUsuario(){
        $sql = "SELECT * FROM usuarios where usu_situacion = 1";
    
        try {
            $usuarios = Usuario::fetchArray($sql);
    
            return $usuarios;
        } catch (Exception $e) {

            return [];
            
        }
    }
    public static function buscarRol(){
        $sql = "SELECT * FROM roles where rol_situacion = 1";
    
        try {
            $roles = Rol::fetchArray($sql);
            return $roles;

        } catch (Exception $e) {
            return [];
            
        }
    }

    public static function guardarAPI()
    {
        try {
            $asignacion = new Asignacion($_POST);
            $resultado = $asignacion->crear();

            if ($resultado['resultado'] == 1) {
                echo json_encode([
                    'mensaje' => 'Registro guardado correctamente',
                    'codigo' => 1
                ]);
            } else {
                echo json_encode([
                    'mensaje' => 'Ocurrió un error',
                    'codigo' => 0
                ]);
            }
            // echo json_encode($resultado);
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    }

    public static function modificarAPI()
    {
   
        try {
            $asignacion = new Asignacion($_POST);
            $resultado = $asignacion->actualizar();

            if ($resultado['resultado'] == 1) {
                echo json_encode([
                    'mensaje' => 'Registro modificado correctamente',
                    'codigo' => 1
                ]);
            } else {
                echo json_encode([
                    'mensaje' => 'Ocurrió un error',
                    'codigo' => 0
                ]);
            }

        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    }

    public static function eliminarAPI()
    {
        try {
            $asignacion_id = $_POST['asignacion_id'];
            $asignacion = Asignacion::find($asignacion_id);
            $asignacion->asignacion_situacion = 0;
            $resultado = $asignacion->actualizar();

            if ($resultado['resultado'] == 1) {
                echo json_encode([
                    'mensaje' => 'Registro eliminado correctamente',
                    'codigo' => 1
                ]);
            } else {
                echo json_encode([
                    'mensaje' => 'Ocurrió un error',
                    'codigo' => 0
                ]);
            }
           
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    }

    public static function activarAPI(){
       
    
        try {
            $usu_id = $_POST['usu_id'];
            $sql = "UPDATE usuario set usu_estado = 'ACTIVO' where usu_id = ${usu_id}";
            $resultado = Usuario::SQL($sql);
            $resultado=1;

            if ($resultado == 1) {
                echo json_encode([
                    'mensaje' => 'Usuario activado correctamente' ,
                    'codigo' => 1
                ]);
            } else {
                echo json_encode([
                    'mensaje' => 'Ocurrió un error al actualizar',
                    'codigo' => 0
                ]);
            }
           
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    }
    public static function desactivarAPI(){
       
    
        try {
            $usu_id = $_POST['usu_id'];
            $sql = "UPDATE usuario set usu_estado = 'INACTIVO' where usu_id = ${usu_id}";
            $resultado = Usuario::SQL($sql);
            $resultado=1;

            if ($resultado == 1) {
                echo json_encode([
                    'mensaje' => 'Usuario activado correctamente' ,
                    'codigo' => 1
                ]);
            } else {
                echo json_encode([
                    'mensaje' => 'Ocurrió un error al actualizar',
                    'codigo' => 0
                ]);
            }
           
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    }
   
    
    public static function buscarAPI()
    {
        $usu_id = $_GET['usu_id'];
        $rol_id = $_GET['rol_id'];

        $sql = "SELECT
        a.asignacion_id,
        u.usu_nombre AS usuario,
        u.usu_id,
        r.rol_nombre AS rol,
        r.rol_id,
        u.usu_estado
    FROM
        asignacion_roles a
    INNER JOIN
        usuarios u ON a.usuario = u.usu_id
    INNER JOIN
        roles r ON a.rol = r.rol_id
    WHERE
        u.usu_situacion = '1' AND
        r.rol_situacion = '1'";
    
    
    if ($usu_id != '') {
        $sql .= " AND usuarios.usu_id = '$usu_id'";
    }
    
    if ($rol_id != '') {
        $sql .= " AND roles.rol_id = '$rol_id'";
    }

        try {

            $asignaciones = Asignacion::fetchArray($sql);

            echo json_encode($asignaciones);
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    }
}