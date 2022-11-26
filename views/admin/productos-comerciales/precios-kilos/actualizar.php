<?php include_once __DIR__ . '/../../../templates/header-dashboard.php'; ?>
<div class="contenedor">
    <div class="flex-izquierda">
        <a class="btn-regresar" href="/admin/producto-comercial/precios-kilos">
            <i class="fa-solid fa-arrow-left"></i> Regresar</a>
    </div>

    <form method="POST" class="formulario">

        <?php include_once __DIR__ . '/../../../templates/alertas.php' ?>

        <fieldset class="formulario__fieldset">

            <legend class="formulario__legend">Información del Producto</legend>

            <div class="formulario__campo">
                <label for="nombre" class="formulario__label">Nombre</label>
                <input type="text" id="nombre" name="nombre" class="formulario__input" placeholder='Ej. KG TUBULAR 18 Y 20' value="<?php echo s($productoKilo->nombre) ?>">
            </div>

            <div class="formulario__campo">
                <label for="codigo" class="formulario__label">Código</label>
                <input type="text" id="codigo" name="codigo" class="formulario__input" placeholder='Ej. O1' value="<?php echo s($productoKilo->codigo) ?>">
            </div>

            <div class="formulario__campo">
                <label for="productosComerciales_id" class="formulario__label">Producto Asociado</label>
                <select class="formulario__input formulario__input--select" name="productosComerciales_id" id="productosComerciales_id">
                    <option value="" selected>--Seleccione una Opción--</option>
                    <?php foreach ($productos as $producto) { ?>
                        <option value="<?php echo $producto->id; ?>" <?php echo $productoKilo->productosComerciales_id == $producto->id ? 'selected' : '' ?>> <?php echo $producto->nombre; ?></option>
                    <?php } ?>
                </select>

                <a class="formulario__enlace" href="/admin/producto-comercial">Gestionar Productos Producción</a>

            </div>



        </fieldset>




        <div class="flex-centro">
            <input class="btn-submit" type="submit" value="Actualizar producto" id="submit-crear">
        </div>

    </form>
</div>

<?php include_once __DIR__ . '/../../../templates/footer-dashboard.php' ?>