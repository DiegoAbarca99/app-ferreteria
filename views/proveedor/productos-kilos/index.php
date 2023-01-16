<?php include_once __DIR__ . '/../../templates/header-dashboard.php'; ?>

<div class="contenedor">
    <div class="filtro">

        <a class="btn-regresar" href="/proveedor/productos">
            <i class="fa-solid fa-arrow-left"></i> Regresar
        </a>

        <form class="filtro__buscador" id="buscador-producto-kilo">
            <input type="text" class="filtro__input" placeholder="Buscar por Nombre">
            <input type="submit" class="filtro__submit" value="Buscar">

        </form>


    </div>

    <div id="productos-kilos" class="bloques-proveedores">

    </div>

    <div class="flex-centro">
        <a id="pdf" class="btn-verde mt-4" href="/proveedor/productos/kilos/pdf">Descargar PDF <i class="fa-solid fa-file-pdf"></i></a>
    </div>

</div>



<?php include_once __DIR__ . '/../../templates/footer-dashboard.php'; ?>