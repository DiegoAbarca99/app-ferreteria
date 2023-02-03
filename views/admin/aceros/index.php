<?php include_once __DIR__ . '/../../templates/header-dashboard.php'; ?>


<div class="contenedor">
    <?php include_once __DIR__ . '/../../templates/filtros-admin.php' ?>
    <?php if (empty($aceros)) { ?>
        <p class="text-center">No Hay Ningún Producto Que Pueda Gestionar Aún</p>
    <?php } else { ?>
        <!--Variables de inicio que permiten diferenciar un cambio de categoria o descripción lo que supone la creación de una Tabla-->
        <?php $categoriaId = 0 ?>
        <?php $descripcionId = 0 ?>
        <?php foreach ($categorias as $categoria) { ?>
            <?php if (isset($aceros[$categoria->id])) { ?>
                <?php $contador = 0; ?>
                <!--Contador se emple como auxiliar para saber cuando el arreglo de aceros formateados está en su ultimo elemento por categoria cafificada-->
                <?php foreach ($aceros[$categoria->id] as $acero) { ?>
                    <?php if ($categoriaId != $acero->categoriaacero_id || $descripcionId != $acero->descripcionacero_id) { ?>
                        <table class="table contenedor-sombra mt-4">

                            <?php if ($categoriaId == $acero->categoriaacero_id) { ?>

                                <caption class="table__caption"><span> Descripción <i class="fa-solid fa-arrow-right"></i> </span><?php echo $acero->descripcion->descripcion; ?></caption>

                            <?php } else { //Escenario por diferencia de categorias
                            ?>
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
                                <tbody class="table__body">
                                <?php } ?>
                            <?php } //Reasignación de valores para comparar el valor actual con el previo, y así continuar apilando registros o crear una nueva tabla
                            ?>
                            <?php $categoriaId = $acero->categoriaacero_id; ?>
                            <?php $descripcionId = $acero->descripcionacero_id; ?>


                            <tr class="table__tr">
                                <td class="table__td "> <?php echo $acero->nombre ?></td>
                                <td class="table__td table__td--prolamsa"> <?php echo $acero->prolamsa ?></td>
                                <td class="table__td table__td--slp"> <?php echo $acero->slp ?></td>
                                <td class="table__td table__td--arcoMetal"> <?php echo $acero->arcoMetal ?></td>

                                <td class="table__td--acciones">
                                    <a class="table__accion table__accion--editar editar-acero" href="/admin/acero/actualizar?id=<?php echo $acero->id ?>">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                        Editar
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

                            <!--Cierre de la tabla actual-->
                            <?php if (!isset($aceros[$categoria->id][$contador + 1])) { ?>
                                </tbody>
                        </table>
                    <?php } ?>
                    <?php $contador++; ?>
                <?php } ?>
            <?php } ?>
        <?php } ?>
    <?php } ?>
</div>


<?php include_once __DIR__ . '/../../templates/footer-dashboard.php' ?>