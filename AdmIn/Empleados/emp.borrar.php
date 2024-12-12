<?php
require_once '../../cOmmOns/config.inc.php';
require_once getLocal('ADMIN') . 'menu.inc.php';
require_once getLocal('EMP') . 'class.empleados.inc.php';

$error = '';
$oEmpleados = new clsEmpleados();
$id = obtenerValor('id');

if (!$oEmpleados->findId($id)) {
	$oSmarty->assign('stTITLE', 'Eliminar Mensagem');
	$oSmarty->assign('stMESSAGE', $oEmpleados->getErrors());
	$oSmarty->display('_informacion.tpl');
	exit();
}


if (($_SESSION['_admLojaId'] != $oEmpleados->getLoja_Id()) && ($_SESSION['_admin'] == 'N')) {
	$oSmarty->assign('stTITLE', 'Acceso denegado.');
	$oSmarty->assign('stMESSAGE', 'Acceso denegado.');
	$oSmarty->display('_informacion.tpl');
	exit();
}


if (!$oEmpleados->Borrar($id)) {
	$oSmarty->assign('stTITLE', 'Eliminar Mensagem');
	$oSmarty->assign('stMESSAGE', $oEmpleados->getErrors());
	$oSmarty->display('_informacion.tpl');
	exit();
}

redireccionar(getWeb('EMP'). 'emp.listar.php');