<div class="filtro">

    <select class="filtro__select" id="filtro-select">
        <option value="" selected disabled>-- <?php echo $mensaje_select?> --</option>
        <option value="">Seleccionar Todas</option>
        <?php foreach ($categorias as $categoria) { ?>
            <option value="<?php echo $categoria->id; ?>"><?php echo $categoria->nombre; ?></option>
        <?php } ?>
    </select>

    <form class="filtro__buscador">
        <input type="text" class="filtro__input" placeholder="Buscar por Nombre">
        <input type="submit" class="filtro__submit" value="Buscar" id="filtro-buscador">
    </form>


    <a class="btn-agregar" href=<?php echo $href?>>
        <i class="fa-solid fa-circle-plus"></i> <?php echo $mensaje_boton?>
    </a>

</div>