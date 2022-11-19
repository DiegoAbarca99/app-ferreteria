<?php

namespace Controllers;

use Model\CategoriaProducto;
use Model\Impuestos;
use Model\PorcentajeGanancias;
use MVC\Router;

class ApiCategoriasProducto
{
    public static function index(Router $router)
    {
        session_start();
        isAuth();
        isAdmin();


        $categorias = CategoriaProducto::all();


        foreach ($categorias as $categoria) {
            $categoria->impuestos = Impuestos::where('id', $categoria->impuestos_id);
            $categoria->ganancias = PorcentajeGanancias::where('id', $categoria->porcentajeGanancias_id);
        }

        echo json_encode($categorias);
    }

    public static function ganancias(Router $router)
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            session_start();
            isAuth();
            isAdmin();

            if (empty($_POST)) {
                echo json_encode([]);
            }

            $ganancias = new PorcentajeGanancias();
            $ganancias->sincronizar($_POST);
            $resultado = $ganancias->guardar();

            if ($resultado) {
                echo json_encode([
                    'tipo' => 'exito',
                    'mensaje' => 'Se Ha Actualizado Correctamente la Información'
                ]);
            }
        }
    }

    public static function impuestos(Router $router)
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            session_start();
            isAuth();
            isAdmin();

            if (empty($_POST)) {
                echo json_encode([]);
            }

            $impuestos = new Impuestos();
            $impuestos->sincronizar($_POST);
            $resultado = $impuestos->guardar();

            if ($resultado) {
                echo json_encode([
                    'tipo' => 'exito',
                    'mensaje' => 'Se Ha Actualizado Correctamente la Información'
                ]);
            }
        }
    }

    public static function eliminar(Router $router)
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            session_start();
            isAuth();
            isAdmin();

            if (empty($_POST)) {
                echo json_encode([]);
            }

            $categorias = new CategoriaProducto();
            $categorias->sincronizar($_POST);
            $resultado = $categorias->eliminar();

            if ($resultado) {
                echo json_encode([
                    'tipo' => 'exito',
                    'mensaje' => 'Se Ha Eliminado Correctamente la Información'
                ]);
            }
        }
    }
}
