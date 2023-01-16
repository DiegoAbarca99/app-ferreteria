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
                echo json_encode([]);
                exit;
            }

            $municipio = Municipios::find($id);
            if (!$municipio) {
                echo json_encode([]);
            }

            $resultado = $municipio->eliminar();

            if ($resultado) {
                echo json_encode([
                    'tipo' => 'exito',
                    'mensaje' => 'Municipio Eliminado Correctamente'
                ]);
            } else {
                echo json_encode([]);
            }
        }
    }
}
