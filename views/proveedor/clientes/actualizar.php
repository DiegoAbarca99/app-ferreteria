<?php include_once __DIR__ . '/../../templates/header-dashboard.php'; ?>
<div class="contenedor">
    <div class="flex-izquierda">
        <a class="btn-regresar" href="<?php echo str_contains($_SERVER['HTTP_REFERER'], '/proveedor/clientes') ? '/proveedor/clientes' : '/proveedor/index' ?>">
            <i class="fa-solid fa-arrow-left"></i> Regresar</a>
    </div>

    <form method="POST" class="formulario">

        <?php include_once __DIR__ . '/../../templates/alertas.php' ?>

        <fieldset class="formulario__fieldset">

            <legend class="formulario__legend">Datos del Cliente</legend>

            <div class="formulario__campo">
                <label for="curp" class="formulario__label">Curp</label>
                <input type="text" id="curp" name="curp" class="formulario__input" placeholder='Introduzca su curp' value="<?php echo s($cliente->curp); ?>">
                <a href="https://www.gob.mx/curp/" target="_blank">Obtenlo aqui.</a>
            </div>




            <div class="formulario__campo">
                <label for="nombre" class="formulario__label">Nombre Completo</label>
                <input type="text" id="nombre" name="nombre" class="formulario__input" placeholder='Ej. Juan Perèz' value="<?php echo s($cliente->nombre); ?>">
            </div>

            <div class="formulario__campo">
                <label for="telefono" class="formulario__label">Telèfono</label>
                <input type="tel" id="telefono" name="telefono" class="formulario__input" placeholder='Ingrese su Teléfono' value="<?php echo s($cliente->telefono); ?>">
            </div>

            <div class="formulario__campo">
                <label for="rfc" class="formulario__label">RFC</label>
                <input type="text" id="rfc" name="rfc" class="formulario__input" placeholder='Ingrese su RFC' value="<?php echo s($cliente->rfc); ?>">
                <a href="https://www.mi-rfc.com.mx/consulta-rfc-homoclave" target="_blank">Obtenlo aqui.</a>
            </div>




        </fieldset>

        <fieldset class="formulario__fieldset">

            <legend class="formulario__legend">Ubicaciòn</legend>

            <div class="formulario__campo">
                <label for="codigoPostal" class="formulario__label">Código Postal</label>
                <input type="number" min="0" id="codigoPostal" name="codigoPostal" class="formulario__input" placeholder='Ingrese su Código Postal' value="<?php echo s($cliente->codigoPostal); ?>">
            </div>

            <div class="formulario__campo">
                <label for="estado" class="formulario__label">Estado</label>
                <input type="text" id="estado" name="estado" class="formulario__input" value="<?php echo s($cliente->estado); ?>">
            </div>

            <div class="formulario__campo">
                <label for="municipio" class="formulario__label">Municipio</label>
                <input type="text" id="municipio" name="municipio" class="formulario__input" value="<?php echo s($municipio->nombre); ?>">
            </div>

            <div class="formulario__campo">
                <label for="colonia" class="formulario__label">Colonia</label>
                <input type="text" id="colonia" name="colonia" class="formulario__input" placeholder='Ingrese su Colonia' value="<?php echo s($cliente->colonia); ?>">
            </div>

            <div class="formulario__campo">
                <label for="calle" class="formulario__label">Calle</label>
                <input type="text" id="calle" name="calle" class="formulario__input" placeholder='Ingrese su Calle' value="<?php echo s($cliente->calle); ?>">
            </div>

            <div class="formulario__contenedor-campos">
                <div class="formulario__campo">
                    <label for="numeroExterno" class="formulario__label">Numero Externo</label>
                    <input type="text" id="numeroExterno" name="numeroExterno" class="formulario__input" placeholder='Ingrese su número externo' value="<?php echo s($cliente->numeroExterno); ?>">
                </div>

                <div class="formulario__campo">
                    <label for="numeroInterno" class="formulario__label">Numero Interno</label>
                    <input type="text" id="numeroInterno" name="numeroInterno" class="formulario__input" placeholder='Ingrese su número interno' value="<?php echo s($cliente->numeroInterno); ?>">
                </div>

            </div>


        </fieldset>



        <fieldset class="formulario__fieldset">

            <legend class="formulario__legend">Información Extra</legend>

            <div class="formulario__contenedor-campos">
                <div class="formulario__campo">
                    <label class="formulario__label">Crèdito </label>
                    <p class="no-margin"><?php echo $cliente->credito == 1 ? 'Activo' : 'Inactivo'; ?></p>
                </div>


                <div class="formulario__campo">
                    <label for="cuotaConsumo" class="formulario__label">Cuota Consumo</label>
                    <input type="number" min="0" step="any" id="cuotaConsumo" name="cuotaConsumo" class="formulario__input" placeholder="Ingrese la cuota" value="<?php echo s($cliente->cuotaConsumo); ?>">
                </div>

            </div>



        </fieldset>




        <div class="flex-centro">
            <input class="btn-submit" type="submit" value="Guardar Cambios">
        </div>

        <div class="flex-centro">
            <button class="btn btn-eliminar d-block w-auto mt-2" id="eliminar-cliente" value="<?php echo $cliente->id; ?>">Eliminar</button>

        </div>

    </form>
</div>


<?php include_once __DIR__ . '/../../templates/footer-dashboard.php' ?>