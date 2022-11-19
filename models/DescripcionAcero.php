<?php
namespace Model;
use Model\ActiveRecord;
class DescripcionAcero extends ActiveRecord {
    protected static $tabla='descripcionacero'; 
    protected static $columnasDB=['id','descripcion'];

    public $id;
    public $descripcion;
   
    public function __construct($args=[]){
        $this->id=$args['id']??null;
        $this->descripcion=$args['descripcion']??'';
       
    }


   
}