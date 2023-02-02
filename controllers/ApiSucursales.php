<?php

namespace Controllers;

use Model\Sucursales;


class ApiSucursales
{

    public static function crearSucursal()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            session_start();
            isAuth();
            isAllowed();

            if (empty($_POST)) {
                echo json_encode([
                    'tipo' => 'error',
                    'mensaje' => 'Ha Ocurrido Un Error'
                ]);
                exit;
            }

            $arregloNormalizado['nombre'] = trim(strtoupper($_POST['nombre']));

            $sucursal = new Sucursales($arregloNormalizado);


            $sucursalExistente = Sucursales::where('nombre', $sucursal->nombre);


            if ($sucursalExistente) {
                echo json_encode(([
                    'tipo' => 'error',
                    'mensaje' => 'Ya Hay Una Sucursal Con Ese Nombre'
                ]));
                exit;
            } else {

                $resultado = $sucursal->guardar();


                if ($resultado) {
                    echo json_encode([
                        'tipo' => 'exito',
                        'mensaje' => 'Se Ha Agregado Correctamente la Sucursal'
                    ]);
                }
            }
        }
    }



    public static function eliminarSucursal()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            session_start();
            isAuth();
            isAdmin();

            $id = filter_var($_POST['id'], FILTER_VALIDATE_INT);

            if (!$id) {
                echo json_encode([
                    'tipo' => 'error',
                    'mensaje' => 'Ha Ocurrido Un Error'
                ]);
                exit;
            }

            $sucursal = Sucursales::find($id);
            $resultado = $sucursal->eliminar();


            if ($resultado) {
                echo json_encode([
                    'tipo' => 'exito',
                    'mensaje' => 'Se Ha Eliminado Correctamente la Sucursal'
                ]);
            }
        }
    }
}
