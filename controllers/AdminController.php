<?php 
namespace Controllers;
use MVC\Router;

class AdminController {
    public static function dashboard(Router $router){
        session_start(); //Se inicia Sesión
        isAuth(); //Función que corrobora que el usuario se haya autenticado de lo contrario redirecciona al login

        isAdmin();// Función que corrobora que el usuario sea administrador
        

        $router->render('admin/index',[
            'titulo'=>'Administración Global',
        ]);
    }
    public static function perfiles(Router $router){
        session_start(); //Se inicia Sesión
        isAuth(); //Función que corrobora que el usuario se haya autenticado de lo contrario redirecciona al login

        isAdmin();// Función que corrobora que el usuario sea administrador
        

        $router->render('admin/perfiles',[
            'titulo'=>'Perfiles',
        ]);
    }

    public static function historial(Router $router){
        session_start(); //Se inicia Sesión
        isAuth(); //Función que corrobora que el usuario se haya autenticado de lo contrario redirecciona al login

        isAdmin();// Función que corrobora que el usuario sea administrador
        

        $router->render('admin/historial',[
            'titulo'=>'Historial',
        ]);
    }


}