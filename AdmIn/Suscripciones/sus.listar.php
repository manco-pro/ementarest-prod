<?php

require_once '../../cOmmOns/config.inc.php';
require_once getLocal('ADMIN') . 'menu.inc.php';
require_once getLocal('SUS') . 'class.suscripcion.inc.php';


if ($_SESSION['_admId'] != 1) {
    $oSmarty->assign('stTITLE', 'Listado de subscri&ccedil;&otilde;es');
    $oSmarty->assign('stMESSAGE', 'Acceso denegado.');
    $oSmarty->display('_informacion.tpl');
    exit();
}


$aValues = array();
$stTITLE = 'Listado de subscri&ccedil;&otilde;es';
$oSuscripciones = new clsSuscripciones();
$aValues = $oSuscripciones->GetAllSuscripciones();

if ($oSuscripciones->hasErrors()) {
    $oSmarty->assign('stTITLE', $stTITLE);
    $stMESSAGE = $oStock->getErrors() . '  ' . $oSuscripciones->getErrors();
    $oSmarty->assign('stMESSAGE',  $stMESSAGE);
    $oSmarty->display('_informacion.tpl');
    exit();
}

/* --------------------------------------------------------------------- */
$oSmarty->assign('stACTION', $_SERVER['PHP_SELF']);
$oSmarty->assign('stVALUES', $aValues);
$oSmarty->assign('stTITLE', $stTITLE);
/* --------------------------------------------------------------------- */
$oSmarty->display('suscripciones/_sus.listar.tpl');
