<?php 
namespace Controllers;
use MVC\Router;

class OficinaController {
    public static function dashboard(Router $router){
        session_start(); //Se inicia Sesión
        isAuth(); //Función que corrobora que el usuario se haya autenticado de lo contrario redirecciona al login
        isOficina();//Función que corrbora que el usuario tenga status de oficina

        $router->render('oficina/index',[
            'titulo'=>'Oficina',
        ]);
    }

   


}