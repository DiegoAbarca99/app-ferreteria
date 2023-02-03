<?php

namespace Controllers;

use Model\CategoriaAcero;
use Model\DescripcionAcero;
use Model\TiposAceros;
use MVC\Router;

class ApiTiposAcero
{
    public static function index(Router $router)
    {
        session_start();
        isAuth();
        isAdmin();

        $aceros = TiposAceros::all();
        echo json_encode($aceros);
    }

    public static function crearCategoria(Router $router)
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            session_start();
            isAuth();
            isAdmin();

            if (empty($_POST)) {
                echo json_encode([
                    'tipo' => 'error',
                    'mensaje' => 'Ha Ocurrido un Error!'
                ]);
                exit;
            }

            $arrayFormateado = [];
            $arrayFormateado['categoria'] = trim(strtoupper($_POST['categoria']));

            $categoria = new CategoriaAcero($arrayFormateado);
            $categoriaExistente = CategoriaAcero::where('categoria', $categoria->categoria);


            if ($categoriaExistente) {
                echo json_encode(([
                    'tipo' => 'error',
                    'mensaje' => 'Ya Hay Una Categoria Con Ese Nombre'
                ]));
            } else {

                $resultado = $categoria->guardar();


                if ($resultado) {
                    echo json_encode([
                        'tipo' => 'exito',
                        'mensaje' => 'Se Ha Agregado Correctamente la Categoria'
                    ]);
                }
            }
        }
    }

    public static function crearDescripcion(Router $router)
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            session_start();
            isAuth();
            isAdmin();

            if (empty($_POST)) {
                echo json_encode([
                    'tipo' => 'error',
                    'mensaje' => 'Ha Ocurrido Un Error'
                ]);
                exit;
            }

            $arrayFormateado = [];
            $arrayFormateado['descripcion'] = trim(strtoupper($_POST['descripcion']));

            $descripcion = new DescripcionAcero($arrayFormateado);
            $descripcionExistente = DescripcionAcero::where('descripcion', $descripcion->descripcion);

            if ($descripcionExistente) {
                echo json_encode([
                    'tipo' => 'error',
                    'mensaje' => 'Ya Hay Una Descripción Con Ese Nombre'
                ]);
            } else {

                $resultado = $descripcion->guardar();

                if ($resultado) {
                    echo json_encode([
                        'tipo' => 'exito',
                        'mensaje' => 'Se Ha Agregado Correctamente la Descripción'
                    ]);
                }
            }
        }
    }

    public static function eliminarCategoria(Router $router)
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            session_start();
            isAuth();
            isAdmin();

            $id = filter_var($_POST['id'], FILTER_VALIDATE_INT);

            if (empty($_POST) || !$id) {
                echo json_encode([
                    'tipo' => 'error',
                    'mensaje' => 'Ha Ocurrido Un Error'
                ]);
                exit;
            }

            $categoria = CategoriaAcero::find($id);
            $resultado = $categoria->eliminar();


            if ($resultado) {
                echo json_encode([
                    'tipo' => 'exito',
                    'mensaje' => 'Se Ha Eliminado Correctamente la Categoria'
                ]);
            }
        }
    }

    public static function eliminarDescripcion(Router $router)
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            session_start();
            isAuth();
            isAdmin();

            $id = filter_var($_POST['id'], FILTER_VALIDATE_INT);


            if (empty($_POST) || !$id) {
                echo json_encode([
                    'tipo' => 'error',
                    'mensaje' => 'Ha Ocurrido Un Error'
                ]);
                exit;
            }


            $descripcion = DescripcionAcero::find($id);
            $resultado = $descripcion->eliminar();


            if ($resultado) {
                echo json_encode([
                    'tipo' => 'exito',
                    'mensaje' => 'Se Ha Eliminado Correctamente la Descripción'
                ]);
            }
        }
    }

    public static function editarPrecios(Router $router)
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            session_start();
            isAuth();
            isAdmin();

            $id = filter_var($_POST['id'], FILTER_VALIDATE_INT);

            if (empty($_POST) || !$id) {
                echo json_encode([
                    'tipo' => 'error',
                    'mensaje' => 'Ha Ocurrido Un Error!'
                ]);
                exit;
            }



            $acero = TiposAceros::find($id);
            $acero->sincronizar($_POST);
            $resultado = $acero->guardar();


            if ($resultado) {

                if (isset($_POST['slp'])) {


                    $aceros = TiposAceros::Notall('id', '1');

                    foreach ($aceros as $acero) {

                        if ($acero->prolamsa >= $acero->arcoMetal) {
                            $acero->slp = $_POST['slp'] + $acero->prolamsa;
                        } else if ($acero->prolamsa < $acero->arcoMetal) {
                            $acero->slp = $_POST['slp'] + $acero->arcoMetal;
                        }

                        $acero->guardar();
                    }

                    echo json_encode([
                        'tipo' => 'exito',
                        'mensaje' => 'Se Ha Actualizado Correctamente el Registro'
                    ]);
                } else if (isset($_POST['prolamsa']) || isset($_POST['arcoMetal'])) {


                    $aceroBase = TiposAceros::find('1');


                    if ($acero->prolamsa >= $acero->arcoMetal) {
                        $acero->slp = $aceroBase->slp + $acero->prolamsa;
                    } else if ($acero->prolamsa < $acero->arcoMetal) {
                        $acero->slp = $aceroBase->slp + $acero->arcoMetal;
                    }

                    $resultado = $acero->guardar();

                    if ($resultado) {
                        echo json_encode([
                            'tipo' => 'exito',
                            'mensaje' => 'Se Ha Actualizado Correctamente el Registro'
                        ]);
                    }
                } else {

                    echo json_encode([
                        'tipo' => 'error',
                        'error' => 'Ha Ocurrido Un Error!'
                    ]);
                }
            }
        }
    }
}
