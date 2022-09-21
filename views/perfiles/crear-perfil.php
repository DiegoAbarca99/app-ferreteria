<?php include_once __DIR__ . '/../templates/header-dashboard.php'; ?>
<div class="contenedor">
    <div class="flex-izquierda">
        <a class="regresar" href="/perfiles/index"> &lArr; Regresar</a>
    </div>
    <form class="formulario formulario-crear-cuenta" method="POST" novalidate>
        <?php include_once __DIR__.'/../templates/alertas.php'; ?>

        <div class="fieldset-grid">
            <fieldset id="campos">
                <legend>Datos de la Cuenta</legend>

                <div class="campo">
                    <label for="usuario">Usuario</label>
                    <input type="text" name="usuario" id="usuario" placeholder="Nombre de Usuario" value="<?php echo s($usuario->usuario)?>">
                </div>

                <div class="campo">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" placeholder="Ingrese Password">
                </div>

                <div class="campo">
                    <label for="password2">Password</label>
                    <input type="password" name="password2" id="password2" placeholder="Confirme el Password">
                </div>

                <div class="campo">
                    <label for="status">Status</label>
                    <select name="status" id="status">
                        <option value="" disabled <?php echo $usuario->status?'': 'selected' ?> >--Seleccione una Opción--</option>
                        <option value="1" <?php echo $usuario->status==='1'? 'selected':''?>>Proveedor</option>
                        <option value="2" <?php echo $usuario->status==='2'? 'selected':''?>>Oficina</option>
                    </select>
                </div>



            </fieldset>
            <fieldset>
                <legend>Datos de Contacto</legend>

                <div class="campo">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" id="nombre" placeholder="Nombre Completo" value="<?php echo s($usuario->nombre)?>">
                </div>

                <div class="campo">
                    <label for="telefono">Teléfono</label>
                    <input type="tel" name="telefono" id="telefono" placeholder="Número de Teléfono" value="<?php echo s($usuario->telefono)?>">
                </div>

                <div class="campo">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" placeholder="Email" value="<?php echo s($usuario->email)?>">
                </div>

                <div class="campo">
                    <label for="surcursal">Surcursal</label>
                    <input type="text" name="surcursal" id="surcursal" placeholder="Surcursal" value="<?php echo s($usuario->surcursal)?>">
                </div>


            </fieldset>

        </div>

        <div class="flex-centro">
            <input type="submit" value="crear cuenta">
        </div>
        

    </form>
</div>
<?php include_once __DIR__ . '/../templates/footer-dashboard.php' ?>