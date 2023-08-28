<?php

namespace Controllers;
use Exception;
use Model\Rol;
use MVC\Router;
use Classes\Validator;

class RolController {
    public static function rolesfun(Router $router){
        $rol = rol::all();
        $router->render('roles/index', [$rol]);
    }

    public static function guardarAPI() 
    {
        try 
        {
            $rules = [
                'rol_nombre' => [
                    [Validator::class, 'validateRequired', "El campo Rol es obligatorio.\n\n"]
                ]
            ];
            
            $errors = Validator::validate($_POST, $rules);
            
            if (empty($errors)) {
                
                $rol = new Rol($_POST);

                $resultado = $rol->guardar();

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

            } else {
                // Los datos no son válidos, mostrar errores
                echo json_encode([
                    'mensaje' => $errors,
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

    public static function buscarApi(){
        $rol_nombre = $_GET['rol_nombre'];


        $sql = "SELECT * FROM roles where rol_situacion = 1 ";
        if ($rol_nombre != '') {
            $sql .= " and rol_nombre like '%$rol_nombre%' ";
        }
         
        try {
            
            $rol = Rol::fetchArray($sql);
            header('Content-Type: application/json');

            echo json_encode($rol);
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    }
    public static function modificarApi(){
     
        try {
            $rol = new Rol($_POST);

            $resultado = $rol->actualizar();

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
            // echo json_encode($resultado);
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    }


    public static function eliminarApi(){
     
        try {
            $rol = new Rol($_POST);
            $resultado = $rol->eliminarRol();

            if ($resultado) {
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
            // echo json_encode($resultado);
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    }

}



 
?>



