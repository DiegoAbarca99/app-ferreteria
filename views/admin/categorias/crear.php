<?php include_once __DIR__ . '/../../templates/header-dashboard.php'; ?>
<div class="contenedor">
    <div class="flex-izquierda">
        <a class="btn-regresar" href="/admin/categoria">
            <i class="fa-solid fa-arrow-left"></i> Regresar</a>
    </div>

    <form method="POST" class="formulario">
        <?php include_once __DIR__ . '/../../templates/alertas.php'; ?>

        <fieldset class="formulario__fieldset">
            <legend class="formulario__legend">Nombre de la Categoría</legend>
            <div class="formulario__campo">
                <label for="nombre" class="formulario__label">Nombre</label>
                <input type="text" id="nombre" name="nombre" class="formulario__input" placeholder="Ej. Metales" value="<?php echo s($categoria->nombre); ?>">
            </div>
        </fieldset>

        <fieldset class="formulario__fieldset">
            <legend class="formulario__legend">Porcentajes de Ganancia</legend>

            <p class="formulario__descripcion">
                Ingrese las ganancias asociadas a los precios comerciales de los productos (%).
            </p>
            <div class="formulario__contenedor-campos">
                <div class="formulario__campo">
                    <label for="publico1" class="formulario__label">Publico1</label>
                    <input step="any" class="formulario__input" type="number" name="gananciapublico1" id="publico1" min='0' placeholder="EJ. 5"  value="<?php echo s($ganancias->gananciapublico1); ?>">
                </div>

                <div class="formulario__campo">
                    <label for="hererro2" class="formulario__label">Herrero2</label>
                    <input step="any" class="formulario__input" type="number" name="gananciaherrero2" id="hererro2" min='0' placeholder="EJ. 5" value="<?php echo s($ganancias->gananciaherrero2); ?>">
                </div>

                <div class="formulario__campo">
                    <label for="herrero3" class="formulario__label">Herrero3</label>
                    <input step="any" class="formulario__input" type="number" name="gananciaherrero3" id="herrero3" min='0' placeholder="EJ. 5" value="<?php echo s($ganancias->gananciaherrero3); ?>">
                </div>

                <div class="formulario__campo">
                    <label for="herrero4" class="formulario__label">Herrero4</label>
                    <input step="any" class="formulario__input" type="number" name="gananciaherrero4" id="herrero4" min='0' placeholder="EJ. 5" value="<?php echo s($ganancias->gananciaherrero4); ?>">
                </div>

                <div class="formulario__campo">
                    <label for="mayoreo1" class="formulario__label">Mayoreo1</label>
                    <input step="any" class="formulario__input" type="number" name="gananciamayoreo1" id="mayoreo1" min='0' placeholder="EJ. 5" value="<?php echo s($ganancias->gananciamayoreo1); ?>">
                </div>

                <div class="formulario__campo">
                    <label for="mayoreo2" class="formulario__label">Mayoreo2</label>
                    <input step="any" class="formulario__input" type="number" name="gananciamayoreo2" id="mayoreo2" min='0' placeholder="EJ. 5" value="<?php echo s($ganancias->gananciamayoreo2); ?>">
                </div>

            </div>

        </fieldset>

        <fieldset class="formulario__fieldset">
            <legend class="formulario__legend">Impuestos</legend>

            <p class="formulario__descripcion">
                Ingrese los valores correspondientes a los impuestos aplicados a los productos.
            </p>

            <div class="formulario__contenedor-campos">
                <div class="formulario__campo">
                    <label for="iva" class="formulario__label">Iva</label>
                    <input step="any" class="formulario__input" type="number" name="iva" id="iva" min='0' placeholder="EJ. 5" value="<?php echo s($impuestos->iva); ?>"> 
                </div>

                <div class="formulario__campo">
                    <label for="flete" class="formulario__label">Flete</label>
                    <input step="any" class="formulario__input" type="number" name="flete" id="flete" min='0' placeholder="EJ. 5" value="<?php echo s($impuestos->flete); ?>">
                </div>

                <div class="formulario__campo">
                    <label for="descarga" class="formulario__label">Descarga</label>
                    <input step="any" class="formulario__input" type="number" name="descarga" id="descarga" min='0' placeholder="EJ. 5" value="<?php echo s($impuestos->descarga); ?>">
                </div>

                <div class="formulario__campo">
                    <label for="seguro" class="formulario__label">Seguro</label>
                    <input step="any" class="formulario__input" type="number" name="seguro" id="seguro" min='0' placeholder="EJ. 5" value="<?php echo s($impuestos->seguro); ?>">
                </div>

            </div>

        </fieldset>

        <div class="flex-centro">
            <input class="btn-submit" type="submit" value="crear categoria">
        </div>

    </form>

</div>




<?php include_once __DIR__ . '/../../templates/footer-dashboard.php' ?>