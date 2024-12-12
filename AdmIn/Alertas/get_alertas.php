<?php
require_once '../../cOmmOns/config.inc.php';
require_once getLocal('ALE') . 'class.alertas.inc.php';
require_once getLocal('ADMIN') . 'menu.inc.php';
$alertas = new clsAlertas();
$alertas->clearAlertas();

$data = $alertas->GetAllAlertasInLoja($_SESSION['_admLojaId']);

header('Content-Type: application/json');
echo json_encode($data);
