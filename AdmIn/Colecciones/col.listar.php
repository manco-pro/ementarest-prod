<?php

require_once '../../cOmmOns/config.inc.php';
require_once getLocal('ADMIN') . 'menu.inc.php';
require_once getLocal('COL') . 'class.colecciones.inc.php';
require_once getLocal('LOJ') . 'class.lojas.inc.php';

$oLojas = new clsLojas();
$arrayLojas = array();
$aValues = array();
$stTITLE = '';
$stLOJA_ID = 0;
$oColecciones = new clsColecciones();




if (!isset($_SESSION['_admId'])) {
	$oSmarty->assign('stTITLE', 'Produto listar');
	$oSmarty->assign('stMESSAGE', 'Acceso denegado.');
	$oSmarty->display('_informacion.tpl');
	exit();
}

$Cid = obtenerValor('Cid');
$Cvalue = obtenerValor('Cvalue');
if ($Cid != false && $Cvalue != false) {
    $oColecciones->findId($Cid);
    $oColecciones->setEnabled($Cvalue);
    if (!$oColecciones->UpdateEstado()){
        $stMESSAGE = $oColecciones->getErrors();
        echo $stMESSAGE;
        exit();
    
    }else{
        echo 'ok';
        exit();
    }
}



if ($_SESSION['_admLojaId'] == 0) { //caso admin

    $arrayLojas = $oLojas->GetAllLojas();

    $stLOJA_ID = obtenerValorPOST('loja_id', FILTER_UNSAFE_RAW);
    if ($stLOJA_ID != null) {
        $aValues = $oColecciones->GetAllColByLoja_Id($stLOJA_ID);
    } else {
        $stLOJA_ID = -1;
        $stTITLE = 'Selecione uma loja para listar seus produtos';
    }
} else { //caso usuario
    $aValues = $oColecciones->GetAllColByLoja_Id($_SESSION['_admLojaId']);
}

if ($stLOJA_ID != -1) {
    
    if ($_SESSION['_admLojaId'] == 0) {
        $oLojas->findId($stLOJA_ID);
    } else {
        $oLojas->findId($_SESSION['_admLojaId']);
    }
    
    $stTITLE = 'lista de Produtos do : ' . $oLojas->getNombre();
    $stLOJA_ID = $oLojas->getId();

}

// if ($_SESSION['_admin'] === 'N' || $loja_id == null || !$oLojas->findId($loja_id) ) {
// $oSmarty->assign('stTITLE', 'Acceso denegado.');
// $oSmarty->assign('stMESSAGE', 'Acceso denegado.');
// $oSmarty->display('_informacion.tpl');
// exit();
// }


if ($oLojas->hasErrors() || $oColecciones->hasErrors()) {
    $oSmarty->assign('stTITLE', 'Listado do Produtos');
    $stMESSAGE = $oColecciones->getErrors() . ' ' . $oLojas->getErrors();
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
$oSmarty->display('colecciones/_col.listar.tpl');
