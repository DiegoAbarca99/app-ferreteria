<aside class="sidebar">
    <div class="contenedor-sidebar">
        <h2>FerreTinoco</h2>

        <div class="cerrar-menu">
            <img id="cerrar-menu" src="build/img/cerrar.svg" alt="imagen cerrar menu">
        </div>
    </div>


<!--Navegación para administradores-->
    <?php if($_SESSION['status']===0){?>
    <nav class="sidebar-nav">
        <a class="<?php echo $titulo === 'Administración Global'?'activo':'' ?>" href="/admin/index">Administración Global</a>
        <a class="<?php echo $titulo === 'Perfiles'?'activo':'' ?>" href="/perfiles/index">Perfiles</a>
        <a class="<?php echo $titulo === 'Historial'?'activo':'' ?>" href="/admin/historial">Historial de Cambios</a>
    </nav>
    <?php }?>

<!--Navegación para proveedores-->
    <?php if($_SESSION['status']===1){?>
    <nav class="sidebar-nav">
        <a class="<?php echo $titulo === 'Levantar Pedido'?'activo':'' ?>" href="/proveedor/index">Levantar Pedido</a>
        <a class="<?php echo $titulo === 'Clientes'?'activo':'' ?>" href="/proveedor/clientes">Clientes</a>
        <a class="<?php echo $titulo === 'Perfil'?'activo':'' ?>" href="/proveedor/perfil">Perfil</a>
    </nav>
    <?php }?>

<!--Navegación para oficina-->
    <?php if($_SESSION['status']===2){?>
    <nav class="sidebar-nav">
        <a class="<?php echo $titulo === 'Gestionar Pedidos'?'activo':'' ?>" href="/oficina/index">Gestionar Pedidos</a>
        <a class="<?php echo $titulo === 'Perfiles'?'activo':'' ?>" href="/perfiles/index">Perfiles</a>
    </nav>
    <?php }?>





    <div class="cerrar-sesion-mobile">
        <a href="/logout" class="cerrar-sesion">Cerrar Sesión</a>
    </div>
</aside>