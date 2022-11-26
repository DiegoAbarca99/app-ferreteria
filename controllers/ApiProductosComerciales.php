<?php

namespace Controllers;

use MVC\Router;
use Model\CategoriaProducto;
use Model\Impuestos;
use Model\PorcentajeGanancias;
use Model\PreciosKilo;
use Model\PreciosProduccion;
use Model\ProductosComerciales;
use Model\TiposAceros;

class ApiProductosComerciales
{

    public static function crear(Router $router)
    {
        session_start();
        isAuth();
        isAdmin();

        $producto = new ProductosComerciales();
        $preciosProduccion = new PreciosProduccion();


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            isAuth();
            isAdmin();

            $producto->sincronizar($_POST);


            if ((isset($_POST['tiposaceros_id']) && empty($_POST['tiposaceros_id'])) || (isset($_POST['costo']) && empty($_POST['costo'])) || empty($_POST['categoriaProducto_id'] || empty($_POST['nombre']))) {

                echo  json_encode([]);
                exit;
            }


            $productoExistente = ProductosComerciales::where('nombre',$producto->nombre);

            if ($productoExistente) {
                echo  json_encode([
                    'tipo' => 'error',
                    'mensaje' => 'Ya existe un producto con ese nombre'
                ]);
            } else {

                //Se obtiene la categoria seleccionada
                $categoria = CategoriaProducto::find($producto->categoriaProducto_id);

                if (!$categoria) {
                    echo json_encode([]);
                    exit;
                }

                //Se obtiene tipo de acero seleccionado en caso de lo que lo haya sido
                if (!is_null($producto->tiposaceros_id)) {

                    $tipoAcero = TiposAceros::find($producto->tiposaceros_id);

                    if (!$tipoAcero) {
                        echo json_encode([]);
                        exit;
                    }
                }



                //Se obtiene valores que operan entre sí para obtener los precios de producción del producto
                $impuestos = Impuestos::find($categoria->impuestos_id);
                $porcentajeGanancias = PorcentajeGanancias::find($categoria->porcentajeGanancias_id);

                //Se convierten las ganancias como nominal
                $porcentajeGanancias->gananciapublico1 = obtenerNominal($porcentajeGanancias->gananciapublico1);
                $porcentajeGanancias->gananciaherrero2 = obtenerNominal($porcentajeGanancias->gananciaherrero2);
                $porcentajeGanancias->gananciaherrero3 = obtenerNominal($porcentajeGanancias->gananciaherrero3);
                $porcentajeGanancias->gananciaherrero4 = obtenerNominal($porcentajeGanancias->gananciaherrero4);
                $porcentajeGanancias->gananciamayoreo1 = obtenerNominal($porcentajeGanancias->gananciamayoreo1);
                $porcentajeGanancias->gananciamayoreo2 = obtenerNominal($porcentajeGanancias->gananciamayoreo2);

                //Se asgina el costo Base si está como NULL
                if (is_null($producto->costo)) {
                    $producto->costo = $tipoAcero->slp;
                }

                //Se calcula el costo neto
                $producto->costoneto = ($producto->costo + $impuestos->flete + $impuestos->descarga + $impuestos->seguro) * $impuestos->iva;

                //Se calculan los costros de Producción
                $preciosProduccion->publico1 = $producto->costoneto * $porcentajeGanancias->gananciapublico1;
                $preciosProduccion->herrero2 = $producto->costoneto * $porcentajeGanancias->gananciaherrero2;
                $preciosProduccion->herrero3 = $producto->costoneto * $porcentajeGanancias->gananciaherrero3;
                $preciosProduccion->herrero4 = $producto->costoneto * $porcentajeGanancias->gananciaherrero4;
                $preciosProduccion->mayoreo1 = $producto->costoneto * $porcentajeGanancias->gananciamayoreo1;
                $preciosProduccion->mayoreo2 = $producto->costoneto * $porcentajeGanancias->gananciamayoreo2;

                $resultado = $preciosProduccion->guardar();

                if ($resultado['id']) {
                    $producto->preciosProduccion_id = $resultado['id'];

                    $respuesta = $producto->guardar();
                    if ($respuesta) {
                        echo json_encode([
                            'tipo' => 'exito',
                            'mensaje' => 'Producto Creado Correctamente'
                        ]);
                    }
                }
            }
        }
    }


    public static function actualizar(Router $router)
    {
        session_start();
        isAuth();
        isAdmin();

        $preciosProduccion = new PreciosProduccion();


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            isAuth();
            isAdmin();


            $id = filter_var($_POST['id'], FILTER_VALIDATE_INT);
            $productoActual = ProductosComerciales::find($id);
            $nombreActual = $productoActual->nombre;


            if (!$productoActual) {
                echo json_encode([]);
                exit;
            }

            //Se corrobora si es pertinente eliminar un costo Base o un tipo de acero previo asociado en función de la actualización realizada

            $eliminarAcero = $_POST['eliminarAcero'] ?? false;
            $eliminarCosto = $_POST['eliminarCosto'] ?? false;

            if ($eliminarAcero) unset($_POST['eliminarAcero']);
            if ($eliminarCosto) unset($_POST['eliminarCosto']);

            $productoActual->sincronizar($_POST);


            if ($eliminarAcero) {
                $productoActual->tiposaceros_id = null;
            }

            if ($eliminarCosto) {

                $productoActual->costo = null;
            }




            if ((isset($_POST['tiposaceros_id']) && empty($_POST['tiposaceros_id'])) || (isset($_POST['costo']) && empty($_POST['costo'])) || empty($_POST['categoriaProducto_id'] || empty($_POST['nombre']))) {

                echo  json_encode([]);
                exit;
            }


            $productoExistente = ProductosComerciales::where('nombre', $productoActual->nombre);

            if ($productoExistente && $productoExistente->nombre != $nombreActual) {
                echo  json_encode([
                    'tipo' => 'error',
                    'mensaje' => 'Ya existe un producto con ese nombre'
                ]);
            } else {

                //Se obtiene la categoria seleccionada
                $categoria = CategoriaProducto::find($productoActual->categoriaProducto_id);

                if (!$categoria) {
                    echo json_encode([]);
                    exit;
                }

                //Se obtiene tipo de acero seleccionado en caso de lo que lo haya sido
                if (!is_null($productoActual->tiposaceros_id)) {
                    $tipoAcero = TiposAceros::find($productoActual->tiposaceros_id);

                    if (!$tipoAcero) {
                        echo json_encode([]);
                        exit;
                    }
                }




                //Se obtiene valores que operan entre sí para obtener los precios de producción del producto
                $impuestos = Impuestos::find($categoria->impuestos_id);
                $porcentajeGanancias = PorcentajeGanancias::find($categoria->porcentajeGanancias_id);

                //Se convierten las ganancias como nominal
                $porcentajeGanancias->gananciapublico1 = obtenerNominal($porcentajeGanancias->gananciapublico1);
                $porcentajeGanancias->gananciaherrero2 = obtenerNominal($porcentajeGanancias->gananciaherrero2);
                $porcentajeGanancias->gananciaherrero3 = obtenerNominal($porcentajeGanancias->gananciaherrero3);
                $porcentajeGanancias->gananciaherrero4 = obtenerNominal($porcentajeGanancias->gananciaherrero4);
                $porcentajeGanancias->gananciamayoreo1 = obtenerNominal($porcentajeGanancias->gananciamayoreo1);
                $porcentajeGanancias->gananciamayoreo2 = obtenerNominal($porcentajeGanancias->gananciamayoreo2);

                //Se asgina el costo Base si está como NULL

                if (is_null($productoActual->costo)) {
                    $productoActual->costo = $tipoAcero->slp;
                }

                //Se calcula el costo neto
                $productoActual->costoneto = ($productoActual->costo + $impuestos->flete + $impuestos->descarga + $impuestos->seguro) * $impuestos->iva;



                //Se obtienen lo costos de producción a actualizar
                $preciosProduccion = PreciosProduccion::find($productoActual->preciosProduccion_id);

                if (!$preciosProduccion) {
                    echo json_encode([]);
                    exit;
                }

                //Se calculan los nuevos costos de Producción
                $preciosProduccion->publico1 = $productoActual->costoneto * $porcentajeGanancias->gananciapublico1;
                $preciosProduccion->herrero2 = $productoActual->costoneto * $porcentajeGanancias->gananciaherrero2;
                $preciosProduccion->herrero3 = $productoActual->costoneto * $porcentajeGanancias->gananciaherrero3;
                $preciosProduccion->herrero4 = $productoActual->costoneto * $porcentajeGanancias->gananciaherrero4;
                $preciosProduccion->mayoreo1 = $productoActual->costoneto * $porcentajeGanancias->gananciamayoreo1;
                $preciosProduccion->mayoreo2 = $productoActual->costoneto * $porcentajeGanancias->gananciamayoreo2;

                $resultado = $preciosProduccion->guardar();

                if ($resultado) {


                    $respuesta = $productoActual->guardar();
                    if ($respuesta) {
                        echo json_encode([
                            'tipo' => 'exito',
                            'mensaje' => 'Producto Actualizado Correctamente'
                        ]);
                    }
                }
            }
        }
    }


    public static function eliminar(Router $router)
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            session_start();
            isAuth();
            isAdmin();

            $id = filter_var($_POST['id'], FILTER_VALIDATE_INT);

            $producto = ProductosComerciales::find($id);

            if (!$id || !$producto) {
                echo json_encode([]);
            }

            $resultado = $producto->eliminar();

            if ($resultado) {
                echo json_encode([
                    'tipo' => 'exito',
                    'mensaje' => 'El producto ha sido eliminado correctamente'
                ]);
            }
        }
    }

    public static function preciosKilosEliminar(Router $router)
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            session_start();
            isAuth();
            isAdmin();

            $id = filter_var($_POST['id'], FILTER_VALIDATE_INT);

            $producto = PreciosKilo::find($id);

            if (!$id || !$producto) {
                echo json_encode([]);
            }

            $resultado = $producto->eliminar();

            if ($resultado) {
                echo json_encode([
                    'tipo' => 'exito',
                    'mensaje' => 'El producto ha sido eliminado correctamente'
                ]);
            }
        }
    }
}
