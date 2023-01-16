<?php

namespace Model;

use Model\ActiveRecord;

class Pedidos extends ActiveRecord
{
    protected static $tabla = 'pedidos';
    protected static $columnasDB = ['id', 'pagado', 'status', 'metodoPago', 'total', 'usuarios_id', 'clientes_id'];

    public $id;
    public $pagado;
    public $status;
    public $metodoPago;
    public $fecha;
    public $total;
    public $usuarios_id;
    public $clientes_id;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->pagado = $args['pagado'] ?? '';
        $this->status = $args['status'] ?? '';
        $this->metodoPago = $args['metodoPago'] ?? '';
        $this->fecha = $args['fecha'] ?? '';
        $this->total = $args['total'] ?? '';
        $this->usuarios_id = $args['usuarios_id'] ?? '';
        $this->clientes_id = $args['clientes_id'] ?? '';
    }

    public function validar()
    {
        if (!$this->pagado) {
            self::$alertas['error'][] = 'Debe especificar si el pedido ya fue pagado';
        }

        if (!$this->status) {
            self::$alertas['error'][] = 'Debe especificar el status del pedido';
        }
        if (!$this->metodoPago) {
            self::$alertas['error'][] = 'Debe especificar el mètodo de pago';
        }
        return self::$alertas;
    }
}
