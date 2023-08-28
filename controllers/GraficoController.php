<?php

namespace Controllers;
use Exception;
use Model\Usuario;
use MVC\Router;

class GraficoController {
    public static function estado(Router $router) 
    {
        $router->render('graficos/usuarioestado', []);
    }

    public static function index(Router $router) 
    {
        $router->render('graficos/index', []);
    }

    public static function getData(Router $router) 
    {

        try {

            if($_GET['tipo'] == 1){

                $sql = "SELECT usu_estado AS estado, COUNT(*) AS cantidad_usuarios
                    FROM usuarios
                    WHERE usu_situacion = 1
                    GROUP BY usu_estado
                    ORDER BY usu_estado";
            }elseif($_GET['tipo'] == 2){

                $sql = "SELECT r.rol_nombre AS rol, COUNT(ar.usuario) AS cantidad_usuarios
                FROM roles r
                LEFT JOIN asignacion_roles ar ON r.rol_id = ar.rol
                WHERE r.rol_situacion = 1
                GROUP BY r.rol_id, r.rol_nombre
                ORDER BY r.rol_nombre";
            }

            $resultados = Usuario::fetchArray($sql);

            echo json_encode($resultados);

        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    }
}
