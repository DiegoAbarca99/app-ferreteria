<?php

function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

// Función que revisa que el usuario este autenticado
function isAuth() : void {
    if(!isset($_SESSION['login'])) {
        header('Location: /');
    }
}

// Función que revisa que el usuario sea administrador
function isAdmin() : void {
    if($_SESSION['status']!==0) {
        header('Location: /');
    }
}

// Función que revisa que el usuario sea proveedor
function isProveedor() : void {
    if($_SESSION['status']!==1) {
        header('Location: /');
    }
}

// Función que revisa que el usuario tenga status de oficina
function isOficina() : void {
    if($_SESSION['status']!==2) {
        header('Location: /');
    }
}

// Función que revisa que el usuario sea administrador o con status de oficina
function isAllowed() : void {
    if($_SESSION['status']===1) {
        header('Location: /');
    }
}


