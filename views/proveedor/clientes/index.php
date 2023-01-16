<?php include_once __DIR__ . '/../../templates/header-dashboard.php'; ?>
<div class="contenedor">
    <div class="filtro">

        <div>
            <select class="filtro__select" id="select-municipio">
                <option value="" selected disabled>--Seleccionar Municipio--</option>
                <option value="">Seleccionar Todas</option>
                <?php foreach ($municipios as $municipio) { ?>
                    <option value="<?php echo $municipio->id ?>"><?php echo $municipio->nombre; ?></option>
                <?php } ?>
            </select>

            <div class="flex-izquierda mt-1">
                <a class="formulario__enlace--eliminar  d-block" id="municipio-eliminar">Eliminar Municipio</a>
            </div>
        </div>


        <form class="filtro__buscador" id="buscador-cliente">
            <input id="buscar-cliente" type="text" class="filtro__input" placeholder="Buscar por Nombre">
            <input type="submit" class="filtro__submit" value="Buscar">

        </form>


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