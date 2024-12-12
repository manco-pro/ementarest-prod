<?php
require_once '../../cOmmOns/config.inc.php';
require_once getLocal('ADMIN') . 'menu.inc.php';
require_once getLocal('COL') . 'class.colecciones.inc.php';

$error = '';
$oColecciones = new clsColecciones();
$id = obtenerValor('id');

if ($id != null) {
	$loja_id = $oColecciones->GetLojaIdByColeccion($id);
}else{
	$error = 'Erro ao acessar a p&aacute;gina.';
}


if (($_SESSION['_admLojaId'] != $loja_id) && ($_SESSION['_admin'] == 'N')) {
	$oSmarty->assign('stTITLE', 'Acceso denegado.');
	$oSmarty->assign('stMESSAGE', 'Acceso denegado.');
	$oSmarty->display('_informacion.tpl');
	exit();
}


if (!empty($error)) {
	$oSmarty->assign('stTITLE', 'Eliminar produto');
	$oSmarty->assign('stMESSAGE', $error);
	$oSmarty->display('_informacion.tpl');
	exit();
}



if (!$oColecciones->findId($id)) {
	$oSmarty->assign('stTITLE', 'Eliminar produto');
	$oSmarty->assign('stMESSAGE', $oColecciones->getErrors());
	$oSmarty->display('_informacion.tpl');
	exit();
}
if (!$oColecciones->Borrar($id)) {
	$oSmarty->assign('stTITLE', 'Eliminar produto');
	$oSmarty->assign('stMESSAGE', $oColecciones->getErrors());
	$oSmarty->display('_informacion.tpl');
	exit();
}

redireccionar(getWeb('COL'). 'col.listar.php');
