<?php include_once __DIR__ . '/../../templates/header-dashboard.php' ?>
<div class="contenedor">
    <?php if ($tokenInvalido) { ?>
        <div class="alerta--error">
            <p class="text-center">Token Invalido </p>
        </div>
    <?php } else { ?>
        <div class="alerta--exito">
            <p class="text-center">El status del proveedor ha sido actualizado correctamente</p>
        </div>
    <?php } ?>
</div>

<?php include_once __DIR__ . '/../../templates/footer-dashboard.php' ?>