<?php
require_once '../../cOmmOns/config.inc.php';
require_once getLocal('PED') . 'class.pedidos.inc.php';

$oPedidos = new clsPedidos();
$result = false;

$id = obtenerValor('id');
//$Mesa = obtenerValorPOST('mesa');
$Pedidos = obtenerValorPOST('idsSeleccionados');

$loja_id = obtenerValor('loja_id');


header('Content-Type: application/text');

if ($oPedidos->findId($id)) {

    if ($loja_id == null) {
        require_once getLocal('ADMIN') . 'sesion_admin.inc.php';
        $loja_id = $_SESSION['_admLojaId'];
    }

    $stLOJA_ID = $loja_id;

    if ($Pedidos == false) {
        echo "bad1";
        exit();
    } else {
        $arrayPedidos = explode(',', $Pedidos);
    }

    if ($oPedidos->PreRegistrar($arrayPedidos, $stLOJA_ID, true) && $oPedidos->ModificarEstadoPedido($id, 'P')) {
        echo 'ok';
    } else {
        echo $oPedidos->getErrors();
        echo 'bad2';
    }
}
