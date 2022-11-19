<?php 
namespace Controllers;
use MVC\Router;

class ProveedorController {
    public static function index(Router $router){
        session_start(); 
        isAuth();
        isProveedor(); 
        

        $router->render('proveedor/index',[
            'titulo'=>'Levantar Pedido',
        ]);
    }




}