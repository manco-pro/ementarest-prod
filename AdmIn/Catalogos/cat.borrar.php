<?php
require_once '../../cOmmOns/config.inc.php';
require_once getLocal('ADMIN') . 'menu.inc.php';
require_once getLocal('CAT') . 'class.catalogos.inc.php';

$error = '';
$id = obtenerValor('id');
$loja_id = obtenerValor('loja_id');

if ($id == null || $loja_id == null) {
	$error = 'Erro ao acessar a p&aacute;gina.';
}
if (!empty($error)) {
	$oSmarty->assign('stTITLE', 'Eliminar catalogo');
	$oSmarty->assign('stMESSAGE', $error);
	$oSmarty->display('_informacion.tpl');
	exit();
}

if (($_SESSION['_admLojaId'] != $loja_id) && ($_SESSION['_admin'] == 'N')) {
	$oSmarty->assign('stTITLE', 'Acceso denegado.');
	$oSmarty->assign('stMESSAGE', 'Acceso denegado.');
	$oSmarty->display('_informacion.tpl');
	exit();
}

$oCatalogos = new clsCatalogos();

if (!$oCatalogos->findId($id)) {
	$oSmarty->assign('stTITLE', 'Eliminar produto');
	$oSmarty->assign('stMESSAGE', $oCatalogos->getErrors());
	$oSmarty->display('_informacion.tpl');
	exit();
}
if (!$oCatalogos->Borrar()) {
	$oSmarty->assign('stTITLE', 'Eliminar produto');
	$oSmarty->assign('stMESSAGE', $oCatalogos->getErrors());
	$oSmarty->display('_informacion.tpl');
	exit();
}

redireccionar(getWeb('CAT') . 'cat.listar.php');
