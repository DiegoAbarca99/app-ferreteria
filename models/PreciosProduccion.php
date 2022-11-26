<?php
namespace Model;

use Model\ActiveRecord;

class PreciosProduccion extends ActiveRecord
{
    protected static $tabla = 'preciosproduccion';
    protected static $columnasDB = ['id', 'publico1', 'herrero2', 'herrero3', 'herrero4', 'mayoreo1', 'mayoreo2'];

    public $id;
    public $publico1;
    public $herrero2;
    public $herrero3;
    public $herrero4;
    public $mayoreo1;
    public $mayoreo2;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->publico1 = $args['publico1'] ?? '';
        $this->herrero2 = $args['herrero2'] ?? '';
        $this->herrero3 = $args['herrero3'] ?? '';
        $this->herrero4 = $args['herrero4'] ?? '';
        $this->mayoreo1 = $args['mayoreo1'] ?? '';
        $this->mayoreo2 = $args['mayoreo2'] ?? '';
    }

  
}
