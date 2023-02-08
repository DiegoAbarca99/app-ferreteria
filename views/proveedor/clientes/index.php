<?php include_once __DIR__ . '/../../templates/header-dashboard.php'; ?>
<div class="contenedor">
    <div class="filtro">

        <div>
           <?php include_once __DIR__ .'/../select-categorias.php'?>

            <div class="flex-izquierda mt-1">
                <a class="formulario__enlace--eliminar  d-block" id="municipio-eliminar">Eliminar Municipio</a>
            </div>
        </div>


       <?php include_once __DIR__.'/../buscador-clientes-productos.php'?>


        <a class="btn-agregar" href="/proveedor/clientes/crear">
            <i class="fa-solid fa-circle-plus"></i>
            Agregar Cliente
        </a>

    </div>

    <div id="clientes" class="bloques-proveedores">

    </div>

    <div class="flex-centro">
        <a class="btn-verde mt-4" href="/proveedor/clientes/pdf">Descargar PDF <i class="fa-solid fa-file-pdf"></i></a>
    </div>

</div>

<?php include_once __DIR__ . '/../../templates/footer-dashboard.php' ?>