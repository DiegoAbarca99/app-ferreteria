<?php

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class ApiCorreos
{
    public static function enviarCorreos()
    {


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            session_start();
            isAuth();
            isProveedor();

            $proveedor = Usuario::find($_SESSION['id']);
            $proveedor->token = uniqid();

            $resultado = $proveedor->guardar();

            if (!$resultado) {
                echo json_encode([
                    'tipo' => 'error',
                    'mensaje' => 'Ha ocurrido un error'
                ]);
                exit;
            }

            $usuariosOficina = Usuario::belongsTo('status', 3);
            $emails = [];
            $nombres = [];
            foreach ($usuariosOficina as $usuario) {
                $emails[] = $usuario->email;
                $nombres[] = $usuario->nombre;
            }




            $email = new Email($emails, $nombres, $proveedor);
            $resultado =   $email->enviarConfirmacion();



            echo json_encode([
                'tipo' => 'exito',
                'mensaje' => 'Email enviado a oficina!'
            ]);
        }
    }

    public static function subirNivel(Router $router)
    {
        session_start();
        isAuth();
        isOficina();

        $tokenInvalido = false;

        $token = $_GET['token'];

        if (!$token) $tokenInvalido = true;
        else {
            $usuario = Usuario::where('token', $token);
            if (!$usuario) $tokenInvalido = true;
            else {
                $usuario->token = '';
                $usuario->nivel = '1';

                $resultado = $usuario->guardar();

                if (!$resultado) $tokenInvalido = true;
            }
        }

        $router->render('proveedor/correos/subir-nivel', [
            'titulo' => 'Mensaje de Confimación',
            'tokenInvalido' => $tokenInvalido
        ]);
    }
}
