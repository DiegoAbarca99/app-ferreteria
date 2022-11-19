<?php include_once __DIR__ . '/../../templates/header-dashboard.php'; ?>
<div class="flex-derecha">
    <a class="btn-agregar" href="/admin/categoria/crear">
        <i class="fa-solid fa-circle-plus"></i>
        Agregar Categoria
    </a>
</div>

<div class="categorias contenedor" id="categorias">

</div>

<div class="categorias__grid">
    <div id='ganancias' class="categoria"></div>
    <div id='impuestos' class="categoria"></div>
</div>



<?php include_once __DIR__ . '/../../templates/footer-dashboard.php' ?>