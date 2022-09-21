<?php include_once __DIR__ . '/../templates/header-dashboard.php'; ?>
<div class="contenedor">
    <div class="flex-izquierda">
        <a class="regresar" href="/perfiles/index"> &lArr; Regresar</a>
    </div>
    <form class="formulario formulario-crear-cuenta">

        <div class="fieldset-grid">
            <fieldset id="campos">
                <legend>Datos de la Cuenta</legend>

                <div class="campo">
                    <label for="usuario">Usuario</label>
                    <input type="text" name="usuario" id="usuario" placeholder="Nombre de Usuario" value="<?php echo s($usuario->usuario)?>" disabled>
                </div>


                <div class="campo">
                    <label for="status">Status</label>
                    <p><?php echo $usuario->status==='1'?'Proveedor':'Oficina'?></p>
                </div>



            </fieldset>
            <fieldset>
                <legend>Datos de Contacto</legend>

                <div class="campo">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" id="nombre" placeholder="Nombre Completo" value="<?php echo s($usuario->nombre)?>" disabled>
                </div>

                <div class="campo">
                    <label for="telefono">Teléfono</label>
                    <input type="tel" name="telefono" id="telefono" placeholder="Número de Teléfono" value="<?php echo s($usuario->telefono)?>" disabled>
                </div>

                <div class="campo">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" placeholder="Email" value="<?php echo s($usuario->email)?>" disabled>
                </div>

                <div class="campo">
                    <label for="surcursal">Surcursal</label>
                    <input type="text" name="surcursal" id="surcursal" placeholder="Surcursal" value="<?php echo s($usuario->surcursal)?>" disabled>
                </div>


            </fieldset>

        </div>
    </form>

    <div class="flex-centro contenedor">
        <a class="btn btn-editar" href="/perfiles/editar?id=<?php echo $usuario->id ?>">Editar</a>
        <form >
            <input id="id" type="hidden" name="id" value="<?php echo $usuario->id ?>">
            <input id="eliminar" class="btn btn-eliminar" type="submit" value="Eliminar">
        </form>
    </div>
</div>
<?php include_once __DIR__ . '/../templates/footer-dashboard.php' ?>