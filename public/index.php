<?php

require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controllers\AuthController;
use Controllers\AdminController;
use Controllers\ApiCategoriasProducto;
use Controllers\ApiClientes;
use Controllers\ApiCorreos;
use Controllers\ApiMunicipios;
use Controllers\ApiPedidos;
use Controllers\ApiProductos;
use Controllers\ApiProductosComerciales;
use Controllers\ApiProductosProveedores;
use Controllers\ApiSucursales;
use Controllers\ApiTiposAcero;
use Controllers\CategoriasProductoController;
use Controllers\OficinaController;
use Controllers\PerfilesController;
use Controllers\ProductosComercialesController;
use Controllers\ProductosProveedoresController;
use Controllers\ProveedorController;
use Controllers\TiposAceroController;
use Controllers\ClientesController;
use Controllers\ProductosController;

$router = new Router();

//Login
$router->get('/', [AuthController::class, 'login']);
$router->post('/', [AuthController::class, 'login']);
$router->get('/logout', [AuthController::class, 'logout']);

//--------------Proveedor---------------
//Dashboard(Proveedor)
$router->get('/proveedor/index', [ProveedorController::class, 'index']);
$router->get('/proveedor/historial-pedidos', [ProveedorController::class, 'historial']);
$router->post('/proveedor/historial-pedidos', [ProveedorController::class, 'historial']);

//Gestión de Clientes(Proveedor)
$router->get('/proveedor/clientes', [ClientesController::class, 'index']); 
$router->get('/proveedor/clientes/pdf', [ClientesController::class, 'pdf']); 
$router->get('/proveedor/clientes/crear', [ClientesController::class, 'crear']);
$router->post('/proveedor/clientes/crear', [ClientesController::class, 'crear']);
$router->get('/proveedor/clientes/actualizar', [ClientesController::class, 'actualizar']);
$router->post('/proveedor/clientes/actualizar', [ClientesController::class, 'actualizar']);
$router->post('/proveedor/clientes/eliminar', [ClientesController::class, 'eliminar']);

//Vistas de Productos (Proveedor)
$router->get('/proveedor/productos', [ProductosController::class, 'index']);
$router->get('/proveedor/productos/kilos', [ProductosController::class, 'indexKilos']);
$router->get('/proveedor/productos/kilos/pdf', [ProductosController::class, 'pdfkilos']);
$router->get('/proveedor/productos/pdf', [ProductosController::class, 'pdf']);





//------------------Admin------------------------
//Dashboard(Admin)
$router->get('/admin/index', [AdminController::class, 'index']);

//Historial de cambios

$router->get('/historial', [AdminController::class, 'historial']);
$router->get('/historial/usuarios', [AdminController::class, 'historialUsuarios']);
$router->post('/historial/usuarios', [AdminController::class, 'historialUsuarios']);
$router->get('/historial/productos', [AdminController::class, 'historialProductos']);
$router->post('/historial/productos', [AdminController::class, 'historialProductos']);

//Gestión categorias del producto - impuestos y ganancias (Admin)
$router->get('/admin/categoria', [CategoriasProductoController::class, 'index']);
$router->get('/admin/categoria/crear', [CategoriasProductoController::class, 'crear']);
$router->post('/admin/categoria/crear', [CategoriasProductoController::class, 'crear']);

//Gestión tipos de Acero (Admin)
$router->get('/admin/acero', [TiposAceroController::class, 'index']);
$router->get('/admin/acero/crear', [TiposAceroController::class, 'crear']);
$router->post('/admin/acero/crear', [TiposAceroController::class, 'crear']);
$router->get('/admin/acero/actualizar', [TiposAceroController::class, 'actualizar']);
$router->post('/admin/acero/actualizar', [TiposAceroController::class, 'actualizar']);
$router->post('/admin/acero/eliminar', [TiposAceroController::class, 'eliminar']);

//Gestión Productos Comerciales o producción (Admin)
$router->get('/admin/producto-comercial', [ProductosComercialesController::class, 'index']);
$router->get('/admin/producto-comercial/crear', [ProductosComercialesController::class, 'crear']);
$router->get('/admin/producto-comercial/ver', [ProductosComercialesController::class, 'ver']);
$router->get('/admin/producto-comercial/actualizar', [ProductosComercialesController::class, 'actualizar']);
$router->get('/admin/producto-comercial/precios-kilos', [ProductosComercialesController::class, 'preciosKilos']);
$router->get('/admin/producto-comercial/precios-kilos/crear', [ProductosComercialesController::class, 'preciosKilosCrear']);
$router->post('/admin/producto-comercial/precios-kilos/crear', [ProductosComercialesController::class, 'preciosKilosCrear']);
$router->get('/admin/producto-comercial/precios-kilos/actualizar', [ProductosComercialesController::class, 'preciosKilosActualizar']);
$router->post('/admin/producto-comercial/precios-kilos/actualizar', [ProductosComercialesController::class, 'preciosKilosActualizar']);


//Gestión Productos Proveedores (Admin)
$router->get('/admin/producto-proveedor', [ProductosProveedoresController::class, 'index']);
$router->get('/admin/producto-proveedor/crear', [ProductosProveedoresController::class, 'crear']);
$router->post('/admin/producto-proveedor/crear', [ProductosProveedoresController::class, 'crear']);
$router->get('/admin/producto-proveedor/actualizar', [ProductosProveedoresController::class, 'actualizar']);
$router->post('/admin/producto-proveedor/actualizar', [ProductosProveedoresController::class, 'actualizar']);

