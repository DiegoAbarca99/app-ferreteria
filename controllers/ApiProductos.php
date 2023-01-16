<?php

namespace Controllers;

use Model\CategoriaProductosProveedores;
use Model\PreciosKilo;
use Model\PreciosProduccion;
use Model\PreciosProveedores;
use Model\ProductosComerciales;
use Model\ProductosProveedores;
use MVC\Router;

class ApiProductos
{
    public static function index(Router $router)
    {
        session_start();
        isAuth();
        isProveedor();

        $id = filter_Var($_GET['id'], FILTER_VALIDATE_INT);

        if (!$id) {

            $productos = ProductosProveedores::all();
        } else {
            $categoria = CategoriaProductosProveedores::find($id);
            if ($categoria) {

                $productos = ProductosProveedores::belongsTo('categoriaProductosProveedores_id', $id);
            }
        }


        foreach ($productos as $producto) {
            $producto->precio = PreciosProveedores::find($producto->preciosProveedores_id);
            $producto->categoria = CategoriaProductosProveedores::find($producto->categoriaProductosProveedores_id);
        }

        echo json_encode($productos);
    }

    public static function kilos(Router $router)
    {
        session_start();
        isAuth();
        isProveedor();


        $productos = PreciosKilo::all();



        foreach ($productos as $producto) {
            $producto->productoProduccion = ProductosComerciales::find($producto->productosComerciales_id);
        }

        foreach ($productos as $producto) {
            $producto->precio = PreciosProduccion::find($producto->productoProduccion->preciosProduccion_id);
        }


        echo json_encode($productos);
    }
}
