<?php
require_once './cOmmOns/config.inc.php';
require_once getLocal('EMENTA') . 'sesion_persit.inc.php';
header('Content-Type: application/text');

$id = obtenerValor('id');

if ($id != false) {
    $key = array_search($id, $_SESSION['carrito']);
    if ($key !== false) {
        unset($_SESSION['carrito'][$key]); 
    }
if (count($_SESSION['carrito']) == 0 ) {
    unset($_SESSION['carrito']);
}  
     echo 'ok';
} else {
    echo 'bad';
}
