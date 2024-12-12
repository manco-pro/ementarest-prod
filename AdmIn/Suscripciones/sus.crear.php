<?php

require_once '../../cOmmOns/config.inc.php';
require_once getLocal('ADMIN') . 'menu.inc.php';
require_once getLocal('LOJ') . 'class.lojas.inc.php';
require_once getLocal('SUS') . 'class.suscripcion.inc.php';

$oLojas = new clsLojas();
$oSuscripcion = new clsSuscripciones();

if (($_SESSION['_admin'] != 'S')) {
    $oSmarty->assign('stTITLE', 'Acceso denegado.');
    $oSmarty->assign('stMESSAGE', 'Acceso denegado.');
    $oSmarty->display('_informacion.tpl');
    exit();
}

$stID = 0;
$stLOJA_ID      = -1;
$stINICIO       = '';
$stFIN          = '';
$stTYPE         = '';
$stPLANO        = '';

$stMENSAJE = false;
$stERROR = '';

if (isset($_POST['Criar'])) {

    $stINICIO   = obtenerValorPOST('inicio');
    $stFIN      = obtenerValorPOST('fin');
    $stTYPE     = obtenerValorPOST('typeSelect');
    $stPLANO    = obtenerValorPOST('planosSelect');
    $stLOJA_ID  = obtenerValor('lojasSelect');
    
    $oSuscripcion->clearSuscripciones();
    $oSuscripcion->setInicio($stINICIO);
    $oSuscripcion->setFin($stFIN);
    $oSuscripcion->setType($stTYPE);
    $oSuscripcion->setPlano($stPLANO);
    $oSuscripcion->setLoja_Id($stLOJA_ID);

    $fecha_inicio_obj = new DateTime($stINICIO);
    $fecha_fin_obj = new DateTime($stFIN);
    $fecha_verificar_obj = new DateTime();
    if ($fecha_verificar_obj >= $fecha_inicio_obj && $fecha_verificar_obj <= $fecha_fin_obj) {
        $oSuscripcion->setActive('S');
    } else {
        $oSuscripcion->setActive('N');
    }

    if (!$oSuscripcion->hasErrors() && $oSuscripcion->Registrar()) {
        redireccionar(getWeb('SUS') . 'sus.modificar.php?id=' . $oSuscripcion->getId() . '&cre=ok');
    }
    $stERROR = $oSuscripcion->getErrors();
}

$oSuscripcion->clearSuscripciones();
$stPLANOS = $oSuscripcion->getPlanos();
$stTIPOS = $oSuscripcion->getTipos();
$stLOJAS = $oSuscripcion->GetAllLojasSinSuscripcion();
if (!$stLOJAS){
    $stLOJAS = array(
        array('id' => '-1', 'nombre' => 'Lojas'));
}

$oSmarty->assign('stID', $stID);

$oSmarty->assign('stPLANOS',    HandlerSelect($stPLANOS, $stPLANO, 'Plano'));
$oSmarty->assign('stTIPOS',     HandlerSelect($stTIPOS, $stTYPE, 'Tipo'));
$oSmarty->assign('stINICIO',    $stINICIO);
$oSmarty->assign('stFIN',       $stFIN);
$oSmarty->assign('stLOJAS',     HandlerSelect($stLOJAS, $stLOJA_ID, 'Lojas'));
$oSmarty->assign('stSUSPENDIDO','');



$oSmarty->assign('stERROR', $stERROR);
$oSmarty->assign('stMENSAJE', $stMENSAJE);

$oSmarty->assign('stACTION', $_SERVER['PHP_SELF']);
$oSmarty->assign('stTITLE', 'Criar subscri&ccedil;&atilde;o');
$oSmarty->assign('stSUBTITLE', 'Subscri&ccedil;&atilde;o de Loja');
$oSmarty->assign('stBTN_ACTION', 'Criar');
$oSmarty->assign('stBTN_ACTION_D', '');
/* ------------------------------------------------------------------ */
$oSmarty->display('suscripciones/_sus.crear.tpl');
