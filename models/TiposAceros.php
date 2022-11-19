<?php

namespace Model;

use Model\ActiveRecord;

class TiposAceros extends ActiveRecord
{
    protected static $tabla = 'tiposaceros';
    protected static $columnasDB = ['id', 'categoriaacero_id', 'nombre', 'prolamsa', 'arcoMetal', 'slp', 'descripcionacero_id'];

    public $id;
    public $categoriaacero_id;
    public $nombre;
    public $prolamsa;
    public $arcoMetal;
    public $slp;
    public $descripcionacero_id;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->categoriaacero_id = $args['categoriaacero_id'] ?? '';
        $this->nombre = $args['nombre'] ?? '';
        $this->prolamsa = $args['prolamsa'] ?? 0;
        $this->arcoMetal = $args['arcoMetal'] ?? 0;
        $this->slp = $args['slp'] ?? 0;
        $this->descripcionacero_id = $args['descripcionacero_id'] ?? '';
    }

    public function validar()
    {

        if (!$this->nombre) {
            self::$alertas['error'][] = 'El nombre es obligatorio';
        }

     

        if (!$this->categoriaacero_id) {
            self::$alertas['error'][] = 'La categoria es obligatoria';
        }
        if (!$this->descripcionacero_id) {
            self::$alertas['error'][] = 'La descripción es obligatoria';
        }


        return self::$alertas;
    }
}
