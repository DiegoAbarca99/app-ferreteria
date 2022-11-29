<?php include_once __DIR__ . '/../../templates/header-dashboard.php'; ?>
<div class="contenedor">
    <div class="filtro">

        <select class="filtro__select" id="select-producto-proveedor">
            <option value="" selected disabled>--Seleccione Una Categoria--</option>
            <option value="">Seleccionar Todas</option>
            <?php foreach ($categorias as $categoria) { ?>
                <option value="<?php echo $categoria->id; ?>"><?php echo $categoria->nombre; ?></option>
            <?php } ?>
        </select>

        <form class="filtro__buscador">
            <input type="text" class="filtro__input" placeholder="Buscar por Nombre">
            <input type="submit" class="filtro__submit" value="Buscar" id="buscador">

        </form>

        <a class="btn-agregar" href="/admin/producto-proveedor/crear">
            <i class="fa-solid fa-circle-plus"></i>
            Agregar Producto
        </a>


    </div>
    <?php if (empty($productos)) { ?>
        <p class="text-center">No Hay Ningún Producto Que Pueda Gestionar Aún</p>
    <?php } else { ?>
        <!--Variables de inicio que permite diferenciar un cambio de categoria lo que supone la creación de una Tabla-->
        <?php $categoriaId = 0 ?>
        <?php foreach ($categorias as $categoria) { ?>
            <?php if (isset($productos[$categoria->id])) { ?>
                <?php $contador = 0; ?>
                <!--Contador se emplea como auxiliar para saber cuando el arreglo de productos formateados está en su ultimo elemento por categoria cafificada-->
                <?php foreach ($productos[$categoria->id] as $key => $producto) { ?>
                    <?php if ($categoriaId != $producto->categoriaProductosProveedores_id) { ?>
                        <table class="table contenedor-sombra mt-4">

                            <caption class="table__caption table__caption--resaltar"><span> Categoria <i class="fa-solid fa-arrow-right"></i> </span><?php echo $producto->categoria->nombre; ?></caption>

                            <thead class="table__head">

                                <tr>
                                    <th class="table__th ">Nombre</th>
                                    <th class="table__th ">PesoP</th>
                                    <th class="table__th ">Peso</th>
                                    <th class="table__th">Publico1</th>
                                    <th class="table__th ">Herrero2</th>
                                    <th class="table__th ">Herrero3</th>
                                    <th class="table__th ">Herrero4</th>
                                    <th class="table__th">Mayoreo1</th>
                                    <th class="table__th">Mayoreo2</th>
                                    <th class="table__th"></th>
                                </tr>
                            </thead>
                            <tbody class="table__body">
                            <?php } //Reasignación de valores para comparar el valor actual con el previo, y así continuar apilando registros o crear una nueva tabla 
                            ?>
                            <?php $categoriaId = $producto->categoriaProductosProveedores_id; ?>


                            <tr class="table__tr">
                                <td class="table__td "> <?php echo $producto->nombre ?></td>
                                <td class="table__td "> <?php echo $producto->peso->pesoPromedio ?></td>
                                <td class="table__td  table__td--resaltar"> <?php echo $producto->peso->pesoNuevo ?></td>
                                <td class="table__td"> <?php echo $producto->precio->publico1 ?></td>
                                <td class="table__td"> <?php echo $producto->precio->herrero2 ?></td>
                                <td class="table__td"> <?php echo $producto->precio->herrero3 ?></td>
                                <td class="table__td"> <?php echo $producto->precio->herrero4 ?></td>
                                <td class="table__td"> <?php echo $producto->precio->mayoreo1 ?></td>
                                <td class="table__td"> <?php echo $producto->precio->mayoreo2 ?></td>

                                <td class="table__td--acciones">
                                    <a class="table__accion table__accion--editar" href="/admin/producto-proveedor/actualizar?id=<?php echo $producto->id ?>">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                        Editar
                                    </a>

                                    <form action="/api/producto-proveedor/eliminar" method="POST" class="table__formulario">
                                        <input type="hidden" class="eliminar-productoProveedor" value="<?php echo $producto->id ?>">
                                        <button class="table__accion table__accion--eliminar btn-eliminar" type="submit">
                                            <i class="fa-solid fa-circle-xmark"></i>
                                            Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <!--Cierre de la tabla actual-->
                            <?php if (!isset($productos[$categoria->id][$contador + 1])) { ?>
                            </tbody>
                        </table>
                    <?php } ?>
                    <?php $contador++; ?>
                <?php } ?>
            <?php } ?>
        <?php } ?>
    <?php } ?>

</div>
<?php include_once __DIR__ . '/../../templates/footer-dashboard.php'; ?>