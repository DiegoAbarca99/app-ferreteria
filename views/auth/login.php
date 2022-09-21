
<div class=" login">

   
    <div class="imagen-login">
        <picture>
            <source  srcset="build/img/login.webp" type="image/webp">
            <img  src="build/img/login.jpg" alt="Imagen del Login">
        </picture>
    </div>

    
    <h1 class="empresa">FerreTinoco</h1>
    <p class="tagline">Panel Administrativo</p>

    <div class="contenedor-formulario">

        <p class="descripcion-pagina">Iniciar Sesión</p>

        <?php include_once __DIR__.'/../templates/alertas.php' ?>

        <form action="/" method="POST" class="formulario" novalidate>
            <div class="campo">
                <label for="usuario">Usuario</label>
                <input type="text" name="usuario" id="usuario" placeholder="Tu Usuario">
            </div>

            <div class="campo">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Tu Password">
            </div>

            <input type="submit" class="boton" value="Iniciar Sesión">
        </form>

    </div>

</div>

