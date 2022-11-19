<?php 
namespace Controllers;
use MVC\Router;

class AdminController {
    public static function index(Router $router){
        session_start(); 
        isAuth(); 
        isAdmin();
        

        $router->render('admin/index',[
            'titulo'=>'Administración Global',
        ]);
    }

    public static function historial(Router $router){
        session_start(); 
        isAuth(); 
        isAdmin();
        

        $router->render('admin/historial',[
            'titulo'=>'Historial',
        ]);
    }


}