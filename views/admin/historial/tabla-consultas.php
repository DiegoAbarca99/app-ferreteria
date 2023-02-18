<div class="contenedor-sombra mt-4">
    <?php if (empty($consultas)) { ?>
        <p class="text-center">Aún no hay modificaciones importantes</p>
    <?php } else { ?>
        <table class="table">
            <thead class="table__head">
                <tr>
                    <th class="table__th">Modificó</th>
                    <th class="table__th">Surcursal</th>
                    <th class="table__th">Entidad Modificada</th>
                    <th class="table__th">Acción</th>
                    <th class="table__th">Valor Anterior</th>
                    <th class="table__th">Valor Actual</th>
                    <th class="table__th">Fecha de modificación</th>
                </tr>
            </thead>
            <tbody class="table__body">
                <?php foreach ($consultas as $consulta) { ?>
                    <tr class="table__tr">
                        <td class="table__td "> <?php echo $consulta->usuario->usuario ?></td>
                        <td class="table__td"> <?php echo $consulta->sucursal->nombre ?></td>
                        <td class="table__td"> <?php echo $consulta->entidadModificada ?></td>
                        <td class="table__td "> <?php echo $consulta->accion ?></td>
                        <td class="table__td "> <?php echo $consulta->valorAnterior ?></td>
                        <td class="table__td "> <?php echo $consulta->valorNuevo ?></td>
                        <td class="table__td "> <?php echo $consulta->fecha ?></td>
                    </tr>

                <?php } ?>
            </tbody>
        </table>
    <?php } ?>
</div>