<?php

require_once __DIR__.'/includes/app.php';

USE Model\Usuario;

$registro=['usuario'=>'Admin','password'=>'123456'];

$usuario=new Usuario($registro);
$usuario->guardar();