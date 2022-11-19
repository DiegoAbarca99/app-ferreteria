<?php include_once __DIR__ . '/../../templates/header-dashboard.php'; ?>


<div class="contenedor">
    <div class="filtro">

        <select class="filtro__select" id="select-acero">
            <option value="" selected disabled>--Seleccione Una Categoria--</option>
            <option value="">Seleccionar Todas</option>
            <?php foreach ($categorias as $categoria) { ?>
                <option value="<?php echo $categoria->id; ?>"><?php echo $categoria->categoria; ?></option>
            <?php } ?>
        </select>

        <a class="btn-agregar" href="/admin/acero/crear">
            <i class="fa-solid fa-circle-plus"></i>
            Agregar Tipo
        </a>


    </div>
    <?php if (empty($aceros)) { ?>
        <p class="text-center">No Hay Ningún Producto Que Pueda Gestionar Aún</p>
    <?php } else { ?>
        <?php $categoriaId = 0 ?>
        <?php $descripcionId = 0 ?>
        <?php foreach ($categorias as $categoria) { ?>
            <?php if (isset($aceros[$categoria->id])) { ?>
                <?php $contador = 0; ?>
                <?php foreach ($aceros[$categoria->id] as $acero) { ?>
                    <?php if ($categoriaId != $acero->categoriaacero_id) { ?>
                        <table class="table contenedor-sombra">

                            <caption class="table__caption table__caption--resaltar"><span> Categoria <i class="fa-solid fa-arrow-right"></i> </span><?php echo $acero->categoria->categoria; ?></caption>
                            <caption class="table__caption"><span> Descripción <i class="fa-solid fa-arrow-right"></i> </span><?php echo $acero->descripcion->descripcion; ?></caption>

                            <thead class="table__head">

                                <tr>
                                    <th class="table__th ">Nombre</th>
                                    <th class="table__th">Prolamsa</th>
                                    <th class="table__th ">SLP</th>
                                    <th class="table__th">ArcoMetal</th>
                                    <th class="table__th"></th>
                                </tr>
                            </thead>
                        <?php } ?>
                        <?php $categoriaId = $acero->categoriaacero_id; ?>
                        <?php $descripcionId = $acero->descripcionacero_id; ?>
                        <tbody class="table__body">

                            <tr class="table__tr">
                                <td class="table__td "> <?php echo $acero->nombre ?></td>
                                <td class="table__td table__td--prolamsa"> <?php echo $acero->prolamsa ?></td>
                                <td class="table__td table__td--slp"> <?php echo $acero->slp ?></td>
                                <td class="table__td table__td--arcoMetal"> <?php echo $acero->arcoMetal ?></td>

                                <td class="table__td--acciones">
                                    <a class="table__accion table__accion--editar" href="/admin/acero/actualizar?id=<?php echo $acero->id ?>">
                                        <i class="fa-solid fa-eye"></i>
                                        Ver
                                    </a>

                                    <form action="/admin/acero/eliminar" method="POST" class="table__formulario">
                                        <input type="hidden" class="id" value="<?php echo $acero->id ?>">
                                        <button class="table__accion table__accion--eliminar eliminar-tipoAcero" type="submit">
                                            <i class="fa-solid fa-circle-xmark"></i>
                                            Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        </tbody>
                        <?php if (!isset($aceros[$categoria->id][$contador + 1])) { ?>
                        </table>
                    <?php } ?>
                    <?php $contador++; ?>
                <?php } ?>
            <?php } ?>
        <?php } ?>
    <?php } ?>
</div>


<?php include_once __DIR__ . '/../../templates/footer-dashboard.php' ?>