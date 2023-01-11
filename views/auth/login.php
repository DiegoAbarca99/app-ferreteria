<div class="login contenedor">

    <?php include_once __DIR__ . '/../templates/alertas.php' ?>

    <h1 class="login__titulo">FerreTinoco</h1>
    <p class="login__tagline">¡Bienvenido!, Comienza a Gestionar tu Negocio</p>
    <p class="login__descripcion">Iniciar Sesión</p>



    <div class="login__contenedor">



        <form action="/" method="POST" class="formulario" novalidate>
            <div class="formulario__campo">
                <label class="formulario__label" for="usuario">Usuario</label>
                <input class="formulario__input" type="text" name="usuario" id="usuario" placeholder="Tu Usuario">
            </div>

            <div class="formulario__campo">
                <label class="formulario__label" for="password">Password</label>
                <input class="formulario__input" type="password" name="password" id="password" placeholder="Tu Password">
            </div>

            <div class="flex-centro">
                <input type="submit" class="btn-submit" value="Iniciar Sesión">
            </div>

        </form>

    </div>

    <footer class="login__footer flex-centro">
        <p class="footer"> Ferretinoco - <span class="footer--regular">Todos los derechos reservados <?php echo date('Y') ?></span> </p>
    </footer>

</div>