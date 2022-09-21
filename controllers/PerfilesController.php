<?php 
namespace Controllers;
use MVC\Router;
use Model\Usuario;
class PerfilesController{

    //Muestra pantalla inicial con el listado de perfiles existentes
    public static function index(Router $router){
        session_start();
        isAuth();
        isAllowed(); //Corrobora que el usuario sea admin o tenga status de oficina

        $usuarios=Usuario::notAll('status','0');

        $router->render('perfiles/index',[
            'titulo'=>'Perfiles',
            'usuarios'=>$usuarios
        ]);
        
    }

        //Muestra formulario y envia petición POST para guardar un usuario 
    public static function crear(Router $router){
        session_start();
        isAuth();
        isAllowed(); //Corrobora que el usuario sea admin o tenga status de oficina

        $usuario=new Usuario();
        $alertas=[];
        if($_SERVER['REQUEST_METHOD']==='POST'){

            $usuario=new Usuario($_POST);
           

            $alertas=$usuario->validarCuenta();

            if(empty($alertas)){
                //Validar que no exista

                $usuarioPrevio=Usuario::where('usuario',$usuario->usuario);
                if($usuarioPrevio){
                    Usuario::setAlerta('error','Ya existe un usuario con ese nombre de usuario');
                }else{
                    //Crear nuevo Usuario
                    $usuario->hashearPassword();
                    $usuario->guardar();
                    header('Location: /perfiles/index');
                }

            }
        }

        $alertas=Usuario::getAlertas();
        $router->render('perfiles/crear-perfil',[
            'titulo'=>'Crear-Perfil',
            'usuario'=>$usuario,
            'alertas'=>$alertas
        ]);
        
    }

    //Muestra el contenido del perfil seleccionado
    public static function perfil(Router $router){
        session_start();
        isAuth();
        isAllowed(); //Corrobora que el usuario sea admin o tenga status de oficina

        //Obtiene y valida Id pasado en la URL 
        $id=filter_Var($_GET['id'],FILTER_VALIDATE_INT);

    

        if(!$id){
            header('Location:/');
        }

      

        $usuario=Usuario::find($id);


        if(!$usuario){
            header('Location:/');
        }


        $router->render('perfiles/perfil',[
            'titulo'=>'Perfil',
            'usuario'=>$usuario
        ]);
    }

     //Muestra formulario y envia petición POST para guardar un usuario 
     public static function editar(Router $router){
        session_start();
        isAuth();
        isAllowed(); //Corrobora que el usuario sea admin o tenga status de oficina

         //Obtiene y valida Id pasado en la URL 
         $id=filter_Var($_GET['id'],FILTER_VALIDATE_INT);


         if(!$id){
             header('Location:/');
         }
 
       
 
         $usuario=Usuario::find($id);
 
 
         if(!$usuario){
             header('Location:/');
         }
  

        $alertas=[];
        if($_SERVER['REQUEST_METHOD']==='POST'){

            $usuario->sincronizar($_POST);
           

            $alertas=$usuario->validarCuenta();

            if(empty($alertas)){

                //Crear nuevo Usuario
                $usuario->hashearPassword();
                $usuario->guardar();
                header('Location: /perfiles/index');
        

            }
        }

        $alertas=Usuario::getAlertas();
        $router->render('perfiles/editar-perfil',[
            'titulo'=>'Editar-Perfil',
            'usuario'=>$usuario,
            'alertas'=>$alertas
        ]);
        
    }

    public static function eliminar(){
       if($_SERVER['REQUEST_METHOD']==='POST'){
            $id=$_POST['id'];
            $usuario=Usuario::find($id);
            $resultado=$usuario->eliminar();

            echo json_encode([
                'resultado'=>$resultado,
                'mensaje'=>'Usuario eliminado correctamente'
            ]);


       }
  
    }



}