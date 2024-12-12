<?php

require_once '../../cOmmOns/config.inc.php';
require_once getLocal('ADMIN') . 'menu.inc.php';
require_once getLocal('SUS') . 'class.suscripcion.inc.php';


$oSuscripcion = new clsSuscripciones();
$oSuscripcion->clearSuscripciones();

$stID = obtenerValor('id', FILTER_UNSAFE_RAW);

if (($_SESSION['_admin'] != 'S') || !$oSuscripcion->findId($stID)) {
    $oSmarty->assign('stTITLE', 'Acceso denegado.');
    $oSmarty->assign('stMESSAGE', 'Acceso denegado.');
    $oSmarty->display('_informacion.tpl');
    exit();
}
/* ------------------------------------------------------------ */

$stLOJA_ID      = -1;
$stINICIO       = '';
$stFIN          = '';
$stTYPE         = '';
$stPLANO        = '';

$stERROR = '';
$stMENSAJE = false;
if (isset($_POST['Modificar'])) {

    $stINICIO   = obtenerValorPOST('inicio');
    $stFIN      = obtenerValorPOST('fin');
    $stTYPE     = obtenerValorPOST('typeSelect');
    $stPLANO    = obtenerValorPOST('planosSelect');
    $stSUSPENDIDO = obtenerValorPOST('suspendido');
    
    if ($stSUSPENDIDO != null) {
        $oSuscripcion->setActive('C');
    }else{
        $fecha_inicio_obj = new DateTime($stINICIO);
        $fecha_fin_obj = new DateTime($stFIN);
        $fecha_verificar_obj = new DateTime();
        if ($fecha_verificar_obj >= $fecha_inicio_obj && $fecha_verificar_obj <= $fecha_fin_obj) {
            $oSuscripcion->setActive('S');
        } else {
            $oSuscripcion->setActive('N');
        }
    }
 

    $oSuscripcion->setId($stID);
    $oSuscripcion->setInicio($stINICIO);
    $oSuscripcion->setFin($stFIN);
    $oSuscripcion->setType($stTYPE);
    $oSuscripcion->setPlano($stPLANO);

      if (!$oSuscripcion->hasErrors() && $oSuscripcion->Modificar()) {
        redireccionar(getWeb('SUS') . 'sus.modificar.php?id=' . $oSuscripcion->getId() . '&mod=ok');
    }
    $stERROR = $oSuscripcion->getErrors();
} elseif (isset($_GET['id'])) {


    if (isset($_GET['mod'])) {
        if ($_GET['mod'] == 'ok') {
            $stMENSAJE = 'dados alterados com sucesso';
        } else if ($_GET['mod'] == 'bad') {
            $stERROR = 'XXXXXXX';
        }
    }
    if (isset($_GET['cre'])) {
        if ($_GET['cre'] == 'ok') {
            $stMENSAJE = 'subscri&ccedil;&atilde;o criado com sucesso';
        }
    }
} else {
    $oSmarty->assign('stTITLE', 'Modificar subscri&ccedil;&atilde;o');
    $oSmarty->assign('stMESSAGE', 'Acceso denegado.');
    $oSmarty->display('_informacion.tpl');
    exit();
}


$stPLANOS = $oSuscripcion->getPlanos();
$stTIPOS = $oSuscripcion->getTipos();

$stLOJAS = $oSuscripcion->GetAllLojasSinSuscripcion();
if (!$stLOJAS){
    $stLOJAS = array(
        array('id' => '-1', 'nombre' => 'Lojas'));
}


/* --------------------------------------------------------------------- */

$oSmarty->assign('stID', $stID);
$oSmarty->assign('stLOJA_ID', $stLOJA_ID);

$oSmarty->assign('stPLANOS',    HandlerSelect($stPLANOS, $oSuscripcion->getPlano(), 'Plano'));
$oSmarty->assign('stTIPOS',     HandlerSelect($stTIPOS, $oSuscripcion->getType(), 'Tipo'));
$oSmarty->assign('stINICIO',    $oSuscripcion->getInicio());
$oSmarty->assign('stFIN',       $oSuscripcion->getFin());
$oSmarty->assign('stLOJAS',     HandlerSelect($stLOJAS, $oSuscripcion->getLoja_Id(), 'Lojas'));
$oSmarty->assign('stLOJAS_DISABLED',    'disabled');
$oSmarty->assign('stSUSPENDIDO',  $oSuscripcion->getActive());


$oSmarty->assign('stERROR', $stERROR);
$oSmarty->assign('stMENSAJE', $stMENSAJE);

$oSmarty->assign('stACTION', $_SERVER['PHP_SELF']);
$oSmarty->assign('stTITLE', 'Modificar subscri&ccedil;&atilde;o');
$oSmarty->assign('stSUBTITLE', 'Subscri&ccedil;&atilde;o de Loja');
$oSmarty->assign('stBTN_ACTION', 'Modificar');
$oSmarty->assign('stBTN_ACTION_D', 'deletar');
/* ------------------------------------------------------------------ */
$oSmarty->display('suscripciones/_sus.crear.tpl');
