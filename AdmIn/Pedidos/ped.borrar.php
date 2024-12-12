<?php
require_once '../../cOmmOns/config.inc.php';
require_once getLocal('ADMIN') . 'menu.inc.php';
require_once getLocal('PED') . 'class.pedidos.inc.php';


$error = '';
$id = obtenerValor('id');


if ($id == null) {
	$error = 'Erro ao acessar a p&aacute;gina.';
}
if (!empty($error)) {
	$oSmarty->assign('stTITLE', 'Eliminar Pedido');
	$oSmarty->assign('stMESSAGE', $error);
	$oSmarty->display('_informacion.tpl');
	exit();
}
$oPedidos = new clsPedidos();

if (!$oPedidos->findId($id)) {
	$oSmarty->assign('stTITLE', 'Eliminar produto');
	$oSmarty->assign('stMESSAGE', $oCatalogos->getErrors());
	$oSmarty->display('_informacion.tpl');
	exit();
}
if (($_SESSION['_admLojaId'] != $oPedidos->getLoja_Id()) && ($_SESSION['_admin'] == 'N')) {
	$oSmarty->assign('stTITLE', 'Acceso denegado.');
	$oSmarty->assign('stMESSAGE', 'Acceso denegado.');
	$oSmarty->display('_informacion.tpl');
	exit();
}


if (!$oPedidos->Borrar($id)) {
	$oSmarty->assign('stTITLE', 'Eliminar produto');
	$oSmarty->assign('stMESSAGE', $oCatalogos->getErrors());
	$oSmarty->display('_informacion.tpl');
	exit();
}

redireccionar(getWeb('PED') . 'ped.listar.php');