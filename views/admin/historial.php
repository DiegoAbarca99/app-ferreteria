<?php include_once __DIR__.'/../templates/header-dashboard.php';?>

<div class="contenedor">
<?php include_once __DIR__ . '/../templates/alertas.php' ?>
<div id="pedido">
        <div class="seccion" id="paso-1">


                <div class="filtro">

                    <form method="POST" class="filtro__buscador" id="buscador-cliente" >
                        <input id="buscar-cliente" name='busqueda' type="text" class="filtro__input" placeholder="Buscar usuario modificado">
                        <input type="submit" class="filtro__submit" name='enviar' value="Buscar">

                    </form>


                </div>
                <!-- Tabla que muestra la búsqueda por nombre de usuario modificado -->
                <?php if($consulta) { ?>
                <div class="contenedor-sombra mt-4">
                    <table class="table">
                <thead class="table__head">
                    <tr>
                        <th class="table__th table__th--ocultar">Modificó</th>
                        <th class="table__th">Usuario modificado</th>
                        <th class="table__th table__th--ocultar">ID Surcursal (usuario modificado)</th>
                        <th class="table__th">Acción</th>
                        <th class="table__th">detalles de la modificación</th>
                        <th class="table__th">Fecha de modificación</th>
                    </tr>
                </thead>

                <tbody class="table__body">
                    <?php foreach ($consulta as $cons) { ?>
                        <tr class="table__tr">
                            <td class="table__td table__td--ocultar"> <?php echo $cons->usuario ?></td>
                            <td class="table__td"> <?php echo $cons->nombre ?></td>
                            <td class="table__td table__td--ocultar"> <?php echo $cons->sucursal ?></td>
                            <td class="table__td "> <?php echo $cons->accion ?></td>
                            <td class="table__td "> <?php echo $cons->detalles ?></td>
                            <td class="table__td "> <?php echo $cons->fecha ?></td>
                        
                        </tr>

                    <?php } ?>
                </tbody>
            </table>
                <?php } ?>
            </div>  
                
        </div>
<div class="contenedor-sombra mt-4">
        <?php if (empty($historico)) { ?>
            <p class="text-center">Aún no hay modificaciones importantes</p>
        <?php } else { ?>
            <table class="table">
                <thead class="table__head">
                    <tr>
                        <th class="table__th table__th--ocultar">Modificó</th>
                        <th class="table__th">Usuario modificado</th>
                        <th class="table__th table__th--ocultar">ID Surcursal (usuario modificado)</th>
                        <th class="table__th">Acción</th>
                        <th class="table__th">detalles de la modificación</th>
                        <th class="table__th">Fecha de modificación</th>
                    </tr>
                </thead>

                <tbody class="table__body">
                    <?php foreach ($historico as $historial) { ?>
                        <tr class="table__tr">
                            <td class="table__td table__td--ocultar"> <?php echo $historial->usuario ?></td>
                            <td class="table__td"> <?php echo $historial->nombre ?></td>
                            <td class="table__td table__td--ocultar"> <?php echo $historial->sucursal ?></td>
                            <td class="table__td "> <?php echo $historial->accion ?></td>
                            <td class="table__td "> <?php echo $historial->detalles ?></td>
                            <td class="table__td "> <?php echo $historial->fecha ?></td>
                        
                        </tr>

                    <?php } ?>
                </tbody>
            </table>
        <?php } ?>
    </div>
</div>

<?php include_once __DIR__.'/../templates/footer-dashboard.php' ?>