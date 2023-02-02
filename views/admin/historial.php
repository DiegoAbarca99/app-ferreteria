<?php include_once __DIR__.'/../templates/header-dashboard.php';?>

<div class="contenedor">
<div class="contenedor-sombra mt-4">
        <?php if (empty($usuarios)) { ?>
            <p class="text-center">Tabla copiada de los usuarios para gestionar, esperando a realizar la tabla de historial y trabajar con ella</p>
        <?php } else { ?>
            <table class="table">
                <thead class="table__head">
                    <tr>
                        <th class="table__th table__th--ocultar">Usuario</th>
                        <th class="table__th">Nombre Completo</th>
                        <th class="table__th table__th--ocultar">Surcursal</th>
                        <th class="table__th">Acción</th>
                        <th class="table__th">detalles de la modificación</th>
                        <th class="table__th">Fecha de modificación</th>
                    </tr>
                </thead>

                <tbody class="table__body">
                    <?php foreach ($usuarios as $usuario) { ?>
                        <tr class="table__tr">
                            <td class="table__td table__td--ocultar"> <?php echo $usuario->usuario ?></td>
                            <td class="table__td"> <?php echo $usuario->nombre ?></td>
                            <td class="table__td table__td--ocultar"> <?php echo $usuario->surcursal ?></td>
                            <td class="table__td "> <?php echo $usuario->status === '1' ? 'Proveedor' : 'Oficina' ?></td>
                            <td class="table__td--acciones">
                        </tr>

                    <?php } ?>
                </tbody>
            </table>
        <?php } ?>
    </div>
</div>

<?php include_once __DIR__.'/../templates/footer-dashboard.php' ?>