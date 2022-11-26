<?php

namespace Controllers;

use Model\CategoriaAcero;
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

    public static function filtrar()
    {
        session_start();
        isAuth();
        isAdmin();

        $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
        $categoriaExistente = CategoriaProducto::find($id);

        if (!$id || !$categoriaExistente) {
            header('Location:/admin/index');
        }

        $categorias = CategoriaProducto::belongsTo('id', $id);

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

    public static function nombre(Router $router)
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            session_start();
            isAuth();
            isAdmin();

            if (empty($_POST)) {
                echo json_encode([]);
                exit;
            }

            $id = filter_var($_POST['id'], FILTER_VALIDATE_INT);

            if (!$id) {
                echo json_encode([]);
                exit;
            }

            $categoria = CategoriaProducto::find($id);

            if (!$categoria) {
                echo json_encode([]);
                exit;
            }

            $nombrePrevio = $categoria->nombre;

            $categoria->sincronizar($_POST);

            $categoriaExistente = CategoriaProducto::where('nombre', $categoria->nombre);

            if ($categoriaExistente && $nombrePrevio != $categoriaExistente->nombre) {
                echo json_encode([
                    'tipo' => 'error',
                    'mensaje' => 'Ya hay una categoria con ese nombre'
                ]);
                exit;
            }

            $resultado =  $categoria->guardar();


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

            $id = $_POST['id'];

            if (!filter_var($id, FILTER_VALIDATE_INT)) {
                echo json_encode([]);
            }

            $categoria = CategoriaProducto::find($id);
            $resultado = $categoria->eliminar();

            if ($resultado) {
                echo json_encode([
                    'tipo' => 'exito',
                    'mensaje' => 'Se Ha Eliminado Correctamente la Información'
                ]);
            }
        }
    }
}
