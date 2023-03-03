<div class="login">

    <div class="login__contenedor">
        <?php include_once __DIR__ . '/../templates/alertas.php' ?>

        <h1 class="login__titulo">FerreTinoco</h1>




        <div class="login__contenedor-formulario">

            <div class="flex-centro-col ">
                <p class="login__descripcion">Iniciar Sesión</p>

                <i class="fa-solid fa-right-to-bracket login__icono "></i>

            </div>

            <form action="/" method="POST" class="formulario mt-3" novalidate>

                <div class="formulario__campo--icono">
                    <i class="fa-solid fa-user formulario__icono"></i>
                    <input class="formulario__input" type="text" name="usuario" id="usuario" placeholder="Tu Usuario">
                </div>

                <div class="formulario__campo--icono">
                    <i class="fa-solid fa-key formulario__icono"></i>
                    <input class="formulario__input" type="password" name="password" id="password" placeholder="Tu Password">
                </div>


                <input type="submit" class="login__boton" value="Iniciar Sesión">


            </form>

        </div>

        <footer class="login__footer flex-centro">
            <p class="footer"> Ferretinoco<span class="footer--regular"> - Todos los derechos reservados <?php echo date('Y') ?></span> </p>
        </footer>

    </div>



</div>