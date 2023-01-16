<?php

namespace Model;

use Model\ActiveRecord;

class ProductosPedidos extends ActiveRecord
{
    protected static $tabla = 'productospedidos';
    protected static $columnasDB = ['id', 'pedidos_id', 'productosProveedores_id','tipo','cantidad','precio'];

    public $id;
    public $pedidos_id;
    public $productosProveedores_id;
    public $tipo;
    public $cantidad;
    public $precio;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->pedidos_id = $args['pedidos_id'] ?? '';
        $this->productosProveedores_id = $args['productosProveedores_id'] ?? '';
        $this->tipo = $args['tipo'] ?? '';
        $this->cantidad = $args['cantidad'] ?? '';
        $this->precio = $args['precio'] ?? '';
    }
}
