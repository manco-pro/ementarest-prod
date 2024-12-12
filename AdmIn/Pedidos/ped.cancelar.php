<?php
require_once '../../cOmmOns/config.inc.php';
require_once getLocal('ADMIN') . 'sesion_admin.inc.php';
require_once getLocal('ADMIN') . 'menu.inc.php';
require_once getLocal('PED') . 'class.pedidos.inc.php';

$oPedidos = new clsPedidos();
$result = false;

$id = obtenerValor('id');




if ($id != null) {
    if (!$oPedidos->Cancelar($id)) {
        echo 'bad1';
        exit;
    }
}

header('Content-Type: application/text');

echo 'OK';
exit;
?> // End of AdmIn/Pedidos/ped.finalizar.php