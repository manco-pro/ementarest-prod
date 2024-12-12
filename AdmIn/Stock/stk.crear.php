<?php

require_once '../../cOmmOns/config.inc.php';
require_once getLocal('ADMIN') . 'menu.inc.php';
require_once getLocal('COL') . 'class.colecciones.inc.php';
require_once getLocal('STK') . 'class.stock.inc.php';
require_once getLocal('LOJ') . 'class.lojas.inc.php';

$oColecciones = new clsColecciones();
$oLojas = new clsLojas();
$oStock = new clsStock();
$oStock->clearStock();


$stLOJA_ID = obtenerValor('loja_id', FILTER_UNSAFE_RAW);

if (!isset($_SESSION['_admin']) || $stLOJA_ID == null || !$oLojas->findId($stLOJA_ID)) {
    $oSmarty->assign('stTITLE', 'Acceso denegado.');
    $oSmarty->assign('stMESSAGE', 'Acceso denegado.');
    $oSmarty->display('_informacion.tpl');
    exit();

}
if ($stLOJA_ID != $_SESSION['_admLojaId'] && $_SESSION['_admin'] != 'S') {
    $oSmarty->assign('stTITLE', 'Modificar Produto');
    $oSmarty->assign('stMESSAGE', 'Acceso denegado.');
    $oSmarty->display('_informacion.tpl');
    exit();
}

$stID = 0;
$stCOLECCION_ID = 0;
$stCANTIDAD = 0;
$stMINIMO = 0;
$stMENSAJE = false;
$stERROR = '';

if (isset($_POST['Criar'])) {

    $stCOLECCION_ID = obtenerValorPOST('coleccionSelect');
    $stCANTIDAD = obtenerValorPOST('cantidad');
    $stMINIMO = obtenerValorPOST('minimo');

    $oStock->setColeccion_id($stCOLECCION_ID);
    $oStock->setLoja_id($stLOJA_ID);
    $oStock->setCantidad((int)$stCANTIDAD);
    $oStock->setMinimo($stMINIMO);

    if (!$oStock->hasErrors() && $oStock->Registrar()) {
        redireccionar(getWeb('STK') . 'stk.modificar.php?id=' . $oStock->getId() . '&cre=ok');
    }
    $stERROR = $oStock->getErrors();
}

$aStock_col_ids = $oStock->GetAllStockColIds($stLOJA_ID);

$stCOLECCION_SELECT = sobreescribirEntidadesHTML($oColecciones->GetAllColByLoja_Id($stLOJA_ID, true, 2));



foreach ($aStock_col_ids as $id) {
    if (isset($stCOLECCION_SELECT[$id])) {
        unset($stCOLECCION_SELECT[$id]);
    }
}

if ($stCOLECCION_SELECT === false) {
    $oSmarty->assign('stTITLE', 'Crear Produto');
    $oSmarty->assign('stMESSAGE', 'Primeiro deve haver pelo menos 1 Produto para criar um Stock.');
    $oSmarty->display('_informacion.tpl');
    exit();
}


$oSmarty->assign('stID', $stID);
$oSmarty->assign('stLOJA_ID', $stLOJA_ID);
$oSmarty->assign('stCOLECCION_SELECT', HandlerSelect($stCOLECCION_SELECT, $stCOLECCION_ID, 'Produto'));
$oSmarty->assign('stCANTIDAD', $stCANTIDAD);
$oSmarty->assign('stMINIMO', $stMINIMO);

$oSmarty->assign('stERROR', $stERROR);
$oSmarty->assign('stMENSAJE', $stMENSAJE);

$oSmarty->assign('stACTION', $_SERVER['PHP_SELF']);
$oSmarty->assign('stTITLE', 'Criar Controle de Stock');
$oSmarty->assign('stSUBTITLE', 'Stock de Produto');
$oSmarty->assign('stBTN_ACTION', 'Criar');
$oSmarty->assign('stBTN_ACTION_D', '');
/* ------------------------------------------------------------------ */
$oSmarty->display('stock/_stk.crear.tpl');
