<?php

namespace Controllers;

use Model\CategoriaAcero;
use Model\CategoriaProducto;
use Model\DescripcionAcero;
use Model\Impuestos;
use Model\Pesos;
use Model\PorcentajeGanancias;
use Model\PreciosProduccion;
use Model\PreciosProveedores;
use Model\ProductosComerciales;
use Model\ProductosProveedores;
use Model\TiposAceros;
use MVC\Router;

class ApiTiposAcero
{
    public static function index(Router $router)
    {
        session_start();
        isAuth();
        isAdmin();

        $aceros = TiposAceros::all();
        echo json_encode($aceros);
    }

    public static function crearCategoria(Router $router)
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            session_start();
            isAuth();
            isAdmin();

            if (empty($_POST)) {
                echo json_encode([
                    'tipo' => 'error',
                    'mensaje' => 'Ha Ocurrido un Error!'
                ]);
                exit;
            }

            $arrayFormateado = [];
            $arrayFormateado['categoria'] = trim(strtoupper($_POST['categoria']));

            $categoria = new CategoriaAcero($arrayFormateado);
            $categoriaExistente = CategoriaAcero::where('categoria', $categoria->categoria);


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

    public static function crearDescripcion(Router $router)
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            session_start();
            isAuth();
            isAdmin();

            if (empty($_POST)) {
                echo json_encode([
                    'tipo' => 'error',
                    'mensaje' => 'Ha Ocurrido Un Error'
                ]);
                exit;
            }

            $arrayFormateado = [];
            $arrayFormateado['descripcion'] = trim(strtoupper($_POST['descripcion']));

            $descripcion = new DescripcionAcero($arrayFormateado);
            $descripcionExistente = DescripcionAcero::where('descripcion', $descripcion->descripcion);

