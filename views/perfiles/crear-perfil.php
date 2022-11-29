<?php include_once __DIR__ . '/../templates/header-dashboard.php'; ?>
<div class="contenedor">
    <div class="flex-izquierda">
        <a class="btn-regresar" href="/perfiles/index">
            <i class="fa-solid fa-arrow-left"></i> Regresar</a>
    </div>
    <form class="formulario " method="POST" novalidate>
        <?php include_once __DIR__ . '/../templates/alertas.php'; ?>

        <?php include_once __DIR__ . '/formulario.php' ?>

        <div class="flex-centro">
            <input class="btn-submit" type="submit" value="crear cuenta">
        </div>


    </form>
</div>
<?php include_once __DIR__ . '/../templates/footer-dashboard.php' ?>