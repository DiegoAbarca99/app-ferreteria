<?php
namespace Model;

use Model\ActiveRecord;
class Historico extends ActiveRecord {
    protected static $tabla='historicousuarios';
    protected static $columnasDB=['id','usuario','nombre','fecha','sucursal','detalles','accion','usuarios_id'];

    public function __construct($args=[]){
        $this->id=$args['id']??null;
        $this->usuario=$args['usuario']??'';
        $this->nombre=$args['nombre']??'';
        $this->fecha=$args['fecha']??'';
        $this->sucursal=$args['sucursal']??'';
        $this->detalles=$args['detalles']??'';
        $this->accion=$args['accion']??'';
        $this->usuarios_id=$args['usuarios_id']??'';
    }


}
