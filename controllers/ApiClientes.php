<?php

namespace Controllers;

use Model\Clientes;
use Model\Municipios;

class ApiClientes
{
    public static function index()
    {
        session_start();
        isAuth();
        isProveedor();

        $id = filter_Var($_GET['id'], FILTER_VALIDATE_INT);

        if (!$id) {

            $clientes = Clientes::all();
            foreach ($clientes as $cliente) {
                $cliente->municipio = Municipios::find($cliente->municipios_id);
            }
        } else {
            $municipio = Municipios::find($id);
            if ($municipio) {

                $clientes = Clientes::belongsTo('municipios_id', $id);

                foreach ($clientes as $cliente) {
                    $cliente->municipio = Municipios::find($cliente->municipios_id);
                }
            }
        }



        echo json_encode($clientes);
    }
}
