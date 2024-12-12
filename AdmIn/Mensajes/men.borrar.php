<?php
require_once '../../cOmmOns/config.inc.php';
require_once getLocal('ADMIN') . 'menu.inc.php';
require_once getLocal('MEN') . 'class.mensajes.inc.php';

$error = '';

$id = obtenerValor('id');

if ($id == null){$error = 'Erro ao acessar a p&aacute;gina.';}

if (!empty($error)) {
	$oSmarty->assign('stTITLE', 'Eliminar Mensagem');
	$oSmarty->assign('stMESSAGE', $error);
	$oSmarty->display('_informacion.tpl');
	exit();
}

$oMensajes = new clsMensajes();

if (!$oMensajes->findId($id)) {
	$oSmarty->assign('stTITLE', 'Eliminar Mensagem');
	$oSmarty->assign('stMESSAGE', $oMensajes->getErrors());
	$oSmarty->display('_informacion.tpl');
	exit();
}
if (!$oMensajes->Borrar($id)) {
	$oSmarty->assign('stTITLE', 'Eliminar Mensagem');
	$oSmarty->assign('stMESSAGE', $oMensajes->getErrors());
	$oSmarty->display('_informacion.tpl');
	exit();
}

redireccionar(getWeb('MEN'). 'men.listar.php');
