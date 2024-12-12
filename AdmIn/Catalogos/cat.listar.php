<?php

require_once '../../cOmmOns/config.inc.php';
require_once getLocal('ADMIN') . 'menu.inc.php';
require_once getLocal('CAT') . 'class.catalogos.inc.php';
require_once getLocal('LOJ') . 'class.lojas.inc.php';

$oLojas = new clsLojas();
$arrayLojas = array();
$aValues = array();
$stTITLE = '';
$stLOJA_ID = 0;
$oCatalogos = new clsCatalogos();

if (!isset($_SESSION['_admId'])) {
	$oSmarty->assign('stTITLE', 'Catalogo listar');
	$oSmarty->assign('stMESSAGE', 'Acceso denegado.');
	$oSmarty->display('_informacion.tpl');
	exit();
}

$stLOJA_ID = obtenerValor('loja_id', FILTER_UNSAFE_RAW);
$Cid = obtenerValor('Cid');
$Cvalue = obtenerValor('Cvalue');
if ($Cid != false && $Cvalue != false) {
    $oCatalogos->findId($Cid);
    $oCatalogos->setEnabled($Cvalue);
    if (!$oCatalogos->UpdateEstado()){
        $stMESSAGE = $oCatalogos->getErrors();
        echo 'bad';
        exit();
    
    }else{
        echo 'ok';
        exit();
    }
}

if ($_SESSION['_admLojaId'] == 0) { //caso admin
    $arrayLojas = $oLojas->GetAllLojas();
    if ($stLOJA_ID != null) {
        $aValues = $oCatalogos->GetAllCatByPadre_Hijo($stLOJA_ID);
    } else {
        $stLOJA_ID = -1;
        $stTITLE = 'Selecione uma loja para listar seus cat&aacute;logos';
    }
} else { //caso usuario
    $aValues = $oCatalogos->GetAllCatByPadre_Hijo($_SESSION['_admLojaId']);
}

if ($stLOJA_ID != -1) {
    if ($_SESSION['_admLojaId'] == 0) {
        $oLojas->findId($stLOJA_ID);
    } else {
        $oLojas->findId($_SESSION['_admLojaId']);
    }
    $stTITLE = 'lista do cat&aacute;logos do : ' . $oLojas->getNombre();
    $stLOJA_ID = $oLojas->getId();
}

if ($oLojas->hasErrors() || $oCatalogos->hasErrors()) {
    $oSmarty->assign('stTITLE', 'Listado do cat&aacute;logos');
    $stMESSAGE = $oCatalogos->getErrors() . ' ' . $oLojas->getErrors();
    $oSmarty->assign('stMESSAGE',  $stMESSAGE);
    $oSmarty->display('_informacion.tpl');
    exit();
}

/* --------------------------------------------------------------------- */
$oSmarty->assign('stSUPER_ADMIN', $_SESSION['_admin']);
$oSmarty->assign('stACTION', $_SERVER['PHP_SELF']);
$oSmarty->assign('stLOJAS_SELECT', HandlerSelect($arrayLojas, $stLOJA_ID, 'Lojas'));
$oSmarty->assign('stLOJA_ID', $stLOJA_ID);
$oSmarty->assign('stVALUES', $aValues);
$oSmarty->assign('stTITLE', $stTITLE);
/* --------------------------------------------------------------------- */
$oSmarty->display('catalogos/_cat.listar.tpl');
