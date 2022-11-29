<?php

namespace Model;

use Model\ActiveRecord;

class Pesos extends ActiveRecord
{
    protected static $tabla = 'pesos';
    protected static $columnasDB = ['id', 'pesoAntiguo', 'pesoNuevo', 'pesoPromedio'];

    public $id;
    public $pesoAntiguo;
    public $pesoNuevo;
    public $pesoPromedio;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->pesoAntiguo = $args['pesoAntiguo'] ?? '';
        $this->pesoNuevo = $args['pesoNuevo'] ?? '';
        $this->pesoPromedio = $args['pesoPromedio'] ?? '';
    }

    public function validar()
    {
        if (!$this->pesoNuevo) {
            self::$alertas['error'][] = 'Debe especificar un peso inicial';
        }
        return self::$alertas;
    }
}
