<?php

namespace Model;

use Model\ActiveRecord;

class Sucursales extends ActiveRecord
{
    protected static $tabla = 'sucursales';
    protected static $columnasDB = ['id', 'nombre'];

    public $id;
    public $nombre;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
    }
}
