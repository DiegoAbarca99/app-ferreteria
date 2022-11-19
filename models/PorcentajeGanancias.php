<?php

namespace Model;

use Model\ActiveRecord;

class PorcentajeGanancias extends ActiveRecord
{
    protected static $tabla = 'porcentajeganancias';
    protected static $columnasDB = ['id', 'gananciapublico1', 'gananciaherrero2', 'gananciaherrero3', 'gananciaherrero4', 'gananciamayoreo1', 'gananciamayoreo2'];

    public $id;
    public $gananciapublico1;
    public $gananciaherrero2;
    public $gananciaherrero3;
    public $gananciaherrero4;
    public $gananciamayoreo1;
    public $gananciamayoreo2;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->gananciapublico1 = $args['gananciapublico1'] ?? '';
        $this->gananciaherrero2 = $args['gananciaherrero2'] ?? '';
        $this->gananciaherrero3 = $args['gananciaherrero3'] ?? '';
        $this->gananciaherrero4 = $args['gananciaherrero4'] ?? '';
        $this->gananciamayoreo1 = $args['gananciamayoreo1'] ?? '';
        $this->gananciamayoreo2 = $args['gananciamayoreo2'] ?? '';
    }

    public function validar(){

        if(!$this->gananciapublico1 || !$this->gananciaherrero2 || !$this->gananciaherrero3 || !$this->gananciaherrero4 || !$this->gananciamayoreo1 || !$this->gananciamayoreo2){
            self::$alertas['error'][]='Hacen falta ganancias por definir';
        }


        return self::$alertas;
    }
}
