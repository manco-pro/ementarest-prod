<?php

require_once '../../cOmmOns/config.inc.php';
require_once getLocal('ADMIN') . 'menu.inc.php';
require_once getLocal('COL') . 'class.colecciones.inc.php';
require_once getLocal('STK') . 'class.stock.inc.php';
require_once getLocal('STK') . 'class.stock_detalle.inc.php';
require_once getLocal('LOJ') . 'class.lojas.inc.php';


$oLojas = new clsLojas();
$oStock = new clsStock();
$oColecciones = new clsColecciones();
$oStockDetalle = new clsStockDetalle();

$oStock->clearStock();
$oStockDetalle->clearStockDetalle();

$stID = 0;
$stCOLECCION_ID = 0;
$stCANTIDAD = 0;
$stMINIMO = 0;
$stMOVIMIENTO = '';
$stCOMENTARIO = '';
$stMENSAJE = false;
$stERROR = '';

$stID = obtenerValor('id', FILTER_UNSAFE_RAW);



if (!isset($_SESSION['_admin']) || $stID == null || !$oStock->findId($stID)) {
    $oSmarty->assign('stTITLE', 'Acceso denegado.');
    $oSmarty->assign('stMESSAGE', 'Acceso denegado.');
    $oSmarty->display('_informacion.tpl');
    exit();
}



if (isset($_POST['Criar'])) {


    $stMOVIMIENTO = obtenerValorPOST('movimiento');
    $stCOMENTARIO = obtenerValorPOST('comentario');
    
    $stCANTIDAD = $oStock->getCantidad() + $stMOVIMIENTO;
    $oStock->setCantidad($stCANTIDAD);
   
    $stLOJA_ID = $oStock->getLoja_Id();

    if ($stLOJA_ID != $_SESSION['_admLojaId'] && $_SESSION['_admin'] != 'S') {
        $oSmarty->assign('stTITLE', 'Modificar Produto');
        $oSmarty->assign('stMESSAGE', 'Acceso denegado.');
        $oSmarty->display('_informacion.tpl');
        exit();
    }
    $variable = '';

    if (!$oStock->hasErrors() && $oStock->Modificar()) { 
   
        $oStockDetalle->setStock_id($stID);
        $oStockDetalle->setCantidad($stMOVIMIENTO);
        $oStockDetalle->setUser($_SESSION['_admId']);
        $oStockDetalle->setComentario($stCOMENTARIO);
        if ($oStockDetalle->Registrar()) {
            redireccionar(getWeb('STK') . 'stk.listar.php?id=' . $oStock->getId() . 'loja_id=' . $stLOJA_ID);
        }
        $stERROR = $oStock->getErrors();
    }
}

$oColecciones->findId($oStock->getColeccion_Id());
$stCOLECCION = $oColecciones->getNombre_pt();

$stLOJA_ID = $oStock->getLoja_Id();
$stCANTIDAD = $oStock->getCantidad();

$stVALUES = $oStockDetalle->GetAllStockDetalle($oStock->getId());


$oSmarty->assign('stID', $stID);
$oSmarty->assign('stLOJA_ID', $stLOJA_ID);
$oSmarty->assign('stCANTIDAD', $stCANTIDAD);
$oSmarty->assign('stMINIMO', $stMINIMO);
$oSmarty->assign('stCOLECCION', $stCOLECCION);
$oSmarty->assign('stMOVIMIENTO', $stMOVIMIENTO);
$oSmarty->assign('stCOMENTARIO', $stCOMENTARIO);
$oSmarty->assign('stVALUES', $stVALUES);

$oSmarty->assign('stERROR', $stERROR);
$oSmarty->assign('stMENSAJE', $stMENSAJE);

$oSmarty->assign('stACTION', $_SERVER['PHP_SELF']);
$oSmarty->assign('stTITLE', 'Movimentar Stock');
$oSmarty->assign('stSUBTITLE', 'Produto: ');
$oSmarty->assign('stBTN_ACTION', 'Criar');
$oSmarty->assign('stBTN_ACTION_D', '');
/* ------------------------------------------------------------------ */
$oSmarty->display('stock/_stk.stock_detalle.tpl');
