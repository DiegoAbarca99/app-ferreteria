<?php include_once __DIR__ . '/../templates/header-dashboard.php'; ?>
<div class="contenedor">
    <div class="flex-derecha">
        <a class="btn-agregar" href="/perfiles/crear">
            <i class="fa-solid fa-circle-plus"></i>
            Crear Perfil
        </a>
    </div>

    <div class="contenedor-sombra mt-4">
        <?php if (empty($usuarios)) { ?>
            <p class="text-center">No Hay Usuarios Que Pueda Gestionar Aún</p>
        <?php } else { ?>
            <table class="table">
                <thead class="table__head">
                    <tr>
                        <th class="table__th table__th--ocultar">Usuario</th>
                        <th class="table__th">Nombre Completo</th>
                        <th class="table__th table__th--ocultar">Surcursal</th>
                        <th class="table__th">Status</th>
                        <th class="table__th"></th>
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
                                <a class="table__accion table__accion--editar" href="/perfiles/perfil?id= <?php echo $usuario->id ?>">
                                    <i class="fa-solid fa-eye"></i>
                                    Ver
                                </a>

                                <form action="/perfiles/eliminar" method="POST" class="table__formulario">
                                    <input type="hidden" id="id" value="<?php echo $usuario->id ?>">
                                    <button class="table__accion table__accion--eliminar eliminar-perfil" type="submit">
                                        <i class="fa-solid fa-circle-xmark"></i>
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>

                    <?php } ?>
                </tbody>
            </table>
        <?php } ?>
    </div>

    <?php
    echo $paginacion;
    ?>
</div>

<?php include_once __DIR__ . '/../templates/footer-dashboard.php' ?>