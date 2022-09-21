<?php include_once __DIR__.'/../templates/header-dashboard.php';?>
    <div class="flex-derecha">
        <a class="crear-perfil" href="/perfiles/crear">
           &#43; Crear Perfil
        </a>
    </div>

    <ul class="listado-perfiles">
        <?php foreach($usuarios as $usuario){ ?>
        <li class="perfil">
            <div class="perfil-informacion">
                <p>Usuario: <span><?php echo $usuario->usuario ?> </span></p>
                <p>Status: <span><?php echo $usuario->status==='1'? 'Proveedor' : 'Oficina' ?> </span></p>
                <p>Surcursal: <span><?php echo $usuario->surcursal ?> </span></p>
            </div>
            
            
            <a class="boton-ver-perfil" href="/perfiles/perfil?id=<?php echo $usuario->id?>">Ver Usuario</a>
        </li>
        <?php }?>
    </ul>
    


    <div class="contenedor">
    </div>
<?php include_once __DIR__.'/../templates/footer-dashboard.php' ?>