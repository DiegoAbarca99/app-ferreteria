<?php
namespace Model;

class OficinaPedido extends ActiveRecord{ 
    protected static $tabla='productospedidos'; 

    protected static $columnasDB=['id','folio','fecha','celular','credito','abono','curp','pagado','status','metodoPago','total','cantidad','precio','tipo','cliente','direccion','ubicacion','telefono','cuota','producto','usuario','sucursal']; //Nombre de las columnas y alias dfinidos tras efectuar los JOINS

    public $id;
    public $folio;
    public $pagado;
    public $fecha;
    public $credito;
    public $abono;
    public $celular;
    public $curp;
    public $status;
    public $metodoPago;
    public $total;
    public $cantidad;
    public $precio;
    public $tipo;
    public $cliente;
    public $direccion;
    public $ubicacion;
    public $telefono;
    public $cuota;
    public $producto;
    public $usuario;
    public $sucursal;

    public function __construct($args=[])
    {
        $this->id=$args['id']??null;
        $this->folio=$args['folio']??null;
        $this->pagado=$args['pagado']??'';
        $this->fecha=$args['fecha']??'';
        $this->credito=$args['credito']??'';
        $this->abono=$args['abono']??'';
        $this->celular=$args['celular']??'';
        $this->curp=$args['curp']??'';
        $this->status=$args['status']??'';
        $this->metodoPago=$args['metodoPago']??'';
        $this->total=$args['total']??'';
        $this->cantidad=$args['cantidad']??'';
        $this->precio=$args['precio']??'';
        $this->tipo=$args['tipo']??'';
        $this->cliente=$args['cliente']??'';
        $this->direccion=$args['direccion']??'';
        $this->ubicacion=$args['ubicacion']??'';
        $this->telefono=$args['telefono']??'';
        $this->cuota=$args['cuota']??'';
        $this->producto=$args['producto']??'';
        $this->usuario=$args['usuario']??'';
        $this->sucursal=$args['sucursal']??'';
        
    }
}