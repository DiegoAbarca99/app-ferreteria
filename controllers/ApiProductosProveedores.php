<?php

namespace Controllers;

use Model\CategoriaProductosProveedores;
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
                echo json_encode([]);
                exit;
            }

            $categoria = new CategoriaProductosProveedores($_POST);
            $categoriaExistente = CategoriaProductosProveedores::where('nombre', $categoria->nombre);


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

    public static function eliminarCategoria()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            session_start();
            isAuth();
            isAdmin();

            $id = filter_var($_POST['id'], FILTER_VALIDATE_INT);

            if (!$id) {
                echo json_encode([]);
                exit;
            }

            $categoria = CategoriaProductosProveedores::find($id);

            if (!$categoria) {
                echo json_encode([]);
                exit;
            }


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
                echo json_encode([]);
                exit;
            }

            $producto = ProductosProveedores::find($id);

            if (!$producto) {
                echo json_encode([]);
                exit;
            }


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
                echo json_encode([]);
                exit;
            }

            $productoProveedor = ProductosProveedores::find($id);

            $pesos = Pesos::find($productoProveedor->pesos_id);
            $precios = PreciosProveedores::find($productoProveedor->preciosProveedores_id);



            if (!$pesos || !$precios) {
                echo json_encode([]);
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

            if(!$resultado){
                echo json_encode([]);
                exit;
            }



            $resultado = $pesos->guardar();


            if ($resultado) {
                echo json_encode([
                    'tipo' => 'exito',
                    'mensaje' => 'Se Ha Actualizado Correctamente el Registro'
                ]);
            }
        }
    }
}
