<?php

namespace Controllers;

use Model\CategoriaProducto;
use Model\Impuestos;
use Model\PorcentajeGanancias;
use MVC\Router;

class CategoriasProductoController
{
    public static function index(Router $router)
    {
        session_start();
        isAuth();
        isAdmin();

        $categoriasProducto=CategoriaProducto::all();


        $router->render('admin/categorias/index', [
            'titulo' => 'Categorias Productos',
            'categorias'=>$categoriasProducto
        ]);
    }

    public static function crear(Router $router)
    {
        session_start();
        isAuth();
        isAdmin();

        $alertas = [];
        $categoria = new CategoriaProducto();
        $impuestos = new Impuestos();
        $ganancias = new PorcentajeGanancias();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {


            $categoria->sincronizar($_POST);
            $impuestos->sincronizar($_POST);
            $ganancias->sincronizar($_POST);



            $alertas = $categoria->validar();
            $alertas = $impuestos->validar();
            $alertas = $ganancias->validar();

            if (empty($alertas)) {

                $resultado = $ganancias->guardar();
                $porcentajeganancias_id = $resultado['id'];

                $resultado = $impuestos->guardar();
                $impuestos_id = $resultado['id'];

                $datos = [
                    'porcentajeGanancias_id' => $porcentajeganancias_id,
                    'impuestos_id' => $impuestos_id,
                    'nombre' => $_POST['nombre']
                ];

                $categoria->sincronizar($datos);
                $resultado = $categoria->guardar();

                if ($resultado) {
                    header('Location:/admin/categoria');
                } else {
                    CategoriaProducto::setAlerta('error', 'Ocurrió un error con la Base de Datos, favor de intentarlo más tarde');
                }
            }
        }




        $alertas=CategoriaProducto::getAlertas();
        $router->render('admin/categorias/crear', [
            'titulo' => 'Crear Categoría',
            'alertas' => $alertas,
            'categoria' => $categoria,
            'impuestos' => $impuestos,
            'ganancias' => $ganancias
        ]);
    }
}
