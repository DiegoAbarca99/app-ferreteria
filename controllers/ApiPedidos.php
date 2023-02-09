<?php

namespace Controllers;

use Model\Clientes;
use Model\OficinaGrafico;
use Model\OficinaPedido;
use Model\OficinaPedidoKilos;
use Model\Pedidos;
use Model\PedidosKilo;
use Model\ProductosPedidos;

class ApiPedidos
{
    public static function index()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            session_start();
            isAuth();
            isProveedor();

            if (empty($_POST['abono']))
                $_POST['abono'] = '0';

            $pedido = new Pedidos($_POST);



            if ($_SESSION['id'] != $_POST['usuarios_id']) {
                echo json_encode([
                    'tipo' => 'error',
                    'mensaje' => 'Ha Ocurrido Un Error!'
                ]);
                exit;
            }


            if (empty($_POST['productos']) && empty($_POST['productoskilos'])) {
                echo json_encode([
                    'tipo' => 'error',
                    'mensaje' => 'Ha Ocurrido Un Error!'
                ]);
                exit;
            }

            $cliente = Clientes::find($_POST['cliente']);

            if (empty($cliente)) {
                echo json_encode([
                    'tipo' => 'error',
                    'mensaje' => 'Ha Ocurrido Un Error!'
                ]);
                exit;
            }

            $pedido->clientes_id = $cliente->id;


            $pedido->total += floatval($cliente->cuotaConsumo);
            $folio = uniqid();
            $pedido->folio = $folio;

            $resultado = $pedido->guardar();

            if (!$resultado) {
                echo json_encode([
                    'tipo' => 'error',
                    'mensaje' => 'Ha Ocurrido Un Error!'
                ]);
                exit;
            }



            $terminado = false;

            if (!empty($_POST['productos'])) {
                $_POST['productos'] = json_decode($_POST['productos']);

                foreach ($_POST['productos'] as $key => $producto) {

                    $tipoPrecio = '';
                    if ($producto->publico1) {
                        $tipoPrecio = 'Publico1';
                    } else if ($producto->herrero2) {
                        $tipoPrecio = 'Herrero2';
                    } else if ($producto->herrero3) {
                        $tipoPrecio = 'Herrero3';
                    } else if ($producto->herrero4) {
                        $tipoPrecio = 'Herrero4';
                    }


                    $args = [
                        'pedidos_id' => $resultado['id'],
                        'productosProveedores_id' => $producto->id,
                        'cantidad' => $producto->cantidad,
                        'precio' => $producto->precio,
                        'tipo' => $tipoPrecio,

                    ];

                    $productoPedido = new ProductosPedidos($args);
                    $resultadoProducto = $productoPedido->guardar();


                    if ($resultadoProducto) {
                        if (array_key_last($_POST['productos']) == $key) {
                            $terminado = true;
                            if ($cliente->credito == '1') {
                                echo json_encode([
                                    'tipo' => 'warning',
                                    'mensaje' => 'PRECAUCIÓN CLIENTE CON CRÉDITO ACTIVO!!, folio de compra: ' . $folio
                                ]);
                            } else {
                                if ($pedido->pagado == 0) $cliente->credito = 1;
                                $respuesta = $cliente->guardar();

                                if ($respuesta)
                                    echo json_encode([
                                        'tipo' => 'exito',
                                        'mensaje' => 'Su folio de compra es el siguiente: ' . $folio
                                    ]);
                            }
                        }
                    } else {
                        echo json_encode([
                            'tipo' => 'error',
                            'mensaje' => 'Ha Ocurrido Un Error!'
                        ]);
                        exit;
                    }
                }
            }

