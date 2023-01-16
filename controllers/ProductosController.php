<?php

namespace Controllers;

use Model\CategoriaProducto;
use Model\CategoriaProductosProveedores;
use Model\PreciosKilo;
use Model\PreciosProduccion;
use Model\ProductosComerciales;
use MVC\Router;
use Dompdf\Dompdf;
use Model\PreciosProveedores;
use Model\ProductosProveedores;

class ProductosController
{
    public static function index(Router $router)
    {


        session_start();
        isAuth();
        isProveedor();

        $categorias = CategoriaProductosProveedores::all();

        $router->render('proveedor/productos/index', [
            'titulo' => 'Listado de Productos',
            'categorias' => $categorias
        ]);
    }
    public static function indexKilos(Router $router)
    {

        session_start();
        isAuth();
        isProveedor();


        $router->render('proveedor/productos-kilos/index', [
            'titulo' => 'Listado de Productos en kilos',

        ]);
    }

    public static function pdfKilos(Router $router)
    {

        session_start();
        isAuth();
        isProveedor();

        $productos = PreciosKilo::all();

        foreach ($productos as $producto) {
            $producto->productoProduccion = ProductosComerciales::find($producto->productosComerciales_id);
        }

        foreach ($productos as $producto) {
            $producto->precio = PreciosProduccion::find($producto->productoProduccion->preciosProduccion_id);
            $producto->categoria = CategoriaProducto::find($producto->productoProduccion->categoriaProducto_id);
        }

        // instantiate and use the dompdf class
        $dompdf = new Dompdf();

        $options = $dompdf->getOptions();
        $options->set(array('isRemoteEnabled' => true));
        $dompdf->setOptions($options);


        ob_start();

?>

        <!DOCTYPE html>
        <html lang="es">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&family=Open+Sans&display=swap" rel="stylesheet">
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        </head>

        <body>
            <div class="contenedor-sombra mt-4">
                <?php if (empty($productos)) { ?>
                    <p class="text-center">No Hay Productos Que Pueda Gestionar Aún</p>
                <?php } else { ?>
                    <h1 class="text-center mb-4">Listado de precios por Kilogramos</h1>
                    <table class="table table-bordered">
                        <thead style="background-color:#2f405d; color:white; font-weight:900;">
                            <tr>
                                <th style="padding: 10px 3px;">Código</th>
                                <th style="padding: 10px 3px;">Nombre</th>
                                <th style="padding: 10px 3px;">Categoria</th>
                                <th style="padding: 10px 3px;">Publico1</th>
                                <th style="padding: 10px 3px;">Herrero2</th>
                                <th style="padding: 10px 3px;">Herrero3</th>
                                <th style="padding: 10px 3px;">Herrero4</th>

                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($productos as $producto) { ?>
                                <tr class="bg-primary">
                                    <td> <?php echo $producto->codigo ?></td>
                                    <td> <?php echo $producto->nombre ?></td>
                                    <td> <?php echo $producto->categoria->nombre; ?></td>
                                    <td> <?php echo $producto->precio->publico1; ?></td>
                                    <td> <?php echo $producto->precio->herrero2; ?></td>
                                    <td> <?php echo $producto->precio->herrero3; ?></td>
                                    <td> <?php echo $producto->precio->herrero4; ?></td>
                                </tr>

                            <?php } ?>
                        </tbody>
                    </table>
                <?php } ?>
            </div>

        </body>

        </html>


    <?php


        $html = ob_get_clean();


        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('letter');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream('productosKilos.pdf', array('Attachment' => true));
    }

    public static function pdf(Router $router)
    {

        session_start();
        isAuth();
        isProveedor();

        $productos = ProductosProveedores::ordenar('categoriaProductosProveedores_id', 'ASC');
        foreach ($productos as $producto) {
            $producto->precio = PreciosProveedores::find($producto->preciosProveedores_id);
            $producto->categoria = CategoriaProductosProveedores::find($producto->categoriaProductosProveedores_id);
        }



        // instantiate and use the dompdf class
        $dompdf = new Dompdf();

        $options = $dompdf->getOptions();
        $options->set(array('isRemoteEnabled' => true));
        $dompdf->setOptions($options);


        ob_start();

    ?>

        <!DOCTYPE html>
        <html lang="es">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&family=Open+Sans&display=swap" rel="stylesheet">
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
            
        </head>

        <body>
            <div class="contenedor-sombra mt-4">
                <?php if (empty($productos)) { ?>
                    <p class="text-center">No Hay Productos Que Pueda Gestionar Aún</p>
                <?php } else { ?>
                    <h1 class="text-center mb-4">Listado de precios de los productos</h1>
                    <table class="table table-bordered">
                        <thead style="background-color:#2f405d; color:white; font-weight:900;" >
                            <tr>
                                <th style="padding: 10px 3px;">Categoria</th>
                                <th style="padding: 10px 3px;">Nombre</th>
                                <th style="padding: 10px 3px;">Publico1</th>
                                <th style="padding: 10px 3px;">Herrero2</th>
                                <th style="padding: 10px 3px;">Herrero3</th>
                                <th style="padding: 10px 3px;">Herrero4</th>

                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($productos as $producto) { ?>
                                <tr>
                                    <td class="text-primary"> <?php echo $producto->categoria->nombre; ?></td>
                                    <td> <?php echo $producto->nombre ?></td>
                                    <td> <?php echo $producto->precio->publico1; ?></td>
                                    <td> <?php echo $producto->precio->herrero2; ?></td>
                                    <td> <?php echo $producto->precio->herrero3; ?></td>
                                    <td> <?php echo $producto->precio->herrero4; ?></td>
                                </tr>

                            <?php } ?>
                        </tbody>
                    </table>
                <?php } ?>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
        </body>

        </html>


<?php


        $html = ob_get_clean();


        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('letter');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream('productos.pdf', array('Attachment' => true));
    }
}
