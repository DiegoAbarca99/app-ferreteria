<?php include_once __DIR__ . '/../../templates/header-dashboard.php'; ?>
<div class="contenedor">
    <div class="flex-izquierda">
        <a class="btn-regresar" href="/admin/producto-proveedor">
            <i class="fa-solid fa-arrow-left"></i> Regresar</a>
    </div>

    <form method="POST" class="formulario">

        <?php include_once __DIR__ . '/../../templates/alertas.php'; ?>

        <fieldset class="formulario__fieldset">

            <legend class="formulario__legend">Información del Producto</legend>

            <div class="formulario__campo">
                <label for="nombre" class="formulario__label">Nombre</label>
                <input type="text" id="nombre" name="nombre" class="formulario__input" placeholder='Ej. 3x6 C-16' value="<?php echo s($productoProveedor->nombre); ?>">
            </div>

            <div class="formulario__campo">
                <label for="categoriaProductosProveedores_id" class="formulario__label">Categoria</label>
                <select class="formulario__input formulario__input--select" name="categoriaProductosProveedores_id" id="categoriaProductosProveedores_id">
                    <option value="" selected>--Seleccione una Opción--</option>
                    <?php foreach ($categorias as $categoria) { ?>
                        <option value="<?php echo $categoria->id; ?>" <?php echo $productoProveedor->categoriaProductosProveedores_id == $categoria->id ? 'selected' : '' ?>> <?php echo $categoria->nombre; ?></option>
                    <?php } ?>
                </select>

                <a class="formulario__enlace" id="categoria-producto">Añadir Categoria</a>
                <a class="formulario__enlace--eliminar" id="categoria-producto-eliminar">Eliminar Categoria</a>

            </div>

            <div class="formulario__campo">
                <label for="productosComerciales_id" class="formulario__label">Producto en Producción Asociado</label>
                <select class="formulario__input formulario__input--select" name="productosComerciales_id" id="productosComerciales_id">
                    <option value="" selected>--Seleccione una Opción--</option>
                    <?php foreach ($productos as $producto) { ?>
                        <option value="<?php echo $producto->id; ?>" <?php echo $productoProveedor->productosComerciales_id == $producto->id ? 'selected' : '' ?>> <?php echo $producto->nombre; ?></option>
                    <?php } ?>
                </select>

            </div>


        </fieldset>




        <div class="flex-centro">
            <input class="btn-submit" type="submit" value="actualizar producto" id="submit-crear">
        </div>

    </form>
</div>

<?php include_once __DIR__ . '/../../templates/footer-dashboard.php' ?>