<?php include_once __DIR__ . '/../../templates/header-dashboard.php'; ?>
<div class="contenedor">
    <div class="flex-izquierda">
        <a class="btn-regresar" href="/admin/producto-comercial">
            <i class="fa-solid fa-arrow-left"></i> Regresar</a>
    </div>

    <form method="POST" class="formulario">

        <?php include_once __DIR__ . '/formulario.php'; ?>
        
        <input type="hidden" id="input-actualizar" value="<?php echo $producto->id ?>">

        <div class="flex-centro">
            <input class="btn-submit" type="submit" value="actualizar producto" id="submit-actualizar">
        </div>

    </form>
</div>

<?php include_once __DIR__ . '/../../templates/footer-dashboard.php' ?>