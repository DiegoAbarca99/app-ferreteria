<?php

namespace Controllers;

use Model\CategoriaAcero;
use MVC\Router;
use Model\CategoriaProducto;
use Model\DescripcionAcero;
use Model\Impuestos;
use Model\PorcentajeGanancias;
use Model\PreciosKilo;
use Model\ProductosComerciales;
use Model\PreciosProduccion;
use Model\TiposAceros;

class ProductosComercialesController
{
    public static function index(Router $router)
    {
        session_start();
        isAuth();
        isAdmin();



        $nombre = $_GET['nombre'] ?? '';


        $productos = [];

        if ($nombre) {
            $productos = ProductosComerciales::filtrar('nombre', $nombre);
        } else {

            $categoriaFiltrada = $_GET['categoria'] ?? '';

            if ($categoriaFiltrada) {

                $respuesta = CategoriaProducto::find($categoriaFiltrada);

                if (!$respuesta || !filter_var($categoriaFiltrada, FILTER_VALIDATE_INT)) {
                    header('Location:/admin/index');
                }
            }

            $productos = ProductosComerciales::belongsToAndOrden('categoriaProducto_id', $categoriaFiltrada, 'categoriaProducto_id', 'ASC');
        }


        $categorias = CategoriaProducto::ordenar('id', 'ASC');
        $productosAll = ProductosComerciales::all();


        //Se eliminan aquellas categorias de producto que no están asociadas a ningún producto 
        $categoriasMostrar = [];
        foreach ($productosAll as $producto) {
            $categoriasMostrar[] = $producto->categoriaProducto_id;
        }


        foreach ($categorias as $key => $categoria) {
            if (!in_array($categoria->id, $categoriasMostrar)) {
                unset($categorias[$key]);
            }
        }

        //Se formatean los productos por categoria de producto asociada, empleando un nuevo arreglo
        $productosFormateados = [];
        foreach ($productos as $producto) {
            $producto->precio = PreciosProduccion::find($producto->preciosProduccion_id);
            $producto->categoria = CategoriaProducto::find($producto->categoriaProducto_id);

            $productosFormateados[$producto->categoriaProducto_id][] = $producto;
        }





        $router->render('/admin/productos-comerciales/index', [
            'titulo' => 'Listado de Precios Producción',
            'categorias' => $categorias,
            'productos' => $productosFormateados
        ]);
    }


    public static function crear(Router $router)
    {
        session_start();
        isAuth();
        isAdmin();

        $categorias = CategoriaProducto::all();
        $aceros = TiposAceros::all();



        $router->render('/admin/productos-comerciales/crear', [
            'titulo' => 'Agregar Producto',
            'categorias' => $categorias,
            'aceros' => $aceros
        ]);
    }

    public static function ver(Router $router)
    {
        session_start();
        isAuth();
        isAdmin();

        if (!filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
            header('Location:/admin/index');
        }

        $id = $_GET['id'];

        $producto = ProductosComerciales::find($id);
        if (!$producto) {
            header('Location:/admin/index');
        }


        //Unión tabla productoscomerciales con categoriaproducto y con Impuestos y PorcentajeGanancias 
        $producto->categoria = CategoriaProducto::find($producto->categoriaProducto_id);
        $producto->categoria->impuestos = Impuestos::find($producto->categoria->impuestos_id);
        $producto->categoria->ganancias = PorcentajeGanancias::find($producto->categoria->porcentajeGanancias_id);

        //Unión tabla productoscomerciales con preciosproduccion
        $producto->precios = PreciosProduccion::find($producto->preciosProduccion_id);


        //Unión tabla productoscomerciales con tiposaceros y con categoriaacero y descripcionacero
        if (!is_null($producto->tiposaceros_id)) {
            $producto->aceros = TiposAceros::find($producto->tiposaceros_id);
            $producto->aceros->categoriaAcero = CategoriaAcero::find($producto->aceros->categoriaacero_id);
            $producto->aceros->descripcionAcero = DescripcionAcero::find($producto->aceros->descripcionacero_id);
        }



        $router->render('/admin/productos-comerciales/ver', [
            'titulo' => 'Ver Producto',
            'producto' => $producto
        ]);
    }

    public static function actualizar(Router $router)
    {
        session_start();
        isAuth();
        isAdmin();

        $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);

        $producto = ProductosComerciales::find($id);

        if (!$id || !$producto) {
            header('Location:/admin/producto-comercial');
        }

        $categorias = CategoriaProducto::all();
        $aceros = TiposAceros::all();



