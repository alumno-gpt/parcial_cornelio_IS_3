<?php

namespace Model;

class Asignacion extends ActiveRecord {
    protected static $tabla = 'asignacion_roles';
    protected static $columnasDB = ['rol', 'usuario','asignacion_situacion'];
    protected static $idTabla = 'asignacion_id';

    public $asignacion_id;
    public $rol;
    public $usuario;
    public $asignacion_situacion;

    public function __construct($args = [])
    {
        $this->asignacion_id = $args['asignacion_id'] ?? null;
        $this->rol = $args['rol'] ?? null;
        $this->usuario = $args['usuario'] ?? null;
        $this->asignacion_situacion = $args['asignacion_situacion'] ?? '1';
    }
}
