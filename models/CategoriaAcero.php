<?php
namespace Model;
use Model\ActiveRecord;
class CategoriaAcero extends ActiveRecord {
    protected static $tabla='categoriaacero'; 
    protected static $columnasDB=['id','categoria'];

    public $id;
    public $categoria;
   
    public function __construct($args=[]){
        $this->id=$args['id']??null;
        $this->categoria=$args['categoria']??'';
       
    }


   
}