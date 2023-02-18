<?php

namespace Model;

use Model\ActiveRecord;

class Historico extends ActiveRecord
{
    protected static $tabla = 'historicousuarios';
    protected static $columnasDB = ['id', 'entidadModificada', 'accion', 'usuarios_id', 'valorNuevo', 'valorAnterior'];

    public $id;
    public $entidadModificada;
    public $fecha;
    public $usuarios_id;
    public $accion;
    public $valorAnterior;
    public $valorNuevo;


    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->entidadModificada = $args['entidadModificada'] ?? '';
        $this->fecha = $args['fecha'] ?? '';
        $this->accion = $args['accion'] ?? '';
        $this->usuarios_id = $args['usuarios_id'] ?? '';
        $this->valorAnterior = $args['valorAnterior'] ?? '';
        $this->valorNuevo = $args['valorNuevo'] ?? '';
    }
}
