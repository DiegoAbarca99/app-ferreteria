<div class="fieldset-grid">
    <fieldset class="formulario__fieldset">
        <legend>Datos de la Cuenta</legend>

        <div class="formulario__campo">
            <label class="formulario__label" for="usuario">Usuario</label>
            <input class="formulario__input" type="text" name="usuario" id="usuario" placeholder="Nombre de Usuario" value="<?php echo s($usuario->usuario) ?>">
        </div>

        <div class="formulario__campo">
            <label class="formulario__label" for="password">Password</label>
            <input class="formulario__input" type="password" name="password" id="password" placeholder="Ingrese Password">
        </div>

        <div class="formulario__campo">
            <label class="formulario__label" for="password2">Password</label>
            <input class="formulario__input" type="password" name="password2" id="password2" placeholder="Confirme el Password">
        </div>

        <div class="formulario__campos-grid" id="campos">
            <div class="formulario__campo">
                <label class="formulario__label" for="status">Status</label>
                <select class="formulario__input formulario__input--select" name="status" id="status">
                    <option value="" disabled <?php echo $usuario->status ? '' : 'selected' ?>>--Seleccione una Opción--</option>
                    <option value="1" <?php echo $usuario->status === '1' ? 'selected' : '' ?>>Proveedor</option>
                    <option value="2" <?php echo $usuario->status === '2' ? 'selected' : '' ?>>Oficina</option>
                </select>
            </div>
        </div>

    </fieldset>

    <fieldset class="formulario__fieldset">
        <legend>Datos de Contacto</legend>

        <div class="formulario__campo">
            <label class="formulario__label" for="nombre">Nombre</label>
            <input class="formulario__input" type="text" name="nombre" id="nombre" placeholder="Nombre Completo" value="<?php echo s($usuario->nombre) ?>">
        </div>

        <div class="formulario__campo">
            <label class="formulario__label" for="telefono">Teléfono</label>
            <input class="formulario__input" type="tel" name="telefono" id="telefono" placeholder="Número de Teléfono" value="<?php echo s($usuario->telefono) ?>">
        </div>

        <div class="formulario__campo">
            <label class="formulario__label" for="email">Email</label>
            <input class="formulario__input" type="email" name="email" id="email" placeholder="Email" value="<?php echo s($usuario->email) ?>">
        </div>

        <div class="formulario__campo">
            <label class="formulario__label" for="surcursal">Surcursal</label>
            <input class="formulario__input" type="text" name="surcursal" id="surcursal" placeholder="Surcursal" value="<?php echo s($usuario->surcursal) ?>">
        </div>


    </fieldset>

</div>