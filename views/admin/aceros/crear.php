<?php include_once __DIR__ . '/../../templates/header-dashboard.php'; ?>
<div class="contenedor">
    <div class="flex-izquierda">
        <a class="btn-regresar" href="/admin/acero">
            <i class="fa-solid fa-arrow-left"></i> Regresar</a>
    </div>

    <form method="POST" class="formulario">
        <?php include_once __DIR__ . '/../../templates/alertas.php'; ?>

        <fieldset class="formulario__fieldset">

            <legend class="formulario__legend">Información Tipo de Acero</legend>

            <div class="formulario__campo">
                <label for="nombre" class="formulario__label">Nombre</label>
                <input type="text" id="nombre" name="nombre" class="formulario__input" placeholder='Ej. Espesor 0.0747"(C14)' value="<?php echo s($acero->nombre); ?>">
            </div>

            <div class="formulario__campo">
                <label for="categoriaacero_id" class="formulario__label">Categoria</label>
                <select class="formulario__input formulario__input--select" name="categoriaacero_id" id="categoriaacero_id">
                    <option value="" selected>--Seleccione una Opción--</option>
                    <?php foreach ($categorias as $categoria) { ?>
                        <option value="<?php echo $categoria->id; ?>" <?php echo $categoria->id == $acero->categoriaacero_id ? 'selected' : '' ?>> <?php echo $categoria->categoria; ?></option>
                    <?php } ?>
                </select>

                <a class="formulario__enlace" id="categoria-acero">Añadir Categoria</a>
                <a class="formulario__enlace--eliminar" id="categoria-acero-eliminar">Eliminar Categoria</a>
            </div>

            <div class="formulario__campo">
                <label for="descripcionacero_id" class="formulario__label">Descripción</label>
                <select class="formulario__input formulario__input--select" name="descripcionacero_id" id="descripcionacero_id">
                    <option value="" selected>--Seleccione una Opción--</option>
                    <?php foreach ($descripciones as $descripcion) { ?>
                        <option value="<?php echo $descripcion->id; ?>" <?php echo $descripcion->id == $acero->descripcionacero_id ? 'selected' : '' ?>> <?php echo $descripcion->descripcion; ?></option>
                    <?php } ?>
                </select>
                <a class="formulario__enlace" id="descripcion-acero">Añadir Descripcion</a>
                <a class="formulario__enlace--eliminar" id="descripcion-acero-eliminar">Eliminar Descripcion</a>
            </div>

        </fieldset>

        <fieldset class="formulario__fieldset">
            <legend class="formulario__legend">Precios</legend>

            <p class="formulario__descripcion">
                Ingrese los precios del Acero en base a su distribuidor.
            </p>
            <div class="formulario__contenedor-campos">
                <div class="formulario__campo">
                    <label for="prolamsa" class="formulario__label">Prolamsa</label>
                    <input step="any" class="formulario__input" type="number" name="prolamsa" id="prolamsa" min='0' placeholder="EJ. 5" value="<?php echo s($acero->prolamsa); ?>">
                </div>

                <div class="formulario__campo">
                    <label for="arcoMetal" class="formulario__label">ArcoMetal</label>
                    <input step="any" class="formulario__input" type="number" name="arcoMetal" id="arcoMetal" min='0' placeholder="EJ. 5" value="<?php echo s($acero->arcoMetal); ?>">
                </div>

            </div>

        </fieldset>


        <div class="flex-centro">
            <input class="btn-submit" type="submit" value="crear tipo">
        </div>

    </form>
</div>

<?php include_once __DIR__ . '/../../templates/footer-dashboard.php' ?>