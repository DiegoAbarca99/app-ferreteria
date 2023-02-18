<?php

namespace Controllers;

use Model\Usuario;
use MVC\Router;

//Controlador encargado del logeo de usuarios
class AuthController
{

    public static function login(Router $router)
    {

        $alertas = [];
        $usuario = new Usuario();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $_POST['usuario'] = trim(strtoupper($_POST['usuario']));
            $usuario = new Usuario($_POST);

            $alertas = $usuario->validarLogin();

            if (empty($alertas)) {
                //Se determina la existencia del usuario.
                $usuario = Usuario::where('usuario', $usuario->usuario);


                if (!$usuario) {
                    Usuario::setAlerta('error', 'No existe el usuario ingresado');
                } else {

                    if ($_POST['password'] === $usuario->password) {

                        //Se inicia sesión
                        session_start();
                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre;
                        $_SESSION['login'] = true;

                        //redireccionar
                        if ($usuario->status === '0') {
                            //Es administrador
                            $_SESSION['status'] = 0;
                            header('Location: /admin/index');
                        }

                        if ($usuario->status === '1') {
                            //Es proveedor
                            $_SESSION['status'] = 1;
                            header('Location: /proveedor/index');
                        }

                        if ($usuario->status === '2') {
                            //Es secretaria
                            $_SESSION['status'] = 2;
                            header('Location: /oficina/index');
                        }
                    } else {
                        Usuario::setAlerta('error', 'El password ingresado es incorrecto');
                    }
                }
            }
        }

        $alertas = Usuario::getAlertas();

        $router->render('auth/login', [
            'titulo' => 'Login',
            'alertas' => $alertas,
            'usuario' => $usuario
        ]);
    }


    public static function logout()
    {
        session_start();
        $_SESSION = [];
        header('Location:/');
    }
}
