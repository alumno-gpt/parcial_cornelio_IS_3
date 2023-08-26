<?php

namespace Model;

class Usuario extends ActiveRecord{
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['usu_nombre','usu_catalogo','rol_usu','usu_password','usu_estado','usu_situacion'];
    protected static $idTabla = 'usu_id';

    public $cliente_id;
    public $usu_nombre;
    public $usu_catalogo;
    public $usu_rol;
    public $usu_password;
    public $usu_estado;
    public $usu_situacion;


    public function __construct($args = [] )
    {
        $this->cliente_id = $args['cliente_id'] ?? null;
        $this->usu_nombre = $args['usu_nombre'] ?? '';
        $this->usu_catalogo = $args['usu_catalogo'] ?? '';
        $this->usu_rol = $args['usu_rol'] ?? '';
        $this->usu_password = $args['usu_password'] ?? '';
        $this->usu_estado = $args['usu_estado'] ?? '';
        $this->usu_situacion = $args['usu_situacion'] ?? '1';
    }
}


