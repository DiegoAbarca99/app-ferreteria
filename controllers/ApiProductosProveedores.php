<?php

namespace Controllers;

use Model\CategoriaProductosProveedores;
use Model\Historico;
use Model\Pesos;
use Model\PreciosProduccion;
use Model\PreciosProveedores;
use Model\ProductosComerciales;
use Model\ProductosProveedores;

class ApiProductosProveedores
{

    public static function crearCategoria()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            session_start();
            isAuth();
            isAdmin();

            if (empty($_POST)) {
                echo json_encode([
                    'tipo' => 'error',
                    'mensaje' => 'Ha Ocurrido Un Error!'
                ]);
                exit;
            }

            $arrayFormateado = [];
            $arrayFormateado['nombre'] = trim(strtoupper($_POST['nombre']));

            $categoria = new CategoriaProductosProveedores($arrayFormateado);
            $categoriaExistente = CategoriaProductosProveedores::where('nombre', $categoria->nombre);


            if ($categoriaExistente) {
                echo json_encode(([
                    'tipo' => 'error',
                    'mensaje' => 'Ya Hay Una Categoria Con Ese Nombre'
                ]));
                exit;
            }

            $resultado = $categoria->guardar();

            if ($resultado) {
                echo json_encode([
                    'tipo' => 'exito',
                    'mensaje' => 'Se Ha Agregado Correctamente la Categoria'
                ]);
            }
        }
    }

    public static function eliminarCategoria()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            session_start();
            isAuth();
            isAdmin();

            $id = filter_var($_POST['id'], FILTER_VALIDATE_INT);

            if (!$id) {
                echo json_encode(([
                    'tipo' => 'error',
                    'mensaje' => 'Ha Ocurrido Un Error!'
                ]));
                exit;
            }

            $categoria = CategoriaProductosProveedores::find($id);
            $resultado = $categoria->eliminar();


            if ($resultado) {
                echo json_encode([
                    'tipo' => 'exito',
                    'mensaje' => 'Se Ha Eliminado Correctamente la Categoria'
                ]);
            }
        }
    }

    public static function eliminarProducto()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            session_start();
            isAuth();
            isAdmin();

            $id = filter_var($_POST['id'], FILTER_VALIDATE_INT);

            if (!$id) {
                echo json_encode([
                    'tipo' => 'error',
                    'mensaje' => 'Ha Ocurrido Un Error!'
                ]);
                exit;
            }

            $producto = ProductosProveedores::find($id);

            $pesos = Pesos::find($producto->pesos_id);
            $resultado = $pesos->eliminar();

            $precios = PreciosProveedores::find($producto->preciosProveedores_id);
            $resultado = $precios->eliminar();

            $resultado = $producto->eliminar();


            if ($resultado) {
                echo json_encode([
                    'tipo' => 'exito',
                    'mensaje' => 'Se Ha Eliminado Correctamente el Registro'
                ]);
            }
        }
    }


    public static function actualizarPeso()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            session_start();
            isAuth();
            isAdmin();

            $id = filter_var($_POST['id'], FILTER_VALIDATE_INT);

            if (!$id || empty($_POST)) {
                echo json_encode([
                    'tipo' => 'error',
                    'mensaje' => 'Ha Ocurrido Un Error!'
                ]);
                exit;
            }

            $productoProveedor = ProductosProveedores::find($id);

            $pesos = Pesos::find($productoProveedor->pesos_id);
            $precios = PreciosProveedores::find($productoProveedor->preciosProveedores_id);



            if (!$pesos || !$precios) {
                echo json_encode([
                    'tipo' => 'error',
                    'mensaje' => 'Ha Ocurrido Un Error!'
                ]);
                exit;
            }

            $pesos->pesoAntiguo = $pesos->pesoNuevo;
            $pesos->pesoNuevo = $_POST['peso'];
            $pesos->pesoPromedio = ($pesos->pesoAntiguo + $pesos->pesoNuevo) / 2;


            //Llenado de la tabla de preciosProveedores 

            $productoProduccion = ProductosComerciales::find($productoProveedor->productosComerciales_id);
            $preciosProduccion = PreciosProduccion::find($productoProduccion->preciosProduccion_id);


            $precios->publico1 = ceil($pesos->pesoPromedio * $preciosProduccion->publico1);
            $precios->herrero2 = ceil($pesos->pesoPromedio * $preciosProduccion->herrero2);
            $precios->herrero3 = ceil($pesos->pesoPromedio * $preciosProduccion->herrero3);
            $precios->herrero4 = ceil($pesos->pesoPromedio * $preciosProduccion->herrero4);
            $precios->mayoreo1 = ceil($pesos->pesoPromedio * $preciosProduccion->mayoreo1);
            $precios->mayoreo2 = ceil($pesos->pesoPromedio * $preciosProduccion->mayoreo2);


            $resultado = $precios->guardar();

            if (!$resultado) {
                echo json_encode([
                    'tipo' => 'error',
                    'mensaje' => 'Ha Ocurrido Un Error!'
                ]);
                exit;
            }


            $resultado = $pesos->guardar();


            if ($resultado) {


                // Historial cambio del valor de los pesos
                $arg = [
                    'usuarios_id' => $_SESSION['id'],
                    'entidadModificada' => $productoProveedor->nombre,
                    'valorAnterior' => $pesos->pesoAntiguo,
                    'valorNuevo' => $pesos->pesoNuevo,
                    'accion' => 'Se modificó el peso del producto'
                ];

                $historico = new Historico($arg);
                $historico->guardar();



                echo json_encode([
                    'tipo' => 'exito',
                    'mensaje' => 'Se Ha Actualizado Correctamente el Registro'
                ]);
            }
        }
    }
}
