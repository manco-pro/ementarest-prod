<?php
require_once '../../cOmmOns/config.inc.php';
require_once getLocal('PED') . 'class.pedidos.inc.php';

$oPedidos = new clsPedidos();

$ArrayPedidos = array();

$full_dashboard = obtenerValor('dashboard');
//$full_dashboard = true;
if ($full_dashboard != null) {
    require_once getLocal('ADMIN') . 'sesion_admin.inc.php';
    $loja_id = $_SESSION['_admLojaId'];
} else {
    $loja_id = obtenerValor('loja_id');
    if ($loja_id == null) {
        echo 'error en la loja';
        exit;
    }
}


$ArrayPedidos = $oPedidos->GetAllPedidosProntoByLoja($loja_id);

$mensaje = json_encode($ArrayPedidos);
//echo  $mensaje;

// Establecemos el tipo de contenido de la respuesta a JSON
//header('Content-Type: application/json');

// Devolvemos la respuesta al cliente
echo $mensaje;
