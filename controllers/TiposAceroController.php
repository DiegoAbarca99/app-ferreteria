<?php

namespace Controllers;

use Model\CategoriaAcero;
use Model\DescripcionAcero;
use Model\TiposAceros;
use MVC\Router;

class TiposAceroController
{
    public static function index(Router $router)
    {
        session_start();
        isAuth();
        isAdmin();


        $categoriaFiltrada = $_GET['categoria'] ?? '';

        if ($categoriaFiltrada) {
            $respuesta = CategoriaAcero::find($categoriaFiltrada);
            if (!$respuesta || !filter_var($categoriaFiltrada, FILTER_VALIDATE_INT)) {
                header('Location:/admin/index');
            }
        }



        $aceros = TiposAceros::belongsToAndOrden('categoriaacero_id', $categoriaFiltrada, 'ASC');
        $categorias = CategoriaAcero::ordenar('id', 'ASC');

        $acerosFormateados = [];
        foreach ($aceros as $acero) {
            $acero->categoria = CategoriaAcero::find($acero->categoriaacero_id);
            $acero->descripcion = DescripcionAcero::find($acero->descripcionacero_id);

            $acerosFormateados[$acero->categoriaacero_id][] = $acero;
        }





        $router->render('admin/aceros/index', [
            'titulo' => 'Tipos de Acero',
            'aceros' => $acerosFormateados,
            'categorias' => $categorias
        ]);
    }

    public static function crear(Router $router)
    {
        session_start();
        isAuth();
        isAdmin();

        $alertas = [];
        $acero = new TiposAceros();
        $categorias = CategoriaAcero::all();
        $descripciones = DescripcionAcero::all();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $acero->sincronizar($_POST);
            $alertas = $acero->validar();



            if (empty($alertas)) {
                $aceroBase = TiposAceros::find('1');

                if ($acero->prolamsa >= $acero->arcoMetal) {
                    $acero->slp = $aceroBase->slp + $acero->prolamsa;
                } else if ($acero->prolamsa < $acero->arcoMetal) {
                    $acero->slp = $aceroBase->slp + $acero->arcoMetal;
                }

                $acero->guardar();
                header('Location:/admin/acero');
            }
        }


        $router->render('admin/aceros/crear', [
            'titulo' => 'Tipos de Acero',
            'alertas' => $alertas,
            'acero' => $acero,
            'categorias' => $categorias,
            'descripciones' => $descripciones
        ]);
    }

    public static function eliminar(Router $router)
    {
        session_start();
        isAuth();
        isAdmin();


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {


            $id = filter_var($_POST['id'], FILTER_VALIDATE_INT);
            if (empty($id)) {
                echo json_encode([]);
            }

            $acero = TiposAceros::find($id);
            $resultado = $acero->eliminar();

            if ($resultado) {
                echo json_encode([
                    'resultado' => true,
                    'mensaje' => 'Registro Eliminado Correctamente'

                ]);
            } else {
                echo json_encode([]);
            }
        }
    }
}
