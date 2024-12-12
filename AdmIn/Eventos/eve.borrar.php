<?php
require_once '../../cOmmOns/config.inc.php';
require_once getLocal('ADMIN') . 'menu.inc.php';
require_once getLocal('EVE') . 'class.eventos.inc.php';

$error = '';
$oEventos = new clsEventos();
$id = obtenerValor('id');

if (!$oEventos->findId($id)) {
	$oSmarty->assign('stTITLE', 'Eliminar Mensagem');
	$oSmarty->assign('stMESSAGE', $oEventos->getErrors());
	$oSmarty->display('_informacion.tpl');
	exit();
}


if (($_SESSION['_admLojaId'] != $oEventos->getLoja_Id()) && ($_SESSION['_admin'] == 'N')) {
	$oSmarty->assign('stTITLE', 'Acceso denegado.');
	$oSmarty->assign('stMESSAGE', 'Acceso denegado.');
	$oSmarty->display('_informacion.tpl');
	exit();
}


if (!$oEventos->Borrar($id)) {
	$oSmarty->assign('stTITLE', 'Eliminar Mensagem');
	$oSmarty->assign('stMESSAGE', $oEventos->getErrors());
	$oSmarty->display('_informacion.tpl');
	exit();
}

redireccionar(getWeb('EVE'). 'eve.listar.php');
