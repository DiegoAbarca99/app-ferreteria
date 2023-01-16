<?php

namespace Model;

use Model\ActiveRecord;

class PedidosKilo extends ActiveRecord
{
    protected static $tabla = 'pedidoskilo';
    protected static $columnasDB = ['id', 'pedidos_id', 'precioskilo_id', 'tipo', 'cantidad', 'precio'];

    public $id;
    public $pedidos_id;
    public $precioskilo_id;
    public $tipo;
    public $cantidad;
    public $precio;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->pedidos_id = $args['pedidos_id'] ?? '';
        $this->precioskilo_id = $args['precioskilo_id'] ?? '';
        $this->tipo = $args['tipo'] ?? '';
        $this->cantidad = $args['cantidad'] ?? '';
        $this->precio = $args['precio'] ?? '';
    }
}