        $router->render('/admin/productos-comerciales/actualizar', [
            'titulo' => 'Agregar Producto',
            'categorias' => $categorias,
            'aceros' => $aceros,
            'producto' => $producto
        ]);
    }

    public static function preciosKilos(Router $router)
    {
        session_start();
        isAuth();
        isAdmin();




        $nombre = $_GET['nombre'] ?? '';
        $productos = [];

        if ($nombre) {
            $productos = ProductosComerciales::filtrar('nombre', $nombre);
        } else {
            $categoriaFiltrada = $_GET['categoria'] ?? '';

            if ($categoriaFiltrada) {
                $respuesta = CategoriaProducto::find($categoriaFiltrada);
                if (!$respuesta || !filter_var($categoriaFiltrada, FILTER_VALIDATE_INT)) {
                    header('Location:/admin/index');
                }
            }

            $productos = ProductosComerciales::belongsToAndOrden('categoriaProducto_id', $categoriaFiltrada, 'categoriaProducto_id', 'ASC');
        }




        $productosKilo = PreciosKilo::all();
        $categorias = CategoriaProducto::ordenar('id', 'ASC');
        $productosAll = ProductosComerciales::all();


        //Se eliminan aquellas categorias de producto que no están asociadas a ningún producto 
        $categoriasMostrar = [];
        foreach ($productosAll as $producto) {
            $categoriasMostrar[] = $producto->categoriaProducto_id;
        }


        foreach ($categorias as $key => $categoria) {
            if (!in_array($categoria->id, $categoriasMostrar)) {
                unset($categorias[$key]);
            }
        }

        //Se determinan los id de los productos filtrados
        $productosId = [];

        foreach ($productos as $producto) {
            $productosId[] = $producto->id;
        }

        //Se filtran los productosKilos cuyos produtosComerciales_id coincinden con los productos comerciales filtrados

        foreach ($productosKilo as $key => $producto) {
            if (!in_array($producto->productosComerciales_id, $productosId)) {
                unset($productosKilo[$key]);
            }
        }



        $productosFormateados = [];
        foreach ($categorias as $categoria) {
            foreach ($productosKilo as $productoKilo) {
                $productoKilo->producto = ProductosComerciales::find($productoKilo->productosComerciales_id);
                $productoKilo->producto->categoria = CategoriaProducto::find($productoKilo->producto->categoriaProducto_id);
                $productoKilo->producto->precio = PreciosProduccion::find($productoKilo->producto->preciosProduccion_id);
                if ($productoKilo->producto->categoriaProducto_id == $categoria->id) {
                    $productosFormateados[$categoria->id][] = $productoKilo;
                }
            }
        }




        $router->render('/admin/productos-comerciales/precios-kilos/index', [
            'titulo' => 'Listado de Precios Producción (Kilos)',
            'categorias' => $categorias,
            'productos' => $productosFormateados
        ]);
    }

    public static function preciosKilosCrear(Router $router)
    {
        session_start();
        isAuth();
        isAdmin();

        $productos = ProductosComerciales::all();
        $alertas = [];
        $productoKilo = new PreciosKilo();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $productoKilo->sincronizar($_POST);

            $alertas = $productoKilo->validar();

            if (empty($alertas)) {

                $nombreExistente = PreciosKilo::where('nombre', $productoKilo->nombre);
                $codigoExistente = PreciosKilo::where('codigo', $productoKilo->codigo);


                if ($nombreExistente) {

                    PreciosKilo::setAlerta('error', 'Ya existe un producto con ese nombre');
                } else if ($codigoExistente) {

                    PreciosKilo::setAlerta('error', 'Ya existe un producto con ese código');
                } else {
                    $resultado = $productoKilo->guardar();
                    if ($resultado) {
                        header('Location:/admin/producto-comercial/precios-kilos');
                    }
                }
            }
        }


        $alertas = PreciosKilo::getAlertas();
        $router->render('/admin/productos-comerciales/precios-kilos/crear', [
            'titulo' => 'Crear Producto (Kilos)',
            'productos' => $productos,
            'alertas' => $alertas,
            'productoKilo' => $productoKilo
        ]);
    }

    public static function preciosKilosActualizar(Router $router)
    {
        session_start();
        isAuth();
        isAdmin();

        $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);

        if (!$id) {
            header('Location:/admin/index');
        }

        $productoKilo = PreciosKilo::find($id);

        if (!$productoKilo) {
            header('Location:/admin/index');
        }

        $productos = ProductosComerciales::all();
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $nombreAnterior = $productoKilo->nombre;
            $codigoAnterior = $productoKilo->codigo;

            $productoKilo->sincronizar($_POST);


            $alertas = $productoKilo->validar();

            if (empty($alertas)) {

                $productoExistente = PreciosKilo::where('nombre', $productoKilo->nombre);
                $productoExistente2 = PreciosKilo::where('codigo', $productoKilo->codigo);


                $nombreExistente = $productoExistente->nombre;
                $codigoExistente = $productoExistente2->codigo;


                if ($nombreExistente && $nombreExistente != $nombreAnterior) {

                    PreciosKilo::setAlerta('error', 'Ya existe un producto con ese nombre');
                } else if ($codigoExistente && $codigoExistente != $codigoAnterior) {

                    PreciosKilo::setAlerta('error', 'Ya existe un producto con ese código');
                } else {
                    $resultado = $productoKilo->guardar();
                    if ($resultado) {
                        header('Location:/admin/producto-comercial/precios-kilos');
                    }
                }
            }
        }


        $alertas = PreciosKilo::getAlertas();
        $router->render('/admin/productos-comerciales/precios-kilos/actualizar', [
            'titulo' => 'Actualizar Producto (Kilos)',
            'productos' => $productos,
            'alertas' => $alertas,
            'productoKilo' => $productoKilo
        ]);
    }
}
