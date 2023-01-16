<?php

namespace Controllers;

use Model\CategoriaProductosProveedores;
use Model\Municipios;
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
}
