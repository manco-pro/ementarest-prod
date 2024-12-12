<?php
require_once '../../cOmmOns/config.inc.php';
require_once getLocal('ADMIN') . 'sesion_admin.inc.php';
require_once getLocal('ADMIN') . 'menu.inc.php';
require_once getLocal('PED') . 'class.pedidos.inc.php';
require_once getLocal('LOJ') . 'class.lojas.inc.php';

$oPedidos = new clsPedidos();
$oLojas = new clsLojas();
$result = false;


$id = obtenerValor('id');
//$Mesa = obtenerValorPOST('mesa');
$Pedidos = obtenerValorPOST('idsSeleccionados');

 $stLOJA_ID = $_SESSION['_admLojaId'];

if (!isset($_SESSION['_admLojaId']) || $stLOJA_ID == null || !$oLojas->findId($_SESSION['_admLojaId'])) {
    return 'bad';
    exit();
}
if ($oLojas->getId() != $_SESSION['_admLojaId'] && $_SESSION['_admin'] != 'S') {
    return 'bad';
    exit();
}



header('Content-Type: application/text');

if ($oPedidos->findId($id)) {
   
    if ($Pedidos == false) {
        echo "bad1";
        exit();
    } else {
        $arrayPedidos = explode(',', $Pedidos);
    }
    //echo '<pre>';
    //print_r($arrayPedidos);
    //echo '</pre>';
    //cambia el estado a Pronto
    if ($oPedidos->PreRegistrar($arrayPedidos, $stLOJA_ID, true) && $oPedidos->ModificarEstadoPedido($id)) {
        echo 'ok';
    } else {
        echo $oPedidos->getErrors();
        echo 'bad2';
    }
}
