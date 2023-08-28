<?php

namespace Controllers;

use Exception;
use Model\Usuario;
use MVC\Router;
use Classes\Validator;
class AdministracionController {

    public static function userAdmin(Router $router) 
    {
        $usuarios = usuario::all();
        $router->render('usuarios/administraciones', []);
    }

    public static function guardarAPI() 
    {
        try 
        {
            $rules = [
                'usu_nombre' => [
                    [Validator::class, 'validateRequired', "El campo nombre es obligatorio.\n\n"],
                    [Validator::class, 'validateAlpha', "El nombre de usuario debe contener solo letras. \n\n"]
                ],
                'usu_catalogo' => [
                    [Validator::class, 'validateRequired', "El campo catalogo es obligatorio. \n\n"],
                    [Validator::class, 'validateNumeric', "El campo catalogo, solo acepta numeros. \n\n"],
                    [Usuario::class, 'validateCatalogo', "El catalogo introducido ya existe. Intente con uno nuevo. \n\n"]
                ],
                'usu_password' => [
                    [Validator::class, 'validateRequired', "El campo contrasena es requerido. \n\n"],
                    [Validator::class, 'validatePassword', "La contraseña debe tener al menos una mayúscula, una minúscula, un número, un símbolo y una longitud minima de 8 caracteres. \n\n"]
                ]
            ];
            
            $errors = Validator::validate($_POST, $rules);
            
            if (empty($errors)) {
                
                $nombre = $_POST["usu_nombre"];
                $catalogo = $_POST["usu_catalogo"];
                $password = $_POST["usu_password"];
                
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                $usuario = new Usuario([
                    'usu_nombre' => $nombre,
                    'usu_catalogo' => $catalogo,
                    'usu_password' => $hashed_password
                ]);

                $resultado = $usuario->guardar();

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

        // $usu_nombre = $_GET['usu_nombre'];
        // $usu_catalogo = $_GET['usu_catalogo'];
        // $rol_usu = $_GET['rol_usu'];
        // $usu_estado = $_GET['usu_estado'];
       

        // $sql = "SELECT * FROM clientes where cliente_situacion = 1 ";
        // if ($usu_nombre != '') {
        //     $sql .= " and usu_nombre like '%$usu_nombre%' ";
        // }

        // if ($usu_catalogo != '') {
        //     $sql .= " and usu_catalogo like '%$usu_catalogo%' ";
        // }
        // if ($rol_usu != '') {
        //     $sql .= " and rol_usu like '%$rol_usu%' ";
        // }
        // if ($usu_estado != '') {
        //     $sql .= " and usu_estado like '%$usu_estado%' ";
        // }
        
        
        try {

            $usuario = new Usuario($_GET);
            $response = $usuario::getUsers();
            header('Content-Type: application/json');
            echo json_encode($response);
            
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    }

    // public static function modificarApi(){
     
    //     try {
    //         $usuario = new Usuario($_POST);

    //         $resultado = $usuario -> actualizar();

    //         if ($resultado['resultado'] == 1) {
    //             echo json_encode([
    //                 'mensaje' => 'Registro modificado correctamente',
    //                 'codigo' => 1
    //             ]);
    //         } else {
    //             echo json_encode([
    //                 'mensaje' => 'Ocurrió un error',
    //                 'codigo' => 0
    //             ]);
    //         }
    //         // echo json_encode($resultado);
    //     } catch (Exception $e) {
    //         echo json_encode([
    //             'detalle' => $e->getMessage(),
    //             'mensaje' => 'Ocurrió un error',
    //             'codigo' => 0
    //         ]);
    //     }
    // }
    // public static function eliminarApi(){
     
    //     try {
    //         $usu_id = $_POST['usu_id'];
    //         $usuario=  Usuario::find($usu_id);
    //         $usuario ->usu_situacion = 0;
    //         $resultado = $usuario ->actualizar();

    //         if ($resultado['resultado'] == 1) {
    //             echo json_encode([
    //                 'mensaje' => 'Registro eliminado correctamente',
    //                 'codigo' => 1
    //             ]);
    //         } else {
    //             echo json_encode([
    //                 'mensaje' => 'Ocurrió un error',
    //                 'codigo' => 0
    //             ]);
    //         }

    //     } catch (Exception $e) {
    //         echo json_encode([
    //             'detalle' => $e->getMessage(),
    //             'mensaje' => 'Ocurrió un error',
    //             'codigo' => 0
    //         ]);
    //     }
    // }
}

?>