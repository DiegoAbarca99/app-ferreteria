<?php 
namespace Controllers;
use MVC\Router;

class OficinaController {
    public static function index(Router $router){
        session_start(); 
        isAuth(); 
        isOficina();

        $router->render('oficina/index',[
            'titulo'=>'Oficina',
        ]);
    }

    public static function historial(Router $router){
        session_start(); 
        isAuth(); 
        isOficina();
        

        $router->render('oficina/historial',[
            'titulo'=>'Historial',
        ]);
    }

    public static function estado(Router $router){
        session_start();
        isAuth();
        isOficina();

        $router->render('oficina/estado-venta/index',[
            'titulo'=>'Estado de venta',
        ]);
    }
   


}