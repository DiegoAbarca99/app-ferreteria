<?php

function debuguear($variable): string
{
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML
function s($html): string
{
    $s = htmlspecialchars($html);
    return $s;
}

// Función que revisa que el usuario este autenticado
function isAuth(): void
{
    if (!isset($_SESSION['login'])) {
        header('Location: /');
    }
}

// Función que revisa que el usuario sea administrador
function isAdmin(): void
{
    if ($_SESSION['status'] !== 0) {
        header('Location: /');
    }
}

// Función que revisa que el usuario sea proveedor
function isProveedor(): void
{
    if ($_SESSION['status'] !== 1) {
        header('Location: /');
    }
}

// Función que revisa que el usuario tenga status de oficina
function isOficina(): void
{
    if ($_SESSION['status'] !== 2) {
        header('Location: /');
    }
}

// Función que revisa que el usuario sea administrador o con status de oficina
function isAllowed(): void
{
    if ($_SESSION['status'] === 1) {
        header('Location: /');
    }
}

//Verifica que exista cierto string en la ruta actual
function pagina_actual($path): bool
{
    return str_contains($_SERVER['PATH_INFO'] ?? '/', $path) ? true : false;
}


//Función que determina si un elemento de un arreglo asociativo  es el último o no
function esUltimo(string $actual, string $proximo): bool
{
    if ($actual !== $proximo) {
        return true;
    }

    return false;
}

function obtenerNominal(string $valor): float
{
    return $valor / 100 + 1;
}
