<?php
require_once '../../cOmmOns/config.inc.php';
require_once getLocal('ADMIN') . 'menu.inc.php';
require_once getLocal('STK') . 'class.stock.inc.php';

$error = '';
$oStock = new clsStock();
$oStock->clearStock();
$id = obtenerValor('id');

if ($id === null || !$oStock->findId($id)) {
	$oSmarty->assign('stTITLE', 'Eliminar produto');
	$oSmarty->assign('stMESSAGE', $oStock->getErrors());
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

if (!$oStock->Borrar($id)) {
	$oSmarty->assign('stTITLE', 'Eliminar Stock control');
	$oSmarty->assign('stMESSAGE', $oStock->getErrors());
	$oSmarty->display('_informacion.tpl');
	exit();
}

redireccionar(getWeb('STK'). 'stk.listar.php');
