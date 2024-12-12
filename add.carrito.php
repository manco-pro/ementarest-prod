<?php
require_once './cOmmOns/config.inc.php';
require_once getLocal('EMENTA') . 'sesion_persit.inc.php';
header('Content-Type: application/text');

$id = obtenerValor('id');

if ($id != false) {
    $_SESSION['carrito'][] = $id;
    echo 'ok';
} else {
    echo 'bad';
}
