<?php

namespace Model;

class Usuario extends ActiveRecord{
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['USU_NOMBRE','USU_CATALOGO','USU_PASSWORD','USU_ESTADO','USU_SITUACION'];
    protected static $idTabla = 'USU_ID';

    public $usu_id;
    public $usu_nombre;
    public $usu_catalogo;
    public $usu_password;
    public $usu_estado;
    public $usu_situacion;


    public function __construct($args = [] )
    {
        $this->usu_id = $args['usu_id'] ?? null;
        $this->usu_nombre = $args['usu_nombre'] ?? '';
        $this->usu_catalogo = $args['usu_catalogo'] ?? '';
        $this->usu_password = $args['usu_password'] ?? '';
        $this->usu_estado = $args['usu_estado'] ?? 'P';
        $this->usu_situacion = $args['usu_situacion'] ?? '1';
    }

    public static function validateCatalogo($catalogo)
    {
        $respuesta = self::where('USU_CATALOGO', $catalogo);

        if(count($respuesta) == 0){
            return true;
        }
        return false;
    }


    public static function getUsers()
    {
        $respuesta = self::consultarSQL("SELECT USU_NOMBRE,USU_CATALOGO,USU_ESTADO,USU_SITUACION FROM usuarios");
        return $respuesta;
    }
}

