<?php

namespace Controllers;

use Model\Municipios;

class ApiMunicipios
{
    public static function eliminar()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            session_start();
            isAuth();
            isProveedor();

            $id = filter_Var($_POST['id'], FILTER_VALIDATE_INT);

            if (!$id) {
                echo json_encode([
                    'tipo' => 'error',
                    'mensaje' => 'Ha Ocurrido Un Error!'
                ]);
                exit;
            }

            $municipio = Municipios::find($id);
            $resultado = $municipio->eliminar();

            if ($resultado) {
                echo json_encode([
                    'tipo' => 'exito',
                    'mensaje' => 'Municipio Eliminado Correctamente'
                ]);
            }
        }
    }
}
