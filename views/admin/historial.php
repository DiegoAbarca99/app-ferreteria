<?php include_once __DIR__.'/../templates/header-dashboard.php';?>

<div class="contenedor">
<div class="contenedor-sombra mt-4">
        <?php if (empty($historico)) { ?>
            <p class="text-center">Tabla copiada de los usuarios para gestionar, esperando a realizar la tabla de historial y trabajar con ella</p>
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