<?php 

namespace Controllers;

use MVC\Router;
use Model\Usuario;
use Model\Historico;
use Classes\paginacion;

class AdminController {
    public static function index(Router $router){
        session_start(); 
        isAuth(); 
        isAdmin();
        isAllowed();
        

        $router->render('admin/index',[
            'titulo'=>'Administración Global',
        ]);
    }

    public static function historial(Router $router){
        session_start(); 
        isAuth(); 
        isAdmin();

        $historico = Historico::all();

        $router->render('admin/historial',[
            'titulo'=>'Historial',
            'historico'=> $historico
            
            
        ]);
    }


}