<?php

namespace Controllers;

use Exception;
use Model\Usuario;
use MVC\Router;
use Classes\Validator;

class UsuarioController {

    public static function usuariosfun(Router $router) 
    {
        $usuarios = usuario::all();
        $router->render('usuarios/index', [$usuarios]);
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

}

?>