<?php

namespace Model;

use Model\ActiveRecord;

class ProductosProveedores extends ActiveRecord
{
    protected static $tabla = 'productosproveedores';
    protected static $columnasDB = ['id', 'nombre', 'categoriaProductosProveedores_id', 'pesos_id', 'preciosProveedores_id', 'productosComerciales_id'];

    public $id;
    public $nombre;
    public $categoriaProductosProveedores_id;
    public $pesos_id;
    public $preciosProveedores_id;
    public $productosComerciales_id;


    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->categoriaProductosProveedores_id = $args['categoriaProductosProveedores_id'] ?? '';
        $this->pesos_id = $args['pesos_id'] ?? '';
        $this->preciosProveedores_id = $args['preciosProveedores_id'] ?? '';
        $this->productosComerciales_id = $args['productosComerciales_id'] ?? '';
        
    }

    public function validar()
    {
        if(!$this->nombre){
            self::$alertas['error'][]='El Nombre Es Obligatorio';
        }

        if(!$this->categoriaProductosProveedores_id){
            self::$alertas['error'][]='La Categoria es obligatoria';
        }


        if(!$this->productosComerciales_id){
            self::$alertas['error'][]='Debe estar asociado a un producto comercial';
        }

        return self::$alertas;


    }

}
