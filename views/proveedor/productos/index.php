<?php include_once __DIR__ . '/../../templates/header-dashboard.php'; ?>

<div class="contenedor">
    <div class="filtro">

        <?php include_once __DIR__ . '/../select-categorias.php' ?>

        <?php include_once __DIR__ . '/../buscador-clientes-productos.php' ?>


        <a class="btn-verde" href="/proveedor/productos/kilos">
            <i class="fa-solid fa-arrow-right"></i> Ver precios en kilos
        </a>

    </div>

    <input type="hidden" value="<?php echo $isPrivilegiado?>" id='isPrivilegiado'>

    <div id="productos" class="bloques-proveedores">

    </div>

    <div class="flex-centro">
        <a class="btn-verde mt-4" href="/proveedor/productos/pdf">Descargar PDF <i class="fa-solid fa-file-pdf"></i></a>
    </div>

</div>



<?php include_once __DIR__ . '/../../templates/footer-dashboard.php'; ?>