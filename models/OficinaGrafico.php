<?php
namespace Model;

class OficinaGrafico extends ActiveRecord{ 
    protected static $tabla='productospedidos'; 

    protected static $columnasDB=['id','fecha','total','abono']; //Nombre de las columnas y alias dfinidos tras efectuar los JOINS

    public $id;
    public $fecha;
    public $total;
    public $abono;
   

    public function __construct($args=[])
    {
        $this->id=$args['id']??null;
        $this->total=$args['total']??'';
        $this->fecha=$args['fecha']??'';
        $this->abono=$args['abono']??'';
       
        
    }
}