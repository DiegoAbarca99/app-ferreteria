<?php

namespace Controllers;

use MVC\Router;
use Model\Usuario;

//Controlador destinado al CRUD de los perfiles de usuarios.
class PerfilesController
{

    //Muestra pantalla inicial con el listado de perfiles existentes
    public static function index(Router $router)
    {
        session_start();
        isAuth();
        isAllowed(); //Corrobora que el usuario sea admin o tenga status de oficina

        //TODO: Filtrar usuario por Nombre
        //Sanitizar usuario
        $usuario = $_GET['nombre'] ?? '';
        $usuarioSanitizado = s($usuario);

        //Status de Oficina
        if ($_SESSION['status'] === 2) {

            $usuarios = Usuario::Notall('status', 0);
            //TODO: Filtrar usuarios por surcusal y nombre
        } else {
            $usuarios = Usuario::Notall('status', 0);
        }



        $router->render('perfiles/index', [
            'titulo' => 'Perfiles',
            'usuarios' => $usuarios,
        ]);
    }

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

        if (!$id)  header('Location:/');

        if ($_SESSION['status'] === 0) $usuario = Usuario::find($id); //Administrador

        if ($_SESSION['status'] === 2) $usuario = Usuario::whereNotArray(['status' => 0, 'id' => $id,]); //Oficina

        if (!$usuario)  header('Location:/');



        $router->render('perfiles/perfil', [
            'titulo' => 'Perfil',
            'usuario' => $usuario
        ]);
    }


    public static function editar(Router $router)
    {
        session_start();
        isAuth();
        isAllowed(); //Corrobora que el usuario sea admin o tenga status de oficina

        //Obtiene y valida Id pasado en la URL 
        $id = filter_Var($_GET['id'], FILTER_VALIDATE_INT);

        if (!$id)  header('Location:/');

        if ($_SESSION['status'] === 0) $usuario = Usuario::find($id); //Administrador

        if ($_SESSION['status'] === 2) $usuario = Usuario::whereNotArray(['status' => 0, 'id' => $id,]); //Oficina

        if (!$usuario)  header('Location:/');

        $nombreUsuarioPrevio = $usuario->usuario;

        $alertas = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {


            $usuario->sincronizar($_POST);    
            $alertas = $usuario->validarCuenta();

            if (empty($alertas)) {

                $usuarioExistente = Usuario::where('usuario', $usuario->usuario);


                if (!is_null($usuarioExistente) && ($usuarioExistente->usuario !== $nombreUsuarioPrevio)) {
                    Usuario::setAlerta('error', 'Ya existe un perfil con ese nombre de usuario');
                } else {
                    $usuario->hashearPassword();
                    $usuario->guardar();
                    header('Location: /perfiles/index');
                }
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
                exit;
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
