<form method="POST" class="filtro filtro--no-margin">

    <input class="formulario__input" type="date" name="fecha" value="<?php echo date('Y-m-d') ?>">

    <div class="filtro__buscador">
        <input type="text" class="filtro__input" name="entidad" placeholder="Buscar por Entidad">
    </div>

    <input type="submit" class="btn-submit" value="Buscar">


</form>