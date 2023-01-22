<?php

namespace Model;

use Model\ActiveRecord;

class Clientes extends ActiveRecord
{
    protected static $tabla = 'clientes';
    protected static $columnasDB = ['id', 'nombre', 'telefono', 'curp', 'rfc', 'codigoPostal', 'estado', 'calle', 'numeroExterno', 'numeroInterno', 'colonia', 'cuotaConsumo', 'credito', 'municipios_id'];

    public $id;
    public $nombre;
    public $telefono;
    public $curp;
    public $rfc;
    public $codigoPostal;
    public $estado;
    public $calle;
    public $numeroExterno;
    public $numeroInterno;
    public $colonia;
    public $cuotaConsumo;
    public $credito;
    public $municipios_id;


    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->curp = $args['curp'] ?? '';
        $this->rfc = $args['rfc'] ?? '';
        $this->codigoPostal = $args['codigoPostal'] ?? '';
        $this->estado = $args['estado'] ?? '';
        $this->calle = $args['calle'] ?? '';
        $this->numeroExterno = $args['numeroExterno'] ?? '';
        $this->numeroInterno = $args['numeroInterno'] ?? '';
        $this->colonia = $args['colonia'] ?? '';
        $this->cuotaConsumo = $args['cuotaConsumo'] ?? '';
        $this->credito = $args['credito'] ?? '';
        $this->municipios_id = $args['municipios_id'] ?? '';
    }

    public function validar()
    {

        if (!$this->nombre) {
            self::$alertas['error'][] = 'El nombre completo es obligatorio';
        }

        if (!$this->curp) {
            self::$alertas['error'][] = 'El CURP es obligatorio';
        }

        if (!validarCURP($this->curp)) {
            self::$alertas['error'][] = 'El CURP no es valido';
        }

        if (!$this->telefono) {
            self::$alertas['error'][] = 'El telefono es obligatorio';
        }

        if (strlen($this->telefono) != 10) {
            self::$alertas['error'][] = 'El telefono debe contener 10 dígitos';
        }

        if (!$this->numeroExterno) {
            self::$alertas['error'][] = 'Debe especificar el nùmero externo';
        }

        if (!$this->rfc) {
            self::$alertas['error'][] = 'Debe especificar el rfc';
        }
        if (!preg_match('/^([A-Z,Ñ,&]{3,4}([0-9]{2})(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1])[A-Z|\d]{3})$/', $this->rfc)) {
            self::$alertas['error'][] = 'El rfc no es valido';
        }

        if (!$this->codigoPostal) {
            self::$alertas['error'][] = 'El còdigo postal es obligatorio';
        }
        if (strlen($this->codigoPostal) != 5) {
            self::$alertas['error'][] = 'El còdigo postal debe constar de 5 digitos';
        }

        if (!$this->estado) {
            self::$alertas['error'][] = 'Debe especificar el estado';
        }


        if (!$this->municipios_id) {
            self::$alertas['error'][] = 'Debe especificar un municipio';
        }

        if (!$this->calle) {
            self::$alertas['error'][] = 'Debe especificar la calle';
        }


        if (!$this->colonia) {
            self::$alertas['error'][] = 'Debe especificar la colonia';
        }




        return self::$alertas;
    }
}
