<?php include_once __DIR__.'/../templates/header-dashboard.php';?>
<div class="contenedor-sm">

    <div class="filtros" id=filtros>
        <div class="filtros-inputs">
            <h2>Filtros:</h2>
            <div class="campo">
                <label for="todas">Todos</label>
                <input type="radio" name="filtro" id="todos"  value="" checked>
            </div>

            <div class="campo">
                <label for="completadas">Tubulares</label>
                <input type="radio" name="filtro" id="tubulares"  value="1">
            </div>

            <div class="campo">
                <label for="pendientes">Solidos</label>
                <input type="radio" name="filtro" id="solidos"  value="0" >
            </div>

        </div>
    </div>

    <ul class="listado-tareas" id="listado-tareas"></ul>
</div>


<?php include_once __DIR__.'/../templates/footer-dashboard.php' ?>
