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

   


}