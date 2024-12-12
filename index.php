<?php
require_once './cOmmOns/config.inc.php';
require_once getLocal('EMENTA') . 'sesion_persit.inc.php';
require_once getLocal('EMENTA') . 'header_menu.php';
require_once getLocal('EVE') . 'class.eventos.inc.php';
$oEventos = new clsEventos();
$oEventos->clearEventos();


$oSmarty->assign('stACTIVA', 'Index');
$oSmarty->assign('stTITULO_PAGINA', '');
$plantilla = $_SESSION['Plantilla'];

$aValues = $oEventos->GetAllActiveEventsByLoja($_SESSION['LojaId']);

$oSmarty->assign('staVALUES', $aValues);
$oSmarty->display('ementa'. $plantilla .'/index.tpl');
