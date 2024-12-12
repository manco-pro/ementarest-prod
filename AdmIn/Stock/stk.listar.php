<?php

require_once '../../cOmmOns/config.inc.php';
require_once getLocal('ADMIN') . 'menu.inc.php';
require_once getLocal('STK') . 'class.stock.inc.php';
require_once getLocal('LOJ') . 'class.lojas.inc.php';

$oLojas = new clsLojas();
$arrayLojas = array();
$aValues = array();
$stTITLE = '';
$stLOJA_ID = 0;
$oStock = new clsStock();


$stLOJA_ID = obtenerValor('loja_id', FILTER_UNSAFE_RAW);
//$Cid = obtenerValor('Cid');
//$Cvalue = obtenerValor('Cvalue');
//if ($Cid != false && $Cvalue != false) {
//    $oStock->findId($Cid);
//    $oStock->setEnabled($Cvalue);
//    if (!$oStock->UpdateEstado()){
//        $stMESSAGE = $oStock->getErrors();
//        echo 'bad';
//        exit();
//    
//    }else{
//        echo 'ok';
//        exit();
//    }
//}

if ($_SESSION['_admLojaId'] == 0) { //caso admin
    $arrayLojas = $oLojas->GetAllLojas();
    if ($stLOJA_ID != null) {
        $aValues = $oStock->GetAllStockByLoja($stLOJA_ID);
    } else {
        $stLOJA_ID = -1;
        $stTITLE = 'Selecione uma loja para listar seus produtos';
    }
} else { //caso usuario
    $aValues = $oStock->GetAllStockByLoja($_SESSION['_admLojaId']);
}

if ($stLOJA_ID != -1) {
    if ($_SESSION['_admLojaId'] == 0) {
        $oLojas->findId($stLOJA_ID);
    } else {
        $oLojas->findId($_SESSION['_admLojaId']);
    }
    $stTITLE = 'lista do Stock do : ' . $oLojas->getNombre();
    $stLOJA_ID = $oLojas->getId();
}

if ($oLojas->hasErrors() || $oStock->hasErrors()) {
    $oSmarty->assign('stTITLE', 'invent&aacute;rio de produtos');
    $stMESSAGE = $oStock->getErrors() . '  ' . $oLojas->getErrors();
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
$oSmarty->display('stock/_stk.listar.tpl');