            if ($descripcionExistente) {
                echo json_encode([
                    'tipo' => 'error',
                    'mensaje' => 'Ya Hay Una Descripción Con Ese Nombre'
                ]);
            } else {

                $resultado = $descripcion->guardar();

                if ($resultado) {
                    echo json_encode([
                        'tipo' => 'exito',
                        'mensaje' => 'Se Ha Agregado Correctamente la Descripción'
                    ]);
                }
            }
        }
    }

    public static function eliminarCategoria(Router $router)
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            session_start();
            isAuth();
            isAdmin();

            $id = filter_var($_POST['id'], FILTER_VALIDATE_INT);

            if (empty($_POST) || !$id) {
                echo json_encode([
                    'tipo' => 'error',
                    'mensaje' => 'Ha Ocurrido Un Error'
                ]);
                exit;
            }

            $categoria = CategoriaAcero::find($id);
            $resultado = $categoria->eliminar();


            if ($resultado) {
                echo json_encode([
                    'tipo' => 'exito',
                    'mensaje' => 'Se Ha Eliminado Correctamente la Categoria'
                ]);
            }
        }
    }

    public static function eliminarDescripcion(Router $router)
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            session_start();
            isAuth();
            isAdmin();

            $id = filter_var($_POST['id'], FILTER_VALIDATE_INT);


            if (empty($_POST) || !$id) {
                echo json_encode([
                    'tipo' => 'error',
                    'mensaje' => 'Ha Ocurrido Un Error'
                ]);
                exit;
            }


            $descripcion = DescripcionAcero::find($id);
            $resultado = $descripcion->eliminar();


            if ($resultado) {
                echo json_encode([
                    'tipo' => 'exito',
                    'mensaje' => 'Se Ha Eliminado Correctamente la Descripción'
                ]);
            }
        }
    }

    public static function editarPrecios(Router $router)
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            session_start();
            isAuth();
            isAdmin();

            $id = filter_var($_POST['id'], FILTER_VALIDATE_INT);

            if (empty($_POST) || !$id) {
                echo json_encode([
                    'tipo' => 'error',
                    'mensaje' => 'Ha Ocurrido Un Error!'
                ]);
                exit;
            }



            $acero = TiposAceros::find($id);
            $acero->sincronizar($_POST);
            $resultado = $acero->guardar();


            if ($resultado) {

                if (isset($_POST['slp'])) {


                    $aceros = TiposAceros::Notall('id', '1');

                    foreach ($aceros as $acero) {

                        if ($acero->prolamsa >= $acero->arcoMetal) {
                            $acero->slp = $_POST['slp'] + $acero->prolamsa;
                        } else if ($acero->prolamsa < $acero->arcoMetal) {
                            $acero->slp = $_POST['slp'] + $acero->arcoMetal;
                        }

                        $acero->guardar();


                        $productosComerciales = ProductosComerciales::belongsTo('tiposaceros_id', $acero->id);

                        foreach ($productosComerciales as $producto) {

                            $categoria = CategoriaProducto::find($producto->categoriaProducto_id);

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

                            $producto->costo = $acero->slp;

                            //Se calcula el costo neto
                            $producto->costoneto = ($producto->costo + $impuestos->flete + $impuestos->descarga + $impuestos->seguro) * $impuestos->iva;

                            //Se obtienen lo costos de producción a actualizar
                            $preciosProduccion = PreciosProduccion::find($producto->preciosProduccion_id);

                            //Se calculan los costros de Producción
                            $preciosProduccion->publico1 = $producto->costoneto * $porcentajeGanancias->gananciapublico1;
                            $preciosProduccion->herrero2 = $producto->costoneto * $porcentajeGanancias->gananciaherrero2;
                            $preciosProduccion->herrero3 = $producto->costoneto * $porcentajeGanancias->gananciaherrero3;
                            $preciosProduccion->herrero4 = $producto->costoneto * $porcentajeGanancias->gananciaherrero4;
                            $preciosProduccion->mayoreo1 = $producto->costoneto * $porcentajeGanancias->gananciamayoreo1;
                            $preciosProduccion->mayoreo2 = $producto->costoneto * $porcentajeGanancias->gananciamayoreo2;

                            $preciosProduccion->guardar();
                            $producto->guardar();

                            $productoProveedor = ProductosProveedores::where('productosComerciales_id', $producto->id);
                            $pesos = Pesos::find($productoProveedor->pesos_id);

                            $precios = PreciosProveedores::find($productoProveedor->preciosProveedores_id);


                            $precios->publico1 = ceil($pesos->pesoPromedio * $preciosProduccion->publico1);
                            $precios->herrero2 = ceil($pesos->pesoPromedio * $preciosProduccion->herrero2);
                            $precios->herrero3 = ceil($pesos->pesoPromedio * $preciosProduccion->herrero3);
                            $precios->herrero4 = ceil($pesos->pesoPromedio * $preciosProduccion->herrero4);
                            $precios->mayoreo1 = ceil($pesos->pesoPromedio * $preciosProduccion->mayoreo1);
                            $precios->mayoreo2 = ceil($pesos->pesoPromedio * $preciosProduccion->mayoreo2);


                            $resultado = $precios->guardar();
                        }
                    }

                    echo json_encode([
                        'tipo' => 'exito',
                        'mensaje' => 'Se Ha Actualizado Correctamente el Registro'
                    ]);
                } else if (isset($_POST['prolamsa']) || isset($_POST['arcoMetal'])) {


                    $aceroBase = TiposAceros::find('1');


                    if ($acero->prolamsa >= $acero->arcoMetal) {
                        $acero->slp = $aceroBase->slp + $acero->prolamsa;
                    } else if ($acero->prolamsa < $acero->arcoMetal) {
                        $acero->slp = $aceroBase->slp + $acero->arcoMetal;
                    }

                    $resultado = $acero->guardar();

                    if ($resultado) {
                        echo json_encode([
                            'tipo' => 'exito',
                            'mensaje' => 'Se Ha Actualizado Correctamente el Registro'
                        ]);
                    }
                } else {

                    echo json_encode([
                        'tipo' => 'error',
                        'error' => 'Ha Ocurrido Un Error!'
                    ]);
                }
            }
        }
    }
}
