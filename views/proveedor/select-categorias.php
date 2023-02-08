<select class="filtro__select" id="select-opcion">
    <option value="" selected disabled>--Seleccionar Opción--</option>
    <option value="">Seleccionar Todas</option>
    <?php foreach ($categorias as $categoria) { ?>
        <option value="<?php echo $categoria->id ?>"><?php echo $categoria->nombre; ?></option>
    <?php } ?>
</select>