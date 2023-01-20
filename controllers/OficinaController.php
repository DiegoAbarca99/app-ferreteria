<?php

namespace Controllers;

use Model\OficinaPedido;
use Model\OficinaPedidoKilos;
use Model\PedidosKilo;
use Model\ProductosPedidos;
use MVC\Router;

class OficinaController
{
    public static function index(Router $router)
    {
        session_start();
        isAuth();
        isOficina();


        $router->render('oficina/index', [
            'titulo' => 'Gestionar Pedidos',
        ]);
    }

    public static function graficar(Router $router)
    {
        session_start();
        isAuth();
        isOficina();

        
        $router->render('oficina/grafico', [
            'titulo' => 'Estadísticas'
        ]);
    }
}
