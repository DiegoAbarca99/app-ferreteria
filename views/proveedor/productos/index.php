<?php include_once __DIR__ . '/../../templates/header-dashboard.php'; ?>

<div class="contenedor">
    <div class="filtro">

        <select class="filtro__select" id="select-producto">
            <option value="" selected disabled>--Seleccionar Categoria--</option>
            <option value="">Seleccionar Todas</option>
            <?php foreach ($categorias as $categoria) { ?>
                <option value="<?php echo $categoria->id ?>"><?php echo $categoria->nombre; ?></option>
            <?php } ?>
        </select>

        <form class="filtro__buscador" id="buscador-producto">
            <input type="text" class="filtro__input" placeholder="Buscar por Nombre">
            <input type="submit" class="filtro__submit" value="Buscar">

        </form>


        <a class="btn-verde" href="/proveedor/productos/kilos">
            <i class="fa-solid fa-arrow-right"></i> Ver precios en kilos
        </a>

    </div>

    <div id="productos" class="bloques-proveedores">

    </div>

    <div class="flex-centro">
        <a class="btn-verde mt-4" href="/proveedor/productos/pdf">Descargar PDF <i class="fa-solid fa-file-pdf"></i></a>
    </div>

</div>



<?php include_once __DIR__ . '/../../templates/footer-dashboard.php'; ?>