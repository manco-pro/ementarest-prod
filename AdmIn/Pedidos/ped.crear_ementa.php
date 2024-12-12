<?php

require_once '../../cOmmOns/config.inc.php';
require_once getLocal('EMENTA') . 'sesion_persit.inc.php';
require_once getLocal('COL') . 'class.colecciones.inc.php';
require_once getLocal('PED') . 'class.pedidos.inc.php';
require_once getLocal('LOJ') . 'class.lojas.inc.php';

$oMySqliDB      = new clsMySqliDB();
$oPedidos       = new clsPedidos();
$oColecciones   = new clsColecciones();
$oLojas         = new clsLojas();

$stMESAS = "";
$stERROR = '';
$stMENSAJE = '';
$arrayPedidos = array();


$loja_id = obtenerValor('loja_id', FILTER_UNSAFE_RAW);
$ementa = obtenerValor('ementa', FILTER_UNSAFE_RAW);


if (isset($_POST['Criar'])) {

    $oPedidos->clearPedidos();
    $Mesa_Selected = obtenerValor('MesasSelect');
    $Pedidos = obtenerValor('idsSeleccionados');

    if ($Pedidos === null || $Pedidos == '') {
        echo 'bad';
       // $stERROR = 'No se han seleccionado productos';
        exit();
    } else {
        $arrayPedidos = explode(',', $Pedidos);
    }

    $oPedidos->setMesa_Id($Mesa_Selected);
    $oPedidos->setEmpleado_Id(0); // 0 prefijo para los administradores

    if (!$oPedidos->hasErrors() && !$oPedidos->PreRegistrar($arrayPedidos, $loja_id)) {

        echo 'bad';
        $stERROR = $oPedidos->getErrors();
        exit();
    }
    unset($_SESSION['carrito']);
    echo  'ok';
}
