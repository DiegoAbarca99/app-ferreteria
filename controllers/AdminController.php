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
        
        $consulta = [];
        $alertas = [];
       
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $busqueda = s($_POST['busqueda']);

            if (empty($busqueda)){
                Historico::setAlerta('error', 'Debe ingresar nombre de usuario modificado');
            
            } else{

                $buscar = Historico::filtrar('nombre', $busqueda);

                if(!$buscar) {
                    Historico::setAlerta('error', 'El usuario ingresado no existe o aun no ha hecho algún cambio');
                }else {
                    foreach($buscar as $busca){
                        $consulta = Historico::filtrarArray([
                            'nombre' => $busca->nombre,
                            'fecha' => $busca->fecha,
                            'usuario' => $busca->usuario,
                            'accion' => $busca->accion,
                            'detalles' => $busca->detalles
                            
                        ]);
                    }
                }
            }
        }
        $historico = Historico::all();
        $alertas = Historico::getAlertas();
        $router->render('admin/historial',[
            'titulo'=>'Historial',
            'historico'=> $historico,
            'consulta'=> $consulta,
            'alertas'=> $alertas
            
            
        ]);
    }


}