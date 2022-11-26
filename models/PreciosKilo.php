<?php

namespace Model;

use Model\ActiveRecord;

class PreciosKilo extends ActiveRecord
{
    protected static $tabla = 'precioskilo';
    protected static $columnasDB = ['id', 'nombre', 'codigo', 'productosComerciales_id'];

    public $id;
    public $nombre;
    public $codigo;
    public $productosComerciales_id;
    

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->codigo = $args['codigo'] ?? '';
        $this->productosComerciales_id = $args['productosComerciales_id'] ?? '';
    }

    public function validar()
    {

        if (!$this->nombre) {
            self::$alertas['error'][] = 'El nombre del producto es obligatorio';
        }

        if (!$this->codigo) {
            self::$alertas['error'][] = 'El código del producto es obligatorio';
        }

        if (!$this->productosComerciales_id) {
            self::$alertas['error'][] = 'Debe estar asociado a un producto existente';
        }


        return self::$alertas;
    }
}