//-------------------Oficina--------------------------
//Dashboard(Oficina)
$router->get('/oficina/index', [OficinaController::class, 'index']);
$router->get('/pedidos/graficar', [OficinaController::class, 'graficar']);

//Gestión de perfiles(Admin y Oficina)
$router->get('/perfiles/index', [PerfilesController::class, 'index']);
$router->get('/perfiles/crear', [PerfilesController::class, 'crear']);
$router->post('/perfiles/crear', [PerfilesController::class, 'crear']);
$router->get('/perfiles/perfil', [PerfilesController::class, 'perfil']);
$router->get('/perfiles/editar', [PerfilesController::class, 'editar']);
$router->post('/perfiles/editar', [PerfilesController::class, 'editar']);
$router->post('/perfiles/eliminar', [PerfilesController::class, 'eliminar']);
//--------------Apis----------------------------------------

//-----Admin----------
//(Actualizar impuestos, ganancias y nombre de las categorias de producto)
$router->get('/api/categorias', [ApiCategoriasProducto::class, 'index']);
$router->get('/api/categorias/filtrar', [ApiCategoriasProducto::class, 'filtrar']);
$router->post('/api/categorias/eliminar', [ApiCategoriasProducto::class, 'eliminar']);
$router->post('/api/categorias/actualizar/ganancias', [ApiCategoriasProducto::class, 'ganancias']);
$router->post('/api/categorias/actualizar/impuestos', [ApiCategoriasProducto::class, 'impuestos']);
$router->post('/api/categorias/actualizar/nombre', [ApiCategoriasProducto::class, 'nombre']);

//(Agregar, eliminar descripciones y categorias de tipos de acero)
$router->get('/api/tipos-acero', [ApiTiposAcero::class, 'index']);
$router->post('/api/tipos-acero/agregar/categoria', [ApiTiposAcero::class, 'crearCategoria']);
$router->post('/api/tipos-acero/eliminar/categoria', [ApiTiposAcero::class, 'eliminarCategoria']);
$router->post('/api/tipos-acero/agregar/descripcion', [ApiTiposAcero::class, 'crearDescripcion']);
$router->post('/api/tipos-acero/eliminar/descripcion', [ApiTiposAcero::class, 'eliminarDescripcion']);
$router->post('/api/tipos-acero/actualizar/precios', [ApiTiposAcero::class, 'editarPrecios']);

//(Agregar, actualizar y eliminar productos comerciales o producción)
$router->post('/api/producto-comercial/precios-kilos/eliminar', [ApiProductosComerciales::class, 'preciosKilosEliminar']);
$router->post('/api/producto-comercial/crear', [ApiProductosComerciales::class, 'crear']);
$router->post('/api/producto-comercial/actualizar', [ApiProductosComerciales::class, 'actualizar']);
$router->post('/api/producto-comercial/eliminar', [ApiProductosComerciales::class, 'eliminar']);

//(Agregar y eliminar cateogorias en la sección de los productos de los proveedores)
$router->post('/api/producto-proveedor/agregar/categoria', [ApiProductosProveedores::class, 'crearCategoria']);
$router->post('/api/producto-proveedor/eliminar/categoria', [ApiProductosProveedores::class, 'eliminarCategoria']);
$router->post('/api/producto-proveedor/eliminar', [ApiProductosProveedores::class, 'eliminarProducto']);
$router->post('/api/producto-proveedor/actualizar/peso', [ApiProductosProveedores::class, 'actualizarPeso']);


//-------Proveedor--------

//Filtrar productos de los proveedores (Perfil de Proveedor)
$router->get('/api/productos', [ApiProductos::class, 'index']);
$router->get('/api/productos/kilos', [ApiProductos::class,'kilos']);

$router->get('/api/clientes', [ApiClientes::class,'index']);
$router->post('/api/municipios/eliminar', [ApiMunicipios::class,'eliminar']);
$router->post('/api/pedidos/levantar', [ApiPedidos::class,'index']);

//-------Oficina---------
$router->get('/api/pedidos/listar', [ApiPedidos::class,'listar']);
$router->post('/api/pedidos/estado', [ApiPedidos::class,'cambiarEstado']);
$router->post('/api/pedidos/pagado', [ApiPedidos::class,'cambiarPagado']);
$router->post('/api/pedidos/credito', [ApiPedidos::class,'cambiarCredito']);
$router->post('/api/pedidos/abono', [ApiPedidos::class,'cambiarAbono']);
$router->post('/api/pedidos/metodo-pago', [ApiPedidos::class,'cambiarMetodoPago']);
$router->get('/api/pedidos/graficar', [ApiPedidos::class,'graficar']);

//-------Perfiles--------
$router->post('/api/sucursales/crear',[ApiSucursales::class,'crearSucursal'] );
$router->post('/api/sucursales/eliminar',[ApiSucursales::class,'eliminarSucursal'] );

//--------Solicitud de subir de nivel Proveedores (Email)
$router->post('/solicitarSubirNivel',[ApiCorreos::class,'enviarCorreos'] );
$router->get('/subirNivel',[ApiCorreos::class,'subirNivel'] );

$router->comprobarRutas();
