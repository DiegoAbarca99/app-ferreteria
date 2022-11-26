<?php

namespace Model;

use Model\ActiveRecord;

class ProductosComerciales extends ActiveRecord
{
    protected static $tabla = 'productoscomerciales';
    protected static $columnasDB = ['id', 'nombre', 'costo', 'costoneto', 'preciosProduccion_id', 'categoriaProducto_id', 'tiposaceros_id'];

    public $id;
    public $nombre;
    public $costo;
    public $costoneto;
    public $preciosProduccion_id;
    public $categoriaProducto_id;
    public $tiposaceros_id;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->costo = $args['costo'] ?? null;
        $this->costoneto = $args['costoneto'] ?? 0;
        $this->preciosProduccion_id = $args['preciosProduccion_id'] ?? '';
        $this->categoriaProducto_id = $args['categoriaProducto_id'] ?? '';
        $this->tiposaceros_id = $args['tiposaceros_id'] ?? null;
    }

}
