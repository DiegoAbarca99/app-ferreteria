<?php

namespace Controllers;

use MVC\Router;
use Model\Usuario;
use Classes\Paginacion;

class PerfilesController
{

    //Muestra pantalla inicial con el listado de perfiles existentes
    public static function index(Router $router)
    {
        session_start();
        isAuth();
        isAllowed(); //Corrobora que el usuario sea admin o tenga status de oficina




        $pagina_actual = $_GET['page'];
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);

        if (!$pagina_actual || $pagina_actual < 1) {
            header('Location:/perfiles/index?page=1');
        }

        $total_registros = 0;
        if ($_SESSION['status'] === 2) {
            $total_registros = Usuario::total('status', 1);
        } else {
            $total_registros = Usuario::totalAndNot('status', 0);
        }

        $registro_por_pagina = 5;

        $paginacion = new Paginacion($pagina_actual, $registro_por_pagina, $total_registros);

        if ($paginacion->total_paginas() < $pagina_actual) {
            header('Location:/perfiles/index?page=1');
        }



        if ($_SESSION['status'] === 2) {
            $usuario = $_GET['nombre'] ?? '';
            if ($usuario) {
                $usuarios = Usuario::whereArray(['status' => 1, 'usuario' => $usuario]);
            } else {
                $usuarios = Usuario::belongsToAndPag('status', 1, $registro_por_pagina, $paginacion->offset());
            }
        } else {
            $usuario = $_GET['nombre'] ?? '';
            if ($usuario) {

                $usuarios = Usuario::whereArray(['status' => 1, 'status' => 2, 'usuario' => $usuario]);
            } else {
                $usuarios = Usuario::whereNotAndPag($paginacion->offset(), $registro_por_pagina, 'status', 0);
            }
        }



        $router->render('perfiles/index', [
            'titulo' => 'Perfiles',
            'usuarios' => $usuarios,
            'paginacion' => $paginacion->paginacion()
        ]);
    }

    //Muestra formulario y envia petición POST para guardar un usuario 
    public static function crear(Router $router)
    {
        session_start();
        isAuth();
        isAllowed(); //Corrobora que el usuario sea admin o tenga status de oficina

        $usuario = new Usuario();
        $alertas = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $usuario = new Usuario($_POST);


            $alertas = $usuario->validarCuenta();

            if (empty($alertas)) {
                //Validar que no exista

                $usuarioPrevio = Usuario::where('usuario', $usuario->usuario);
                if ($usuarioPrevio) {
                    Usuario::setAlerta('error', 'Ya existe un usuario con ese nombre de usuario');
                } else {
                    //Crear nuevo Usuario
                    $usuario->hashearPassword();
                    $usuario->guardar();
                    header('Location: /perfiles/index');
                }
            }
        }

        $alertas = Usuario::getAlertas();
        $router->render('perfiles/crear-perfil', [
            'titulo' => 'Crear-Perfil',
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }

    //Muestra el contenido del perfil seleccionado
    public static function perfil(Router $router)
    {
        session_start();
        isAuth();
        isAllowed(); //Corrobora que el usuario sea admin o tenga status de oficina

        //Obtiene y valida Id pasado en la URL 
        $id = filter_Var($_GET['id'], FILTER_VALIDATE_INT);



        if (!$id) {
            header('Location:/');
        }



        $usuario = Usuario::find($id);


        if (!$usuario) {
            header('Location:/');
        }


        $router->render('perfiles/perfil', [
            'titulo' => 'Perfil',
            'usuario' => $usuario
        ]);
    }

    //Muestra formulario y envia petición POST para guardar un usuario 
    public static function editar(Router $router)
    {
        session_start();
        isAuth();
        isAllowed(); //Corrobora que el usuario sea admin o tenga status de oficina

        //Obtiene y valida Id pasado en la URL 
        $id = filter_Var($_GET['id'], FILTER_VALIDATE_INT);


        if (!$id) {
            header('Location:/');
        }



        $usuario = Usuario::find($id);


        if (!$usuario) {
            header('Location:/');
        }


        $alertas = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $usuario->sincronizar($_POST);


            $alertas = $usuario->validarCuenta();

            if (empty($alertas)) {

                //Crear nuevo Usuario
                $usuario->hashearPassword();
                $usuario->guardar();
                header('Location: /perfiles/index');
            }
        }

        $alertas = Usuario::getAlertas();
        $router->render('perfiles/editar-perfil', [
            'titulo' => 'Editar-Perfil',
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }

    public static function eliminar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $id = filter_var($_POST['id'], FILTER_VALIDATE_INT);

            if (!$id) {
                echo json_encode([]);
            }

            $usuario = Usuario::find($id);
            $resultado = $usuario->eliminar();

            echo json_encode([
                'resultado' => $resultado,
                'mensaje' => 'Usuario eliminado correctamente'
            ]);
        }
    }
}
