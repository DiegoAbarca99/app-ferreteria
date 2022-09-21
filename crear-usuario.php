<?php

require_once __DIR__.'/includes/app.php';

USE Model\Usuario;

$registro=['usuario'=>'Admin','password'=>password_hash('123456',PASSWORD_BCRYPT)];

$usuario=new Usuario($registro);
$usuario->guardar();