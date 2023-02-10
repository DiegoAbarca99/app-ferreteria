<?php

namespace Controllers;

use Classes\Paginacion;
use Model\CategoriaProductosProveedores;
use Model\Pesos;
use Model\PreciosProduccion;
use Model\PreciosProveedores;
use Model\ProductosComerciales;
use Model\ProductosProveedores;
use MVC\Router;

class ProductosProveedoresController
{

    public static function index(Router $router)
    {
        session_start();
        isAuth();
        isAdmin();



        //Se obtiene el nombre que filtrará a las categorias enviada vía GET
        $nombre = $_GET['nombre'] ?? '';

        $productos = [];

        if ($nombre) {

            $productos = ProductosProveedores::filtrar('nombre', $nombre);
        } else {

            //Se define la categoria Filtrado enviada via GET
            $categoriaFiltrada = $_GET['categoria'] ?? '';

            if ($categoriaFiltrada) {
                $respuesta = CategoriaProductosProveedores::find($categoriaFiltrada);
                if (!$respuesta || !filter_var($categoriaFiltrada, FILTER_VALIDATE_INT)) {
                    header('Location:/admin/index');
                }
            }


            $productos = ProductosProveedores::belongsToAndOrden('categoriaProductosProveedores_id', $categoriaFiltrada, 'id', 'ASC');
        }


        $categorias = [];

        $categorias = CategoriaProductosProveedores::ordenar('id', 'ASC');
        $productosAll = ProductosProveedores::all();


        //Se eliminan aquellas categorias de producto que no están asociadas a ningún producto 
        $categoriasMostrar = [];
        foreach ($productosAll as $producto) {
            $categoriasMostrar[] = $producto->categoriaProductosProveedores_id;
        }


        foreach ($categorias as $key => $categoria) {
            if (!in_array($categoria->id, $categoriasMostrar)) {
                unset($categorias[$key]);
            }
        }

        //Se formatean los productos por categoria de producto asociada, empleando un nuevo arreglo
        $productosFormateados = [];
        foreach ($productos as $producto) {
            $producto->precio = PreciosProveedores::find($producto->preciosProveedores_id);
            $producto->categoria = CategoriaProductosProveedores::find($producto->categoriaProductosProveedores_id);
            $producto->peso = Pesos::find($producto->pesos_id);

            $productosFormateados[$producto->categoriaProductosProveedores_id][] = $producto;
        }





        $router->render('/admin/productos-proveedores/index', [
            'titulo' => 'Listado de Precios Proveedores',
            'categorias' => $categorias,
            'productos' => $productosFormateados,
            'href' => '/admin/producto-proveedor/crear',
            'mensaje_boton' => ' Agregar Producto',
            'mensaje_select' => 'Seleccione una Categoria'
        ]);
    }

    public static function crear(Router $router)
    {
        session_start();
        isAuth();
        isAdmin();

        $categorias = CategoriaProductosProveedores::all();
        $productos = ProductosComerciales::all();
        $productoProveedor = new ProductosProveedores();
        $pesos = new Pesos();
        $precios = new PreciosProveedores();
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $_POST['nombre'] = trim(strtoupper($_POST['nombre']));
            $productoProveedor->sincronizar($_POST);
            $pesos->sincronizar($_POST);


            $alertas = $productoProveedor->validar();
            $alertas = $pesos->validar();


            if (empty($alertas)) {

                $productoExistente = ProductosProveedores::where('nombre', $productoProveedor->nombre);

                if ($productoExistente) {
                    ProductosProveedores::setAlerta('error', 'Ya existe un producto con ese nombre');
                } else {

                    // Llenado de la tabla de Pesos 

                    $pesos->pesoAntiguo = 0;
                    $pesos->pesoPromedio = ($pesos->pesoAntiguo + intval($pesos->pesoNuevo)) / 2;

                    $resultado = $pesos->guardar();

                    if (!$resultado) {
                        exit;
                    }

                    $productoProveedor->pesos_id = $resultado['id'];


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
                        exit;
                    }

                    $productoProveedor->preciosProveedores_id = $resultado['id'];



                    $resultado = $productoProveedor->guardar();
                    if ($resultado) {
                        header('Location:/admin/producto-proveedor');
                    }
                }
            }
        }

        $alertas = ProductosProveedores::getAlertas();
        $router->render('/admin/productos-proveedores/crear', [
            'titulo' => 'Crear Producto',
            'categorias' => $categorias,
            'productos' => $productos,
            'productoProveedor' => $productoProveedor,
            'peso' => $pesos,
            'alertas' => $alertas,

        ]);
    }



    public static function actualizar(Router $router)
    {
        session_start();
        isAuth();
        isAdmin();

        $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);

        $productoProveedor = ProductosProveedores::find($id);

        if (!$productoProveedor) {
            header('Location:/admin/producto-proveedor');
        }


        $pesos = Pesos::find($productoProveedor->pesos_id);
        $precios = PreciosProveedores::find(($productoProveedor->preciosProveedores_id));

        $categorias = CategoriaProductosProveedores::all();
        $productos = ProductosComerciales::all();

        $alertas = [];

        $nombrePrevio = $productoProveedor->nombre;


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $_POST['nombre'] = trim(strtoupper($_POST['nombre']));
            $productoProveedor->sincronizar($_POST);

            $alertas = $productoProveedor->validar();


            if (empty($alertas)) {

                $productoExistente = ProductosProveedores::where('nombre', $productoProveedor->nombre);

                if ($productoExistente && $nombrePrevio != $productoExistente->nombre) {
                    ProductosProveedores::setAlerta('error', 'Ya existe un producto con ese nombre');
                } else {


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
                        exit;
                    }




                    $resultado = $productoProveedor->guardar();
                    if ($resultado) {
                        header('Location:/admin/producto-proveedor');
                    }
                }
            }
        }

        $alertas = ProductosProveedores::getAlertas();
        $router->render('/admin/productos-proveedores/actualizar', [
            'titulo' => 'Crear Producto',
            'categorias' => $categorias,
            'productos' => $productos,
            'productoProveedor' => $productoProveedor,
            'peso' => $pesos,
            'alertas' => $alertas

        ]);
    }
}
