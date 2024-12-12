<?php
require_once '../../cOmmOns/config.inc.php';
require_once getLocal('ADMIN') . 'menu.inc.php';
require_once getLocal('STK') . 'class.stock.inc.php';

$error = '';
$oStockDeatlle = new clsStockDetalle();
$oStock = new clsStock();
$oStock->clearStock();
$oStockDeatlle->clearStockDetalle();
$id = obtenerValor('id');

if ($id === null || !$oStockDeatlle->findId($id) || !$oStock->findId($oStockDeatlle->getStock_Id())) {
	$oSmarty->assign('stTITLE', 'Eliminar produto');
	$oSmarty->assign('stMESSAGE', $oStockDeatlle->getErrors());
	$oSmarty->display('_informacion.tpl');
	exit();
}

$loja_id = $oStock->getLoja_Id();
if (($_SESSION['_admLojaId'] != $loja_id) && ($_SESSION['_admin'] == 'N')) {
	$oSmarty->assign('stTITLE', 'Acceso denegado.');
	$oSmarty->assign('stMESSAGE', 'Acceso denegado.');
	$oSmarty->display('_informacion.tpl');
	exit();
}

if (!$oStockDeatlle->Borrar()) {
	
	$oSmarty->assign('stTITLE', 'Eliminar detalhe de stock');
	$oSmarty->assign('stMESSAGE', $oStockDeatlle->getErrors());
	$oSmarty->display('_informacion.tpl');
	exit();
}
if (!$oStock->ActualizarStockCantidad($oStockDeatlle->getCantidad())) {
	$oSmarty->assign('stTITLE', 'atualizar quantidade em stock');
	$oSmarty->assign('stMESSAGE', $oStock->getErrors() );
	$oSmarty->display('_informacion.tpl');
	exit();
}

redireccionar(getWeb('STK'). 'stk.stock_detalle.php?id=' . $oStock->getId() );
