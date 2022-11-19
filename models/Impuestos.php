<?php

namespace Model;

use Model\ActiveRecord;

class Impuestos extends ActiveRecord
{
    protected static $tabla = 'impuestos';
    protected static $columnasDB = ['id', 'iva', 'flete', 'descarga', 'seguro'];

    public $id;
    public $iva;
    public $flete;
    public $descarga;
    public $seguro;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->iva = $args['iva'] ?? '';
        $this->flete = $args['flete'] ?? '';
        $this->descarga = $args['descarga'] ?? '';
        $this->seguro = $args['seguro'] ?? '';
    }

    public function validar(){

        if(!$this->iva || !$this->flete || !$this->descarga || !$this->seguro){
            self::$alertas['error'][]='Hacen falta impuestos por definir';
        }


        return self::$alertas;
    }

}