            if (!empty($_POST['productoskilos'])) {
                $_POST['productoskilos'] = json_decode($_POST['productoskilos']);
                foreach ($_POST['productoskilos'] as $key => $producto) {

                    $tipoPrecio = '';
                    if ($producto->publico1) {
                        $tipoPrecio = 'Publico1';
                    } else if ($producto->herrero2) {
                        $tipoPrecio = 'Herrero2';
                    } else if ($producto->herrero3) {
                        $tipoPrecio = 'Herrero3';
                    } else if ($producto->herrero4) {
                        $tipoPrecio = 'Herrero4';
                    }


                    $args = [
                        'pedidos_id' => $resultado['id'],
                        'precioskilo_id' => $producto->id,
                        'cantidad' => $producto->cantidad,
                        'precio' => $producto->precio,
                        'tipo' => $tipoPrecio,

                    ];

                    $productoPedido = new PedidosKilo($args);
                    $resultadoProducto = $productoPedido->guardar();

                    if ($resultadoProducto) {
                        if (array_key_last($_POST['productoskilos']) == $key) {
                            if ($terminado) {
                                exit;
                            } else {

                                if ($cliente->credito == '1') {
                                    echo json_encode([
                                        'tipo' => 'warning',
                                        'mensaje' => 'PRECAUCIÓN CLIENTE CON CRÉDITO ACTIVO!!, folio de compra: ' . $folio
                                    ]);
                                } else {
                                    if ($pedido->pagado == 0) $cliente->credito = 1;
                                    $respuesta = $cliente->guardar();

                                    if ($respuesta)
                                        echo json_encode([
                                            'tipo' => 'exito',
                                            'mensaje' => 'Su folio de compra es el siguiente: ' . $folio
                                        ]);
                                }
                            }
                        }
                    } else {
                        echo json_encode([]);
                        exit;
                    }
                }
            }
        }
    }

    public static function listar()
    {
        session_start();
        isAuth();
        isOficina();



        $fecha = $_GET['fecha'] ?? ''; //Obtiene la fecha actual.




        if (empty($_GET['tipo']) || is_null($_GET['pagado'])) {
            echo json_encode([]);
            exit;
        }

        $pagado = $_GET['pagado'];
        $tipo = $_GET['tipo'];
        $usuario = $_GET['usuario'] ?? '';



        $consulta = "  SELECT pedidos.id,fecha, folio, pagado, pedidos.status, abono, metodoPago, total, usuarios.nombre as usuario, sucursales.nombre as sucursal,";
        $consulta .= " clientes.nombre as cliente, clientes.curp, clientes.telefono as celular, clientes.credito, CONCAT( clientes.calle,' ', clientes.numeroExterno,' ',clientes.numeroInterno) as direccion, CONCAT(clientes.estado,' ',municipios.nombre) as ubicacion, ";
        $consulta .= " clientes.cuotaConsumo as cuota, clientes.telefono, productosproveedores.nombre as producto, ";
        $consulta .= " productospedidos.cantidad, productospedidos.precio, productospedidos.tipo";
        $consulta .= " FROM pedidos ";
        $consulta .= " INNER JOIN usuarios ";
        $consulta .= " ON pedidos.usuarios_id=usuarios.id  ";
        $consulta .= " INNER JOIN sucursales ";
        $consulta .= " ON usuarios.sucursal_id=sucursales.id  ";
        $consulta .= " INNER JOIN clientes ";
        $consulta .= " ON pedidos.clientes_id=clientes.id ";
        $consulta .= " INNER JOIN municipios ";
        $consulta .= " ON clientes.municipios_id=municipios.id ";
        $consulta .= " INNER JOIN productospedidos ";
        $consulta .= " ON productospedidos.pedidos_id=pedidos.id ";
        $consulta .= " INNER JOIN productosproveedores ";
        $consulta .= " ON productospedidos.productosProveedores_id=productosproveedores.id ";
        if (empty($usuario)) {
            $consulta .= " WHERE pedidos.fecha  LIKE  '{$fecha}%' AND pedidos.pagado = '{$pagado}' ORDER BY pedidos.id ASC";
        } else {

            if ($tipo == 'folio') {
                $consulta .= " WHERE pedidos.folio LIKE '%{$usuario}%' ORDER BY pedidos.id ASC";
            } else {
                $consulta .= " WHERE pedidos.fecha  LIKE  '{$fecha}%' AND pedidos.pagado = '{$pagado}'";
                if ($tipo == 'proveedor') {
                    $consulta .= " AND usuarios.nombre LIKE '%{$usuario}%' ORDER BY pedidos.id ASC";
                } else if ($tipo == 'cliente') {
                    $consulta .= " AND clientes.nombre LIKE '%{$usuario}%' ORDER BY pedidos.id ASC";
                }
            }
        }


        $pedidos = OficinaPedido::SQL($consulta);




        $query = "  SELECT pedidos.id, pagado,fecha, folio, abono, pedidos.status, metodoPago, total, usuarios.nombre as usuario, sucursales.nombre as sucursal,";
        $query .= " clientes.nombre as cliente, clientes.curp, clientes.telefono as celular, clientes.credito, CONCAT( clientes.calle,' ', clientes.numeroExterno,' ',clientes.numeroInterno) as direccion, CONCAT(clientes.estado,' ',municipios.nombre) as ubicacion, ";
        $query .= " clientes.cuotaConsumo as cuota, clientes.telefono, precioskilo.nombre as producto, ";
        $query .= " pedidoskilo.cantidad, pedidoskilo.precio, pedidoskilo.tipo";
        $query .= " FROM pedidos ";
        $query .= " INNER JOIN usuarios ";
        $query .= " ON pedidos.usuarios_id=usuarios.id  ";
        $query .= " INNER JOIN sucursales ";
        $query .= " ON usuarios.sucursal_id=sucursales.id  ";
        $query .= " INNER JOIN clientes ";
        $query .= " ON pedidos.clientes_id=clientes.id ";
        $query .= " INNER JOIN municipios ";
        $query .= " ON clientes.municipios_id=municipios.id ";
        $query .= " INNER JOIN pedidoskilo ";
        $query .= " ON pedidoskilo.pedidos_id=pedidos.id ";
        $query .= " INNER JOIN precioskilo ";
        $query .= " ON pedidoskilo.precioskilo_id=precioskilo.id ";
        if (empty($usuario) || empty($tipo)) {
            $query .= " WHERE pedidos.fecha  LIKE  '{$fecha}%' AND pedidos.pagado = '{$pagado}' ORDER BY pedidos.id ASC ";
        } else {

            if ($tipo == 'folio') {
                $query .= " WHERE pedidos.folio LIKE '%{$usuario}%' ORDER BY pedidos.id ASC";
            } else {
                $query .= " WHERE pedidos.fecha  LIKE  '{$fecha}%' AND pedidos.pagado = '{$pagado}'";
                if ($tipo == 'proveedor') {
                    $query .= " AND usuarios.nombre LIKE '%{$usuario}%' ORDER BY pedidos.id ASC";
                } else if ($tipo == 'cliente') {
                    $query .= " AND clientes.nombre LIKE '%{$usuario}%' ORDER BY pedidos.id ASC";
                }
            }
        }


        $pedidoskilos = OficinaPedido::SQL($query);

        if (empty($pedidos) && empty($pedidoskilos)) {
            echo json_encode([]);
            exit;
        }

        $arregloPedidos = [];
        $arregloPedidos[] = $pedidos;
        $arregloPedidos[] = $pedidoskilos;


        echo json_encode($arregloPedidos);
    }

    public static function cambiarEstado()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            session_start();
            isAuth();
            isOficina();


            $id = filter_var($_POST['id'], FILTER_VALIDATE_INT);
            $status = filter_Var($_POST['status'], FILTER_VALIDATE_INT);



            $pedido = Pedidos::find($id);

            if (!$pedido) {
                echo json_encode([]);
                exit;
            }

            $pedido->status = $status;
            $resultado = $pedido->guardar();

            if ($resultado) {
                echo json_encode([
                    'tipo' => 'exito',
                    'mensaje' => 'El Status Ha Sido Actualizado'
                ]);
            } else {
                echo json_encode([]);
                exit;
            }
        }
    }
    public static function cambiarPagado()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            session_start();
            isAuth();
            isOficina();


            $id = filter_var($_POST['id'], FILTER_VALIDATE_INT);
            $pagado = filter_Var($_POST['pagado'], FILTER_VALIDATE_INT);



            $pedido = Pedidos::find($id);

            if (!$pedido) {
                echo json_encode([]);
                exit;
            }

            $pedido->pagado = $pagado;
            $resultado = $pedido->guardar();

            if ($resultado) {
                echo json_encode([
                    'tipo' => 'exito',
                    'mensaje' => 'El Pedido Se Ha Sido Actualizado'
                ]);
            } else {
                echo json_encode([]);
                exit;
            }
        }
    }

    public static function cambiarCredito()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            session_start();
            isAuth();
            isOficina();


            $credito = filter_var($_POST['credito'], FILTER_VALIDATE_INT);
            $curp = $_POST['curp'] ?? '';





            if (is_null($credito) || !$curp) {
                echo json_encode([]);
                exit;
            }

            $cliente = Clientes::where('curp', $curp);

            if (!$cliente) {
                echo json_encode([]);
                exit;
            }

            if ($cliente->credito != $credito) {
                $cliente->credito = $credito;
                $resultado = $cliente->guardar();
                if ($resultado) {
                    echo json_encode([
                        'tipo' => 'exito',
                        'mensaje' => 'El estado de crédito del cliente ha cambiado'
                    ]);
                } else {
                    echo json_encode([]);
                    exit;
                }
            } else {

                echo json_encode([
                    'tipo' => 'exito',
                ]);
            }
        }
    }
    public static function cambiarAbono()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            session_start();
            isAuth();
            isOficina();


            $id = filter_var($_POST['id'], FILTER_VALIDATE_INT);
            $abono = $_POST['abono'] ?? '';


            if (is_null($id) || $abono == '') {
                echo json_encode([]);
                exit;
            }

            $pedido = Pedidos::find($id);

            if ($abono == $pedido->total)
                $pedido->abono = 0;
            else
                $pedido->abono = $abono;

                
            $resultado = $pedido->guardar();




            if ($resultado) {
                echo json_encode([
                    'tipo' => 'exito',
                    'mensaje' => 'El Pedido Se Ha Sido Actualizado'
                ]);
            }
        }
    }

    public static function graficar()
    {

        session_start();
        isAuth();
        isOficina();


        $fecha = $_GET['fecha'] ?? '';
        $pagado = $_GET['pagado'] ?? '';

        if (is_null($pagado) || !$fecha) {
            echo json_encode([]);
            exit;
        }


        $query = "  SELECT pedidos.id, fecha, total";
        $query .= " FROM pedidos WHERE pedidos.fecha  LIKE  '{$fecha}%' AND pedidos.pagado = '{$pagado}' ORDER BY pedidos.fecha ASC";


        $pedidos = OficinaGrafico::SQL($query);

        if (empty($pedidos)) {
            echo json_encode([]);
            exit;
        }

        $arregloClasificado = [];
        $arregloTotales = [0, 0, 0, 0];


        foreach ($pedidos as  $pedido) {
            if (preg_match_all('/20..\-..\-0([1-7])/', $pedido->fecha)) $arregloClasificado[0][] = $pedido;
            if (preg_match_all('/20..\-..\-(0([8-9])|1([0-4]))/', $pedido->fecha)) $arregloClasificado[1][] = $pedido;
            if (preg_match_all('/20..\-..\-(1([5-9])|2([0-1]))/', $pedido->fecha)) $arregloClasificado[2][] = $pedido;
            if (preg_match_all('/20..\-..\-(2([2-9])|3([0-1]))/', $pedido->fecha)) $arregloClasificado[3][] = $pedido;
        }


        foreach ($arregloClasificado as $key => $arreglo) {
            foreach ($arreglo as $elemento) {
                $arregloTotales[$key] += $elemento->total;
            }
        }




        echo json_encode($arregloTotales);
    }
}
