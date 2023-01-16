<?php 
    namespace Model;
    use Model\ActiveRecord;

 class Municipios extends ActiveRecord{

    protected static $tabla = 'municipios';
    protected static $columnasDB = ['id', 'nombre'];

        public $id;
        public $nombre;

        public function __construct($args=[])
        {
            $this->id=$args['id']??'';
            $this->nombre=$args['nombre']??'';
        
        }


    }
