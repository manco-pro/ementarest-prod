<?php
require_once '../../cOmmOns/config.inc.php';
require_once getLocal('ADMIN') . 'menu.inc.php';
require_once getLocal('ADM') . 'class.administrador.inc.php';

$oAdministrador = new clsAdministrador();


if ($_SESSION['_admId'] != 1) {
	$oSmarty->assign('stTITLE', 'Crear administrador');
	$oSmarty->assign('stMESSAGE', 'Acceso denegado.');
	$oSmarty->display('_informacion.tpl');
	exit();
} else {
	$result = $oAdministrador->GetAllAdmins();
}

$Cid = obtenerValor('Cid');
$Cvalue = obtenerValor('Cvalue');
if ($Cid != false && $Cvalue != false) {
	$oAdministrador->findId($Cid);
	$oAdministrador->setEnabled($Cvalue);
	if (!$oAdministrador->UpdateEstado()){
		$stMESSAGE = $oAdministrador->getErrors();
		echo $stMESSAGE;
		exit();
	
	}else{
		echo 'ok';
		exit();
	}
}

if ($result != false) {
	foreach ($result as $value) {
		$Id = $value['id'];
		$aValues[$Id]['nombre']     = $oAdministrador->forShow($value['nombre']);
		$aValues[$Id]['apellido']   = $oAdministrador->forShow($value['apellido']);
		$aValues[$Id]['email']      = $oAdministrador->forShow($value['email']);
		$aValues[$Id]['loja']       = $oAdministrador->forShow($value['loja']);
		$aValues[$Id]['telefono']   = $oAdministrador->forShow($value['telefono']);
		$aValues[$Id]['enabled']    = $oAdministrador->forShow($value['enabled']);
	}
} else {
	$aValues = array();
}

// resultados
/*---------------------------------------------------------------------*/
$oSmarty->assign('stSUPER_ADMIN', $_SESSION['_admin']);
$oSmarty->assign('stVALUES', $aValues);
$oSmarty->assign('stTITLE', 'Listado de Administradores');
/*---------------------------------------------------------------------*/
$oSmarty->display('admin/_adm.listar.tpl');
