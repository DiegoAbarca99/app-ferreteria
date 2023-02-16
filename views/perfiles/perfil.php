<?php include_once __DIR__ . '/../templates/header-dashboard.php'; ?>
<div class="contenedor">
    <div class="flex-izquierda">
        <a class="btn-regresar" href="/perfiles/index">
            <i class="fa-solid fa-arrow-left"></i> Regresar</a>
    </div>
    <form class="formulario ">

        <div class="fieldset-grid">
            <fieldset class="formulario__fieldset">
                <legend class="formulario__legend">Datos de la Cuenta</legend>

                <div class="formulario__campo">
                    <label class="formulario__label" for="usuario">Usuario</label>
                    <input disabled class="formulario__input" type="text" name="usuario" id="usuario" placeholder="Nombre de Usuario" value="<?php echo s($usuario->usuario) ?>">
                </div>

                <div class="formulario__campo">
                    <label class="formulario__label" for="password">Password</label>
                    <input disabled class="formulario__input" type="password" name="password" id="password" placeholder="Ingrese Password" value="*******">
                </div>

                <div class="formulario__campo">
                    <label class="formulario__label" for="password2">Password</label>
                    <input disabled class="formulario__input" type="password" name="password2" id="password2" placeholder="Confirme el Password" value="*******">
                </div>

                <div class="formulario__campos-grid">

                    <div class="formulario__campo">
                        <label for="status">Status</label>
                        <p><?php echo $usuario->status === '1' ? 'Proveedor' : 'Oficina' ?></p>
                    </div>

                   <?php if ($usuario->status === '1') { ?>
                        <div class="formulario__campo">
                            <label for="status">Nivel de Acesso</label>
                            <p><?php echo $usuario->nivel === '0' ? 'Regular' : 'Privilegiado'?></p>
                        </div>
                    <?php } ?>
                   

                </div>

            </fieldset>

            <fieldset class="formulario__fieldset">
                <legend class="formulario__legend">Datos de Contacto</legend>

                <div class="formulario__campo">
                    <label class="formulario__label" for="nombre">Nombre</label>
                    <input disabled class="formulario__input" type="text" name="nombre" id="nombre" placeholder="Nombre Completo" value="<?php echo s($usuario->nombre) ?>">
                </div>

                <div class="formulario__campo">
                    <label class="formulario__label" for="telefono">Teléfono</label>
                    <input disabled class="formulario__input" type="tel" name="telefono" id="telefono" placeholder="Número de Teléfono" value="<?php echo s($usuario->telefono) ?>">
                </div>

                <div class="formulario__campo">
                    <label class="formulario__label" for="email">Email</label>
                    <input disabled class="formulario__input" type="email" name="email" id="email" placeholder="Email" value="<?php echo s($usuario->email) ?>">
                </div>

                <div class="formulario__campo">
                    <label class="formulario__label" for="sucursal">Sucursal</label>
                    <input disabled class="formulario__input" type="text" name="surcursal" id="sucursal" placeholder="Surcursal" value="<?php echo s($sucursal->nombre) ?>">
                </div>


            </fieldset>

        </div>
    </form>


    <div class="flex-centro contenedor">
        <a class="btn btn-editar" href="/perfiles/editar?id=<?php echo $usuario->id ?>">Editar</a>
        <form>
            <input id="id" type="hidden" name="id" value="<?php echo $usuario->id ?>">
            <input id="eliminar-perfil" class="btn btn-eliminar" type="submit" value="Eliminar">
        </form>
    </div>
</div>
<?php include_once __DIR__ . '/../templates/footer-dashboard.php' ?>