<?php

require_once __DIR__ . '/../includes/app.php';
use MVC\Router;
use Controllers\AuthController;
use Controllers\AdminController;
use Controllers\ApiCategoriasProducto;
use Controllers\ApiTiposAcero;
use Controllers\CategoriasProductoController;
use Controllers\OficinaController;
use Controllers\PerfilesController;
use Controllers\ProveedorController;
use Controllers\TiposAceroController;

$router = new Router();

//Login
$router->get('/',[AuthController::class,'login']);
$router->post('/',[AuthController::class,'login']);
$router->get('/logout',[AuthController::class,'logout']);


//Dashboard(Proveedor)
$router->get('/proveedor/index',[ProveedorController::class,'index']);


//Dashboard(Admin)
$router->get('/admin/index',[AdminController::class,'index']);
$router->get('/historial',[AdminController::class,'historial']);

//Gestión categorias del producto - impuestos y ganancias (Admin)
$router->get('/admin/categoria',[CategoriasProductoController ::class,'index']);
$router->get('/admin/categoria/crear',[CategoriasProductoController ::class,'crear']);
$router->post('/admin/categoria/crear',[CategoriasProductoController ::class,'crear']);

//Gestión tipos de Acero (Admin)
$router->get('/admin/acero',[TiposAceroController::class,'index']);
$router->get('/admin/acero/crear',[TiposAceroController::class,'crear']);
$router->post('/admin/acero/crear',[TiposAceroController::class,'crear']);
$router->get('/admin/acero/actualizar',[TiposAceroController::class,'actualizar']);
$router->post('/admin/acero/actualizar',[TiposAceroController::class,'actualizar']);
$router->post('/admin/acero/eliminar',[TiposAceroController::class,'eliminar']);


//Dashboard(Oficina)
$router->get('/oficina/index',[OficinaController::class,'index']);

//Gestión de perfiles(Admin y Oficina)
$router->get('/perfiles/index',[PerfilesController::class,'index']);
$router->get('/perfiles/crear',[PerfilesController::class,'crear']);
$router->post('/perfiles/crear',[PerfilesController::class,'crear']);
$router->get('/perfiles/perfil',[PerfilesController::class,'perfil']);
$router->get('/perfiles/editar',[PerfilesController::class,'editar']);
$router->post('/perfiles/editar',[PerfilesController::class,'editar']);
$router->post('/perfiles/eliminar',[PerfilesController::class,'eliminar']);

//--------------Apis----------------------------------------
//(Actualizar impuestos y ganancias de las categorias de producto)
$router->get('/api/categorias',[ApiCategoriasProducto::class,'index']);
$router->post('/api/categorias/eliminar',[ApiCategoriasProducto::class,'eliminar']);
$router->post('/api/categorias/actualizar/ganancias',[ApiCategoriasProducto::class,'ganancias']);
$router->post('/api/categorias/actualizar/impuestos',[ApiCategoriasProducto::class,'impuestos']);

//(Agregar, eliminar descripciones y categorias de tipos de acero)
$router->post('/api/tipos-acero/agregar/categoria',[ApiTiposAcero::class,'crearCategoria']);
$router->post('/api/tipos-acero/eliminar/categoria',[ApiTiposAcero::class,'eliminarCategoria']);
$router->post('/api/tipos-acero/agregar/descripcion',[ApiTiposAcero::class,'crearDescripcion']);
$router->post('/api/tipos-acero/eliminar/descripcion',[ApiTiposAcero::class,'eliminarDescripcion']);
$router->post('/api/tipos-acero/actualizar/precios',[ApiTiposAcero::class,'editarPrecios']);

$router->comprobarRutas();