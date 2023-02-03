<?php

namespace Controllers;

use Model\Clientes;
use Model\Municipios;
use Model\Historico;
use Model\Usuario;
use MVC\Router;
use Dompdf\Dompdf;
use Model\Pedidos;

class ClientesController
{
    public static function index(Router $router)
    {
        session_start();
        isAuth();
        isProveedor();

        $municipios = Municipios::all();

        $router->render('proveedor/clientes/index', [
            'titulo' => 'Gestionar Clientes',
            'municipios' => $municipios
        ]);
    }

    public static function pdf(Router $router)
    {
        session_start();
        isAuth();
        isProveedor();

        $clientes = Clientes::ordenar('municipios_id', 'ASC');


        foreach ($clientes as $cliente) {
            $cliente->municipio = Municipios::find($cliente->municipios_id);
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
                <?php if (empty($clientes)) { ?>
                    <p class="text-center">No Hay Clientes Que Pueda Gestionar Aún</p>
                <?php } else { ?>
                    <h1 class="text-center mb-4">Listado de clientes</h1>
                    <table class="table table-bordered">
                        <thead style="background-color:#2f405d; color:white; font-weight:900;">
                            <tr>
                                <th style="padding: 10px 3px;">Nombre</th>
                                <th style="padding: 10px 3px;">telèfono</th>
                                <th style="padding: 10px 3px;">Estado</th>
                                <th style="padding: 10px 3px;">Municipio</th>
                                <th style="padding: 10px 3px;">Direcciòn</th>
                                <th style="padding: 10px 3px;">Crédito</th>
                                <th style="padding: 10px 3px;">Cuota Consumo</th>

                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($clientes as $cliente) { ?>
                                <tr class="bg-primary">
                                    <td> <?php echo $cliente->nombre ?></td>
                                    <td> <?php echo $cliente->telefono ?></td>
                                    <td> <?php echo $cliente->estado ?></td>
                                    <td> <?php echo $cliente->municipio->nombre; ?></td>
                                    <td> <?php echo $cliente->colonia . ' ' . $cliente->calle . ' #' . $cliente->numeroExterno . ' (Externo)' . ' #' . $cliente->numeroInterno ?? ''; ?></td>
                                    <td> <?php echo $cliente->credito == 1 ? 'Activo' : 'Inactivo'; ?></td>
                                    <td> <?php echo $cliente->cuotaConsumo; ?></td>
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
        $dompdf->stream('Clientes.pdf', array('Attachment' => true));
    }


    public static function crear(Router $router)
    {
        session_start();
        isAuth();
        isProveedor();

        $cliente = new Clientes();
        $municipio = new Municipios();
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $municipio->nombre = $_POST['municipio'];

            $resultado = [];

            if (!empty($municipio->nombre)) {
                $municipioExistente = Municipios::where('nombre', $municipio->nombre);

                if ($municipioExistente) {
                    $resultado['id'] = $municipioExistente->id;
                } else {
                    $resultado = $municipio->crear();
                }
            }

            $cliente->sincronizar($_POST);
            $cliente->municipios_id = $resultado['id'] ?? '';
            $alertas = $cliente->validar();



            if (empty($alertas)) {
                $cliente->guardar();
                header('Location:/proveedor/clientes');
            }
        }


        $alertas = Clientes::getAlertas();
        $router->render('proveedor/clientes/crear', [
            'titulo' => 'Añadir Cliente',
            'alertas' => $alertas,
            'cliente' => $cliente,
            'municipio' => $municipio
        ]);
    }
    public static function actualizar(Router $router)
    {
        session_start();
        isAuth();
        isProveedor();

        $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);

        if (!$id) {
            header('Location:/proveedor/clientes');
            exit;
        }

        $cliente = Clientes::find($id);

        $usuario = Usuario::find($id);

        if (!$cliente) {
            header('Location:/proveedor/clientes');
            exit;
        }

        $municipio = Municipios::find($cliente->municipios_id);
        $pedidos = Pedidos::belongsTo('clientes_id', $cliente->id);


        $alertas = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $municipio->nombre = $_POST['municipio'];
            $resultado = [];

            if (!empty($municipio->nombre)) {
                $municipioExistente = Municipios::where('nombre', $municipio->nombre);

                if ($municipioExistente) {
                    $resultado['id'] = $municipioExistente->id;
                } else {
                    $resultado = $municipio->crear();
                }
            }

            $cuotaAnterior = $cliente->cuotaConsumo;


            $cliente->sincronizar($_POST);
            if ($cuotaAnterior != $cliente->cuotaConsumo){
                $diferencia = abs(floatval($cuotaAnterior) - floatval($cliente->cuotaConsumo));
                $arg=['usuario'=>$usuario->usuario,
                'nombre'=>'Nombre cliente: '.$cliente->nombre ,
                'sucursal'=>$usuario->surcursal
                ,'detalles'=>'Cuota anterior: '.$cuotaAnterior.' nueva: '.$cliente->cuotaConsumo,
                'accion'=>'Se modificó la cuota de consumo'];

            } 
            foreach ($pedidos as $pedido) {
                if ($cuotaAnterior > $cliente->cuotaConsumo) {
                    $pedido->total = floatval($pedido->total) - $diferencia;
                } else {
                    $pedido->total = floatval($pedido->total) + $diferencia;
                }
                $pedido->guardar();
            }
            // Historial
            
            
            $historico = new Historico($arg);

            $cliente->id = $id;
            $cliente->municipios_id = $resultado['id'] ?? '';
            $alertas = $cliente->validar();



            if (empty($alertas)) {
                $cliente->guardar();
                if(!empty($arg)) $historico->guardar();
                header('Location:/proveedor/clientes');
            }
        }


        $alertas = Clientes::getAlertas();
        $router->render('proveedor/clientes/actualizar', [
            'titulo' => 'Añadir Cliente',
            'alertas' => $alertas,
            'cliente' => $cliente,
            'municipio' => $municipio
        ]);
    }

    public static function eliminar()
    {


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            session_start();
            isAuth();
            isProveedor();

            $id = filter_var($_POST['id'], FILTER_VALIDATE_INT);

            if (!$id) {
                echo json_encode([]);
                exit;
            }

            $cliente = Clientes::find($id);

            if (!$cliente) {
                echo json_encode([]);
                exit;
            }

            $resultado = $cliente->eliminar();

            if ($resultado) {
                echo json_encode([
                    'resultado' => true,
                    'mensaje' => 'Registro Eliminado Correctamente'
                ]);
            } else {
                echo json_encode([]);
            }
        }
    }
}
