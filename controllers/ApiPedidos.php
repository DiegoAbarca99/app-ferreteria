<?php

namespace Controllers;

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

            $pedido = new Pedidos($_POST);



            if ($_SESSION['id'] != $_POST['usuarios_id']) {
                echo json_encode([]);
                exit;
            }


            $pedido->clientes_id = $_POST['cliente'];

            if (empty($_POST['productos']) && empty($_POST['productoskilos'])) {
                echo json_encode([]);
                exit;
            }

            $resultado = $pedido->guardar();

            if (!$resultado) {
                echo json_encode([]);
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
                            echo json_encode([
                                'tipo' => 'exito',
                                'mensaje' => 'Pedido Realizado Correctamente'
                            ]);
                        }
                    } else {
                        echo json_encode([]);
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
                                echo json_encode([
                                    'tipo' => 'exito',
                                    'mensaje' => 'Pedido Realizado Correctamente'
                                ]);
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
}
