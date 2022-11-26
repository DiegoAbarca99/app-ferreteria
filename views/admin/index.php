<?php include_once __DIR__ . '/../templates/header-dashboard.php'; ?>

<main class="contenedor  bloques">
    <div class="bloques__grid">
        <a class="bloque" href="#">
            <div class="bloque__contenido">
                <h3 class="bloque__heading">Productos Proveedores</h3>
            </div>
        </a>

        <a class="bloque" href="/admin/producto-comercial">
            <div class="bloque__contenido">
                <h3 class="bloque__heading">Productos Producción </h3>
            </div>
        </a>

        <a class="bloque" href="/admin/acero">
            <div class="bloque__contenido">
                <h3 class="bloque__heading">Tipos de Aceros</h3>
            </div>
        </a>

        <a class="bloque" href="/admin/categoria">
            <div class="bloque__contenido">
                <h3 class="bloque__heading">Impuestos y Ganancias</h3>
            </div>
        </a>
    </div>

</main>

<?php include_once __DIR__ . '/../templates/footer-dashboard.php' ?>