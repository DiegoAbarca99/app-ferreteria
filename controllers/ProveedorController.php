<?php 
namespace Controllers;
use MVC\Router;

class ProveedorController {
    public static function dashboard(Router $router){
        session_start(); //Se inicia Sesión
        isAuth(); //Función que corrobora que el usuario se haya autenticado de lo contrario redirecciona al login

        isProveedor(); //Función que corrbora si el usuario es proveedor.
        

        $router->render('proveedor/index',[
            'titulo'=>'Levantar Pedido',
        ]);
    }

    public static function clientes(Router $router){
        session_start();
        isAuth();
        isProveedor(); 

        $router->render('proveedor/clientes',[
            'titulo'=>'Clientes',
        ]);
    }

    public static function perfil(Router $router){
        session_start();
        isAuth();
        isProveedor(); 

        $router->render('proveedor/index',[
            'titulo'=>'Perfil',
        ]);
    }


}