<?php
require_once '../../cOmmOns/config.inc.php';
require_once getLocal('ADMIN') . 'sesion_admin.inc.php';
require_once getLocal('ADMIN') . 'menu.inc.php';
require_once getLocal('PED') . 'class.pedidos.inc.php';
require_once getLocal('VEN') . 'class.facturacion.inc.php';

$oPedidos = new clsPedidos();
$oFacturas = new clsFacturas();
$result = false;
$arrayColeccionesID = array();
$pedidos = obtenerValor('pedidos');
$bandera = false;

if ($pedidos != null) {
    $pedidos = json_decode($pedidos, true);
    foreach ($pedidos as $pedido) {
      if (!$oPedidos->ModificarEstadoPedido($pedido['id'], "F")) {
          echo 'bad1';
          exit;
      }
      if ($bandera == false) {
          $bandera = true;
          $oPedidos->findId($pedido['id']);
          $mesa = $oPedidos->getMesa_Id();
      }
         
    }
    $oFacturas->Registrar($pedidos,$mesa); 
}

header('Content-Type: application/text');
  
echo 'OK';
exit;
?>  