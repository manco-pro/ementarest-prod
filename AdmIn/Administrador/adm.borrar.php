<?php
	require_once '../../cOmmOns/config.inc.php';
	require_once getLocal('ADMIN').'menu.inc.php';
	require_once getLocal('ADM').'class.administrador.inc.php';

	$error = '';

	$id = obtenerValor('id');

	if ($id == null){$error = 'Erro ao acessar a p&aacute;gina.';}
	
	if (!empty($error)) {
		$oSmarty->assign('stTITLE', 'Eliminar produto');
		$oSmarty->assign('stMESSAGE', $error);
		$oSmarty->display('_informacion.tpl');
		exit();
	}
	
	$oAdministrador = new clsAdministrador();
	
	if (!$oAdministrador->findId($id)) {
		$oSmarty->assign('stTITLE', 'Eliminar produto');
		$oSmarty->assign('stMESSAGE', $oAdministrador->getErrors());
		$oSmarty->display('_informacion.tpl');
		exit();
	}
	if (!$oAdministrador->Borrar($id)) {
		$oSmarty->assign('stTITLE', 'Eliminar produto');
		$oSmarty->assign('stMESSAGE', $oAdministrador->getErrors());
		$oSmarty->display('_informacion.tpl');
		exit();
	}
	
	redireccionar(getWeb('ADM'). 'adm.listar.php');