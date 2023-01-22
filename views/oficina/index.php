<?php include_once __DIR__ . '/../templates/header-dashboard.php'; ?>
<div class="contenedor">
    <div class="flex-centro-col ">

        <div class="formulario__contenedor--radios">
            <div class="formulario__campo">
                <label for="si">Pagados</label>
                <input type="radio" name="pagado" id="si" value="1">
            </div>
            <div class="formulario__campo">
                <label for="no">No pagados</label>
                <input type="radio" name="pagado" id="no" value="0">
            </div>

        </div>
        <div class="formulario__contenedor--radios">
            <div class="formulario__campo">
                <label for="proveedor">Proveedor</label>
                <input type="radio" name="tipo" id="proveedor" value="proveedor">
            </div>
            <div class="formulario__campo">
                <label for="cliente">Cliente</label>
                <input type="radio" name="tipo" id="cliente" value="cliente">
            </div>
            <div class="formulario__campo">
                <label for="folio">Folio</label>
                <input type="radio" name="tipo" id="folio" value="folio">
            </div>

        </div>
    </div>
    <form class="filtro filtro--no-margin">


        <input class="formulario__input" type="date" name="fecha" id="fecha" value="<?php echo date('Y-m-d') ?>">

        <div class="filtro__buscador">
            <input type="text" class="filtro__input" placeholder="Ingrese Nombre" id="buscador-usuario">
        </div>

        <input type="submit" class="btn-submit" value="Buscar" id="buscar-pedido">



    </form>
    <p id="advertencia"></p>

    <div class="contenedor-pedidos">
        <div class="contenedor-sm pedidos" id="pedidos">

        </div>
        <div class="mt-4">
            <div id="resumen-pedidos">

            </div>
        </div>
    </div>

</div>
<div class="btn-arriba" id="arriba">
    <i class="fa-solid fa-arrow-up"></i>
</div>

<div class="btn-abajo" id="abajo">
    <i class="fa-solid fa-arrow-down"></i>
</div>
<div class="abajo"></div>
<?php include_once __DIR__ . '/../templates/footer-dashboard.php' ?>