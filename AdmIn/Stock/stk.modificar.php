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
/* ------------------------------------------------------------ */
$stID = obtenerValor('id', FILTER_UNSAFE_RAW);

if (!isset($_SESSION['_admin'])  || $stID == null || !$oStock->findId($stID)) {
    $oSmarty->assign('stTITLE', 'Acceso denegado.');
    $oSmarty->assign('stMESSAGE', 'Acceso denegado.');
    $oSmarty->display('_informacion.tpl');
    exit();

}
$stLOJA_ID = $oStock->getLoja_Id();
if ($stLOJA_ID != $_SESSION['_admLojaId'] && $_SESSION['_admin'] != 'S') {
    $oSmarty->assign('stTITLE', 'Modificar Produto');
    $oSmarty->assign('stMESSAGE', 'Acceso denegado.');
    $oSmarty->display('_informacion.tpl');
    exit();
}
/* ------------------------------------------------------------ */

$stMENSAJE = false;

$stID = 0;
$stCOLECCION_ID = 0;
$stCANTIDAD = 0;
$stMINIMO = 0;

$stERROR = '';

if (isset($_POST['Modificar'])) {
    
   

    $stMINIMO = obtenerValorPOST('minimo');
    $oStock->setMinimo($stMINIMO);

    if (!$oStock->hasErrors() && $oStock->Modificar()) {
        redireccionar(getWeb('STK') . 'stk.modificar.php?id=' . $oStock->getId() . '&mod=ok');
    }
    $stERROR = $oStock->getErrors();
} elseif (isset($_GET['id'])) {

    $stID = $_GET['id'];
    if (isset($_GET['mod'])) {
        if ($_GET['mod'] == 'ok') {
            $stMENSAJE = 'dados alterados com sucesso';
        } else if ($_GET['mod'] == 'bad') {
            $stERROR = 'XXXXXXX';
        }
    }
    if (isset($_GET['cre'])) {
        if ($_GET['cre'] == 'ok') {
            $stMENSAJE = 'Controle de stock criado com sucesso';
        }
    }

} else {
    $oSmarty->assign('stTITLE', 'Modificar cat&aacute;logo');
    $oSmarty->assign('stMESSAGE', 'Acceso denegado.');
    $oSmarty->display('_informacion.tpl');
    exit();
}

$aStock_col_ids = $oStock->GetAllStockColIds($stLOJA_ID);
$stCOLECCION_SELECT = sobreescribirEntidadesHTML($oColecciones->GetAllColByLoja_Id($stLOJA_ID, true, 2));

/* --------------------------------------------------------------------- */

$oSmarty->assign('stID', $stID);
$oSmarty->assign('stLOJA_ID', $stLOJA_ID);
$oSmarty->assign('stCOLECCION_SELECT', HandlerSelect($stCOLECCION_SELECT, $oStock->getColeccion_Id(), 'Selecione'));

$oSmarty->assign('stCANTIDAD', "");
$oSmarty->assign('stDISABLE', "disabled");
$oSmarty->assign('stMINIMO', $oStock->getMinimo());

$oSmarty->assign('stERROR', $stERROR);
$oSmarty->assign('stMENSAJE', $stMENSAJE);

$oSmarty->assign('stACTION', $_SERVER['PHP_SELF']);
$oSmarty->assign('stTITLE', 'Modificar Controle de Stock');
$oSmarty->assign('stSUBTITLE', 'Stock de Produto');
$oSmarty->assign('stBTN_ACTION', 'Modificar');
$oSmarty->assign('stBTN_ACTION_D', 'deletar');
/* ------------------------------------------------------------------ */
$oSmarty->display('stock/_stk.crear.tpl');
