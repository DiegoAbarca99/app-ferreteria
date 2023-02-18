<?php

namespace Controllers;

use MVC\Router;
use Model\Usuario;
use Model\Historico;
use Model\Sucursales;

class AdminController
{
    public static function index(Router $router)
    {
        session_start();
        isAuth();
        isAdmin();
        isAllowed();


        $router->render('admin/index', [
            'titulo' => 'Administración Global',
        ]);
    }

    public static function historial(Router $router)
    {
        session_start();
        isAuth();
        isAdmin();



        $alertas = Historico::getAlertas();
        $router->render('admin/historial/index', [
            'titulo' => 'Historial de Cambios',
            'alertas' => $alertas


        ]);
    }

    public static function historialProductos(Router $router)
    {
        session_start();
        isAuth();
        isAdmin();


        $consultas = Historico::belongsToAndOrden('accion', 'Se modificó el peso del producto', 'fecha', 'asc');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $fecha = s($_POST['fecha']);
            $entidadNombre = '';
            if (!empty($_POST['entidad']))  $entidadNombre = S($_POST['entidad']) ?? '';



            $consultas = Historico::filtrarArrayAll([
                'accion' => 'Se modificó el peso del producto',
                'fecha' => $fecha,
                'entidadModificada' => $entidadNombre,

            ]);
        }


        foreach ($consultas as $consulta) {
            $consulta->usuario = Usuario::find($consulta->usuarios_id);
            $consulta->sucursal = Sucursales::find($consulta->usuario->sucursal_id);
        }


        $alertas = Historico::getAlertas();
        $router->render('admin/historial/historial-productos', [
            'titulo' => 'Cambios Productos',
            'alertas' => $alertas,
            'consultas' => $consultas


        ]);
    }


    public static function historialUsuarios(Router $router)
    {
        session_start();
        isAuth();
        isAdmin();


        $query = "SELECT * FROM historicousuarios WHERE accion LIKE '%acceso%' ORDER BY fecha ASC ";
      
        $consultas = Historico::SQL($query);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $fecha = s($_POST['fecha']);
            $entidadNombre = '';
            if (!empty($_POST['entidad']))  $entidadNombre = S($_POST['entidad']) ?? '';

            $query = "SELECT * FROM historicousuarios WHERE accion LIKE '%acceso%' AND fecha LIKE '%$fecha%' AND entidadModificada LIKE '%$entidadNombre%' ORDER BY $fecha ASC ";
            $consultas = Historico::SQL($query);
        }


        foreach ($consultas as $consulta) {
            $consulta->usuario = Usuario::find($consulta->usuarios_id);
            $consulta->sucursal = Sucursales::find($consulta->usuario->sucursal_id);
        }


        $alertas = Historico::getAlertas();
        $router->render('admin/historial/historial-usuarios', [
            'titulo' => 'Cambios Usuarios',
            'alertas' => $alertas,
            'consultas' => $consultas


        ]);
    }
}
