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
    if ($_SESSION['status'] !== 1 && $_SESSION['status'] !== 0) {
        header('Location: /');
    }
}
//Función que revisa que el usuario sea el usuario Raiz
function isAdminRoot(): void
{
    if ($_SESSION['status'] !== 0) {
        header('Location: /');
    }
}

// Función que revisa que el usuario sea proveedor
function isProveedor(): void
{
    if ($_SESSION['status'] !== 2) {
        header('Location: /');
    }
}

// Función que revisa que el usuario tenga status de oficina
function isOficina(): void
{
    if ($_SESSION['status'] !== 3) {
        header('Location: /');
    }
}

function isOficinaOrProveedor(): void
{
    if ($_SESSION['status'] === 0 || $_SESSION['status'] === 1) {
        header('Location: /');
    }
}

// Función que revisa que el usuario sea administrador o con status de oficina
function isAllowed(): void
{
    if ($_SESSION['status'] === 2) {
        header('Location: /');
    }
}

//Verifica que exista cierto string en la ruta actual
function pagina_actual($path): bool
{   
    return str_contains($_SERVER['REQUEST_URI'] ?? '/', $path) ? true : false;
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

function validarCURP($cadena)
{
    $curp = mb_strtoupper($cadena, "UTF-8");
    $pattern = "/^([A-Z][AEIOUX][A-Z]{2}\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])[HM](?:AS|B[CS]|C[CLMSH]|D[FG]|G[TR]|HG|JC|M[CNS]|N[ETL]|OC|PL|Q[TR]|S[PLR]|T[CSL]|VZ|YN|ZS)[B-DF-HJ-NP-TV-Z]{3}[A-Z\d])(\d)$/";
    $validacionRegex = preg_match($pattern, $curp);
    if ($validacionRegex === 0) {
        #No cumple con un formato válido
        return false;
    }
    #De aquí en adelante se verifica el dígito verificador
    $diccionario = "0123456789ABCDEFGHIJKLMNÑOPQRSTUVWXYZ";
    $lngSuma = 0.0;
    $lngDigito = 0.0;
    $curp17 = substr($curp, 0, 17);
    for ($i = 0; $i < 17; $i++) {

        $lngSuma = $lngSuma + mb_strpos($diccionario, mb_substr($curp17, $i, 1)) * (18 - $i);
    }
    $lngDigito = 10 - ($lngSuma % 10);
    if ($lngDigito == 10) {
        $digitoVerificador = 0;
    }
    $digitoVerificador = $lngDigito;
    return $digitoVerificador == $curp[17];
}
