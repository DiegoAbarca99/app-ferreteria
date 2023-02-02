<?php

namespace Controllers;

use Model\Sucursales;
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

        //Sanitizar usuario
        $nombreUsuarioFiltrado = $_GET['nombre'] ?? '';
        $nombreUsuarioSanitizado = s($nombreUsuarioFiltrado);
        $usuarios = [];

        //Filtrar por nombre de usuario
        if (!empty($nombreUsuarioSanitizado)) {
            //Status de Oficina
            if ($_SESSION['status'] === 2) {
                $usuarios = Usuario::filtrarArrayNot([
                    'usuario' => $nombreUsuarioSanitizado,
                    'status' => 0
                ]);
            } else {
                $usuarios = Usuario::filtrar('usuario', $nombreUsuarioSanitizado);
            }
        } else {

            $idSucursalFiltrada = $_GET['categoria'] ?? '';
            $idSucursalSanitizada = filter_var($idSucursalFiltrada, FILTER_VALIDATE_INT) ?? '';

            //Filtrar por sucursal_id
            if (!empty($idSucursalSanitizada)) {
                //Status de Oficina
                if ($_SESSION['status'] === 2) {
                    $usuarios = Usuario::whereArrayNot([
                        'sucursal_id' => $idSucursalSanitizada,
                        'status' => 0
                    ]);
                } else {
                    $usuarios = Usuario::filtrar('sucursal_id', $idSucursalSanitizada);
                }
                //Sin Filtrar
            } else {
                //Status de Oficina
                if ($_SESSION['status'] === 2) {
                    $usuarios = Usuario::Notall('status', 0);
                } else {
                    $usuarios = Usuario::all();
                }
            }
        }

        $categorias = Sucursales::all();

        if (!empty($usuarios))
            foreach ($usuarios as $usuario) $usuario->sucursal = Sucursales::find($usuario->sucursal_id);


        $router->render('perfiles/index', [
            'titulo' => 'Perfiles',
            'usuarios' => $usuarios,
            'categorias' => $categorias,
            'href' => '/perfiles/crear',
            'mensaje_boton' => ' Crear Perfil',
            'mensaje_select' => 'Seleccione una Sucursal'
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

            $arregloNormalizado = [];
            foreach ($_POST as $key => $value) {

                if ($key === 'email') $arregloNormalizado[$key] = trim(strtolower($value));

                else if ($key === 'usuario' || $key === 'nombre') $arregloNormalizado[$key] = trim(strtoupper($value));

                else $arregloNormalizado[$key] = $value;
            }


            $usuario = new Usuario($arregloNormalizado);


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
        $sucursales = Sucursales::all();
        $router->render('perfiles/crear-perfil', [
            'titulo' => 'Crear-Perfil',
            'usuario' => $usuario,
            'alertas' => $alertas,
            'sucursales' => $sucursales
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


        $sucursal = Sucursales::where('id', $usuario->sucursal_id);
        $router->render('perfiles/perfil', [
            'titulo' => 'Perfil',
            'usuario' => $usuario,
            'sucursal' => $sucursal
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



            $arregloNormalizado = [];
            foreach ($_POST as $key => $value) {
                if ($key === 'email') $arregloNormalizado[$key] = trim(strtolower($value));
                else if ($key === 'usuario' || $key === 'nombre') $arregloNormalizado[$key] = trim(strtoupper($value));
                else $arregloNormalizado[$key] = $value;
            }


            $usuario->sincronizar($arregloNormalizado);
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

        $sucursales = Sucursales::all();
        $alertas = Usuario::getAlertas();
        $router->render('perfiles/editar-perfil', [
            'titulo' => 'Editar-Perfil',
            'usuario' => $usuario,
            'alertas' => $alertas,
            'sucursales' => $sucursales
        ]);
    }

    public static function eliminar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $id = filter_var($_POST['id'], FILTER_VALIDATE_INT);

            if (!$id) {
                echo json_encode([
                    'tipo' => 'error',
                    'mensaje' => 'Ha Ocurrido Un Error!'
                ]);
                exit;
            }

            $usuario = Usuario::find($id);            
            $resultado = $usuario->eliminar();

            if ($resultado) {
                echo json_encode([
                    'tipo' => 'exito',
                    'mensaje' => 'Usuario Eliminado Correctamente'
                ]);
            }
        }
    }
}
