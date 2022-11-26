<?php include_once __DIR__ . '/../../templates/header-dashboard.php'; ?>

<div class="contenedor">

    <div class="filtro">


        <div>
            <select class="filtro__select" id="select-categoria">
                <option value="" selected disabled>--Seleccione Una Categoria--</option>
                <?php foreach ($categorias as $categoria) { ?>
                    <option value="<?php echo $categoria->id; ?>"><?php echo $categoria->nombre; ?></option>
                <?php } ?>

            </select>

        </div>

        <a class="btn-agregar" href="/admin/categoria/crear">
            <i class="fa-solid fa-circle-plus"></i>
            Agregar Categoria
        </a>

    </div>

    <div class="flex-izquierda">
            <a class="formulario__enlace d-block" id="categoria-editar">Editar Nombre</a>
            <a class="formulario__enlace--eliminar  d-block" id="categoria-eliminar">Eliminar Categoria</a>
    </div>






    <div class="categorias__grid">
        <table id='ganancias' class="table ">
            <tbody class="table__body">

            </tbody>
        </table>
        <table id='impuestos' class="table ">
            <tbody class="table__body">

            </tbody>
        </table>
    </div>

</div>




<?php include_once __DIR__ . '/../../templates/footer-dashboard.php' ?>