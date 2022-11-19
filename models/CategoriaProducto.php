<?php
namespace Model;
use Model\ActiveRecord;
class CategoriaProducto extends ActiveRecord {
    protected static $tabla='categoriaproducto'; 
    protected static $columnasDB=['id','nombre','impuestos_id','porcentajeGanancias_id'];

    public $id;
    public $nombre;
    public $impuestos_id;
    public $porcentajeGanancias_id;
   
    public function __construct($args=[]){
        $this->id=$args['id']??null;
        $this->nombre=$args['nombre']??'';
        $this->impuestos_id=$args['impuestos_id']??'';
        $this->porcentajeGanancias_id=$args['porcentajeGanancias_id']??'';

    }

    public function validar(){

        if(!$this->nombre){
            self::$alertas['error'][]='El nombre de la categoria es obligatorio';
        }


        return self::$alertas;
    }

   
}