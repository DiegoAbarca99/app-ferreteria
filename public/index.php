<?php

require_once __DIR__ . '/../includes/app.php';
use MVC\Router;
use Controllers\LoginController;
use Controllers\AdminController;
use Controllers\OficinaController;
use Controllers\PerfilesController;
use Controllers\ProveedorController;


$router = new Router();

//Login
$router->get('/',[LoginController::class,'login']);
$router->post('/',[LoginController::class,'login']);
$router->get('/logout',[LoginController::class,'logout']);


//Dashboard(Proveedor)
$router->get('/proveedor/index',[ProveedorController::class,'dashboard']);
$router->get('/proveedor/clientes',[ProveedorController::class,'clientes']);
$router->post('/proveedor/clientes',[ProveedorController::class,'clientes']);
$router->get('/proveedor/perfil',[ProveedorController::class,'perfil']);
$router->post('/proveedor/perfil',[ProveedorController::class,'perfil']);

//Dashboard(Admin)
$router->get('/admin/index',[AdminController::class,'dashboard']);
$router->get('/admin/perfiles',[AdminController::class,'perfiles']);
$router->get('/admin/historial',[AdminController::class,'historial']);

//Dashboard(Oficina)
$router->get('/oficina/index',[OficinaController::class,'dashboard']);

//Gestión de perfiles(Admin y Oficina)
$router->get('/perfiles/index',[PerfilesController::class,'index']);
$router->get('/perfiles/crear',[PerfilesController::class,'crear']);
$router->post('/perfiles/crear',[PerfilesController::class,'crear']);
$router->get('/perfiles/perfil',[PerfilesController::class,'perfil']);
$router->get('/perfiles/editar',[PerfilesController::class,'editar']);
$router->post('/perfiles/editar',[PerfilesController::class,'editar']);
$router->post('/perfiles/eliminar',[PerfilesController::class,'eliminar']);


$router->comprobarRutas();