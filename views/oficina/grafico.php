<?php include_once __DIR__ . '/../templates/header-dashboard.php'; ?>
<div class="contenedor">
    <div class="flex-centro-col">
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
    </div>
    <form class="flex-centro">

        <input class="" type="month" name="fecha" id="mes">
        <input type="submit" class="btn-submit" value="Buscar" id="buscar-pedidos">

    </form>
    <div class="contenedor-sm mt-4" id="grafico">
    </div>
</div>



<?php include_once __DIR__ . '/../templates/footer-dashboard.php' ?>