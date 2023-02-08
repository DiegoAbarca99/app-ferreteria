<?php

namespace Controllers;

use Model\CategoriaProductosProveedores;
use Model\Clientes;
use Model\Municipios;
use Model\Pedidos;
use MVC\Router;

class ProveedorController
{
    public static function index(Router $router)
    {
        session_start();
        isAuth();
        isProveedor();


        $municipios = Municipios::all();
        $categorias = CategoriaProductosProveedores::all();


        $router->render('proveedor/index', [
            'titulo' => 'Levantar Pedido',
            'municipios' => $municipios,
            'categorias' => $categorias
        ]);
    }

    public static function historial(Router $router)
    {
        session_start();
        isAuth();
        isProveedor();

        $alertas = [];
        $pedidos = [];
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $fecha = s($_POST['fecha']);
            $clienteNombre = s($_POST['cliente']);


            if (empty($fecha)) {
                Pedidos::setAlerta('error', 'La Fecha es Obligatoria');
            } else if (empty($clienteNombre)) {

                $pedidos = Pedidos::filtrarArray([
                    'usuarios_id' => $_SESSION['id'],
                    'fecha' => $fecha,
                ]);

                foreach ($pedidos as $pedido) {
                    $pedido->cliente = Clientes::find($pedido->clientes_id);
                }
            } else {

                $clientes = Clientes::filtrar('nombre', $clienteNombre);



                if (!$clientes) {
                    Pedidos::setAlerta('error', 'El cliente ingresado no está registrado');
                } else {


                    if (count($clientes) == 1) {
                        $pedidos = Pedidos::filtrarArray([
                            'usuarios_id' => $_SESSION['id'],
                            'clientes_id' => $clientes[0]->id,
                            'fecha' => $fecha,
                        ]);
                    } else {
                        foreach ($clientes as $cliente) {
                            $pedidos = Pedidos::filtrarArray([
                                'usuarios_id' => $_SESSION['id'],
                                'clientes_id' => $cliente->id,
                                'fecha' => $fecha,
                            ]);
                        }
                    }

                    foreach ($pedidos as $pedido) {
                        $pedido->cliente = Clientes::find($pedido->clientes_id);
                    }
                }
            }
        }



        $alertas = Pedidos::getAlertas();
        $router->render('proveedor/historial/index', [
            'titulo' => 'Historial Pedidos',
            'alertas' => $alertas,
            'pedidos' => $pedidos

        ]);
    }
}
