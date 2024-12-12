<?php
require_once '../../cOmmOns/config.inc.php';
require_once getLocal('ADMIN') . 'menu.inc.php';
require_once getLocal('VEN') . 'class.facturacion.inc.php';
require_once getLocal('LOJ') . 'class.lojas.inc.php';

$oFacturas = new clsFacturas();
$oLojas = new clsLojas();
$oFacturas->clearFacturas();
$oLojas->clearLojas();

$stLOJA_ID = obtenerValor('loja_id');
$stID = obtenerValor('id');


if (!isset($_SESSION['_admin']) || $stLOJA_ID == null || !$oFacturas->findId($stID)) {
    return 'bad';
    exit();
}
//if ($stLOJA_ID != $_SESSION['_admLojaId'] && $_SESSION['_admin'] != 'S') {
//    return 'bad';
//    exit();
//}
header('Content-Type: application/text');


$aValues = $oFacturas->GetallDetallesFacturaByFacturaId($oFacturas->getId());
$total = 0;
if ($aValues) {
    $html = "<table class='table'>
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Precio unitario</th>
                        <th>Cantidad</th>
                        <th>Precio total</th>
                    </tr>
                </thead>
                <tbody>";
    foreach ($aValues as $key => $value) {
        $Item_total = $value['precio'] * $value['cantidad'];
        $total += $Item_total;
        $html .= "<tr class='border-bottom'>
                    <td>
                        <p class='ta'>" . $value['nombre_pt'] . "</p>
                    </td>
                    <td>
                        <p class='ta'>€" .  $value['precio'] . "</p>
                    </td>
                    <td>
                        <p class='ta'>" . $value['cantidad'] . "</p>
                    </td>
                    <td>
                        <p class='ta'>€" .  $Item_total . "</p>
                    </td>
                </tr>";
    }
    $html .= "<tr style='background-color: #eee; margin:0; padding:0'>
                <td colspan='3' style='text-align: right;'>
                    <b class='ta'><h5>Total :</h5></b>
                </td>
                <td>
                    <b class='ta'>€" . $total . "</b>
                </td>
            </tr>
        </tbody>
    </table>";
    echo $html;
} else {
    echo 'bad';
}
